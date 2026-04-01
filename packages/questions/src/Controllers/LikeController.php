<?php

namespace Questions\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Questions\Models\Answer;

class LikeController extends Controller
{
    public function toggleLikeOnAnswer(Request $request, $id)
    {
        if (!auth()->check()) {
            flash('error', 'Log in to like this question.');
            return redirect('/login');
        }

        $answer = Answer::findOrFail($id);
        $userId = auth()->id();

        try {
            $answer->toggleLike($userId);
            flash('success', 'Answer liked');
        } catch (Exception $ex) {
            flash('error', "Error while liking answer: {$ex->getMessage()}");
        }
        return redirect($request->header('referer') ?? '/questions');
    }

    public function toggleLikeOnQuestion(Request $request,$id) {
        if (!auth()->check()) {
            flash('error', 'Log in to like this question.');
            return redirect('/login');
        }

        $question = Question::findOrFail($id);
        $userId = auth()->id();

        try {
            $question->toggleLike($userId);
            flash('success', 'Question liked');
        } catch (Exception $ex) {
            flash('error', "Error while liking question: {$ex->getMessage()}");
        }

        return redirect($request->header('referer') ?? '/questions');
    }
}
