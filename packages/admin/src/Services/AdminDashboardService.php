<?php

namespace Admin\Services;

class AdminDashboardService
{
    private $userStats;
    private $questionStats;

    public function __construct(UserStatisticsService $userStats, QuestionStatisticsService $questionStats)
    {
        $this->userStats = $userStats;
        $this->questionStats = $questionStats;
    }

    public function getDashboardData(): array
    {
        return [
            'totalUsers' => $this->userStats->getTotalUsers(),
            'blockedUsers' => $this->userStats->getBlockedUsersCount(),
            'totalQuestions' => $this->questionStats->getTotalQuestions(),
            'totalAnswers' => $this->questionStats->getTotalAnswers(),
        ];
    }
}