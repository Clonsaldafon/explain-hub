<?php

namespace Questions\Controllers;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Questions\Models\Answer;
use Questions\Models\Question;
use Questions\Models\Tag;
use Users\Models\User;

class QuestionController extends Controller
{
    private function canEdit($id): bool
    {
        if (!auth()->check()) return false;

        $user = auth()->user();
        $question = Question::findOrFail($id);

        return ($question->author_id === $user->id) || $user->isEditor();
    }

    private function canDelete($id): bool
    {
        if (!auth()->check()) return false;

        $user = auth()->user();
        $question = Question::findOrFail($id);

        return ($question->author_id == $user->id) || $user->isModerator();
    }

    private function canChangeStatus($id): bool
    {
        if (!auth()->check()) return false;

        $user = auth()->user();

        return $user && $user->isModerator();
    }

    private function checkManageGrants($id)
    {
        if (!auth()->check()) return false;

        $user = auth()->user();
        $question = Question::findOrFail($id);

        return ($question->author_id == $user->id || $user->isAdmin());
    }

    public function index(Request $request)
    {
        $authorId = $request->input('author_id');
        $query = Question::with('author');

        if ($authorId) {
            $query->where('author_id', $authorId);
        } else {
            $query->where('status', 'published');
        }

        $questions = $query->orderBy('created_at', 'desc')->get();

        return view('questions::questions.questions', [
            'questions' => $questions,
            'filter_type' => $request->has('author_id') ? 'user' : 'all'
        ]);
    }
    
    public function create()
    {
        if (!auth()->check()) {
            flash('error', 'Log in to ask a question');
            return redirect('/login');
        }

        return view('questions::questions.question-create');
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            flash('error', 'Log in to ask a question');
            return redirect('/login');
        }

        $errors = [];
        $title = trim($request->input('title'));
        $content = trim($request->input('content'));
        $tagsInput = $request->input('tags');

        if (is_string($tagsInput)) {
            $tags = array_map('trim', explode(',', $tagsInput));
            $tags = array_filter($tags);
        } else {
            $tags = is_array($tagsInput) ? $tagsInput : [];
        }

        if (empty($title)) {
            $errors['title'][] = 'Title is required';
        }

        if (empty($content)) {
            $errors['content'][] = 'Content is required';
        }

        if (empty($tags)) {
            $errors['tags'][] = 'Your question should contain at least 1 tag';
        }

        if (!empty($errors)) {
            flash('errors', $errors);
            flash('old', $request->all());
            return redirect('/questions/create');
        }

        try {
            $question = Question::create([
                'title' => $title,
                'content' => $content,
                'tags' => $tags ?? [],
                'status' => 'on_moderate',
                'author_id' => auth()->id(),
                'views' => 0,
                "likes" => 0,
            ]);

            $tagIds = [];
            foreach ($tags as $tagName) {
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $question->tags()->sync($tagIds);

            flash('success', 'Question created');
            return redirect('/my-questions');
        } catch (Exception $ex) {
            flash('error', "Error while creating a question: {$ex->getMessage()}");
            flash('old', $request->all());
            return redirect('/questions/create');
        }
    }

    public function show($id)
    {
        $question = Question::with('author')->findOrFail($id);
        $question->increment('views');

        if ($question->status !== 'published') {
            $user = auth()->user();
            $isOwner = (auth()->check() && auth()->id() == $question->author_id);
            if (!$isOwner && !$user->isEditor()) {
                abort(403, "Permission denied");
            }
        }

        $answers = Answer::with('question')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('questions::questions.question', compact('question', 'answers'));
    }

    public function edit($id)
    {
        if (!$this->canEdit($id)) {
            flash('error', 'You do not have permission to edit this question');
            return redirect('/questions/' . $id);
        }

        $question = Question::findOrFail($id);
        return view('questions::questions.question-edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        if (!$this->canEdit($id)) {
            flash('error', 'You do not have permission to edit this question');
            return redirect('/questions/' . $id);
        }

        $errors = [];
        $question = Question::findOrFail($id);
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

            $tags = $request->input('tags');
            if (!is_null($tags)) {
                $tagIds = Tag::whereIn('name', (array)$tags->pluck('id'));
                $question->tags()->sync($tagIds);
            }

            flash('success', 'Question updated successfully');
            return redirect('/questions/' . $id);
        } catch (Exception $ex) {
            flash('error', "Error while updating a question: {$ex->getMessage()}");
            flash('old', $request->all());
            return redirect('/questions/' . $id . '/edit');
        }
    }

    public function destroy(Request $request, $id)
    {
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

    public function moderate(Request $request, $id)
    {
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

    public function myQuestions()
    {
        if (!auth()->check()) {
            flash('error', 'Log in to see your questions');
            return redirect('/login');
        }

        $questions = Question::where('author_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('questions::questions.my-questions', ['questions' => $questions]);
    }
}
