<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PassportController extends Controller
{
    public function user(){
        $user= User::get();
        return response()->json([
            "message"=>'data fetch Succesfuly',
            "user"=>$user,
        ],200);
    //    dd($user);
    }

    // public function profile(Request $request)
    // {
    //     // dd("hello");
    //     // Check if the user is authenticated
    //     if (Auth::check()) {
    //         return response()->json([
    //             'message' => 'Profile data fetched successfully!',
    //             'user' => Auth::user()  // Returns authenticated user's data
    //         ]);
    //     }

    //     // If not authenticated, return an unauthorized response
    //     return response()->json([
    //         'message' => 'Unauthorized'
    //     ], 401);  // 401 means Unauthorized
    // }

    public function profile(Request $request)
    {
        // Check if the user is authenticated using the 'api' guard
        $user = Auth::user();  // This will give the authenticated user

        if ($user) {
            // If the user is authenticated, return their profile data
            return response()->json([
                'message' => 'Profile data fetched successfully!',
                'user' => $user  // Returning the authenticated user's data
            ]);
        }

        // If not authenticated, return an unauthorized response
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);  // 401 means Unauthorized
    }


public function adminindex(){
    $user = Auth::user();
    $admins =$user->with('roles')->first();
    if($admins->name == 'superadmin'){
        return "hello";
    }

    // 12/12 re ya ku use kariki permission assign kara jiba by help of chart gpt
    // chat gpt link ->https://chatgpt.com/c/675927c2-4018-800e-8911-d5aae51
//    dd( $admins->name);
}



}
