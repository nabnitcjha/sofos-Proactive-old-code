<?php

namespace App\Http\Controllers\Forms;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Guardian;
use App\Models\Subject;
use App\Models\TimeTable;
use App\Models\StudentSession;
use App\Models\Student_Teacher;
use App\Models\Student_Subject;
use App\Models\Parent_students;
use App\Models\Subject_Teacher;
use App\Models\AllotedClasses;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentTeacherController extends BaseController
{
    //

    /**
     * * @OA\Get(
     *     path="/api/getTeacherWithStudents/{teacherId}",
     *     tags={"StudentAndTeacher"},
     *   summary="Get TeacherWithStudents",
     *   operationId="getTeacherWithStudents",
     *security={{ "apiAuth": {} }},

     *   @OA\Parameter(
     *      name="teacherId",
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
     **/

    /**
     * * @OA\Post(
     *     path="/api/getAssociatedStudents/{teacherId}",
     *     tags={"StudentAndTeacher"},
     *   summary="AssociatedStudents",
     *   operationId="getAssociatedStudents",
     *security={{ "apiAuth": {} }},

     
     *   @OA\Parameter(
     *      name="teacherId",
     *      in="query",
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
     **/

    /**
     * * @OA\Get(
     *     path="/api/getStudentWithTeachers/{studentId}",
     *     tags={"StudentAndTeacher"},
     *   summary="Get StudentWithTeachers",
     *   operationId="getStudentWithTeachers",
     *security={{ "apiAuth": {} }},

     *   @OA\Parameter(
     *      name="studentId",
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
     **/

    /**
     * * @OA\Get(
     *     path="/api/getAllTeachersWithStudents",
     *     tags={"StudentAndTeacher"},
     *   summary="Get AllTeachersWithStudents",
     *   operationId="getAllTeachersWithStudents",
     *security={{ "apiAuth": {} }},

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
     **/

    /**
     * @OA\Post(
     ** path="/api/addStudentTeacher",
     *   tags={"StudentAndTeacher"},
     *   summary="Add Student Teacher",
     *   operationId="addStudentTeacher",
     *security={{ "apiAuth": {} }},

     *  @OA\Parameter(
     *      name="student_id",
     *      in="query",
     *      @OA\Schema(
     *           type="integer"
     *      )
     *   ),
     *
     *  @OA\Parameter(
     *      name="teacher_id",
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
     ** path="/api/getFilteredAssociatedStudents",
     *   tags={"StudentAndTeacher"},
     *   summary="Add Student Teacher",
     *   operationId="getFilteredAssociatedStudents",
     *security={{ "apiAuth": {} }},

     *  @OA\Parameter(
     *      name="searchText",
     *      in="query",
     *      @OA\Schema(
     *           type="string"
     *      )
     *   ),
     *
     *  @OA\Parameter(
     *      name="teacher_id",
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
     ** path="/api/deleteStudentTeacher",
     *   tags={"StudentAndTeacher"},
     *   summary="Delete StudentTeacher",
     *   operationId="deleteStudentTeacher",
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
     * StudentTeacher api
     *
     * @return \Illuminate\Http\Response
     */
    //

    public $model_name = "App\Models\Student_Teacher";

    public function addStudentTeacher(Request $request)
    {
        $stu_tec = Student_Teacher::where('student_id', $request->student_id)->where('teacher_id', $request->teacher_id)->first();
        if ($stu_tec) {
            return 'record already exist';
        }
        return parent::store($request);
    }
    public function forgotPassword(Request $request)
    {
        try {
            //code...
            if ($request->userEmail != "") {
                $user = User::where('email', $request->userEmail)->first();
                if ($user) {
                    dispatch(new \App\Jobs\ForgotPassword($user));
                } else {
                    return array(
                        "status"  => "Email not registered"
                    );
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            return array(
                "status"  => "Email not send",
                "error" => $th
            );
        }
        return array(
            "status"  => "Email send"
        );
    }
    public function resetPassword(Request $request)
    {
        try {
            //code...
            if ($request->password != "") {
                $user = User::where('id', $request->id)->first();
                $user->password = bcrypt($request->password);
                $user->save();
            }
        } catch (\Throwable $th) {
            //throw $th;
            return array(
                "status"  => "Password not change",
                "error" => $th
            );
        }
        return array(
            "status"  => "Password Change"
        );
    }
    public function deleteStudentTeacher(Request $request)
    {

        $stu_tec = Student_Teacher::where('student_id', $request->student_id)->where('teacher_id', $request->teacher_id)->first();
        if ($stu_tec) {
            $stu_tec->delete();
            return array(
                "status"  => "ok",
                "message" => "",
                "result"  => $stu_tec
            );
        }
    }


    public function getStudentWithTeachers($studentId)
    {
        $students = Student::with('teacher')->where('id', $studentId)->get();
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $students
        );
    }

    public function getTeacherWithStudents($teacherId)
    {
        $teacher = Teacher::with('student')->where('id', $teacherId)->get();
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher
        );
    }
    public function getAllTeachersWithStudents()
    {
        $teachers = Teacher::with('student')->get();
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teachers
        );
    }
    public function alotClass(Request $request)
    {
        if ($request->mode == 'one-to-one') {
            $alot_clas = AllotedClasses::where('teacher_id', $request->teacher_id)
                ->where('subject_id', $request->subject_id)
                ->where('slot_id', $request->slot_id)
                ->first();
            if ($alot_clas) {
                $alot_clas->delete();
            }
        } else {
            $alot_clas = AllotedClasses::where('student_id', $request->student_id)
                ->where('teacher_id', $request->teacher_id)
                ->where('subject_id', $request->subject_id)
                ->where('slot_id', $request->slot_id)
                ->first();
            if ($alot_clas) {
                $alot_clas->delete();
            }
        }

        $alotClass = new AllotedClasses();
        $alotClass->student_id = $request->student_id;
        $alotClass->teacher_id = $request->teacher_id;
        $alotClass->subject_id = $request->subject_id;
        $alotClass->slot_id = $request->slot_id;
        $alotClass->grade_id = $request->grade_id;
        $alotClass->save();
        return array(
            "status"  => "ok",
            "message" => "stored",
            "result"  => $alotClass
        );
    }
    public function deleteAlotClass(Request $request)
    {

        $alot_clas = AllotedClasses::where('student_id', $request->student_id)
            ->where('teacher_id', $request->teacher_id)
            ->where('subject_id', $request->subject_id)
            ->where('slot_id', $request->slot_id)
            ->first();
        if ($alot_clas) {
            $alot_clas->delete();
            return array(
                "status"  => "ok",
                "message" => "",
                "result"  => $alot_clas
            );
        }
    }
    public function getstudentForSlots(Request $request)
    {
        $teacherId = $request->teacher_id;
        $slotId = $request->slot_id;
        $studentIDS = Student_Teacher::where('teacher_id', $request->teacher_id)->pluck('student_id');
        $filterStudentsID = Student_Subject::whereIn('student_id', $studentIDS)->where('subject_id', $request->subject_id)->pluck('student_id');
        $students = Student::with(['teacher' => function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        }])->with(['allotedclass' => function ($q) use ($slotId) {
                $q->where('slot_id', $slotId);
            }])
            ->whereIn('id', $filterStudentsID)
            ->paginate(20);


        // $students = Student::with(['teacher'=>function($q) use($teacherId){
        //         $q->where('teacher_id',$teacherId);
        // }])->paginate(4);

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $students
        );
    }
    public function getParentStudents($id)
    {

        $parent = Guardian::with('student')->where('id', $id)->first();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $parent
        );
    }
    public function getStudentParents($id)
    {

        $student = Student::with('parent')->where('id', $id)->first();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $student
        );
    }
    public function getTimeTableAccordingParent($id)
    {

        $studentIds = Parent_students::where('parent_id', $id)->pluck('student_id');
        $timetableIds = StudentSession::whereIn('student_id', $studentIds)->pluck('timetable_id');

        $sub = TimeTable::orderBy('id', 'DESC');
        $timetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->whereIn('id', $timetableIds)
            ->groupBy('session_id')
            ->get();
        foreach ($timetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }
        }
        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $timetable
        );
    }
    public function getTeacherAccordingParent($id)
    {

        $studentIds = Parent_students::where('parent_id', $id)->pluck('student_id');
        $teacherIds = Student_Teacher::whereIn('student_id', $studentIds)->pluck('teacher_id');
        $teacher = Teacher::whereIn('id', $teacherIds)->get();
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher
        );
    }
    public function getStudentTeachers($id)
    {

        $student = Student::with('teacher')->where('id', $id)->first();
        $admin = User::where('id', 1)->first();
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $student,
            "admin"   => $admin
        );
    }

    public function getTeacherStudentsTest($id)
    {

        $teacher = Teacher::with('student', 'student.timetable')->where('id', $id)->first();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher
        );
    }

    public function getTeacherStudents($id)
    {

        $teacher = Teacher::with('student', 'student.timetable')->where('id', $id)->first();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher
        );
    }

    public function getAssociatedParents(Request $request)
    {
        $students = Student::with('parent')->where('id', $request->studentId)
            ->paginate(20);


        // $students = Student::with(['teacher'=>function($q) use($teacherId){
        //         $q->where('teacher_id',$teacherId);
        // }])->paginate(4);

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $students
        );
    }
    public function getAllTeachers()
    {
        $teachers = Teacher::select(DB::raw("CONCAT(first_name, ' ', last_name) AS name"), "id")->get();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teachers
        );
    }

    public function getStudentAccordingTeacher(Request $request)
    {
        // $teacherId = $request->teacherId;

        // $students = Student::with(['teacher' => function ($q) use ($teacherId) {
        //     $q->where('teacher_id', $teacherId);
        // }])->select(DB::raw("CONCAT(first_name, ' ', last_name) AS name"), "id")->get();
        $students = Student::select(DB::raw("CONCAT(first_name, ' ', last_name) AS name"), "id")->get();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $students
        );
    }

    public function getAssociatedStudents(Request $request)
    {
        $teacherId = $request->teacherId;
        // $subjectIDS = Subject_Teacher::where('teacher_id',$request->teacherId)->pluck('subject_id');
        // $studentIDS = Student_Subject::whereIn('subject_id',$subjectIDS)->pluck('student_id');
        // $students = Student::with(['teacher'=>function($q) use($teacherId){
        //             $q->where('teacher_id',$teacherId);
        //     }])->whereIn('id', $studentIDS)
        // ->paginate(20);


        // $students = Student::with(['teacher'=>function($q) use($teacherId){
        //         $q->where('teacher_id',$teacherId);
        // }])->paginate(4);

        $students = Student::with(['teacher' => function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        }])
            ->paginate(10);

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $students
        );
    }
    public function getFilteredTeachers(Request $request)
    {
        $searchText = $request->searchText;

        $teachers = Teacher::where(function ($query) use ($searchText) {
            $query->where('first_name', 'like', "%$searchText%")
                ->orwhere('middle_name', 'like', "%$searchText%")
                ->orwhere('last_name', 'like', "%$searchText%")
                ->orWhere('email', 'like', "%$searchText%")
                ->orWhere('phone', 'like', "%$searchText%");
        })
            ->get();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teachers
        );
    }
    public function getStudentTimetableDetails($studentId)
    {
            $sub = TimeTable::orderBy('id','DESC'); 
            $timetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->groupBy('session_id')
            ->get();


        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $timetable
        );
    }
    public function getFilteredSubjects(Request $request)
    {
        $searchText = $request->searchText;

        $subjects = Subject::where(function ($query) use ($searchText) {
            $query->where('name', 'like', "%$searchText%");
        })
            ->get();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $subjects
        );
    }
    public function getFilteredStudents(Request $request)
    {
        $searchText = $request->searchText;

        $students = Student::where(function ($query) use ($searchText) {
            $query->where('first_name', 'like', "%$searchText%")
                ->orwhere('middle_name', 'like', "%$searchText%")
                ->orwhere('last_name', 'like', "%$searchText%")
                ->orWhere('email', 'like', "%$searchText%")
                ->orWhere('phone', 'like', "%$searchText%");
        })
            ->get();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $students
        );
    }
    public function getFilteredTimetable(Request $request)
    {
        $searchText = $request->searchText;
        $sub = TimeTable::orderBy('id','DESC'); 
        $timetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
        ->groupBy('session_id')
        ->get(); 
       
        foreach ($timetable as $key => $value) {
            $isMatch = false;
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            if (str_contains(strtolower($subject->name),strtolower($searchText))
            ||str_contains(strtolower($teacher->first_name),strtolower($searchText))
            ||str_contains(strtolower($teacher->last_name),strtolower($searchText))
            ||str_contains(strtolower($value->topic),strtolower($searchText))) { 
                $value->textMatch = true;
            }else{
                $value->textMatch = false;
            }
            if ($subject) {
                $value->subjectName = $subject->name;
            }else{
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name .' ' . $teacher->middle_name . ' '. $teacher->last_name;
            }else{
                $value->teacherName = null;
            }
             
            
           
        }
      
        
        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $timetable
        );

        // $searchText = $request->searchText;

        // $timetable = TimeTable::where(function ($query) use ($searchText) {
        //     $query->where('first_name', 'like', "%$searchText%")
        //         ->orwhere('middle_name', 'like', "%$searchText%")
        //         ->orwhere('last_name', 'like', "%$searchText%")
        //         ->orWhere('email', 'like', "%$searchText%")
        //         ->orWhere('phone', 'like', "%$searchText%");
        // })
        //     ->get();

        // return array(
        //     "status"  => "ok",
        //     "message" => "",
        //     "result"  => $timetable
        // );
    }
    public function getFilteredAssociatedStudents(Request $request)
    {
        $teacherId = $request->teacher_id;
        $searchText = $request->searchText;

        $students = Student::with(['teacher' => function ($q) use ($teacherId) {
            $q->where('teacher_id', $teacherId);
        }])
            ->where(function ($query) use ($searchText) {
                $query->where('first_name', 'like', "%$searchText%")
                    ->orwhere('middle_name', 'like', "%$searchText%")
                    ->orwhere('last_name', 'like', "%$searchText%")
                    ->orWhere('email', 'like', "%$searchText%")
                    ->orWhere('phone', 'like', "%$searchText%");
            })
            ->get();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $students
        );
        // $teacherId = $request->teacher_id;
        // $searchText = $request->searchText;
        // $subjectIDS = Subject_Teacher::where('teacher_id',$request->teacher_id)->pluck('subject_id');
        // $studentIDS = Student_Subject::whereIn('subject_id',$subjectIDS)->pluck('student_id');
        // $students = Student::with(['teacher'=>function($q) use($teacherId){
        //             $q->where('teacher_id',$teacherId);
        //     }])
        //     ->whereIn('id', $studentIDS)
        //     ->where(function($query) use ($searchText){
        //         $query->where('first_name','like',"%$searchText%")
        //         ->orwhere('middle_name','like',"%$searchText%")
        //         ->orwhere('last_name','like',"%$searchText%")
        //         ->orWhere('email','like',"%$searchText%")
        //         ->orWhere('phone','like',"%$searchText%")
        //         ;
        //     })->paginate(20);

        // return array(
        //     "status"  => "ok",
        //     "message" => "",
        //     "result"  => $students
        // );
    }
}
