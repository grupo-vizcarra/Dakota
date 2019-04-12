<?php

namespace App\Http\Controllers;
use App\TaskType;
use Illuminate\Http\Request;
class TaskTypeController extends Controller{
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
            'name' => 'required|unique:task_types'
        ]);
    }

    public function getAll(){
        return response()->json(TaskType::all());
    }

    public function find($id){
        return response()->json(TaskType::find($id));
    }

    public function create(Request $request){
        $this->checkData($request);

        $task_type = new TaskType;
        $task_type->name = $request->name;
        
        return response()->json($task_type->save());
    }

    public function update(Request $request, $id){
        $task_type = $this->find($id);
        $task_type = $task_type->original;
        $exist = (array)$task_type;
        if(!count($exist)){
            return response("Tarea no encontrada", 400);
        }
        if(strtoupper($request->name)!=strtoupper($task_type->name)){
            $this->checkData($request);
            $task_type->name = $request->name;
        }
        return response()->json($task_type->save());
    }

    public function delete($id){
        $task_type = $this->find($id);
        $task_type = $task_type->original;
        $exist = (array)$task_type;
        if(!count($exist)){
            return response("Tarea no encontrada", 400);
        }
        return response()->json($task_type->delete());
    }
}