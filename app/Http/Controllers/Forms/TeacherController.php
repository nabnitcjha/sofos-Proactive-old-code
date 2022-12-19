<?php

namespace App\Http\Controllers\Forms;

use App\Models\User;
use App\Models\Teacher;
use App\Models\TeacherNotes;
use App\Models\GradeTeacher;
use App\Models\Subject_Teacher;
use App\Models\Grade;
use App\Models\TimeTable;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Forms\BaseController;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TeacherController extends BaseController
{
    //

    /**
      * * @OA\Get(
 *     path="/api/getTeachers",
 *     tags={"Teacher"},
     *   summary="Get Teacher",
     *   operationId="getTeacher",
     * security={{ "apiAuth": {} }},
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
 * * * @OA\Get(
 *     path="/api/getTeacher/{id}",
 *     tags={"Teacher"},
     *   summary="Get Teacher",
     *   operationId="getTeacher",
     *security={{ "apiAuth": {} }},

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
     ** path="/api/addTeacher",
     *   tags={"Teacher"},
     *   summary="Add Teacher",
     *   operationId="addTeacher",
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
     ** path="/api/updateTeacher",
     *   tags={"Teacher"},
     *   summary="Update Teacher",
     *   operationId="updateTeacher",
     *
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
     ** path="/api/deleteTeacher",
     *   tags={"Teacher"},
     *   summary="Delete Teacher",
     *   operationId="deleteTeacher",
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
     * @OA\Post(
     ** path="/api/uploadTeacherImage",
     *   tags={"Teacher"},
     *   summary="Upload Teacher Image",
     *   operationId="UploadTeacherImage",
     *security={{ "apiAuth": {} }},
     
     *  @OA\Parameter(
     *      name="id",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *  @OA\Parameter(
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
     * Teacher api
     *
     * @return \Illuminate\Http\Response
     */
    //

    public $model_name = "App\Models\\Teacher";

    public function getTeachers(Request $request)
    { 
        $result = Teacher::with(['grade'=>function($q){
            $q->select('grade.id','grade.name');
        }])
        ->with(['subject'=>function($q){
            $q->select('subject.id','subject.name');
        }])->orderBy('id', 'desc')->paginate(5);
        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $result
        );
     //   return parent::index($request);
    }

    public function getTeacher($id) 
    {
        $teacher = Teacher::with(['grade'=>function($q){
            $q->select('grade.id','grade.name');
        }])
        ->with(['subject'=>function($q){
            $q->select('subject.id','subject.name');
        }])
        ->where('id','=',$id)->get();
        
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher
        ); 

        // return parent::show($id);
    }

    //get subject according to teacher
    public function getTeacherSubject(Request $request){
        $teacher_data = TimeTable::where('teacher_id', $request->teacher_id)->get(); //geting current teacher from timetable
        
        $subject_data = [];
        foreach($teacher_data as $teacher_info){
            $subject_data[] = $teacher_info->subject_id;
        }
        $d = array_unique($subject_data);

        $subject_info = Subject::whereIn('id', $subject_data)->get();
        // dd($subject_info);
        

        return array(
            "status"  => "ok",
            "result" => $subject_info
        );

    }

     //get  teacher according to subject
     public function getSubjectTeacher(Request $request){
        $subject = Subject::where('id',$request->subject_id)->first();
        $teacherIds = TimeTable::where('subject_id', $request->subject_id)->groupBy('session_id')->pluck('teacher_id'); 
        $teacher_info = Teacher::whereIn('id', $teacherIds)->get();
        // dd($teacher_info);
        return array(
            "status"  => "ok",
            "teachers" => $teacher_info,
            "subject" => $subject
        );

    }
    public function getTeacherNote($id) 
    {
        $teacher_note = TeacherNotes::where('id','=',$id)->first();
        
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher_note
        ); 
    }
    public function getTeacherNotes(Request $request)  
    {
        $teacher_notes = TeacherNotes::with('teacher')->where('timetable_id','=',$request->timetable_id)->where('teacher_id','=',$request->teacher_id)->get();
        
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher_notes
        ); 
    }
    public function getTeacherAllNotes(Request $request) 
    {
        $session = TimeTable::where('id', $request->timetable_id)->first();
        $teacher_notes = [];
        if ($request->mode=='student') {
            # code...
            $teacher_notes = TeacherNotes::where('teacher_id','=',$request->teacher_id)->where('session_id','=',$session->session_id)
            ->where('access_type','public')->get();
        }else {
            $teacher_notes = TeacherNotes::where('teacher_id','=',$request->teacher_id)->where('session_id','=',$session->session_id)->get();
        }
      
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher_notes
        ); 
    }
    public function addTeacherNote(Request $request){
        $session = TimeTable::where('id', $request->timetable_id)->first();
        if ($request->mode=='edit') {
            $teacher_notes = TeacherNotes::where('id','=',$request->id)->first();
        }else{
            $teacher_notes = new TeacherNotes();
        }
        
        $teacher_notes->notes = $request->notes;
        $teacher_notes->timetable_id = $request->timetable_id;
        $teacher_notes->teacher_id = $request->teacher_id;
        $teacher_notes->access_type = $request->access_type;
        $teacher_notes->session_id = $session->session_id;
        $teacher_notes->save();
        return array(
            "status"  => "ok",
            "message" => "teacher note save successfully"
        ); 
    }
    public function deleteTeacherNotes(Request $request)
    {
        $teacher_note = TeacherNotes::where('id','=',$request->id)->delete();
        
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher_note
        ); 
    }
    
    public function addTeacher(Request $request)
    {
       
        $validator =  Validator::make(
            $request->all(),
            [
                'teacher_first_name' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->getError($validator->errors()->all());
        }

        $user = new User();
          $user->first_name = $request->teacher_first_name;
          $user->last_name = $request->teacher_last_name;
          $user->name = $request->teacher_first_name.' '.$request->teacher_last_name;
        if ($request->teacher_email!="") {
            $user->email = $request->teacher_email;
        
            $dynamicPassword = Str::random($length = 10);
            $user->password = bcrypt($dynamicPassword);
            $token = random_bytes(8);
            $token = bin2hex($token);
            $user->verify_token = $token;
        }
       

        $user->save();
        $role = Role::findByName('teacher');
        if ($role) {
          $user->assignRole($role);
        }


          $teacher = new Teacher();
          $teacher->first_name=$request->teacher_first_name;
        //   $teacher->middle_name=$request->teacher_middle_name;
          $teacher->last_name=$request->teacher_last_name;

        //   $teacher->gender=$request->teacher_gender;
        //   $teacher->DOB=$request->teacher_dob;
         
          $teacher->email=$request->teacher_email;
        //   $teacher->religion = $request->teacher_religion;
          $teacher->user_id = $user->id;
         
          if ($image = $request->file('teacher_image')) {
            $groupId = 0;
            $uploadGroupId = $this->manageUploads($image, $savepath = 'teacher', $groupId); 
            $teacher->teacher_image = $uploadGroupId;
      
            $user = User::where('id', $user->id)->first();
            $user->user_image = $uploadGroupId;
            $user->save();
        }



          $teacher->address=$request->teacher_address;
          $teacher->address2=$request->teacher_address2;
          $teacher->country=$request->teacher_country;
          $teacher->state=$request->teacher_state;        
          $teacher->zip=$request->teacher_zip;
          $teacher->phone=$request->teacher_phone;
          $teacher->alternate_phone=$request->teacher_alternate_phone;
        //   $teacher->highest_degree = $request->teacher_highest_degree;
          
        //   $teacher->university=$request->teacher_collage;
        //   $teacher->year_passed=$request->teacher_year_passed;
        //   $teacher->cgpa=$request->teacher_cgpa;
        //   $teacher->other_degree=$request->teacher_other_degree;
        //   $teacher->other_university=$request->teacher_other_collage;
        //   $teacher->other_year_passed=$request->teacher_other_year_passed;
        //   $teacher->other_cgpa = $request->teacher_other_cgpa;
          $teacher->save();
          
        //   foreach ($request->selectedGrades as $key => $value) {
        //       $gradeteacher = new GradeTeacher();
        //       $gradeteacher->grade_id = $value['id'];
        //       $gradeteacher->teacher_id = $teacher->id;
        //       $gradeteacher->save();
        //   }
        if ($request->teacher_email!="") {
            dispatch(new \App\Jobs\AccountActivate($user,$dynamicPassword)); 
        }

         
          return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $teacher
        );
        // return parent::store($request);
    }
    public function addTeacherGradeAndSubject(Request $request){

        foreach ($request->teacher_selectedSubjects as $key => $value) {
            $subject_teacher = new Subject_Teacher();
            $subject_teacher->subject_id = $value['id'];
            $subject_teacher->teacher_id = $request->teacher_id;
            $subject_teacher->save();
        }

        foreach ($request->teacher_selectedGrade as $key => $val) {
            $grade_teacher = new GradeTeacher();
            $grade_teacher->grade_id = $val['id'];
            $grade_teacher->teacher_id = $request->teacher_id;
            $grade_teacher->save();
        }

        return array(
            "status"  => "ok",
            "message" => "Stored"
        );
    }
    public function allActiveTeachers(Request $request){
        $teacher = Teacher::with('user')->where('user_status','>',0)->paginate(20);
        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $teacher
        );
    }

    public function updateTeacherContact(Request $request) 
    {
        $teacher = Teacher::where('id',$request->teacher_id)->first();
        $teacher->address=$request->address;
        $teacher->phone=$request->phone;
        $teacher->save();
        
        return array(
            "status"  => "ok",
            "message" => "update successfully",
            "result"  => $teacher
        );
        // return parent::update($request, $id);
    }
   
    public function updateTeacher(Request $request) 
    {

        $teacher = Teacher::where('id',$request->teacher_id)->first();
        $teacherOldEmail = $teacher->email;
        $user =User::where('id',$teacher->user_id)->first();
        $user->first_name = $request->teacher_first_name;
          $user->last_name = $request->teacher_last_name;
          $user->name = $request->teacher_first_name.' '.$request->teacher_last_name;
        
         
        $teacher->first_name=$request->teacher_first_name;
        $teacher->middle_name=$request->teacher_middle_name;
        $teacher->last_name=$request->teacher_last_name;

        $teacher->gender=$request->teacher_gender;
        $teacher->DOB=$request->teacher_dob;
        
        

        $teacher->email=$request->teacher_email;
        if ($request->teacher_email!="" && $teacherOldEmail=="") {
            // return '1st-if-old-email ='.$teacherOldEmail .' and teacher-email = '. $request->teacher_email;
            $user->email = $request->teacher_email;
            $dynamicPassword = Str::random($length = 10);
            $user->password = bcrypt($dynamicPassword);
            $token = random_bytes(8);
            $token = bin2hex($token);
            $user->verify_token = $token;
       }else{
        if ($request->teacher_email!="" && $teacherOldEmail!=$request->teacher_email) {
            // return 'else-part-old-email ='.$teacherOldEmail .' and teacher-email = '. $request->teacher_email;
            $user->email = $request->teacher_email;
            $dynamicPassword = Str::random($length = 10);
            $user->password = bcrypt($dynamicPassword);
            $token = random_bytes(8);
            $token = bin2hex($token);
            $user->verify_token = $token;
       }
       }
       $user->save();
        $teacher->religion = $request->teacher_religion;
        $teacher->user_id = $user->id;
       
        if ($image = $request->file('teacher_image')) {
          $groupId = 0;
          $uploadGroupId = $this->manageUploads($image, $savepath = 'teacher', $groupId);
          $teacher->teacher_image = $uploadGroupId;
    
          $user = User::where('id', $user->id)->first();
          $user->user_image = $uploadGroupId;
          $user->save();
      }



        $teacher->address=$request->teacher_address;
        $teacher->address2=$request->teacher_address2;
        $teacher->country=$request->teacher_country;
        $teacher->state=$request->teacher_state;        
        $teacher->zip=$request->teacher_zip;
        $teacher->phone=$request->teacher_phone;
        $teacher->alternate_phone=$request->teacher_alternate_phone;
        $teacher->highest_degree = $request->teacher_highest_degree;
        
        $teacher->university=$request->teacher_collage;
        $teacher->year_passed=$request->teacher_year_passed;
        $teacher->cgpa=$request->teacher_cgpa;
        $teacher->other_degree=$request->teacher_other_degree;
        $teacher->other_university=$request->teacher_other_collage;
        $teacher->other_year_passed=$request->teacher_other_year_passed;
        $teacher->other_cgpa = $request->teacher_other_cgpa;
        $teacher->save();
          
        //   $grdTeacher=GradeTeacher::where('teacher_id',$id)->delete();

        // foreach ($request->selectedGrades as $key => $value) {
        //     $gradeteacher = new GradeTeacher();
        //     $gradeteacher->grade_id = $value['id'];
        //     $gradeteacher->teacher_id = $teacher->id;
        //     $gradeteacher->save();
        // }
        if ($request->teacher_email!="" && $teacherOldEmail=="") {
            dispatch(new \App\Jobs\AccountActivate($user,$dynamicPassword)); 
       }else{
            if ($request->teacher_email!="" && $teacherOldEmail!=$request->teacher_email) {
                dispatch(new \App\Jobs\AccountActivate($user,$dynamicPassword)); 
        }
       }
        
        
        return array(
            "status"  => "ok",
            "message" => "update successfully",
            "result"  => $teacher
        );
        // return parent::update($request, $id);
    }

    /*update teacher password*/
    public function updateTeacherPassword(Request $request){
        //dd($request);
        $teacher_user = Teacher::where('id', $request->teacher_id)->first();
        $user = User::where('id', $teacher_user->user_id)->first();
        //dd($user);
        $user->name = $request->name;
        $user->password = bcrypt($request->password);
        $user->save();
        return array(
           "status"  => "ok",
           "message" => "Stored",
           "result"  => $user
        );

    }
    public function teacherAccordingSubject(Request $request){
       $teacherIDS = Subject_Teacher::where('subject_id',$request->subject_id)->pluck('teacher_id');
       $teachers = Teacher::whereIn('id', $teacherIDS)
       ->get();

    //    foreach ($request->teacher_selectedSubjects as $key => $value) {
    //         $subject_teacher = new Subject_Teacher();
    //         $subject_teacher->subject_id = $value['id'];
    //         $subject_teacher->teacher_id = $request->teacher_id;
    //         $subject_teacher->save();
    //     }

        return array(
            "status"  => "ok",
            "result" => $teachers
        );
    }
    public function updateTeacherSubject(Request $request){
        DB::table('subject_teacher')->where('teacher_id',$request->teacher_id)->delete();
        // DB::table('gradeteacher')->where('teacher_id',$request->teacher_id)->delete();
        foreach ($request->teacher_selectedSubjects as $key => $value) {
            $subject_teacher = new Subject_Teacher();
            $subject_teacher->subject_id = $value['id'];
            $subject_teacher->teacher_id = $request->teacher_id;
            $subject_teacher->save();
        }

        // foreach ($request->teacher_selectedGrade as $key => $val) {
        //     $grade_teacher = new GradeTeacher();
        //     $grade_teacher->grade_id = $val['id'];
        //     $grade_teacher->teacher_id = $request->teacher_id;
        //     $grade_teacher->save();
        // }

        return array(
            "status"  => "ok",
            "message" => "Stored"
        );
    }
    public function deleteTeacher(Request $request)
    {
        $teacher = Teacher::find($request->id);
        User::where('id','=',$teacher->user_id)->delete();

        // teacher notes delete
        DB::table('teacher_notes')->where('teacher_id',$request->id)->delete();

        // teacher session delete
        DB::table('timetable')->where('teacher_id',$request->id)->delete();
        
        DB::table('student_teachers')->where('teacher_id',$request->id)->delete();

        return parent::destroy($request->id);
    }
    
    public function getSubjectAccordingGrade(Request $request)
    {
        $subjects = array();
        $i=0;
        foreach ($request->grade_ids as $key => $value) {
            $grade = Grade::with(['subject' => function($query){
                $query->select("subject.id","subject.name");
            }])->where('id', $value)->first();

            foreach ($grade->subject as $key => $val) {
                # code...
                if (count($subjects)>0) {
                    # code...
                    $allow = true;
                    foreach ($subjects as $key => $v) {
                        # code...
                        if ($v['name']==$val['name']) {
                            # code...
                            $allow = false;
                        }
                    }
                    if ($allow) {
                        # code...
                        $subjects[$i] = $val;
                        $i = $i + 1;
                    }
                }else{
                    $subjects[$i] = $val;
                    $i = $i + 1;
                }
               
            }
        }
        
        return array(
            "status"  => "ok",
            "message" => "update successfully",
            "result"  => $subjects
        );

        
    }
    public function uploadTeacherImage(Request $request)
    {
        if (isset($request->id)) {
            $teacher =Teacher::find($request->id);
            if ($image = $request->file('userImage')) {
            $groupId = $teacher->teacher_image == 0 ? '' : $teacher->teacher_image;
            $uploadGroupId = $this->manageUploads($image, $savepath = 'teacher', $groupId);
            $teacher->teacher_image = $uploadGroupId;
            // $teacher->image_url = $request->imageURL;
            $teacher->save();
            $user = User::where('id', $teacher->user_id)->first();
            $user->user_image = $uploadGroupId;
            // $user->image_url = $request->imageURL;
            $user->save();
        }
        return response()->json(compact('teacher'));
        }
        return response()->json(compact('not uploaded'));
    }
}
