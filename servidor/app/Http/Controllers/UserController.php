<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => ['register']]);
        $this->middleware('can:sale.show', ['only'=> ['show', 'list']]);
        $this->middleware('sl.permission', ['only'=> ['create']]);
        $this->middleware('can:sale.delete', ['only'=> ['delete']]);
    }
    
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
        ]); 

        if($validator->fails()) 
            return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);

        $user->documento = $request->documento;
        $user->nombres   = $request->nombres;
        $user->telefono  = $request->telefono;
        $user->direccion = $request->direccion;
        $user->ciudad    = $request->ciudad;
        $user->email     = $request->email;

        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User updated successfully',
            'user' => $user
        ], 200);
    }

    public function changePassword(Request $request, $id)
    {
        $user = User::find($id);
        if(!$user)
            return response()->json(['status'=> 'error', 'message'=> 'User not found'], 400); 

        $validator = Validator::make($request->all(), [
            'cur_password' => 'required|min:3',
            'new_password' => 'required|min:3',
        ]);

        if($validator->fails()) return response()->json(['message' => 'Field validation failed: '.$validator->errors()->toJson()],400);
        
        if(!Hash::check($request->cur_password, $user->password))
            return response()->json(['status'=> 'error', 'message'=> 'Contraseña actual incorrecta'], 400); 

        if($request->new_password != $request->confirm_password)
            return response()->json(['status'=> 'error', 'message'=> 'Las contraseñas no coinciden'], 400); 

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Contraseña actualizada exitosamente',
        ], 200);
    }


}
