<?php

namespace App\Http\Controllers;
use App\AccountData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountDataController extends Controller{
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
            'names' => 'required|max:60',
            'first_name' => 'required|max:60',
            'last_name' => 'max:60',
            'birthdate' => 'date',
            'photo' => 'mimes:jpeg,jpg,png'
        ]);
    }

    public function getAll(){
        return response()->json(AccountData::all());
    }

    public function find($id){
        return response()->json(AccountData::find($id));
    }

    public function create(Request $request){
        $this->checkData($request);

        $account_data = new AccountData;
        $account_data->names = $request->names;
        $account_data->first_name = $request->first_name;
        $account_data->last_name = $request->last_name;
        $account_data->birthdate = $request->birthdate;
        $account_data->key = time();
        if ($request->hasFile('photo')) {
            $fileName =  time().'.png';
            $destinationPath = __DIR__.'./photos';
            $account_data->photo = $fileName;
            $request->file('photo')->move($destinationPath, $fileName);
        }
        $save = $account_data->save();
        if($save){
            $account_data->key = Hash::make(env('TIENDA').$account_data->id);
        }
        return response()->json($account_data->save());
    }

    public function update(Request $request, $id){
        $account_data = $this->find($id);
        $account_data = $account_data->original;
        $exist = (array)$account_data;
        if(!count($exist)){
            return response("Cuenta no encontrada", 400);
        }
        $this->checkData($request);
        $account_data->names = $request->names;
        $account_data->first_name = $request->first_name;
        $account_data->last_name = $request->last_name;
        $account_data->birthdate = $request->birthdate;
        if ($request->hasFile('photo')) {
            $fileName =  time().'.png';
            $destinationPath = __DIR__.'./photos';
            $account_data->photo = $fileName;
            $request->file('photo')->move($destinationPath, $fileName);
        }
        return response()->json($account_data->save());
    }

    public function delete($id){
        $account_data = $this->find($id);
        $account_data = $account_data->original;
        $exist = (array)$account_data;
        if(!count($exist)){
            return response("Cuenta no encontrada", 400);
        }
        return response()->json($account_data->delete());
    }
}
