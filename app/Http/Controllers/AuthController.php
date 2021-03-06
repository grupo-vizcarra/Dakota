<?php

namespace App\Http\Controllers;
use Validator;
use App\User;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AccountDataController;
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
        $user = User::where('email', $this->request->user)
                    ->orWhere('nickname', $this->request->user)
                    ->orWhere('num_employer', $this->request->user)
                    ->first();
        if(!$user){
            return response(['msg' => "Usuario no encontrado", 'status' => 404], 200);
        }
        // Verify the password and generate the token
        if (Hash::check($this->request->input('password'), $user->password)) {
            $usuario = new AccountController();
            $usuario_data = new AccountDataController();
            $id = New Request();
            $id->id = $user->key;
            $permisos = $usuario->permissions($id);
            $datos_usuario = $usuario_data->find($user->id);
            return response()->json([
                'account' => [
                    '_token' => $this->jwt($user),
                    '_status' => $user->status->id,
                    '_id' => $user->id,
                    '_key' => $user->key,
                    '_nickname' => $user->nickname,
                    '_num_employer' => $user->num_employer,
                    '_photo' =>  $datos_usuario->original->photo
                ],'user' =>[
                    '_rol' => ['_id' => $user->rol->id, '_name' => $user->rol->name],
                    '_name' => ['_names' => $datos_usuario->original->names, '_fname' => $datos_usuario->original->first_name, '_lname' => $datos_usuario->original->last_name]
                ], '_permissions' => $permisos->original['permissions'],
                'status' => 200
            ], 200);
        }
        // Bad Request response
        return response()->json([
            'msg' => 'Usuario o contraseña incorrecta',
            'status' => 400
        ], 400);
    }
}