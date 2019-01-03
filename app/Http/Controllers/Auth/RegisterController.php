<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\PrivateUserResource;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Run the user register action.
     *
     * @param RegisterRequest $request
     * @return PrivateUserResource
     */
    public function action(RegisterRequest $request)
    {
        $user = User::create($request->only('email', 'name', 'password'));

        return new PrivateUserResource($user);
    }
}
