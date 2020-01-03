<?php

namespace App\Http\Controllers;

use App\User;

class UserController extends Controller
{
    public function profile(User $user)
    {
        $user->load('trainings', 'applications');
        return view('profile', compact('user'));
    }

    public function trainings(User $user)
    {
        return response(['trainings' => $user->trainings]);
    }
}
