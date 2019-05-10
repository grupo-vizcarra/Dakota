<?php

namespace App\Http\Controllers;
use Validator;
use App\User;
use App\Http\Controllers\AccountController;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;
class AuthController extends BaseController {
    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    private $request;
    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }
    /**
     * Create a new token.
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'rol_id' => $user->rol_id, // Rol id
            'status' => $user->status_id, //Status de la cuenta
            'iat' => time(), // Time when JWT was issued. 
            'exp' => time() + 60*60 // Expiration time
        ];
        
        // As you can see we are passing `JWT_SECRET` as the second parameter that will 
        // be used to decode the token in the future.
        return JWT::encode($payload, env('JWT_SECRET'));
    }
    /**
     * Authenticate a user and return the token if the provided credentials are correct.
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function authenticate(User $user) {
        $this->validate($this->request, [
            'password'  => 'required'
        ]);
        // Find the user by email, nickname, num_employer
        $user = User::where('email', $this->request->user)->first();
        if(!$user){
            $user = User::where('nickname', $this->request->user)->first();
        }
        if(!$user){
            $user = User::where('num_employer', $this->request->user)->first();
        }
        if(!$user){
            return response("Usuario no encontrado", 400);
        }
        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $user->password)) {
            $usuario = new AccountController();
            $id = New Request();
            $id->id = $user->key;
            $permisos = $usuario->permissions($id);
            return response()->json([
                'token' => $this->jwt($user),
                'permissions' => $permisos,
                'rol_id' => $user->rol_id,
                'status_id' => $user->status->id
            ], 200);
        }
        // Bad Request response
        return response()->json([
            'error' => 'Usuario o contraseña incorrecta'
        ], 400);
    }
}