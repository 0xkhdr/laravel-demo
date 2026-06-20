<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetAuthenticatedUser
{
    public function __invoke(Request $request): User
    {
        return Auth::user();
    }
}
