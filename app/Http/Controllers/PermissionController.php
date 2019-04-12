<?php

namespace App\Http\Controllers;
use App\Permission;
use Illuminate\Http\Request;
class PermissionController extends Controller{
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
            'name' => 'required|unique:permissions'
        ]);
    }

    public function getAll(){
        return response()->json(Permission::all());
    }

    public function find($id){
        return response()->json(Permission::find($id));
    }

    public function create(Request $request){
        $this->checkData($request);

        $permission = new Permission;
        $permission->name = $request->name;
        
        return response()->json($permission->save());
    }

    public function update(Request $request, $id){
        $permission = $this->find($id);
        $permission = $permission->original;
        $exist = (array)$permission;
        if(!count($exist)){
            return response("Permiso no encontrado", 400);
        }
        if(strtoupper($request->name)!=strtoupper($permission->name)){
            $this->checkData($request);
            $permission->name = $request->name;
        }
        return response()->json($permission->save());
    }

    public function delete($id){
        $permission = $this->find($id);
        $permission = $permission->original;
        $exist = (array)$permission;
        if(!count($exist)){
            return response("Permiso no encontrado", 400);
        }
        return response()->json($permission->delete());
    }
}