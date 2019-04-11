<?php

namespace App\Http\Controllers;
use App\AccountStatus;
use Illuminate\Http\Request;
class AccountStatusController extends Controller{
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
            'name' => 'required|unique:accounts_status'
        ]);
    }

    public function getAll(){
        return response()->json(AccountStatus::all());
    }

    public function find($id){
        return response()->json(AccountStatus::find($id));
    }

    public function create(Request $request){
        $this->checkData($request);

        $account_status = new AccountStatus;
        $account_status->name = $request->name;
        
        return response()->json($account_status->save());
    }

    public function update(Request $request, $id){
        $account_status = $this->find($id);
        $account_status = $account_status->original;
        $exist = (array)$account_status;
        if(!count($exist)){
            return response("Status no encontrado", 400);
        }
        if(strtoupper($request->name)!=strtoupper($account_status->name)){
            $this->checkData($request);
            $account_status->name = $request->name;
        }
        return response()->json($account_status->save());
    }

    public function delete($id){
        $account_status = $this->find($id);
        $account_status = $account_status->original;
        $exist = (array)$account_status;
        if(!count($exist)){
            return response("Status no encontrado", 400);
        }
        return response()->json($account_status->delete());
    }
}
