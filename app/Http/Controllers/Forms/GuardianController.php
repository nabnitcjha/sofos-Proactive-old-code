<?php

namespace App\Http\Controllers\Forms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Forms\BaseController;
use App\Models\Student;
use App\Models\Parent_students;
use App\Models\User;
use App\Models\Guardian;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;


class GuardianController extends BaseController
{
     /**
      * * @OA\Get(
 *     path="/api/getParents",
 *     tags={"Parent"},
     *   summary="Get Parent",
     *   operationId="getParent",
     * security={{ "apiAuth": {} }},
 *     @OA\Response(
     *      response=201,
     *       description="Success",
     *
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
 * )
 *
 *
 * * * @OA\Get(
 *     path="/api/getParent/{id}",
 *     tags={"Parent"},
     *   summary="Get Parent",
     *   operationId="getParent",
     * security={{ "apiAuth": {} }},
     *
     *   @OA\Parameter(
     *      name="id",
     *      in="path",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
 *     @OA\Response(
     *      response=201,
     *       description="Success",
     *
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
 * )
 *
 *
 *
     * @OA\Post(
     ** path="/api/addParent",
     *   tags={"Parent"},
     *   summary="Add Parent",
     *   operationId="addParent",
     *security={{ "apiAuth": {} }},

     *  @OA\Parameter(
     *      name="full_name",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *  @OA\Parameter(
     *      name="email",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     * @OA\Parameter(
     *      name="country",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     * @OA\Parameter(
     *      name="address",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *
     * @OA\Parameter(
     *      name="city",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *
     * @OA\Parameter(
     *      name="state",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *
     * @OA\Parameter(
     *      name="zip",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *   @OA\Parameter(
     *       name="phoneNumber",
     *      in="query",
     *      required=true,
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     * @OA\Parameter(
     *      name="user_image",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
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
     * @OA\Post(
     ** path="/api/updateParent",
     *   tags={"Parent"},
     *   summary="Update Parent",
     *   operationId="updateParent",
     *security={{ "apiAuth": {} }},

     *  @OA\Parameter(
     *      name="id",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *
     *   @OA\Response(
     *      response=201,
     *       description="Success",
     *
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
     * @OA\Post(
     ** path="/api/deleteParent",
     *   tags={"Parent"},
     *   summary="Delete Parent",
     *   operationId="deleteParent",
     *security={{ "apiAuth": {} }},
     
     *  @OA\Parameter(
     *      name="id",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
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
     * Parent api
     *
     * @return \Illuminate\Http\Response
     */
    //
    public $model_name = "App\Models\Guardian";

    public function getParents(){
        return parent::index(0);
    }

    public function getParent($id){
        $studentIds = Parent_students::where('parent_id',$id)->groupBy('student_id')->pluck('student_id');
        $parentIds = Parent_students::whereIn('student_id',$studentIds)->groupBy('parent_id')->pluck('parent_id');
        $parents =   Guardian::whereIn('id',$parentIds)->get();
        return array(
            "status"  => "ok",
            "message" => "success",
            "result" => $parents
        );
    }

    public function addParent(Request $request){
        $studentIds = Parent_students::where('parent_id',$request->parent_id)->groupBy('student_id')->pluck('student_id');
        
        foreach ($studentIds as $stdId) {
            foreach ($request->dynamic_parent_list as $key => $value) {
                $user = new User();
                $user->first_name = $value['first_name'];
               $user->last_name = $value['last_name'];
               $user->name = $value['first_name'].' '.$value['last_name'];
                if ($value['email']!="") {
                    $user->email = $value['email'];
                    $dynamicPassword = Str::random($length = 10);
                    $user->password = bcrypt($dynamicPassword);
                    $token = random_bytes(8);
                    $token = bin2hex($token);
                    $user->verify_token = $token;
                }
              
                $user->save();
                $role = Role::findByName('parent');
                if ($role) {
                  $user->assignRole($role);
                }
    
                $guardian = new Guardian();
    
                $guardian->first_name=$value['first_name'];
                $guardian->last_name=$value['last_name'];
                $guardian->phone=$value['phone'];
                $guardian->email=$value['email'];
                $guardian->user_id = $user->id;
      
                $guardian->address=$value['address'];
                $guardian->country=$value['country'];
                $guardian->state=$value['state'];
                $guardian->save();
                if ($value['email']!="") {
                    dispatch(new \App\Jobs\AccountActivate($user,$dynamicPassword)); 
               }
                $parent_student = new Parent_students();
                $parent_student->student_id = $stdId;
                $parent_student->parent_id = $guardian->id;
                $parent_student->save();
    
            }
        }
      

          return array(
            "status"  => "ok",
            "message" => "Stored"
        );
    }

    public function addParentFromDetail(Request $request){
        // $request->student_id
        
        foreach ($request->dynamic_parent_list as $key => $value) {
            $user = new User();
            $user->first_name = $value['first_name'];
           $user->last_name = $value['last_name'];
           $user->name = $value['first_name'].' '.$value['last_name'];
            if ($value['email']!="") {
                $user->email = $value['email'];
                $dynamicPassword = Str::random($length = 10);
                $user->password = bcrypt($dynamicPassword);
                $token = random_bytes(8);
                $token = bin2hex($token);
                $user->verify_token = $token;
            }
          
            $user->save();
            $role = Role::findByName('parent');
            if ($role) {
              $user->assignRole($role);
            }

            $guardian = new Guardian();

            $guardian->first_name=$value['first_name'];
            $guardian->last_name=$value['last_name'];
            $guardian->phone=$value['phone'];
            $guardian->email=$value['email'];
            $guardian->user_id = $user->id;
  
            $guardian->address=$value['address'];
            $guardian->country=$value['country'];
            $guardian->state=$value['state'];
            $guardian->save();
            if ($value['email']!="") {
                dispatch(new \App\Jobs\AccountActivate($user,$dynamicPassword)); 
           }
            $parent_student = new Parent_students();
            $parent_student->student_id = $request->student_id;
            $parent_student->parent_id = $guardian->id;
            $parent_student->save();

        }
          return array(
            "status"  => "ok",
            "message" => "Stored"
        );
    }
    
    public function updateParent(Request $request,$id){
        return parent::update($request,$id);
    }

    public function deleteParent(Request $request){
        $parent = Guardian::find($request->id);
        User::where('id','=',$parent->user_id)->delete();
        return parent::destroy($request->id);
    }
}
