<?php

namespace Questions\Controllers;

use App\Http\Controllers\Controller;
use Users\Models\User;
use Exception;
use Illuminate\Http\Request;
use Questions\Models\Answer;
use Questions\Models\Question;

class AnswerController extends Controller
{

    private $currentUser = null;

    private function getCurrentUser()
    {
        if ($this->currentUser === null) {
            $userId = session('user_id');
            $this->currentUser = $userId ? User::find($userId) : null;
        }
        return $this->currentUser;
    }

    private function canEdit($id): bool
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return false;
        }

        $answer = Answer::findOrFail($id);

        return ($answer->author_id === $user->id) || $user->isEditor();
    }

    private function canDelete($id): bool
    {
        $user = $this->getCurrentUser();

        if (!$user) {
            return false;
        }

        $answer = Answer::findOrFail($id);

        return ($answer->author_id == $user->id) || $user->isModerator();
    }

    private function canChangeStatus($id): bool
    {
        $user = $this->getCurrentUser();
        return $user && $user->isModerator();
    }

    public function index(Request $request) {
        $user = $this->getCurrentUser();

        if (!$user) {
            flash('error', 'Log in to get answers ');
            return redirect('/login');
        }

        $answers = Answer::with('question')
            ->where('author_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('answers::index', [
            'answers' => $answers,
            'filter_type' => 'user'
        ]);
    }

    public function store(Request $request, $questionId) {
        if (!session()->has('user_id')) {
            flash('error', 'Log in to write an answer. ');
            return redirect('/login');
        }

        $question = Question::findOrFail($questionId);
        $errors = [];
        $content = trim($request->input('answer'));

        if (empty($content)) {
            $errors['answer'][] = 'Content is required';
        } elseif (strlen($content) < 5) {
            $errors['answer'][] = 'Answer must be at least 5 characters';
        }

        if (!empty($errors)) {
            flash('errors', $errors);
            flash('old', $request->all());
            return redirect('/questions/' . $questionId);
        }

        try {
            Answer::create([
                'answer' => $content,
                'author_id' => session('user_id'),
                'question_id' => $question->id,
                'status' => 'on_moderate',
                'views' => 0,
                'likes' => 0,
            ]);

            flash('success', 'Answer added successfully');
            return redirect('/questions/' . $questionId);
        } catch (Exception $ex) {
            flash('error', "Error while creating an answer: {$ex->getMessage()}");
            flash('old', $request->all());
            return redirect('/questions/' . $questionId);
        }
    }

    public function edit(Request $request, $id) {
        if (!$this->canEdit($id)) {
            flash('error', 'You do not have permission to edit this answer.');
            $answer = Answer::findOrFail($id);
            return redirect('/questions/' . $answer->question_id);
        }

        $answer = Answer::findOrFail($id);
        return view('answers::edit', compact('answer'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->canEdit($id)) {
            flash('error', 'You do not have permission to edit this answer.');
            $answer = Answer::findOrFail($id);
            return redirect('/questions/' . $answer->question_id);
        }

        $answer = Answer::findOrFail($id);
        $errors = [];
        $content = trim($request->input('answer'));

        if (empty($content)) {
            $errors['answer'][] = 'Content is required';
        } elseif (strlen($content) < 5) {
            $errors['answer'][] = 'Answer must be at least 5 characters';
        }

        if (!empty($errors)) {
            flash('errors', $errors);
            flash('old', $request->all());
            return redirect('/questions/' . $id . '/edit');
        }

        try {
            $answer->update(['answer' => $content]);

            flash('success', 'Answer updated successfully');
            return redirect('/questions/' . $answer->question_id);
        } catch (Exception $ex) {
            flash('error', "Error while updating an answer: {$ex->getMessage()}");
            flash('old', $request->all());
            return redirect('/questions/' . $id . '/edit');
        }
    }

    public function destroy($id) {
        if (!$this->canDelete($id)) {
            flash('error', 'You do not have permission to delete this answer.');
            $answer = Answer::findOrFail($id);
            return redirect('/questions/' . $answer->question_id);
        }

        $answer = Answer::findOrFail($id);
        $questionId = $answer->question_id;

        try {
            $answer->delete();
            flash('success', 'Answer deleted successfully');
            return redirect('/questions/' . $questionId);

        } catch (Exception $ex) {
            flash('error', "Error while deleting an answer: {$ex->getMessage()}");
            return redirect('/questions/' . $questionId);
        }
    }

    public function moderate(Request $request, $id) {
        if (!$this->canChangeStatus($id)) {
            abort(403, "Permission denied");
        }

        $answer = Answer::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:draft,on_moderate,published,rejected'
        ]);

        $answer->update(['status' => $validated['status']]);

        flash('success', 'Answer updated successfully');
        return redirect('/questions/' . $answer->question_id);
    }

}
