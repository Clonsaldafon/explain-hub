<?php

namespace Admin\Services;

use Questions\Models\Question;
use Questions\Models\Answer;
use Illuminate\Support\Facades\Log;

class QuestionStatisticsService
{
    public function getTotalQuestions(): int
    {
        return Question::count();
    }

    public function getTotalAnswers(): int
    {
        return Answer::count();
    }

    public function getQuestionsPaginated(array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Question::with('author');

        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
        }

        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('id', 'desc')->paginate(20);
    }

    public function findQuestion(int $id)
    {
        return Question::findOrFail($id);
    }

    public function deleteQuestion(int $id): void
    {
        $question = $this->findQuestion($id);
        $question->delete();
    }

    public function getAnswersPaginated(array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = Answer::with('author', 'question');

        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereRaw("JSON_UNQUOTE(JSON_EXTRACT(answer, '$.text')) LIKE ?", ["%{$search}%"]);
        }

        if (isset($filters['status']) && !empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('id', 'desc')->paginate(20);
    }

    public function findAnswer(int $id)
    {
        return Answer::findOrFail($id);
    }

    public function deleteAnswer(int $id): void
    {
        $answer = $this->findAnswer($id);
        $answer->delete();
    }

    public function logAdminAction(string $action, int $userId, string $message): void
    {
        Log::info($message);
    }
}