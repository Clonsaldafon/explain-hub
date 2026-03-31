<?php

namespace Questions\Controllers;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Questions\Models\Question;
use Users\Models\User;

class QuestionController extends Controller
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

    private function canEdit($id): bool {
        $user = $this->getCurrentUser();

        if (!$user) {
            return false;
        }

        $question = Question::findOrFail($id);

        return ($question->author_id === $user->id) || $user->isEditor();
    }

    private function canDelete($id): bool {
        $user = $this->getCurrentUser();
        if (!$user) {
            return false;
        }

        $question = Question::findOrFail($id);
        return ($question->author_id == $user->id) || $user->isModerator();
    }

    private function canChangeStatus($id): bool {
        $user = $this->getCurrentUser();
        return $user && $user->isModerator();
    }

    private function checkManageGrants($id) {
        $user = $this->getCurrentUser();
        if (!$user) {
            return false;
        }

        $question = Question::findOrFail($id);

        return ($question->author_id == $user->id || $user->isAdmin());
    }

    public function index(Request $request) {
        $query = Question::with('author');

        if ($request->has('author_id')) {
            $query->where('author_id', $request->input('author_id'));
        } else {
            $query->where('status', 'published');
        }

        $questions = $query->orderBy('created_at', 'desc')->get();

        return view('questions::index', [
            'questions' => $questions,
            'filter_type' => $request->has('author_id') ? 'user' : 'all'
        ]);
    }
    public function create(Request $request) {
        $user = $this->getCurrentUser();

        if (!$user) {
            flash('error', 'Log in to ask a question');
            return redirect('login');
        }

        return view('questions::create');
    }

    public function store(Request $request) {


        if (!session()->has('user_id')) {
            flash('error', 'Log in to ask a question');
            return redirect('/login');
        }

        $errors = [];


        $title = trim($request->input('title'));
        $content = trim($request->input('content'));
        $tags = $request->input('tags');

        if (empty($title)) {
            $errors['title'][] = 'Title is required';
        }

        if (empty($content)) {
            $errors['content'][] = 'Content is required';
        }

        if (!is_null($tags) && !is_array($tags)) {
            $errors['tags'][] = 'Your question should contain at least 1 tag';
        }

        if (!empty($errors)) {
            flash('errors', $errors);
            flash('old', $request->all());
            return redirect('/questions/create');
        }

        try {
            Question::create([
                'title' => $title,
                'content' => $content,
                'tags' => $tags ?? [],
                'status' => 'on_moderate',
                'author_id' => session('user_id'),
                'views' => 0,
                "likes" => 0,
            ]);

            flash('success', 'Question created');
            return redirect('/my-questions');
        } catch (Exception $ex) {
            flash('error', "Error while creating a question: {$ex->getMessage()}");
            flash('old', $request->all());
            return redirect('/questions/create');
        }
    }

    public function show($id) {
        $question = Question::with('author', 'answers.author')->findOrFail($id);
        $question->increment('views');
        if ($question->status !== 'published') {
            $user = $this->getCurrentUser();
            $currentUserId = session('user_id');

            $isOwner = ($currentUserId && $currentUserId == $question->author_id);
            if (!$isOwner && !$user->isEditor()) {
                abort(403, "Permission denied");
            }
        }

        return view('questions::show', compact('question'));
    }

    public function edit($id) {
        if (!$this->canEdit($id)) {
            flash('error', 'You do not have permission to edit this question');
            return redirect('/questions/' . $id);
        }

        $question = Question::findOrFail($id);
        return view('questions::edit', compact('question'));
    }

    public function update(Request $request, $id) {
        if (!$this->canEdit($id)) {
            flash('error', 'You do not have permission to edit this question');
            return redirect('/questions/' . $id);
        }

        $question = Question::findOrFail($id);

        $errors = [];
        $content = trim($request->input('content'));
        $title = trim($request->input('title'));

        if (empty($title)) {
            $errors['title'][] = 'Title is required';
        }

        if (empty($content)) {
            $errors['content'][] = 'Content is required';
        }

        if (!empty($errors)) {
            flash('errors', $errors);
            flash('old', $request->all());
            return redirect('/questions/' . $id . '/edit');
        }

        try {
            $question->update([
                'title' => $title,
                'content' => $content,
                'tags' => $request->input('tags') ?? $question->tags,
            ]);

            flash('success', 'Question updated successfully');
            return redirect('/questions/' . $id);
        } catch (Exception $ex) {
            flash('error', "Error while updating a question: {$ex->getMessage()}");
            flash('old', $request->all());
            return redirect('/questions/' . $id . '/edit');
        }
    }

    public function destroy(Request $request, $id) {
        if (!$this->canDelete($id)) {
            flash('error', 'You do not have permission to delete this question');
            return redirect('/questions/' . $id);
        }

        $question = Question::findOrFail($id);

        try {
            $question->delete();
            flash('success', 'Question deleted successfully');
            return redirect('/my-questions');

        } catch (Exception $e) {
            flash('error', "Error while deleting a question: {$e->getMessage()}");
            return redirect('/questions/' . $id);
        }
    }

    public function moderate(Request $request, $id) {
        if (!$this->canChangeStatus($id)) {
            abort(403, "Permission denied");
        }

        $question = Question::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:draft,on_moderate,published,rejected',
        ]);

        $question->update(['status' => $validated['status']]);
        flash('success', 'Question moderated successfully');
        return redirect('/questions/' . $id);
    }
}
