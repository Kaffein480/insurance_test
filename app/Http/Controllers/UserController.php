<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getUserData()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized'
            ], 401);
        }

        return response()->json([
            'error' => false,
            'data' => [
                'name'  => $user->name,
                'email' => $user->email,
            ]
        ], 200);
    }

    public function updateUserData(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'error' => true,
                'message' => 'Unauthorized user'
            ], 401);
        } else if (!$request->name || !$request->email) {

            return response()->json([
                'error' => true,
                'message' => 'Name and Email are required'
            ], 422);
        } else {

            $validated = $request->validate([
                'name'  => 'string|max:255',
                'email' => 'email|max:255',
            ]);
            
            $user->name  = $validated['name'];
            $user->email = $validated['email'];

            if ($user->save()) {

                return response()->json([
                    'error' => false,
                    'message' => 'User updated successfully',
                    'data' => [
                        'name'  => $user->name,
                        'email' => $user->email,
                    ]
                ], 200);
            } else {

                return response()->json([
                    'error' => true,
                    'message' => 'Failed to update user'
                ], 500);
            }
        }
    }
}
