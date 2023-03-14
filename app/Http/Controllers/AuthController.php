<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;
use Hash;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){

    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'user_type' =>'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    

        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
      

        if($request->is_social == true) {
           

            $email = User::where('email',$request['email'])->first();
           
            if($email)
            {
                $data = array(
                    'email' => $request['email'],
                    "password" => $request['password']
                );
 
                if (! $token = auth()->attempt($data)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
        
                return $this->createNewToken($token);
            
            }else{

                $add = $request->all();
                $add['password'] = Hash::make( $request['password']);
                $insert = User::create($add);
                $data = array(
                    'email' => $request['email'],
                    "password" => $request['password']
                );
 
                if (! $token = auth()->attempt($data)) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }
        
                return $this->createNewToken($token);
            }
 
        }else{

        
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:users',
                'password' => 'required|string|min:6',
                'password_confirmation' => 'required|string|same:password',
                
            ]);

            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }

            $user = User::create(array_merge(
                        $validator->validated(),
                        ['password' => Hash::make($request->password)],
                        ["user_type" => $request['user_type']],
                    ));
            $data = array(
                'email' => $request['email'],
                "password" => $request['password']
            );
 
            if (! $token = auth()->attempt($data)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        
            return $this->createNewToken($token);

            
        }
    }


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }


   

}
