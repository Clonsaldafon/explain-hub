<?php

namespace Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Admin\Services\UserStatisticsService;
use Admin\Services\QuestionStatisticsService;
use Admin\Services\AdminDashboardService;
use Framework\Container\ContainerInterface;

class AdminController extends Controller
{
    private $container;
    private $userStats;
    private $questionStats;
    private $dashboardService;

    public function __construct(
        ContainerInterface $container,
        UserStatisticsService $userStats,
        QuestionStatisticsService $questionStats,
        AdminDashboardService $dashboardService
    ) {
        $this->container = $container;
        $this->userStats = $userStats;
        $this->questionStats = $questionStats;
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $data = $this->dashboardService->getDashboardData();
        return view('admin::dashboard', $data);
    }

    public function users(Request $request)
    {
        $filters = $request->only(['search', 'role', 'blocked']);
        $users = $this->userStats->getUsersPaginated($filters);

        return view('admin::users', compact('users'));
    }

    public function banUser($id)
    {
        try {
            $user = $this->userStats->findUser($id);
            if ($user->isAdmin()) {
                flash('error', 'Нельзя блокировать администратора.');
                return redirect('/admin/users');
            }

            $this->userStats->banUser($id);
            $this->questionStats->logAdminAction('ban', $id, "Admin {$_SESSION['user_id']} banned user {$id}");
            flash('success', 'Пользователь заблокирован.');
        } catch (\Exception $e) {
            flash('error', 'Произошла ошибка при блокировке пользователя.');
        }

        return redirect('/admin/users');
    }

    public function unbanUser($id)
    {
        $this->userStats->unbanUser($id);
        $this->questionStats->logAdminAction('unban', $id, "Admin {$_SESSION['user_id']} unbanned user {$id}");
        flash('success', 'Пользователь разблокирован.');
        return redirect('/admin/users');
    }

    public function editUser($id)
    {
        $user = $this->userStats->findUser($id);
        return view('admin::edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:user,editor,moderator,admin',
            'is_blocked' => 'boolean',
        ]);

        if ($validator->fails()) {
            flash('errors', $validator->errors()->toArray());
            flash('old', $request->all());
            return redirect()->back();
        }

        $this->userStats->updateUser($id, $request->only(['name', 'email', 'role', 'is_blocked']));
        $this->questionStats->logAdminAction('update', $id, "Admin {$_SESSION['user_id']} updated user {$id}");
        flash('success', 'Пользователь обновлен.');
        return redirect('/admin/users');
    }

    public function questions(Request $request)
    {
        $filters = $request->only(['search', 'status']);
        $questions = $this->questionStats->getQuestionsPaginated($filters);

        return view('admin::questions', compact('questions'));
    }

    public function deleteQuestion($id)
    {
        $this->questionStats->deleteQuestion($id);
        $this->questionStats->logAdminAction('delete_question', $id, "Admin {$_SESSION['user_id']} deleted question {$id}");
        flash('success', 'Вопрос удален.');
        return redirect('/admin/questions');
    }

    public function answers(Request $request)
    {
        $filters = $request->only(['search', 'status']);
        $answers = $this->questionStats->getAnswersPaginated($filters);

        return view('admin::answers', compact('answers'));
    }

    public function deleteAnswer($id)
    {
        $this->questionStats->deleteAnswer($id);
        $this->questionStats->logAdminAction('delete_answer', $id, "Admin {$_SESSION['user_id']} deleted answer {$id}");
        flash('success', 'Ответ удален.');
        return redirect('/admin/answers');
    }
}