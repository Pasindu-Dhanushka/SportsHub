<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Csrf;
use App\Models\User;

final class ProfileController
{
    public function index(): void
    {
        Auth::requireLogin();
        $user = User::find(Auth::id());
        view('pages/profile', ['title' => 'My Profile', 'profileUser' => $user]);
    }

    public function update(): void
    {
        Auth::requireLogin();
        Csrf::verify();
        User::updateProfile(Auth::id(), [
            'name' => trim($_POST['name'] ?? ''),
            'student_id' => trim($_POST['student_id'] ?? ''),
            'faculty' => trim($_POST['faculty'] ?? ''),
        ]);
        $fresh = User::find(Auth::id());
        Auth::login($fresh);
        flash('success', 'Profile updated successfully.');
        redirect('profile');
    }

    public function password(): void
    {
        Auth::requireLogin();
        Csrf::verify();
        $user = User::find(Auth::id());
        $current = $_POST['current_password'] ?? '';
        $new = $_POST['new_password'] ?? '';
        $confirm = $_POST['new_password_confirmation'] ?? '';
        if (!$user || !password_verify($current, $user['password'])) {
            flash('error', 'Current password is incorrect.');
        } elseif (strlen($new) < 8 || $new !== $confirm) {
            flash('error', 'New passwords must match and contain at least 8 characters.');
        } else {
            User::changePassword(Auth::id(), password_hash($new, PASSWORD_DEFAULT));
            flash('success', 'Password changed successfully.');
        }
        redirect('profile');
    }
}
