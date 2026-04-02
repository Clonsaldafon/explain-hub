<?php

namespace Users\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        if (!auth()->check()) {
            flash('error', "Log in to check your profile");
            return redirect('/login');
        }

        $user = auth()->user();

        $stats = [
            'questions_count' => $user->questions()->count(),
            'answers_count' => $user->answers()->count(),
            'rating' => $user->rating,
            'account_created' => $user->created_at->format("d M Y"),
        ];

        $recentQuestions = $user->questions()->orderBy('created_at', 'desc')->take(5)->get();
        $recentAnswers = $user->answers()->with('question:id,title')->orderBy('created_at', 'desc')->take(5)->get();


        return view('users::profile', compact('user', 'stats', 'recentQuestions', 'recentAnswers'));
    }

    public function updateEmail(Request $request) {
        if (!auth()->check()) {
            flash('error', "Log in to update email");
            return redirect('/login');
        }

        $user = auth()->user();

        $validated = $request->validate([
            'email' => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'current_password' => 'required|string',
        ], [
            'email.unique' => 'This email is already taken.',
            'email.required' => 'Email is required.',
            'email.max' => 'Email is too long.',
            'email.email' => 'Email is invalid.',
            'current_password.required' => 'Current password is required.',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            flash('error', 'Current password is incorrect');
            return redirect()->back();
        }

        $user->update([
            'email' => $validated['email']
        ]);

        flash('success', 'Email changed successfully. Your new email:  ' . $validated['email']);
        return redirect($request->header('referer') ?? '/profile');
    }

    public function updatePassword(Request $request) {
        if (!auth()->check()) {
            flash('error', "Log in to change password");
            return redirect('/login');
        }

        $user = auth()->user();
        $validated = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ], [
            'current_password.required' => 'Current password is required.',
            'new_password.required' => 'New password is required.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'confirm_password.same' => 'Passwords do not match.',
            'confirm_password.required' => 'Confirm password is required.',
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            flash('error', 'Current password is incorrect');
            return redirect()->back();
        }

        $user->update(['password' => Hash::make($validated['new_password'])]);

        flash('success', 'Password changed successfully.');
        return redirect($request->header('referer') ?? '/profile');
    }
}
