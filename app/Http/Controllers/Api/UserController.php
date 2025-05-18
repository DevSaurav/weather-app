<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Resources\UserResource;
use App\Models\User;

/**
 *  A class to deal with user informations.
 *
 */
class UserController extends BaseController
{
    /**
     *  A function to get the user detail.
     *
     * @param string, user id
     * @return Object, App/Models/User
     */
    public function show($id)
    {
        /**
         * @var init user object
         */
        $user = User::with('posts')->find($id);

        if (!$user) {
            return $this->error('User not found', 404);
        }

        return $this->success(new UserResource($user), 'User retrieved successfully');
    }
}
