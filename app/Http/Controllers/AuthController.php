<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use App\Models\User;
use Illuminate\Http\Response;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    protected $issuedAt;
    protected $expire;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'device_token' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (is_null($user) || !Hash::check($request->password, $user->password))
        {
            return response()->json('Usuário ou senha inválidos!', 401);
        }

        if ($request->device_token !== $user->device_token)
        {
            $user->device_token = $request->device_token;
            $user->save();
        }

        $payload = [
            "email" => $request->email,
            "exp" => time() + 3600
        ];

        $token = JWT::encode($payload, env('JWT_KEY'), 'HS256');

        return [
            'id' => $user->id,
            'role' => $user->role,
            'name' => $user->name,
            'token' => $token
        ];
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|confirmed',
            'device_token' => 'required'
        ];

        $this->validate($request, $rules);

        $userRequest = $request->merge(['password' => Hash::make($request->get('password'))])->all();
        User::create($userRequest);
        $user = User::where('email', $request->email)->first();

        $payload = [
            "email" => $request->email,
            "exp" => time() + 3600
        ];

        $token = JWT::encode($payload, env('JWT_KEY'), 'HS256');

        return [
            'id' => $user->id,
            'role' => $user->role,
            'name' => $user->name,
            'token' => $token
        ];
    }
}