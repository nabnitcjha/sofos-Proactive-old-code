<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Student;
use App\Models\Student_Teacher;
use App\Models\Teacher;
use App\Models\Guardian;
use App\Models\Parent_students;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class userController extends Controller
{
    //
    /**
     * @OA\Post(
     ** path="/api/getUserList",
     *   tags={"User"},
     *   summary="Get UserList",
     *   operationId="getUserList",
     *security={{ "apiAuth": {} }},

     *  @OA\Parameter(
     *      name="userType",
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
     * User api
     *
     * @return \Illuminate\Http\Response
     */
    //
    
    public function getStudentAndParentList(Request $request)
    {
        $studentIds = Student_Teacher::where('teacher_id',$request->teacher_id)->groupBy('student_id')->pluck('student_id');
        $parentIds = Parent_students::whereIn('student_id',$studentIds)->groupBy('parent_id')->pluck('parent_id');
        $admin = User::where('id',1)->first();

        $students = Student::whereIn('id',$studentIds)->get();
    //    return $students;
        foreach ($students as $key => $value) {
            if (($value->phone==null)) {
                # code...
                $value->sendButton = 'disable'; 
            }else{
                $value->sendButton = 'active'; 
            }
        }
        $parents = Guardian::whereIn('id',$parentIds)->get();
        foreach ($parents as $key => $value) {
            if (($value->phone==null)) {
                # code...
                if ($value->alternate_phone==null) {
                    # code...
                    $value->sendButton = 'disable'; 
                }
                
            }else{
                $value->sendButton = 'active'; 
            }
        }

        return array(
            "status"  => "ok",
            "message" => "fetch success",
            "students"  => $students,
            "parents"  => $parents,
            "admin"   => $admin
        );
    }

    public function getAllUserList()
    {
        $authorizedRoles = ['teacher', 'student', 'parent'];
        
        $user = User::whereHas(
            'roles', function($q) use($authorizedRoles){
                $q->whereIn('name', $authorizedRoles);
            }
        )
        
        ->with(['roles' => function($role)  use($authorizedRoles) {
            $role->whereIn('name', $authorizedRoles);
        }])
        
        ->with('teacher')->with('student')->with('parent')->where('first_name','<>',null)->get();
        return array(
            "status"  => "ok",
            "message" => "fetch success",
            "result"  => $user
        );
    }


    public function getUserList(Request $request)
    {
        $myId =  Auth::user();
        if ($request->userType == 'teacher') {
            # code...
            $users = Student::where('user_id', '<>', $myId->id)->get();
        } else {
            $users = Teacher::where('user_id', '<>', $myId->id)->get();
        }

        // $users = User::where('id','<>',$myId->id)->get();
        return response()->json(compact('users'));
    }

    public function getRoles()
    {
        return Role::where('name', '<>', 'admin')->get();
    }


    public function getPermissions()
    {
        return Permission::all();
    }
    public function getRoleHasPermissions()
    {
        return  DB::table('role_has_permissions')->get();
    }
    public function savePermissions(Request $request)
    {
        //  return $request->all();
        $keep = DB::table('role_has_permissions')->where('role_id', 1)->groupBy('role_id')
        ->pluck('role_id');
        DB::table('role_has_permissions')->whereNotIn('role_id',  $keep)->delete();
        foreach ($request->all() as $key => $value) {
            $role = Role::findByName($value['role']);
            if ($role) {
                foreach ($value['permissions'] as $key => $val) {
                    $role->givePermissionTo($val);
                }
            }
        }
        return 'permission saved successfully';
        //$role->givePermissionTo('edit articles');
        //$role = Role::findByName('writer');
    }

    public function activateAccount(Request $request)
    {
        $user = User::where('verify_token', $request->token)->first();
        $teacher = Teacher::where('user_id', $user->id)->first();
        $student = Student::where('user_id', $user->id)->first();
        // $parent = Guardian::where('user_id', $user->id)->first();
        if ($user) {
            $user->password = bcrypt($request->password);
            $user->user_status = 1;
            $user->verify_token = null;
            $user->save();
        }
        if ($teacher) {
            $teacher->user_status = 1;
            $teacher->save();
        }
        if ($student) {
            $student->user_status = 1;
            $student->save();
        }
        return response()->json(compact('user'));
    }

    public function updateStudentProfile(Request $request)
    {

           $user = User::where('id', auth()->user()->id)->first();
           $user->name = $request->name;
           $user->password = bcrypt($request->password);
           $user->save();
           return array(
               "status"  => "ok",
               "message" => "Stored",
               "result"  => $user
           );
    }

    
    public function updateTeacherProfile(Request $request)
    {

           $user = User::where('id', auth()->user()->id)->first();
           $user->name = $request->name;
           $user->password = bcrypt($request->password);
           $user->save();
           return array(
               "status"  => "ok",
               "message" => "Stored",
               "result"  => $user
           );
    }

    public function updateAdminProfile(Request $request)
    {

           $user = User::where('id', auth()->user()->id)->first();
           $user->name = $request->name;
           $user->password = bcrypt($request->password);
           $user->save();
           return array(
               "status"  => "ok",
               "message" => "Stored",
               "result"  => $user
           );
    }
}
