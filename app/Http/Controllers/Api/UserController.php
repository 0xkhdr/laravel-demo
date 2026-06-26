<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Models\User;

class UserController extends Controller
{
    public function index(): UserCollection
    {
        return new UserCollection(User::query()->latest()->paginate(10));
    }
}
