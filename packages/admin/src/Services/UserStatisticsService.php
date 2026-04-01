<?php

namespace Admin\Services;

use Users\Models\User;

class UserStatisticsService
{
    public function getTotalUsers(): int
    {
        return User::count();
    }

    public function getBlockedUsersCount(): int
    {
        return User::where('is_blocked', true)->count();
    }

    public function getUsersPaginated(array $filters = []): \Illuminate\Contracts\Pagination\LengthAwarePaginator
    {
        $query = User::query();

        if (isset($filters['search']) && !empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        if (isset($filters['role']) && !empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (isset($filters['blocked']) && $filters['blocked'] !== '') {
            $query->where('is_blocked', (bool)$filters['blocked']);
        }

        return $query->orderBy('id', 'desc')->paginate(20);
    }

    public function findUser(int $id)
    {
        return User::findOrFail($id);
    }

    public function banUser(int $id): void
    {
        $user = $this->findUser($id);
        $user->is_blocked = true;
        $user->save();
    }

    public function unbanUser(int $id): void
    {
        $user = $this->findUser($id);
        $user->is_blocked = false;
        $user->save();
    }

    public function updateUser(int $id, array $data): void
    {
        $user = $this->findUser($id);
        $user->update($data);
    }
}