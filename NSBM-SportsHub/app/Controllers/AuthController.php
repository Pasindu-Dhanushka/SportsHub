<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Models\User;

final class AuthController
{
    public function loginForm(): void
    {
        if (Auth::check()) redirect('dashboard');
        view('auth/login', ['title' => 'Sign in']);
    }

    public function login(): void
    {
        Csrf::verify();
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $user = User::findByEmail($email);
        if (!$user || !password_verify($password, $user['password'])) {
            flash('error', 'Invalid email or password.');
            redirect('login');
        }
        if (($user['status'] ?? 'active') !== 'active') {
            flash('error', 'Your account is currently inactive.');
            redirect('login');
        }
        Auth::login($user);
        flash('success', 'Welcome back, ' . $user['name'] . '!');
        redirect('dashboard');
    }

    public function registerForm(): void
    {
        if (Auth::check()) redirect('dashboard');
        view('auth/register', ['title' => 'Create account']);
    }

    public function register(): void
    {
        Csrf::verify();
        $name = trim($_POST['name'] ?? '');
        $email = strtolower(trim($_POST['email'] ?? ''));
        $studentId = strtoupper(trim($_POST['student_id'] ?? ''));
        $faculty = trim($_POST['faculty'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm = $_POST['password_confirmation'] ?? '';

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || $studentId === '' || $faculty === '') {
            flash('error', 'Please complete all required fields with valid information.');
            redirect('register');
        }
        if (strlen($password) < 8 || $password !== $confirm) {
            flash('error', 'Passwords must match and contain at least 8 characters.');
            redirect('register');
        }
        if (User::findByEmail($email)) {
            flash('error', 'An account already exists for this email.');
            redirect('register');
        }

        try {
            $id = User::create([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'student_id' => $studentId,
                'faculty' => $faculty,
            ]);
            $user = User::find($id);
            Auth::login($user);
            flash('success', 'Account created successfully. Welcome to SportsHub!');
            redirect('dashboard');
        } catch (\Throwable $e) {
            flash('error', 'Registration failed. Student ID or email may already be in use.');
            redirect('register');
        }
    }

    public function logout(): void
    {
        Csrf::verify();
        Auth::logout();
        session_start();
        flash('success', 'You have been signed out.');
        redirect('home');
    }
}
