<?php

namespace App\Http\Controllers;
use App\Rol;
use Illuminate\Http\Request;
class RolController extends Controller{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        //
    }
    //Función para validar los datos que llegan del front
    public function checkData($request){
        $validateData = $this->validate($request, [
            'name' => 'required|unique:roles'
        ]);
    }

    public function getAll(){
        return response()->json(Rol::all());
    }

    public function find($id){
        return response()->json(Rol::find($id));
    }

    public function create(Request $request){
        $this->checkData($request);

        $rol = new Rol;
        $rol->name = $request->name;
        
        return response()->json($rol->save());
    }

    public function update(Request $request, $id){
        $rol = $this->find($id);
        $rol = $rol->original;
        $exist = (array)$rol;
        if(!count($exist)){
            return response("Rol no encontrado", 400);
        }
        if(strtoupper($request->name)!=strtoupper($rol->name)){
            $this->checkData($request);
            $rol->name = $request->name;
        }
        return response()->json($rol->save());
    }

    public function delete($id){
        $rol = $this->find($id);
        $rol = $rol->original;
        $exist = (array)$rol;
        if(!count($exist)){
            return response("Status no encontrado", 400);
        }
        return response()->json($rol->delete());
    }

    public function permissions($id){
        $rol = $this->find($id);
        $rol = $rol->original;
        $exist = (array)$rol;
        if(!count($exist)){
            return response("Rol no encontrado", 400);
        }
        $permissions = [];
        foreach($rol->permissions as $permission){
            array_push($permissions, 2);
        }
        return response()->json([
            'rol' => $id,
            'permissions' => $permissions
        ]);
    }

    public function updatePermissions(Request $request, $id){
        $rol = $this->find($id);
        $rol = $rol->original;
        $exist = (array)$rol;
        if(!count($exist)){
            return response("Rol no encontrado", 400);
        }
        return response()->json($rol->permissions()->sync($request->permissions));
    }

    public function togglePermission(Request $request, $id){
        $rol = $this->find($id);
        $rol = $rol->original;
        $exist = (array)$rol;
        if(!count($exist)){
            return response("Rol no encontrado", 400);
        }
        return response()->json($rol->permissions()->toggle($request->permissions));
    }
}