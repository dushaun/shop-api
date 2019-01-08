<?php

namespace App\Http\Controllers\Auth;

use App\Http\Resources\PrivateUserResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MeController extends Controller
{
    /**
     * MeController constructor.
     */
    public function __construct()
    {
        $this->middleware(['auth:api']);
    }

    /**
     * Run self user action.
     *
     * @param Request $request
     * @return PrivateUserResource
     */
    public function action(Request $request)
    {
        return new PrivateUserResource($request->user());
    }
}
