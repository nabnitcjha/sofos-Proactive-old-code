<?php

namespace App\Http\Controllers\Forms;

use App\Models\User;
use App\Models\Subject;
use App\Models\GradeSubject;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\TimeTable;
use App\Models\StudentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Forms\BaseController;

class SubjectController extends BaseController
{
   
    public $model_name = "App\Models\Subject";
    
    public function getSubjects(Request $request){  
        return parent::index($request);
    }
    public function getSubject($id){
        $subject = Subject::with('teacher')->with(['grade'=>function($q){
            $q->select('grade.id','grade.name'); 
        }])
        ->where('id','=',$id)->get();
        
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $subject
        ); 
    }
    public function getAllSubjects(Request $request){  
        $result = Subject::orderBy('id', 'desc')->paginate(5);
        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $result
        );
    }
    public function studentAccordingGradeSubject(Request $request)
    { 
        $gradeStudents = DB::table('student_teachers')
            ->join('student_subject', 'student_teachers.student_id', '=', 'student_subject.student_id')
            ->where('student_subject.subject_id',$request->subject_id)
            ->where('student_teachers.teacher_id',$request->teacher_id)
            ->select('student_subject.*')
            ->get();
        foreach ($gradeStudents as $key => $value) {
            $student = Student::where('grade_id',$request->grade_id)->where('id',$value->student_id)->first();
            $value->student = $student;
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $gradeStudents
        ); 
    }

    public function teacherAccordingGradeSubject(Request $request)
    { 
        $gradeTeachers = DB::table('gradeteacher')
            ->join('subject_teacher', 'gradeteacher.teacher_id', '=', 'subject_teacher.teacher_id')
            ->where('subject_teacher.subject_id',$request->subject_id)
            ->where('gradeteacher.grade_id',$request->grade_id)
            ->select('gradeteacher.*')
            ->get();
        
        foreach ($gradeTeachers as $key => $value) {
            $teacher = Teacher::with('subject')->where('id',$value->teacher_id)->first();
            $value->teacher = $teacher;
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $gradeTeachers
        ); 
    }

    public function teacherAccordingSubject(Request $request)
    { 
        $subjectTeachers = DB::table('subject_teacher')->where('subject_id',$request->subject_id)->get();
        
        foreach ($subjectTeachers as $key => $value) {
            $teacher = Teacher::with('subject')->where('id',$value->teacher_id)->first();
            $value->teacher = $teacher;
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $subjectTeachers
        ); 
    }

    public function addSubject(Request $request){

        $validator =  Validator::make(
            $request->all(),
            [
                'name' => 'required'
            ]
        );


          if ($validator->fails()) {
            return $this->getError($validator->errors()->all());
          }
          $subject = new Subject();
          $subject->name = $request->name;
          $subject->save();
          

          return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $subject
        );
    }
    public function updateSubject(Request $request,$id){
        $subject = Subject::where('id',$id)->first();
        $subject->name=$request->name;
        $subject->save();
        return array(
            "status"  => "ok",
            "message" => "subject Record Update Successfully",
            "result"  => $subject
        );
    }
    public function deleteSubject(Request $request){
        $timetableIds = TimeTable::where('subject_id',$request->id)->pluck('id');
        StudentSession::whereIn('timetable_id',$timetableIds)->delete();
        TimeTable::where('subject_id',$request->id)->delete();
        return parent::destroy($request->id);
    }
}


