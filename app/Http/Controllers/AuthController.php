<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Teacher;
use App\Models\Guardian;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class AuthController extends Controller
{

       /**
     * @OA\Post(
     ** path="/api/login",
     *   tags={"Auth"},
     *   summary="login",
     *   operationId="getlogin",
     *
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *      name="password",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *      @OA\MediaType(
     *           mediaType="application/json",
     *      )
     *   ),
     *   @OA\Response(
     *      response=401,
     *       description="Unauthenticated"
     *   ),
     *   @OA\Response(
     *      response=400,
     *      description="Bad Request"
     *   ),
     *   @OA\Response(
     *      response=404,
     *      description="not found"
     *   ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden"
     *      )
     *)
     **/


    /**
     * Auth api
     *
     * @return \Illuminate\Http\Response
     */
    //

      /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $user = User::where('email', request(['email']))->where('user_status','=',0)->first();
        if ($user) {
            $user->user_status = 1; 
            $roleName = $user->getRoleNames(); 
            if ($roleName[0]=='teacher') {
                $teacher = Teacher::where('user_id', $user->id)->first();
                $teacher->user_status = 1; 
                $teacher->save();
            }
            if ($roleName[0]=='student') {
                $student = Student::where('user_id', $user->id)->first();
                $student->user_status = 1; 
                $student->save();
            }
            $user->save();
        }
        
        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        $user = User::find(auth()->user()->id);
        $user->permissions = $user->getPermissionsViaRoles();
        $user->roleNames = $user->getRoleNames(); 
        $roleName = $user->getRoleNames(); 

        if ($roleName[0]=='teacher') {
            $teacher = Teacher::with('grade')->with('subject')->where('user_id',$user->id)->first();
            if ($teacher->phone==null) {
                # code...
                if ($teacher->alternate_phone==null) {
                    $user->sendButton = 'disable'; 
                }
                
            }else{
                $user->sendButton = 'active'; 
            }
            $user->teacher = $teacher; 
        }
        if ($roleName[0]=='student') { 
            $student = Student::where('user_id',$user->id)->first();
            if (($student->phone==null)) {
                # code...
                $user->sendButton = 'disable'; 
            }else{
                $user->sendButton = 'active'; 
            }
            $user->student = $student; 
        }
        if ($roleName[0]=='parent') {
            $parent = Guardian::where('user_id',$user->id)->first();
            if (($parent->phone==null)) {
                # code...
                if ($parent->alternate_phone==null) {
                    $user->sendButton = 'disable'; 
                } 
            }else{
                $user->sendButton = 'active'; 
            }
            $user->parent = $parent; 
        }
    
        // $users = DB::table('users')
        //     ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
        //     ->join('role_has_permissions', 'model_has_roles.role_id', '=', 'role_has_permissions.role_id')
        //     ->join('roles', 'role_has_permissions.role_id', '=', 'roles.id')
        //     ->join('permissions', 'role_has_permissions.permission_id', '=', 'permissions.id')
        //     ->select('users.*','roles.name as roleName', 'permissions.name as permissionName')
        //     ->where('users.id',auth()->user()->id)
        //     ->get();
            return $user;
        // return response()->json($users);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout(true);
        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
