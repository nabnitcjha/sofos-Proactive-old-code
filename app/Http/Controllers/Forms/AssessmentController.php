<?php

namespace App\Http\Controllers\Forms;
use App\Models\Assessment;
use App\Models\Student_Teacher;
use App\Models\Student;
use App\Models\AssignAssessment;
use App\Models\AssignmentSolution;
use App\Models\Teacher;
use App\Http\Controllers\Forms\BaseController;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AssessmentController extends BaseController
{
    //
    public $model_name = "App\Models\Assessment";
    public function getAssessment($id)
    { 
        $assessment = Assessment::with('grade')->with('subject')->with('teacher')->where('id',$id)->get();
        foreach ($assessment as $key => $value) {
            # code...
            $value->assessmentFile = $this->getFile($value->assessment_file);
        }
        return array(
            "status"  => "ok",
            "message" => "fetch assessment record successfully",
            "result"  => $assessment
        );
    }

    public function updateTeacherAssessment(Request $request)
    {
          $assessment = Assessment::where('id',$request->assessment_id)->first();
          if ($assessment) {
            $assessment->grade_id = $request->grade_id;
            // $assessment->subject_id = $request->subject_id;
            $assessment->assessment_type = $request->assessment_type_id;
            $assessment->deadline = $request->deadline;
            $assessment->time_am_pm = $request->time_am_pm;
            if ($assessment_file = $request->file('assessment_file')) {
                $groupId = $assessment->assessment_file == 0 ? '' : $assessment->assessment_file;
                $uploadGroupId = $this->manageUploads($assessment_file, $savepath = 'assessment', $groupId);
                $assessment->assessment_file = $uploadGroupId;
            }
            $assessment->remark = $request->remark;
            $assessment->save();
  
            return array(
              "status"  => "ok",
              "message" => "Stored",
              "result"  => $assessment
          );
          }else{
            return array(
                "status"  => "not updated",
                "message" => "record not exist",
                "result"  => ''
            );
          }

        // return parent::store($request);
    }
  
    public function addAssessmentSolution(Request $request)
    {
        $assessment = new AssignmentSolution();
        $assessment->assessment_id = $request->assessment_id;
        if ($assessment_answer_file = $request->file('assessment_answer_file')) {
            $groupId = '';
            $uploadGroupId = $this->manageUploads($assessment_answer_file, $savepath = 'assessment', $groupId);
            $assessment->assessment_answer_file = $uploadGroupId;
        }
        $assessment->student_id = $request->student_id;
        $assessment->save();

        return array(
          "status"  => "ok",
          "message" => "Stored",
          "result"  => $assessment
      );
    }

    public function addTeacherAssessment(Request $request)
    {
        // return auth()->user()->id;
        $validator =  Validator::make(
            $request->all(),
            [
                'timetable_id' => 'required'
            ]
        );

        if ($validator->fails()) {
            return $this->getError($validator->errors()->all());
        }
        $timetable = TimeTable::where('id','=',$request->timetable_id)->first();
          $teacher = Teacher::where('id','=',$timetable->teacher_id)->first();
          if ($teacher) {
            $assessment = new Assessment();
            $assessment->timetable_id = $request->timetable_id;
            // $assessment->subject_id = $request->subject_id;
            $assessment->assessment_type = $request->assessment_type_id;
            if ($request->deadline) {
                $assessment->deadline = $request->deadline;
                $assessment->time_am_pm = $request->time_am_pm;
            }
            
            
            if ($assessment_file = $request->file('assessment_file')) {
                $groupId = '';
                $uploadGroupId = $this->manageUploads($assessment_file, $savepath = 'assessment', $groupId);
                $assessment->assessment_file = $uploadGroupId;
            }
            $assessment->topic = $request->topic;
            $assessment->teacher_id = $teacher->id;
            $assessment->save();
  
            return array(
              "status"  => "ok",
              "message" => "Stored",
              "result"  => $assessment
          );
          }else{
            return array(
                "status"  => "not created",
                "message" => "Teacher not exist",
                "result"  => ''
            );
          }

        // return parent::store($request);
    }

    public function getAssessmentAccordingGrade(Request $request){
        
        $assessments = '';
        if ($request->mode=='student') {
            
            $studentId = $request->student_id;
            $assessments = Assessment::with(['assessmentsolution'=>function($q) use($studentId){
                $q->where('student_id',$studentId);
        }])->where('timetable_id',$request->timetable_id)->where('teacher_id',$request->teacher_id)
            ->where('assessment_type',2)
            ->get();
            foreach ($assessments as $key => $value) {
                # code...
                if (isset($value->assessmentsolution)) {
                    $value->student = Student::where('id',$value->assessmentsolution->student_id)->first();
                    $value->solutionFile = $this->getFile($value->assessmentsolution->assessment_answer_file);
                    $value->submitted_date = Carbon::parse($value->assessmentsolution->created_at)->format('Y-m-d H:i:s');
                }else{
                    $value->student = '';
                    $value->solutionFile = '';
                    $value->submitted_date = '';
                }
            }

        //     $assessments = Assessment::with(['assessmentsolution'=>function($q) use($studentId){
        //         $q->where('student_id',$studentId);
        // }])->where('grade_id',$request->grade_id)->where('teacher_id',$request->teacher_id)
        // ->where('assessment_type',2)->get();
        }
        if ($request->mode=='teacher') {
            $studentIds = Student_Teacher::where('teacher_id', $request->teacher_id)->groupBy('student_id')->pluck('student_id');
            $assessments = Assessment::with(['assessmentsolution'=>function($q) use($studentIds){
                $q->whereIn('student_id',$studentIds);
        }])->where('timetable_id',$request->timetable_id)->where('teacher_id',$request->teacher_id)
            ->where('assessment_type',2)
            ->get();

            foreach ($assessments as $key => $value) {
                # code...
                if (isset($value->assessmentsolution)) {
                    $value->student = Student::where('id',$value->assessmentsolution->student_id)->first();
                    // $assmnt = Assessment::where('id',$value->assessmentsolution->assessment_id)->first();
                    $value->solutionFile = $this->getFile($value->assessmentsolution->assessment_answer_file);
                    $value->submitted_date = Carbon::parse($value->assessmentsolution->created_at)->format('Y-m-d H:i:s');
                }else{
                    $value->student = '';
                    $value->solutionFile = '';
                    $value->submitted_date = '';
                }
            }

            // $assessments = Assessment::where('timetable_id',$request->timetable_id)->where('teacher_id',$request->teacher_id)
            // ->where('assessment_type',2)
            // ->get();
        }

        if ($request->mode=='admin') {
            $assessments = Assessment::where('timetable_id',$request->timetable_id)->where('teacher_id',$request->teacher_id)
            ->where('assessment_type',2)
            ->get();
        }

        if ($request->mode=='teacher-study-resources') {
            $assessments = Assessment::where('timetable_id',$request->timetable_id)->where('teacher_id',$request->teacher_id)
            ->where('assessment_type',1)
            ->get();
        }
        if ($request->mode=='student-study-resources') {
            $assessments = Assessment::where('timetable_id',$request->timetable_id)->where('teacher_id',$request->teacher_id)
            ->where('assessment_type',1)
            ->get();
        }
        
        foreach ($assessments as $key => $value) {
            # code...
            $value->assessmentFile = $this->getFile($value->assessment_file);
        }
        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => $assessments
        );
    }

    public function teacherStudyResources(Request $request){
        $assessment = Assessment::where('teacher_id', $request->teacher_id)
        ->where('timetable_id', $request->timetable_id)
        ->where('assessment_type',1)
        ->get();
        foreach ($assessment as $key => $value) {
            # code...
            $value->assessmentFile = $this->getFile($value->assessment_file);
        }
        
        return array(
            "status"  => "ok",
            "message" => "New Assessment",
            "result"  =>  $assessment
        );
    }


    public function getAssessments(Request $request){
        $teacher = Teacher::where('user_id','=',auth()->user()->id)->first();
        $studentIds = Student_Teacher::where('teacher_id', $teacher->id)->groupBy('student_id')->pluck('student_id');

        if ($request->mode == 'new') {
            $assessment = Assessment::with(['assessmentsolution'=>function($q) use($studentIds){
                $q->whereIn('student_id',$studentIds);
        }])->where('teacher_id',$teacher->id)
            ->where('assessment_type',2)
            ->where('created_at', '>=', Carbon::today())->paginate(20);
            foreach ($assessment as $key => $value) {
                # code...
                $value->assessmentFile = $this->getFile($value->assessment_file);
                if (isset($value->assessmentsolution)) {
                    $value->student = Student::where('id',$value->assessmentsolution->student_id)->first();
                    // $assmnt = Assessment::where('id',$value->assessmentsolution->assessment_id)->first();
                    $value->solutionFile = $this->getFile($value->assessmentsolution->assessment_answer_file);
                    $value->submitted_date = Carbon::parse($value->assessmentsolution->created_at)->format('Y-m-d H:i:s');
                }else{
                    $value->student = '';
                    $value->solutionFile = '';
                    $value->submitted_date = '';
                }
            }
           
            return array(
                "status"  => "ok",
                "message" => "New Assessment",
                "result"  =>  $assessment
            );
        }else{
            $assessment = Assessment::with(['assessmentsolution'=>function($q) use($studentIds){
                $q->whereIn('student_id',$studentIds);
        }])->where('teacher_id',$teacher->id)
            ->where('assessment_type',2)
            ->whereDate('created_at', '>=', Carbon::now()->subDays(30))->whereDate('created_at', '<', Carbon::now())->paginate(20);
            foreach ($assessment as $key => $value) {
                # code...
                $value->assessmentFile = $this->getFile($value->assessment_file);
                if (isset($value->assessmentsolution)) {
                    $value->student = Student::where('id',$value->assessmentsolution->student_id)->first();
                    // $assmnt = Assessment::where('id',$value->assessmentsolution->assessment_id)->first();
                    $value->solutionFile = $this->getFile($value->assessmentsolution->assessment_answer_file);
                    $value->submitted_date = Carbon::parse($value->assessmentsolution->created_at)->format('Y-m-d H:i:s');
                }else{
                    $value->student = '';
                    $value->solutionFile = '';
                    $value->submitted_date = '';
                }
            }
            // $assessment = Assessment::with('grade')->with('subject')->with('teacher')->where('teacher_id', $teacher->id)->whereDate('created_at', '>=', Carbon::now()->subDays(30))->whereDate('created_at', '<', Carbon::now())->paginate(20);
            // foreach ($assessment as $key => $value) {
            //     # code...
            //     $value->assessmentFile = $this->getFile($value->assessment_file);
            // }
            return array(
                "status"  => "ok",
                "message" => "Previous Assessment",
                "result"  =>  $assessment
            );
        }
    }

    public function deleteAssessment(Request $request) 
    {
        $teacher_assessment = Assessment::where('id','=',$request->id)->delete();
        
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $teacher_assessment
        ); 
        return parent::destroy($request->id);
    }

    public function assignAssement(Request $request){
        $students = $request->selectedStudents;
        foreach ($students as $key => $value) {
            # code...
            $assignAssessment = new AssignAssessment();
            $assignAssessment->assessment_id=$request->assessment_id;
            $assignAssessment->student_id=$value['id'];
            $assignAssessment->save();
        }
    }
    
}
