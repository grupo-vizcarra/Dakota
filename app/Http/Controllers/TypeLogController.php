<?php

namespace App\Http\Controllers;
use App\TypeLog;
use Illuminate\Http\Request;
class TypeLogController extends Controller{
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
            'name' => 'required|unique:type_log'
        ]);
    }

    public function getAll(){
        return response()->json(TypeLog::all());
    }

    public function find($id){
        return response()->json(TypeLog::find($id));
    }

    public function create(Request $request){
        $this->checkData($request);

        $type_log = new TypeLog;
        $type_log->name = $request->name;
        
        return response()->json($type_log->save());
    }

    public function update(Request $request, $id){
        $type_log = $this->find($id);
        $type_log = $type_log->original;
        $exist = (array)$type_log;
        if(!count($exist)){
            return response("Type log no encontrado", 400);
        }
        if(strtoupper($request->name)!=strtoupper($type_log->name)){
            $this->checkData($request);
            $type_log->name = $request->name;
        }
        return response()->json($type_log->save());
    }

    public function delete($id){
        $type_log = $this->find($id);
        $type_log = $type_log->original;
        $exist = (array)$type_log;
        if(!count($exist)){
            return response("Type log no encontrado", 400);
        }
        return response()->json($type_log->delete());
    }
}
