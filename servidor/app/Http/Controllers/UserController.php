<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $users = User::paginate();
        return response()->json($users, 200);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'documento' => 'required|max:20',
            'nombres' => 'required|string|max:255',
            'telefono' => 'required|max:15',
            'direccion' => 'required|max:255',
            'ciudad' => 'required|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3',
        ]);

        if($validator->fails()) return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
        $user = User::create(array_merge($validator->validate(), 
            [
                'password' => Hash::make($request->password),
            ]
        ));

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if(!$user) 
            return response()->json(['status'=> 'error', 'message'=> 'User not found'], 400);
        
        $validator = Validator::make($request->all(), [
            'documento' => 'required|max:20',
            'nombres' => 'required|string|max:255',
            'telefono' => 'required|max:15',
            'direccion' => 'required|max:255',
            'ciudad' => 'required|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:3',
        ]); 

        if($validator->fails()) 
            return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);

        $user->documento = $request->documento;
        $user->nombres   = $request->nombres;
        $user->telefono  = $request->telefono;
        $user->direccion = $request->direccion;
        $user->ciudad    = $request->ciudad;
        $user->email     = $request->email;
        $user->password  = Hash::make($request->password);

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }


}
