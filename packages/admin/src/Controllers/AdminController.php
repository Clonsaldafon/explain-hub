<?php

namespace Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Users\Models\User;
use Questions\Models\Question;
use Questions\Models\Answer;

class AdminController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $blockedUsers = User::where('is_blocked', true)->count();
        $totalQuestions = Question::count();
        $totalAnswers = Answer::count();

        return view('admin::dashboard', compact('totalUsers', 'blockedUsers', 'totalQuestions', 'totalAnswers'));
    }

    public function users(Request $request)
    {
        $query = User::query();

        // email search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        // roles filtet
        if ($request->has('role') && !empty($request->role)) {
            $query->where('role', $request->role);
        }

        // bans filter
        if ($request->has('blocked') && $request->blocked !== '') {
            $query->where('is_blocked', $request->boolean('blocked'));
        }

        $users = $query->orderBy('id', 'desc')->paginate(20);

        return view('admin::users', compact('users'));
    }

    public function banUser($id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            flash('error', 'Нельзя блокировать администратора.');
            return redirect('/admin/users');
        }

        $user->is_blocked = true;
        $user->save();

        Log::info("Admin {$_SESSION['user_id']} banned user {$id}");

        flash('success', 'Пользователь заблокирован.');
        return redirect('/admin/users');
    }

    public function unbanUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false;
        $user->save();

        Log::info("Admin {$_SESSION['user_id']} unbanned user {$id}");

        flash('success', 'Пользователь разблокирован.');
        return redirect('/admin/users');
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin::edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:user,editor,moderator,admin',
            'is_blocked' => 'boolean',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'is_blocked']));

        Log::info("Admin {$_SESSION['user_id']} updated user {$id}");

        flash('success', 'Пользователь обновлен.');
        return redirect('/admin/users');
    }

    public function questions(Request $request)
    {
        $query = Question::with('author');

        // search by title and content
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        // status of question
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $questions = $query->orderBy('id', 'desc')->paginate(20);

        return view('admin::questions', compact('questions'));
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        Log::info("Admin {$_SESSION['user_id']} deleted question {$id}");

        flash('success', 'Вопрос удален.');
        return redirect('/admin/questions');
    }

    public function answers(Request $request)
    {
        $query = Answer::with('author', 'question');

        // search by answer content
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(answer, '$.text')) LIKE ?", ["%{$search}%"]);
        }

        // status of answer
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $answers = $query->orderBy('id', 'desc')->paginate(20);

        return view('admin::answers', compact('answers'));
    }

    public function deleteAnswer($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();

        Log::info("Admin {$_SESSION['user_id']} deleted answer {$id}");

        flash('success', 'Ответ удален.');
        return redirect('/admin/answers');
    }
}
