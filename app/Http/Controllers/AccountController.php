<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //
    }
    //Función para validar los datos que llegan del front
    public function checkData($request, $bandera){
        if($bandera){
            $validateData = $this->validate($request, [
                'nickname' => 'required|unique:accounts',
                'num_employer' => 'required|unique:accounts',
                'email' => 'required|unique:accounts',
                'password' => 'required',
                'data_id' => 'required|exists:accounts_data,key',
                'status_id' => 'required|exists:accounts_status,id',
                'rol_id' => 'required|exists:roles,id'
            ]);
        }else{
            $validateData = $this->validate($request, [
                'nickname' => 'required|unique:accounts',
                'num_employer' => 'required|unique:accounts',
                'email' => 'required|unique:accounts',
                'data_id' => 'required|exists:accounts_data,key',
                'status_id' => 'required|exists:accounts_status,id',
                'rol_id' => 'required|exists:roles,id'
            ]);
        }
    }

    public function getAll(){
        return response()->json(User::all());
    }

    public function find($id){
        return response()->json(User::find($id));
    }

    public function create(Request $request){
        $this->checkData($request, true);

        $user = new User;
        $user->nickname = $request->nickname;
        $user->num_employer = $request->num_employer;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->status_id = $request->status_id;
        $user->data_id = $request->data_id;
        $user->rol_id = $request->rol_id;
        $user->key = time();
        $save = $user->save();
        if($save){
            $user->key = Hash::make(env('TIENDA').$user->id);
        }
        return response()->json($user->save());
    }

    public function update(Request $request, $id){
        $user = $this->find($id);
        $user = $user->original;
        $exist = (array)$user;
        if(!count($exist)){
            return response("Cuenta no encontrada", 400);
        }
        if(strtoupper($request->nicknname)!=strtoupper($user->nickname) ||
        strtoupper($request->email)!=strtoupper($user->email) ||
        strtoupper($request->num_employer)!=strtoupper($user->num_employer)){
            $this->checkData($request, false);
            $user->nickname = $request->nickname;
            $user->num_employer = $request->num_employer;
            $user->email = $request->email;
        }
        $user->status_id = $request->status_id;
        $user->data_id = $request->data_id;
        $user->rol_id = $request->rol_id;
        return response()->json($user->save());
    }

    public function delete($id){
        $user = $this->find($id);
        $user = $user->original;
        $exist = (array)$user;
        if(!count($exist)){
            return response("Cuenta no encontrada", 400);
        }
        return response()->json($user->delete());
    }

    public function permissions(Request $request){
        $user = $this->find($request->id);
        $user = $user->original;
        $exist = (array)$user;
        if(!count($exist)){
            return response("Cuenta de usuario no encontrada", 400);
        }
        $permissions = [];
        foreach($user->permissions as $permission){
            array_push($permissions, $permission->id);
        }
        return response()->json([
            'usuario_id' => $user->key,
            'permissions' => $permissions
        ]);
    }

    public function updatePermissions(Request $request){
        $user = $this->find($request->id);
        $user = $user->original;
        $exist = (array)$user;
        if(!count($exist)){
            return response("Cuenta de usuario no encontrada", 400);
        }
        return response()->json($user->permissions()->sync($request->permissions));
    }

    public function togglePermission(Request $request){
        $user = $this->find($request->id);
        $user = $user->original;
        $exist = (array)$user;
        if(!count($exist)){
            return response("Cuenta de usuario no encontrada", 400);
        }
        return response()->json($user->permissions()->toggle($request->permissions));
    }

    public function logs(Request $request){
        $user = $this->find($request->id);
        $user = $user->original;
        $exist = (array)$user;
        if(!count($exist)){
            return response("Cuenta de usuario no encontrada", 400);
        }
        $logs = [];
        foreach($user->logs as $log){
            array_push($logs, $log->id);
        }
        return response()->json([
            'usuario_id' => $user->key,
            'logs' => $logs
        ]);
    }

    public function updateLogs(Request $request){
        $user = $this->find($request->id);
        $user = $user->original;
        $exist = (array)$user;
        if(!count($exist)){
            return response("Cuenta de usuario no encontrada", 400);
        }
        return response()->json($user->logs()->sync($request->logs));
    }

    public function toggleLog(Request $request){
        $user = $this->find($request->id);
        $user = $user->original;
        $exist = (array)$user;
        if(!count($exist)){
            return response("Cuenta de usuario no encontrada", 400);
        }
        return response()->json($user->logs()->toggle($request->logs));
    }
}