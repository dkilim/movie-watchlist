<?php

namespace App\Services;

use App\Http\Requests\AddUserRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserService
{
    public function createUser(RegisterRequest|AddUserRequest $request)
    {

        try {
            $user = User::create([
                'firstName' => $request->input('firstName'),
                'lastName' => $request->input('lastName'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
                'role_id' => 1
            ]);

            $watchlistService = new WatchlistService();
            $watchlistService->createWatchlist($user->id);


            return response(new UserResource($user->load('role')), Response::HTTP_CREATED);

        }
        catch (\PDOException $e) {
            if ($e->getCode() == "23000")
            {
                return response([
                    'error' => 'Username or email is already used'
                ], Response::HTTP_CONFLICT);
            }
        }
        catch (\Exception $e)
        {
            return response([
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response([
            'error' => 'Bad request'
        ], Response::HTTP_BAD_REQUEST);
    }

    public function updateUser(UpdateUserRequest $request,User $user)
    {

        if (!empty($user))
        {
            try {
                $user->update($request->only('firstName','lastName','username','email'));

                return response(new UserResource($user), Response::HTTP_ACCEPTED);
            }
            catch (\PDOException $e)
            {
                if ($e->getCode() == "23000")
                {
                    return response([
                        'error' => 'Username or email is already used'
                    ], Response::HTTP_CONFLICT);
                }
            }
            catch (\Exception $e)
            {
                return response([
                    'error' => $e->getMessage()
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }


        }
        return response([
            'message' => "User with id=$user->id was not found"
        ], Response::HTTP_BAD_REQUEST);
    }
}
