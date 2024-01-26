<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function Register(Request $request){
        $validator = Validator::make($request->all(),[
            'fc_divisioncode' => 'required',
            'fc_branch' => 'required',
            'fc_userid' => 'required|unique:users',
            'fc_username' => 'required|unique:users',
            'fc_password' => 'required',
            'fc_groupuser' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 300,
                'message' => $validator->errors()->first()
            ]);
        }

        $insertdata = $request->all();

        $insertdata['fc_password'] = bcrypt($request->fc_password);
    }
}
