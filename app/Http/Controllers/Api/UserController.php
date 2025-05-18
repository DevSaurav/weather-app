<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends BaseController
{
    public function show($id)
    {
        $user = User::with('posts')->find($id);

        if (!$user) {
            return $this->error('User not found', 404);
        }

        return $this->success(new UserResource($user), 'User retrieved successfully');
    }
}
