<?php

namespace Admin\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
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

    public function users()
    {
        $users = User::orderBy('id', 'desc')->get();
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

        flash('success', 'Пользователь заблокирован.');
        return redirect('/admin/users');
    }

    public function unbanUser($id)
    {
        $user = User::findOrFail($id);
        $user->is_blocked = false;
        $user->save();

        flash('success', 'Пользователь разблокирован.');
        return redirect('/admin/users');
    }

    public function questions()
    {
        $questions = Question::with('author')->orderBy('id', 'desc')->get();
        return view('admin::questions', compact('questions'));
    }

    public function deleteQuestion($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        flash('success', 'Вопрос удален.');
        return redirect('/admin/questions');
    }

    public function answers()
    {
        $answers = Answer::with('author', 'question')->orderBy('id', 'desc')->get();
        return view('admin::answers', compact('answers'));
    }

    public function deleteAnswer($id)
    {
        $answer = Answer::findOrFail($id);
        $answer->delete();

        flash('success', 'Ответ удален.');
        return redirect('/admin/answers');
    }
}
