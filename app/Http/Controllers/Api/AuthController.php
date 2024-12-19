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
    try {
        // Ensure the user is authenticated
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
            ], 401);
        }

        // Revoke all existing tokens for the user (optional)
        $user->tokens()->delete();

        // Create a new personal access token with required scopes
        $newToken = $user->createToken('API Token', ['create-data','view-data','delete-data','edit-data']); // Add all required scopes here

        return response()->json([
            'success' => true,
            'token' => $newToken->accessToken, // Passport provides the token string directly
            'expires_in' => now()->addDays(15)->diffInSeconds(), // Set the expiration time
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 500);
    }
}

public function generateToken(Request $request)
    {
        $user = $request->user(); // Get the authenticated user
        // $token = $user->createToken('API Token', ['view-data'])->accessToken;
        $token = $user->createToken('API Token', ['create-data','view-data','delete-data','edit-data'])->accessToken;
        return response(['access_token' => $token]);
    }




public function protectedRoute($id)
{
    try {
        // Get the authenticated user's ID
        $authId = Auth::id();

        // Check if the provided ID matches the authenticated user ID
        if ($id != $authId) {
            return response()->json([
                "message" => "Unauthorized access. Invalid user ID provided."
            ], 403);
        }

        // Fetch the authenticated user and their roles
        $authUser = Auth::user();

        // Check if the authenticated user has the 'User' role
        if (!$authUser->roles->contains('name', 'User')) {
            return response()->json([
                "message" => "Access denied. You do not have the Permission."
            ], 403);
        }

        // Fetch customers associated with the authenticated user
        $customers = Customer::where('user_id', $authId)->get();

        return response()->json([
            "success" => true,
            "customers" => $customers
        ], 200);
    } catch (\Exception $e) {
        return response()->json([
            "success" => false,
            "error" => $e->getMessage(),
        ], 500);
    }
}
public function customercreate(Request $request)
{
    try {
        // Get the currently authenticated user
        $authUser = Auth::user();

        // Check if the authenticated user has the 'User' role
        if (!$authUser->roles->contains('name', 'User')) {
            return response()->json([
                "message" => "Access denied. You do not have the permission."
            ], 403);
        }

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
            'user_id' => $authUser->id, // Associate customer with the authenticated user
        ];

        // Save the customer data into the database
        $customer = Customer::create($customerData);

        return response()->json([
            'success' => true,
            'customer' => $customer
        ], 201);
    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        // Handle other exceptions
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function delete($id, $user_id)
{
    try {
        // Get the authenticated user
        $authUser = Auth::user();

        if (!$authUser->roles->contains('name', 'User')) {
            return response()->json([
                'message' => 'Access denied. You do not have the permission.'
            ], 403);
        }

        // Find and delete the customer
        $customer = Customer::where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found or already deleted.'
            ], 404);
        }

        $customer->delete();

        return response()->json([
            'success' => true,
            'message' => 'Customer deleted successfully.'
        ], 200);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
}
public function customeredit(Request $request, $id, $user_id)
{
    try {
        // Get the authenticated user
        $authUser = Auth::user();

        // Check if the authenticated user has the 'User' role
        if (!$authUser->roles->contains('name', 'User')) {
            return response()->json([
                'message' => 'Access denied. You do not have the permission.'
            ], 403);
        }

        // Find the customer by ID and user_id
        $customer = Customer::where('id', $id)
            ->where('user_id', $user_id)
            ->first();

        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found or unauthorized to edit this customer.'
            ], 404);
        }

        // Validate the incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id,
            'mobile' => 'required|string|max:15',
            'subscription' => 'required|string',
            'gender' => 'required|string',
            'dob' => 'required|date',
            'additional_info' => 'nullable|string',
            'preferences' => 'nullable|string',
        ]);

        // Update the customer data
        $customer->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Customer updated successfully.',
            'customer' => $customer,
        ], 200);

    } catch (\Illuminate\Validation\ValidationException $e) {
        // Handle validation errors
        return response()->json([
            'success' => false,
            'errors' => $e->errors(),
        ], 422);
    } catch (\Exception $e) {
        // Handle unexpected errors
        return response()->json([
            'success' => false,
            'error' => $e->getMessage(),
        ], 500);
    }
}


}