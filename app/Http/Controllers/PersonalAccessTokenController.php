<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\PersonalAccessTokenResult;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\Token;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController as BasePersonalAccessTokenController;
Passport::routes();  
class PersonalAccessTokenController extends Controller
{
    /**
     * Create a new personal access token for the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // Ensure the user is authenticated
        $user = Auth::user();

        // Create a personal access token for the user
        $token = $user->createToken('Personal Access Token')->accessToken;

        return response()->json(['token' => $token]);
    }

    /**
     * Revoke a specific personal access token.
     *
     * @param  string  $tokenId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($tokenId)
    {
        // Find the token by ID
        $token = Token::findOrFail($tokenId);

        // Revoke the token
        $token->delete();

        return response()->json(['message' => 'Token revoked successfully']);
    }
}
