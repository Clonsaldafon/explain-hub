<?php

namespace Users\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Users\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('users::auth.login');
    }

    public function login(Request $request)
    {
        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if (!$user) {
            flash('error', 'Пользователь не найден');
            flash('old', $request->all());
            return redirect('/login');
        }

        if (!Hash::check($password, $user->password)) {
            flash('error', 'Неверный пароль');
            flash('old', $request->all());
            return redirect('/login');
        }

        if ($user->is_blocked) {
            flash('error', 'Аккаунт заблокирован');
            return redirect('/login');
        }

        $_SESSION['user_id']   = $user->id;
        $_SESSION['user_role'] = $user->role;
        $_SESSION['user_name'] = $user->name;

        return redirect('/questions');
    }

    public function showRegisterForm()
    {
        return view('users::auth.register');
    }

    public function register(Request $request)
    {
        $errors = [];

        $name = trim($request->input('name'));
        if (empty($name)) {
            $errors['name'][] = 'Имя обязательно для заполнения';
        } elseif (strlen($name) > 255) {
            $errors['name'][] = 'Имя не должно превышать 255 символов';
        }

        $email = trim($request->input('email'));
        if (empty($email)) {
            $errors['email'][] = 'Email обязателен для заполнения';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = 'Введите корректный email адрес';
        } elseif (User::where('email', $email)->exists()) {
            $errors['email'][] = 'Пользователь с таким email уже зарегистрирован';
        }

        $password = $request->input('password');
        $passwordConfirmation = $request->input('password_confirmation');

        if (empty($password)) {
            $errors['password'][] = 'Пароль обязателен для заполнения';
        } elseif (strlen($password) < 8) {
            $errors['password'][] = 'Пароль должен содержать минимум 8 символов';
        } elseif ($password !== $passwordConfirmation) {
            $errors['password'][] = 'Пароли не совпадают';
        }

        if (!empty($errors)) {
            flash('errors', $errors);
            error_log('Flash errors set: ' . print_r($_SESSION['_flash']['errors'] ?? 'null', true));
            flash('old', $request->all());
            return redirect('/register');
        }

        try {
            $user = User::create([
                'name'       => $name,
                'email'      => $email,
                'password'   => Hash::make($password),
                'role'       => 'user',
                'rating'     => 0,
                'is_blocked' => false,
            ]);

            $_SESSION['user_id'] = $user->id;
            $_SESSION['user_role'] = $user->role;
            $_SESSION['user_name'] = $user->name;

            return redirect('/questions');
        } catch (\Exception $e) {
            flash('error', 'Ошибка при регистрации. Попробуйте позже.');
            return redirect('/register');
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        
        return redirect('/login');
    }
}