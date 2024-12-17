<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Client;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'password' => 'required|confirmed'
        ]);

        $validatedData['password'] = Hash::make($request->password);

        $user = User::create($validatedData);

        $token = $user->createToken('API Token')->accessToken;

        return response(['user' => $user, 'access_token' => $token]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        if (!auth()->attempt($credentials)) {
            return response(['message' => 'Invalid Credentials'], 401);
        }
    
        $user = auth()->user();
    
        // Revoke existing tokens for the user (optional, but recommended)
        $user->tokens->each(function ($token) {
            $token->revoke();
        });
    
        // Create a new token with refresh token
        $tokenResult = $user->createToken('API Token');
        $accessToken = $tokenResult->accessToken;
        $refreshToken = $tokenResult->token->id; // Get the refresh token ID
    
        return response([
            'user' => $user,
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ]);
    }
    public function refreshToken(Request $request)
    {
        $request->validate([
            'refresh_token' => 'required|string',
            'client_id' => 'required',
            'client_secret' => 'required',
        ]);
    
        try {
            // dd($request->all());
    
            $refreshToken = $request->input('refresh_token');
            // dd( $refreshToken);
            $clientId = $request->input('client_id');
            // dd( $clientId);
            $clientSecret = $request->input('client_secret');
            // dd( $clientSecret);
    
            $client = Client::find($clientId);
            // dd($client);
            if (!$client || !hash_equals($client->secret, $clientSecret)) {
                dd("hello");
                Log::warning("Client secret mismatch or client not found.");
                return response()->json(['error' => 'Invalid client credentials'], 401);
            }
    
            Log::info("Client credentials validated."); 
    
            $refreshTokenRepository = app(RefreshTokenRepository::class);
            Log::info("RefreshTokenRepository instantiated.");
    
            $tokenRepository = app(TokenRepository::class);
            Log::info("TokenRepository instantiated.");
    
            $refreshTokenModel = DB::table('oauth_refresh_tokens')->where('id', $refreshToken)->first();
    
            if (!$refreshTokenModel) {
                Log::warning("Refresh token not found: " . $refreshToken);
                return response()->json(['error' => 'Invalid refresh token'], 400);
            }
    
            Log::info("Refresh token found.");
    
            $accessToken = DB::table('oauth_access_tokens')->where('id', $refreshTokenModel->access_token_id)->first();
            if (!$accessToken || $accessToken->revoked) {
                Log::warning("Access token associated with refresh token was revoked or doesn't exist.");
                return response()->json(['error' => 'Access token has been revoked or does not exist'], 401);
            }
    
            Log::info("Access token found and not revoked.");
    
            if (Carbon::parse($accessToken->expires_at)->isPast()) {
                Log::warning("Access token associated with refresh token is expired.");
                return response()->json(['error' => 'Access token is expired'], 401);
            }
    
            Log::info("Access token is not expired.");
    
            if ($accessToken->client_id != $clientId) {
                Log::warning("Client ID mismatch.");
                return response()->json(['error' => 'Client ID mismatch'], 400);
            }
    
            $user = \App\Models\User::find($accessToken->user_id);
    
            if (!$user) {
                Log::warning("User not found for access token.");
                return response()->json(['error' => 'User not found.'], 401);
            }
    
            Log::info("User found.");
    
            // Revoke old tokens
            DB::table('oauth_refresh_tokens')->where('id', $refreshToken)->update(['revoked' => true]);
            DB::table('oauth_access_tokens')->where('id', $accessToken->id)->update(['revoked' => true]);
    
            Log::info("Old tokens revoked.");
    
            // Issue new tokens using Passport::actingAs
            Passport::actingAs($user);
            $newTokenInstance = Passport::token();
            $newAccessToken = $newTokenInstance->accessToken;
            $newRefreshTokenId = $newTokenInstance->id;
    
            Log::info("New tokens issued successfully.");
    
            return response()->json([
                'access_token' => $newAccessToken,
                'refresh_token' => $newRefreshTokenId,
                'expires_at' => now()->addDays(15),
            ]);
    
        } catch (\Exception $e) {
            Log::error("Error refreshing token: " . $e->getMessage() . "\nTrace: " . $e->getTraceAsString());
            return response()->json(['error' => 'Could not refresh token'], 500);
        }
    }
    public function generateToken(Request $request)
    {
        $user = $request->user(); // Get the authenticated user
        // $token = $user->createToken('API Token', ['view-data'])->accessToken;
        $token = $user->createToken('API Token', ['create-data','view-data'])->accessToken;
        return response(['access_token' => $token]);
    }
    public function protectedRoute()
{
    $customers = Customer::get();
    // dd($customers);
    return response()->json([$customers]);
}


// public function customercreate(Request $request){
//     // dd(Auth::user()->id);
//     $create_customer = new Customer();
//     // $create_customer = Auth::user()->id;
//     $create_customer->name = $request->name;
//     $create_customer->email = $request->email;
//     $create_customer->mobile=$request->mobile;
//     $create_customer->subscription=$request->subscription;
//     $create_customer->gender=$request->gender;
//     $create_customer->dob=$request->dob;
//     $create_customer->additional_info=$request->additional_info;
//     $create_customer->preferences=$request->preferences;
//     $create_customer->save();
//     return response()->json(['create_customer' => $create_customer]);
// }

public function customercreate(Request $request)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:customers,email',
        'mobile' => 'required|string|max:15',
        'subscription' => 'required|string',
        'gender' => 'required|string',
        'dob' => 'required|date',
        'additional_info' => 'nullable|string',
        'preferences' => 'nullable|string',
    ]);

    // Get the currently authenticated user
    $userId = auth()->id(); // This will get the authenticated user's ID

    // Prepare data for insertion
    $customerData = [
        'name' => $validated['name'],
        'email' => $validated['email'],
        'mobile' => $validated['mobile'],
        'subscription' => $validated['subscription'],
        'gender' => $validated['gender'],
        'dob' => $validated['dob'],
        'additional_info' => $validated['additional_info'] ?? null,
        'preferences' => $validated['preferences'] ?? null,
        'user_id' => $userId,  // Add the user_id here
    ];

    // Save the customer data into the database
    try {
        $customer = Customer::create($customerData);
        return response()->json(['success' => true, 'customer' => $customer]);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
    }
}



}