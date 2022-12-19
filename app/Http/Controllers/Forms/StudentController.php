<?php

namespace App\Http\Controllers\Forms;

use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\TeacherNotes;
use App\Models\Assessment;
use App\Models\AllotedClasses;
use App\Models\Guardian;
use App\Models\StudentNotes;
use App\Jobs\SendEmailTest;

use Auth;

use Illuminate\Http\Request;
use App\Models\Parent_students;
use App\Models\Student_Subject;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Forms\BaseController;
use Illuminate\Support\Str;

class StudentController extends BaseController
{
    //

    /**
     *
     *
     *
     * * @OA\Get(
     *     path="/api/getStudents",
     *     tags={"Student"},
     *   summary="Get Student",
     *   operationId="getStudent",
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
     *
     * * * @OA\Get(
     *     path="/api/getStudent/{id}",
     *     tags={"Student"},
     *   summary="Get Student",
     *   operationId="getStudent",
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
     ** path="/api/addStudent",
     *   tags={"Student"},
     *   summary="Add Student",
     *   operationId="addStudent",
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
     ** path="/api/updateStudent",
     *   tags={"Student"},
     *   summary="Update Student",
     *   operationId="updateStudent",
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
     ** path="/api/deleteStudent",
     *   tags={"Student"},
     *   summary="Delete Student",
     *   operationId="deleteStudent",
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
     ** path="/api/uploadStudentImage",
     *   tags={"Student"},
     *   summary="Upload Student Image",
     *   operationId="UploadStudentImage",
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
     * Student api
     *
     * @return \Illuminate\Http\Response
     */
    //

    public $model_name = "App\Models\Student";

    public function allActiveStudents(Request $request)
    {
        $student = Student::with('user')->where('user_status', '>', 0)->paginate(20);
        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $student
        );
    }
    public function getStudents(Request $request)
    {
        // $user = auth()->user();
        // $user->assignRole('student');
        // $role = Role::create(['name' => 'student']);
        // $permission = Permission::create(['name' => 'edit articles']);
        // return parent::index($request);
        $result = Student::with('parent')->with('teacher')->with('grade')->with('subject')->orderBy('id', 'desc')->paginate(5);
        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $result
        );
    }
    public function deleteStudentNotes(Request $request)
    {
        $student_note = StudentNotes::where('id', '=', $request->id)->delete();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $student_note
        );
    }
    public function getStudentNotes(Request $request)
    {
        $student_notes = TeacherNotes::where('timetable_id', '=', $request->timetable_id)
            ->where('teacher_id', '=', $request->teacher_id)
            ->where('access_type', '=', 'public')
            ->get();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $student_notes
        );
    }

    public function studentEnableStatus(Request $request)
    {
        $student = Student::where('id', '=', $request->student_id)->first();
        $student->isEnable = $request->status;
        $student->save();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $student
        );
    }
    public function teacherEnableStatus(Request $request)
    {
        $teacher = Teacher::where('id', '=', $request->teacher_id)->first();
        $teacher->isEnable = $request->status;
        $teacher->save();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher
        );
    }

    public function getStudentAssessment(Request $request)
    {
        $gradeIds = AllotedClasses::where('student_id', $request->student_id)->pluck('grade_id');
        $assessments = Assessment::with('grade')->with('assessmentsolution')->whereIn('grade_id', $gradeIds)
            ->where('assessment_type', 2)
            ->get();

        foreach ($assessments as $key => $value) {
            # code...
            $value->assessmentFile = $this->getFile($value->assessment_file);
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $assessments
        );
    }

    public function addStudentNote(Request $request)
    {
        if ($request->mode == 'edit') {
            $student_notes = StudentNotes::where('id', '=', $request->id)->first();
        } else {
            $student_notes = new StudentNotes();
        }

        $student_notes->notes = $request->notes;
        $student_notes->timetable_id = $request->timetable_id;
        $student_notes->student_id = $request->student_id;
        $student_notes->save();
        return array(
            "status"  => "ok",
            "message" => "student note save successfully"
        );
    }
    public function getStudent($id)
    {
        $result = Student::with('parent')->with('teacher')->with('grade')->with('subject')->where('id', $id)->get();
        foreach ($result as $key => $value) {
            # code...
            $value->studentImage = $this->getFile($value->user_image);
        }
        return response()->json(compact('result'));
        // return parent::show($id);
    }

    public function addDynamicParent(Request $request)
    {
        // return $value[$key]->first_name;
        if ($request->mode == 'edit') {
            $parentIds = Parent_students::where('student_id', $request->student_id)->pluck('parent_id');

            $userIds = Guardian::whereIn('id', $parentIds)->pluck('user_id');
            User::whereIn('id', $userIds)->delete();
            Guardian::whereIn('id', $parentIds)->delete();
            Parent_students::where('student_id', $request->student_id)->delete();
        }
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->name = $request->first_name . ' ' . $request->last_name;
        if ($request->email != "") {
            $user->email = $request->email;
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

        $guardian->first_name = $request->first_name;
        $guardian->last_name = $request->last_name;
        $guardian->phone = $request->phone;
        $guardian->email = $request->email;
        $guardian->user_id = $user->id;

        if ($image = $request->file('parent_image')) {
            $groupId = 0;
            $uploadGroupId = $this->manageUploads($image, $savepath = 'parent', $groupId);
            $guardian->parent_image = $uploadGroupId;

            $user = User::where('id', $user->id)->first();
            $user->user_image = $uploadGroupId;
            $user->save();
        }

        $guardian->address = $request->address;
        $guardian->country = $request->country;
        $guardian->state = $request->state;
        $guardian->save();
        if ($request->email != "") {
            dispatch(new \App\Jobs\AccountActivate($user, $dynamicPassword));
        }
        $parent_student = new Parent_students();
        $parent_student->student_id = $request->student_id;
        $parent_student->parent_id = $guardian->id;
        $parent_student->save();

        return 'success';
    }
    public function addStudent(Request $request)
    {
        //dd($request);
        $validator =  Validator::make(
            $request->all(),
            [
                'student_first_name' => 'required'
            ]
        );


        if ($validator->fails()) {
            return $this->getError($validator->errors()->all());
        }

        $user = new User();
        $user->first_name = $request->student_first_name;
        $user->last_name = $request->student_last_name;
        $user->name = $request->student_first_name . ' ' . $request->student_last_name;
        if ($request->student_email != "") {
            $user->email = $request->student_email;
            $dynamicPassword = Str::random($length = 10);
            $user->password = bcrypt($dynamicPassword);
            $token = random_bytes(8);
            $token = bin2hex($token);
            $user->verify_token = $token;
        }

        $user->save();
        $role = Role::findByName('student');
        if ($role) {
            $user->assignRole($role);
        }


        $student = new Student();
        $student->first_name = $request->student_first_name;
        $student->last_name = $request->student_last_name;
        $student->user_id = $user->id;
        $student->dob = $request->student_dob;
        $student->phone = $request->student_phone;
        $student->email = $request->student_email;
        $student->country = $request->student_address;
        //   if ($image = $request->student_image) {
        //     $groupId = 0;
        //     $uploadGroupId = $this->manageUploads($image, $savepath = 'student', $groupId);
        //     $student->student_image = $uploadGroupId;

        //     $user = User::where('id', $user->id)->first();
        //     $user->user_image = $uploadGroupId;
        //     $user->save();
        // }
        $student->save();
        if ($request->student_email != "") {
            dispatch(new \App\Jobs\AccountActivate($user, $dynamicPassword));
        }


        foreach ($request->dynamic_parent_list as $key => $value) {
            $user = new User();
            $user->first_name = $value['first_name'];
            $user->last_name = $value['last_name'];
            $user->name = $value['first_name'] . ' ' . $value['last_name'];
            if ($value['email'] != "") {
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

            $guardian->first_name = $value['first_name'];
            $guardian->last_name = $value['last_name'];
            $guardian->phone = $value['phone'];
            $guardian->email = $value['email'];
            $guardian->user_id = $user->id;

            //     if ($image = $value->parent_image) {
            //       $groupId = 0;
            //       $uploadGroupId = $this->manageUploads($image, $savepath = 'parent', $groupId);
            //       $guardian->parent_image = $uploadGroupId;

            //       $user = User::where('id', $user->id)->first();
            //       $user->user_image = $uploadGroupId;
            //       $user->save();
            //   }

            $guardian->address = $value['address'];
            $guardian->country = $value['country'];
            $guardian->state = $value['state'];
            $guardian->save();
            if ($value['email'] != "") {
                dispatch(new \App\Jobs\AccountActivate($user, $dynamicPassword));
            }
            $parent_student = new Parent_students();
            $parent_student->student_id = $student->id;
            $parent_student->parent_id = $guardian->id;
            $parent_student->save();
        }

        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $student
        );
        //   return 'Student Record Save Successfully';
    }
    public function addStudentSubject(Request $request)
    {
        foreach ($request->student_selectedSubjects as $key => $value) {
            $studentsubject = new Student_Subject();
            $studentsubject->subject_id = $value['id'];
            $studentsubject->student_id = $request->student_id;
            $studentsubject->save();
        }
        return array(
            "status"  => "ok",
            "message" => "Stored"
        );
    }

    //update student password
    public function updateStudentPassword(Request $request)
    {
        //dd($request);
        $student_user = Student::where('id', $request->student_id)->first();
        $user = User::where('id', $student_user->user_id)->first();
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
    public function studentAccordingTeacherSubjects(Request $request)
    {
        foreach ($request->student_selectedSubjects as $key => $value) {
            $studentsubject = new Student_Subject();
            $studentsubject->subject_id = $value['id'];
            $studentsubject->student_id = $request->student_id;
            $studentsubject->save();
        }
    }
    public function updateStudentSubject(Request $request)
    {
        DB::table('student_subject')->where('student_id', $request->student_id)->delete();
        foreach ($request->student_selectedSubjects as $key => $value) {
            $studentsubject = new Student_Subject();
            $studentsubject->subject_id = $value['id'];
            $studentsubject->student_id = $request->student_id;
            $studentsubject->save();
        }
    }
    public function updateStudent(Request $request)
    {

        $student = Student::where('id', $request->student_id)->first();
        $studentOldEmail = $student->email;
        $user = User::where('id', $student->user_id)->first();
        $user->first_name = $request->student_first_name;
        $user->last_name = $request->student_last_name;
        $user->name = $request->student_first_name . ' ' . $request->student_last_name;

        if ($request->student_email != "" && $studentOldEmail != $request->student_email) {
            $user->email = $request->student_email;
            $dynamicPassword = Str::random($length = 10);
            $user->password = bcrypt($dynamicPassword);
            $token = random_bytes(8);
            $token = bin2hex($token);
            $user->verify_token = $token;
        }
        $user->save();

        $student->first_name = $request->student_first_name;
        $student->last_name = $request->student_last_name;

        $student->phone = $request->student_phone;
        $student->country = $request->student_address;
        if ($request->student_email != "" && $studentOldEmail != $request->student_email) {
            $student->email = $request->student_email;
        }


        //   if ($image = $request->file('student_image')) {
        //     $groupId = 0;
        //     $uploadGroupId = $this->manageUploads($image, $savepath = 'student', $groupId);
        //     $student->student_image = $uploadGroupId;

        //     $user = User::where('id', $user->id)->first();
        //     $user->user_image = $uploadGroupId;
        //     $user->save();
        // }

        $student->user_id = $user->id;
        $student->save();
        if ($request->student_email != "" && $studentOldEmail != $request->student_email) {
            dispatch(new \App\Jobs\AccountActivate($user, $dynamicPassword));
        }

        //   ------------------------------------




        $parentIds = Parent_students::where('student_id', $student->id)->pluck('parent_id');

        $userIds = Guardian::whereIn('id', $parentIds)->pluck('user_id');
        // DB::table('users')
        // ->whereIn('id',$userIds)
        // ->delete();
        // DB::table('parents')
        // ->whereIn('id',$parentIds)
        // ->delete();
        // DB::table('parent_students')
        // ->whereIn('student_id',$student->id)
        // ->delete();

        User::whereIn('id', $userIds)->delete();
        Guardian::whereIn('id', $parentIds)->delete();
        Parent_students::where('student_id', $student->id)->delete();


        foreach ($request->dynamic_parent_list as $key => $value) {
            $user = new User();
            $user->name = $value['first_name'];
            if ($value['email'] != "") {
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

            $guardian->first_name = $value['first_name'];
            $guardian->last_name = $value['last_name'];
            $guardian->phone = $value['phone'];
            $guardian->email = $value['email'];
            $guardian->user_id = $user->id;



            $guardian->address = $value['address'];
            $guardian->country = $value['country'];
            $guardian->state = $value['state'];
            $guardian->save();
            if ($value['email'] != "") {
                dispatch(new \App\Jobs\AccountActivate($user, $dynamicPassword));
            }
            $parent_student = new Parent_students();
            $parent_student->student_id = $student->id;
            $parent_student->parent_id = $guardian->id;
            $parent_student->save();
        }



        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $student
        );
        // return parent::update($request,$id);
    }
    public function deleteStudent(Request $request)
    {
        // delete student from user table
        $student = Student::find($request->id);
        User::where('id', '=', $student->user_id)->delete();


        $parentIds = Parent_students::where('student_id', $request->id)->groupBy('parent_id')->pluck('parent_id');



        // $userIds = Guardian::whereIn('id','=',$parentIds)->get();
        $userIds = DB::table('parents')
            ->whereIn('id', $parentIds)
            ->pluck('user_id');




        //delete parent from user table-----both method work
        // User::whereIn('id',$userIds)->delete();
        User::destroy($userIds);

        // delete parent----both method work
        Guardian::whereIn('id', $parentIds)->delete();
        // Guardian::destroy($parentIds);
        Parent_students::where('student_id', $request->id)->delete();

        // student notes delete
        DB::table('student_notes')->where('student_id', $request->id)->delete();

        // student session delete
        DB::table('student_sessions')->where('student_id', $request->id)->delete();

        // student teacher delete
        DB::table('student_teachers')->where('student_id', $request->id)->delete();

        // delete student from student table
        return parent::destroy($request->id);
    }

    public function uploadStudentImage(Request $request)
    {

        if (isset($request->id)) {
            $student = Student::find($request->id);
            if ($image = $request->file('userImage')) {
                $groupId = $student->user_image == 0 ? '' : $student->user_image;
                $uploadGroupId = $this->manageUploads($image, $savepath = 'student', $groupId);
                $student->user_image = $uploadGroupId;
                // $student->image_url = $request->imageURL;
                $student->save();
                $user = User::where('id', $student->user_id)->first();
                $user->user_image = $uploadGroupId;
                // $user->image_url = $request->imageURL;
                $user->save();
            }
            return response()->json(compact('student'));
        }
        return response()->json(compact('not uploaded'));
    }

    public function uploadImage(Request $request)
    {
        if ($request->mode == 'student') {
            $student = Student::where('id', $request->student_id)->first();
            $user = User::where('id', $student->user_id)->first();
        } else if ($request->mode == 'teacher') {
            $teacher = Teacher::where('id', $request->teacher_id)->first();
            $user = User::where('id', $teacher->user_id)->first();
        } else {
            $user = User::where('id', auth()->user()->id)->first();
        }
        //    return $user->getRoleNames();
        if ($image = $request->file('userImage')) {
            $groupId = 0;
            $uploadGroupId = $this->manageUploads($image, $savepath = 'admin', $groupId);
            $user->user_image = $uploadGroupId;
            $user->save();
            if (Auth::user()->hasRole('teacher')) {
                $teacher = Teacher::where('user_id', $user->id)->first();
                $teacher->teacher_image = $uploadGroupId;
                $teacher->save();
            }
            if (Auth::user()->hasRole('student')) {
                $student = Student::where('user_id', $user->id)->first();
                $student->student_image = $uploadGroupId;
                $student->save();
            }
            if (Auth::user()->hasRole('parent')) {
                $parent = Guardian::where('user_id', $user->id)->first();
                $parent->parent_image = $uploadGroupId;
                $parent->save();
            }
            if (Auth::user()->hasRole('admin')) {
                if ($request->mode == 'student') {
                    $student->student_image = $uploadGroupId;
                    $student->save();
                } else if ($request->mode == 'teacher') {
                    $teacher->teacher_image = $uploadGroupId;
                    $teacher->save();
                }
            }
            return array(
                "status"  => "ok",
                "message" => "Stored",
                "result"  => $user
            );
        }
    }
}
