<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
 
class AuthController extends Controller
{
    /**
     * Registro user_token
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken($request->email)->plainTextToken;
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    /**
     * Login user_token
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // check user_email
        $user = User::where('email', $request->email)->first();

        // valida user_email e user_password
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }
        $token = DB::table('personal_access_tokens')->where('tokenable_id', $user->id)->first();
        if ($token) {
            return response([
                'message' => 'Token de usuario já criado.'
            ]);
        }
        $token = $user->createToken($request->email)->plainTextToken;
        return response([
            'token' => $token
        ]);
    }
}
