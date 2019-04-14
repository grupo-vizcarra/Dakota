<?php
namespace App\Http\Middleware;
use Closure;
use Exception;
use App\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
class JwtMiddleware{
    public function handle($request, Closure $next, $guard = null){
        $bearerToken = $request->header('Authorization');
        $token = null;
        if($bearerToken){
            $token = explode(" ", $bearerToken)[1];
        }
        
        if(!$token) {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'No se ha proporcionado un token.'
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'El token ha inspirado.'
            ], 400);
        } catch(Exception $e) {
            return response()->json([
                'error' => "Ha ocurrido un error con el token"
            ], 400);
        }
        $user = User::find($credentials->sub);
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;
        return $next($request);
    }
}