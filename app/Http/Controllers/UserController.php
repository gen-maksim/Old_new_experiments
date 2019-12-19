<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(User $user)
    {
        return response($user);
    }

    public function trainings(User $user)
    {
        return response(['trainings' => $user->trainings]);
    }
}
