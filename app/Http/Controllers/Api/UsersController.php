<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\UsersController as ParentController;
use App\User;
use Illuminate\Contracts\Validation\Validator;

class UsersController extends ParentController
{
    public function __construct()
    {
        // Kill middleware defined by ParentController.
        $this->middleware = [];

        parent::__construct();
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        return json()->withItem(
            \App\User::with('articles', 'comments')->findOrFail($id),
            new \App\Transformers\UserTransformer
        );
    }

    /**
     * Make validation error response.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondValidationError(Validator $validator)
    {
        return json()->unprocessableError($validator->errors()->all());
    }

    /**
     * Make a success response.
     *
     * @param \App\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondCreated(User $user)
    {
        return json()->setMeta(['token' => \JWTAuth::fromUser($user)])->created();
    }
}
