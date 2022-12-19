<?php

namespace App\Http\Controllers\Forms;

use App\Models\User;
use App\Models\Grade;
use App\Models\Parent_students;
use App\Models\Subject;
use App\Models\Student;
use App\Models\Student_Teacher;
use App\Models\Teacher;
use App\Models\StudentSession;
use App\Models\AllotedClasses;
use App\Models\TimeTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Forms\BaseController;
use Illuminate\Support\Str;
use Carbon\Carbon;
class TimeTableController extends BaseController
{
   
    public $model_name = "App\Models\TimeTable";

    public function getAllTimeTables(Request $request){  
        $timetable = "";
        if ($request->mode=='student') {
        $timetableIds = StudentSession::where('student_id', $request->student_id)->groupBy('timetable_id')->pluck('timetable_id');
        $timetable = TimeTable::with('subject')
        ->with('teacher')
        ->with('student')
        ->whereIn('id',$timetableIds)
        ->groupBy('session_id')->pluck('session_id');
    }
        if ($request->mode=='teacher') {
            $timetable = TimeTable::with('subject')
            ->with('teacher')
            ->with('student')
            ->where('teacher_id',$request->teacher_id)
            ->groupBy('session_id')->pluck('session_id');
        }
        
       
        return array(
            "status"  => "ok",
            "message" => "success",
            "sessionIds"  => $timetable
        );
    }

    public function getWeekRecordForAdmin(Request $request){  
        
        $timetable = TimeTable::with('subject')
        ->with('teacher')
        ->with('student')
        ->where('session_id',$request->session_id)
        ->get();
        return array(
            "status"  => "ok",
            "message" => "success",
            "result"  => $timetable
        );
    }

    public function getDayRecordForAdmin(Request $request){  
        
        $timetable = TimeTable::with('subject')
        ->with('teacher')
        ->with('student')
        ->where('session_id',$request->session_id)
        ->get();
        return array(
            "status"  => "ok",
            "message" => "success",
            "result"  => $timetable
        );
    }
    
    public function getTimeTables(Request $request){  
        $sub = TimeTable::orderBy('id','DESC'); 
        $timetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
        ->groupBy('session_id')
        ->paginate(5); 
       
        foreach ($timetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            
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
        
    }
    public function teacherSlots(Request $request){   
        // $timetable = DB::table('timetable')
        //         ->where('teacher_id',$request->teacher_id)
        //         ->where('subject_id',$request->subject_id)
        //         ->get();
        $timetable = TimeTable::with('used_slot')
        ->where('teacher_id',$request->teacher_id)
        ->where('subject_id',$request->subject_id)
        ->get();
        return array(
            "status"  => "ok",
            "message" => "success",
            "result"  => $timetable
        );
        // return parent::index($request);
    }
    public function getParentTimeTable($id){
        $studentIds = Parent_students::where('parent_id',$id)->pluck('student_id');
        $teacherIds = Student_Teacher::whereIn('student_id',$id)->pluck('teacher_id');
        $studentAllTimeTable = TimeTable::with('subject')
        ->with('teacher')
        ->whereIn('teacher_id',$teacherIds)
        ->get();
        
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $studentAllTimeTable
        ); 
    }
    public function getStudentTimeTable($id){
           $teacherIds = Student_Teacher::where('student_id',$id)->pluck('teacher_id');

        $sub = TimeTable::orderBy('id','DESC'); 
        $timetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
        ->whereIn('teacher_id',$teacherIds)
        ->groupBy('session_id')
        ->get(); 
       
        foreach ($timetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            
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

        // $teacherIds = Student_Teacher::where('student_id',$id)->pluck('teacher_id');
        // $studentAllTimeTable = TimeTable::with('subject')
        // ->with('teacher')
        // ->whereIn('teacher_id',$teacherIds)
        // ->get();
        
        // return array(
        //     "status"  => "ok",
        //     "message" => "",
        //     "result"  => $studentAllTimeTable
        // ); 
    }
    public function getTeacherTimeTable($id){
        $sub = TimeTable::orderBy('id','DESC'); 
        $timetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
        ->where('teacher_id',$id)
        ->groupBy('session_id')
        ->get(); 
       
        foreach ($timetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            
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
        
        // $teacherAllTimeTable = TimeTable::with('subject')
        // ->with('teacher')
        // ->where('teacher_id',$id)
        // ->get();
        
        // return array(
        //     "status"  => "ok",
        //     "message" => "",
        //     "result"  => $teacherAllTimeTable
        // ); 
    } 
    public function getTeacherSlots(Request $request){   
        $timetable = DB::table('timetable')
                ->whereYear('time', $request->year)
                ->whereMonth('time', $request->month)
                ->where('teacher_id',$request->teacher_id)
                ->where('class_id',$request->class_id)
                ->get();

        return array(
            "status"  => "ok",
            "message" => "success",
            "result"  => $timetable
        );
        // return parent::index($request);
    }

    public function saveZoomLink(Request $request){   
        $timetable = TimeTable::find($request->timetable_id);
        $timetable->zoomLink = $request->zoomLink;
        $timetable->save();
        return array(
            "status"  => "ok",
            "message" => "success",
            "result"  => $timetable
        );
        // return parent::index($request);
    }

    public function getDashboard(Request $request){  
        $timetable = '';
        $sub = '';
        if ($request->mode=='admin') {
            $totalTeacher = Teacher::count();
            $totalStudent = Student::count();
            $newlyAddedStudent = Student::whereDate('created_at', '>=', Carbon::now()->subDays(8))->whereDate('created_at', '<', Carbon::now())->get();
            $sub = TimeTable::orderBy('id','DESC'); 
            $totalClass = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->groupBy('session_id')
            ->get();
            return array(
                "status"  => "ok",
                "message" => "success",
                "totalClass"  => $totalClass->count(),
                "totalTeacher"  => $totalTeacher,
                "totalStudent"  => $totalStudent,
                "newlyAddedStudent" => $newlyAddedStudent
            );
        }else if ($request->mode=='teacher'){
            // $timetable = TimeTable::where('teacher_id',$request->teacher_id)->get();
            $totalStudent = Student_Teacher::where('teacher_id',$request->teacher_id)->groupBy('student_id')->pluck('student_id')->count();
            $sub = TimeTable::orderBy('id','DESC'); 
            $totalClass = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->groupBy('session_id')
            ->where('teacher_id',$request->teacher_id)->get();
            $todayClass = TimeTable::where('start_date', '=', Carbon::today())->where('teacher_id',$request->teacher_id)->get();
            return array(
                "status"  => "ok",
                "message" => "success",
                "totalClass"  => $totalClass->count(),
                "totalStudent"  => $totalStudent,
                "totalTeacher"  => '',
                "todayClass"    => $todayClass
            );

        }else if ($request->mode=='student'){
            $totalTeacher = Student_Teacher::where('student_id',$request->student_id)->groupBy('teacher_id')->pluck('teacher_id');
            $sub = TimeTable::orderBy('id','DESC'); 
            $totalClass = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->groupBy('session_id')
            ->whereIn('teacher_id',$totalTeacher)->get();

            $todayClass = TimeTable::where('start_date', '=', Carbon::today())->whereIn('teacher_id',$totalTeacher)->get();

            return array(
                "status"  => "ok",
                "message" => "success",
                "totalClass"  => $totalClass->count(),
                "totalTeacher"  => $totalTeacher->count(),
                "totalStudent"  => '',
                "todayClass"    => $todayClass
            );
            
        }else{
            // parent side code here
            $totalStudent = Parent_students::where('parent_id',$request->parent_id)->groupBy('student_id')->pluck('student_id');
            $totalTeacher = Student_Teacher::whereIn('student_id',$totalStudent)->groupBy('teacher_id')->pluck('teacher_id');
            $sub = TimeTable::orderBy('id','DESC'); 
            $totalClass = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->groupBy('session_id')
            ->whereIn('teacher_id',$totalTeacher)->get();

            $todayClass = TimeTable::where('start_date', '=', Carbon::today())->whereIn('teacher_id',$totalTeacher)->get();

            return array(
                "status"  => "ok",
                "message" => "success",
                "totalClass"  => $totalClass->count(),
                "totalTeacher"  => $totalTeacher->count(),
                "totalStudent"  => $totalStudent->count(),
                "todayClass"    => $todayClass
            );
        }
       
       
        // return parent::index($request);
    }

    public function getSlots(Request $request){  
        $timetable = '';
        $sub = '';
        if ($request->mode=='admin') {
            // $sub = TimeTable::orderBy('id','DESC'); 
            // $timetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            // ->get(); 
            if ($request->submode=='admin-student') {
                $sessionIds = StudentSession::where('student_id',$request->student_id)->groupBy('session_id')->pluck('session_id');
                $timetable = TimeTable::with(['teacher','student'])->whereIn('session_id',$sessionIds)->get();
            }
            if ($request->submode=='admin-teacher') {
                $timetable = TimeTable::with(['teacher','student'])->where('teacher_id',$request->teacher_id)->get();
            }
            // if (count($request->session)>0) {
            //     $timetable = TimeTable::with(['teacher','student'])->whereIn('session_id',$request->session)->get();
            // }else{
            //     $timetable = TimeTable::with(['teacher','student'])->get();
            // }
            

        }else if ($request->mode=='teacher'){
           
            if (isset($request->session)) {
                $timetable = TimeTable::where([
                    ['teacher_id',$request->teacher_id],
                    ['session_id',$request->session],
                    ])->get();
            }else{
                $timetable = TimeTable::with(['teacher','student'])->where('teacher_id',$request->teacher_id)->get();
            }
        }else if ($request->mode=='student'){
            $teacherIds = Student_Teacher::with(['teacher','student'])->where('student_id',$request->student_id)->pluck('teacher_id');
            
            if (isset($request->session)) {
                $timetable = TimeTable::with(['teacher','student'])->whereIn('teacher_id',$teacherIds)->where('session_id',$request->session)->get();
            }else{
                $timetable = TimeTable::with(['teacher','student'])->whereIn('teacher_id',$teacherIds)->get(); 
            }
        }else{
            $studentIds = Parent_students::where('parent_id',$request->parent_id)->groupBy('student_id')->pluck('student_id');
            $teacherIds = Student_Teacher::whereIn('student_id',$studentIds)->pluck('teacher_id');
            
            if (isset($request->session)) {
                $timetable = TimeTable::with(['teacher','student'])->whereIn('teacher_id',$teacherIds)->where('session_id',$request->session)->get();
            }else{
                $timetable = TimeTable::with(['teacher','student'])->whereIn('teacher_id',$teacherIds)->get();
            }
        }
       

        return array(
            "status"  => "ok",
            "message" => "success",
            "result"  => $timetable
        );
        // return parent::index($request);
    }
    public function getTimeTable($id){
        $teacher = Teacher::all();
        $student = Student::all();
        $result = TimeTable::with('grade')
            ->with('subject')
            ->with('teacher')
            ->with('student')
            ->where('id',$id)
            ->first();
//$result = TimeTable::where('id',$id)->first();
return array(
    "status"  => "ok",
    "message" => "success",
    "result"  => $result,
    "teacher"  => $teacher,
    "student"  => $student,
);
    }

    public function addTimeTable(Request $request){
       
        $validator =  Validator::make(
            $request->all(),
            [
                'topic' => 'required'
            ]
        );


          if ($validator->fails()) {
            return $this->getError($validator->errors()->all());
          }
          $slotTimes = $request->slotTimes;
        
          $session_id = Str::random($length = 10);

          if ($request->pageType!='edit') {
              foreach ($request['slotTimes'] as $key => $value) {

            $start = $value['startDate'];
            $end = $value['endDate'];
            // return Carbon::parse($start)->dayName;
            $timetable = TimeTable::where('teacher_id',$request->teacher_id)
            ->where(function($query) use($start, $end){
                $query->whereBetween('start_date', [$start, $end])
                ->orWhereBetween('end_date', [$start, $end]);
            })
            ->get();
            // return $timetable;
            if (count($timetable)>0) {
              return array(
                  "status"  => "not save",
                  "message" => "teacher not available",
                  "dayName" => Carbon::parse($start)->dayName,
                  "startDate" =>Carbon::parse($start)->format('d-m-Y'),
                  "time_am_pm" =>$timetable[0]->time_am_pm,
                  "current_time_am_pm" =>$value['time_am_pm']
              );
            }

            foreach ($request['students'] as $key => $val) {
                $studnetTimetable = StudentSession::where('student_id',$val['id'])
                ->where(function($query) use($start, $end){
                    $query->whereBetween('start_date', [$start, $end])
                    ->orWhereBetween('end_date', [$start, $end]);
                })
                ->get(); 
                // return 'id=>'.$val['id'].' '.'start=>'.$start.' '.'end=>'.$end;
                if (count($studnetTimetable)>0) {
                  return array(
                      "status"  => "not save",
                      "message" => "student not available",
                      "dayName" => Carbon::parse($start)->dayName,
                      "startDate" =>Carbon::parse($start)->format('d-m-Y'),
                      "time_am_pm" =>$studnetTimetable[0]->time_am_pm,
                      "current_time_am_pm" =>$value['time_am_pm']
                  );
                }
            }


          }


          }
          
          foreach ($request['slotTimes'] as $key => $value) {
            $timetable = '';
              if ($request->pageType=='edit') {
                  TimeTable::where('session_id',$request->session_id)->delete();
                  StudentSession::where('session_id',$request->session_id)->delete();
              }
            
            $timetable = new TimeTable();
            // return json_decode(json_encode($request->selected_day),true);
            // return json_decode(json_encode($request->selected_day),true);
            $timetable->selected_day = implode(", ",$request->selected_day);
            $timetable->session_repeat = $request->session_repeat;
            $timetable->subject_id = $request->subject_id;
            $timetable->teacher_id = $request->teacher_id;
            $timetable->topic = $request->topic;
            $timetable->start_date = $value['startDate'];
            $timetable->end_date = $value['endDate'];

            $timetable->start_time = $value['startTime'];
            $timetable->end_time = $value['endTime'];
            $timetable->time_am_pm = $value['time_am_pm'];
            $timetable->session_id = $session_id;
            if ($request->event_message) {
                $timetable->event_message = $request->event_message;
            }
            
            $timetable->save();

            foreach ($request['students'] as $key => $val) {
                $stdSession = new StudentSession();
                $stdSession->student_id = $val['id'];
                $stdSession->timetable_id = $timetable->id;
                $stdSession->session_id = $session_id;
                $stdSession->start_date = $value['startDate'];
                $stdSession->end_date = $value['endDate'];
                $stdSession->time_am_pm = $value['time_am_pm'];
                $stdSession->save();
            }

          }
          return array(
            "status"  => "ok",
            "message" => "session save successfully"
        );

         
    }
    public function updateDragTimeTable(Request $request){
        $timetable = TimeTable::where('id',$request->id)->first();
        // time_am_pm   start_date   end_date   start_time   end_time

          $timetable->end_time = $request->end_time;
          $timetable->start_time = $request->start_time;
          $timetable->start_date = $request->start_date;
          $timetable->end_date = $request->end_date;
          $timetable->time_am_pm = $request->time_am_pm;
        
          $timetable->save();
        return array(
            "status"  => "ok",
            "message" => "timetable Record Update Successfully",
            "result"  => $timetable
        );
    }

    public function updateSingleSlot(Request $request){
        // time_am_pm   start_date   end_date   start_time   end_time

        $start = $request->start_date;
        $end = $request->end_date;
        // return Carbon::parse($start)->dayName;
        $timetable = TimeTable::where('teacher_id',$request->teacher_id)
        ->where(function($query) use($start, $end){
            $query->whereBetween('start_date', [$start, $end])
            ->orWhereBetween('end_date', [$start, $end]);
        })
        ->get();
        // return $timetable;
        if (count($timetable)>0) {
          return array(
              "status"  => "not save",
              "message" => "teacher not available",
              "dayName" => Carbon::parse($start)->dayName,
              "startDate" =>Carbon::parse($start)->format('d-m-Y'),
              "time_am_pm" =>$request->time_am_pm,
              "current_time_am_pm" =>$request->time_am_pm
          );
        }

        foreach ($request['students'] as $key => $val) {
            $studnetTimetable = StudentSession::where('student_id',$val['id'])
            ->where(function($query) use($start, $end){
                $query->whereBetween('start_date', [$start, $end])
                ->orWhereBetween('end_date', [$start, $end]);
            })
            ->get(); 
            // return 'id=>'.$val['id'].' '.'start=>'.$start.' '.'end=>'.$end;
            if (count($studnetTimetable)>0) {
              return array(
                  "status"  => "not save",
                  "message" => "student not available",
                  "dayName" => Carbon::parse($start)->dayName,
                  "startDate" =>Carbon::parse($start)->format('d-m-Y'),
                  "time_am_pm" =>$studnetTimetable[0]->time_am_pm,
                  "current_time_am_pm" =>$request->time_am_pm
              );
            }
        }
        $timetable = TimeTable::where('id',$request->timetable_id)->first();

          $timetable->end_time = $request->end_time;
          $timetable->start_time = $request->start_time;
          $timetable->start_date = $request->start_date;
          $timetable->end_date = $request->end_date;
          $timetable->time_am_pm = $request->time_am_pm;

          $timetable->subject_id = $request->subject_id;
          $timetable->teacher_id = $request->teacher_id;
          $timetable->topic = $request->topic;
        
          $timetable->event_message = $request->event_message;
          $timetable->save();

          $stdSession = StudentSession::where('timetable_id',$request->timetable_id)->first();
          $session_id = $stdSession->session_id;
          $stdSession->delete();
          foreach ($request['students'] as $key => $val) {
            $stdSession = new StudentSession();
            $stdSession->student_id = $val['id'];
            $stdSession->timetable_id = $timetable->id;
            $stdSession->session_id = $session_id;
            $stdSession->start_date = $request->start_date;
            $stdSession->end_date = $request->end_date;
            $stdSession->time_am_pm = $request->time_am_pm;
            $stdSession->save();
        }

        return array(
            "status"  => "ok",
            "message" => "timetable Record Update Successfully",
            "result"  => $timetable
        );
    }

    public function updateTimeTable(Request $request,$id){
        $timetable = TimeTable::where('id',$id)->first();
          $timetable->class_id = $request->class_id;
          $timetable->subject_id = $request->subject_id;
          $timetable->teacher_id = $request->teacher_id;
          $timetable->topic = $request->topic;
          $timetable->start_date = $request->start_date;
          $timetable->end_date = $request->end_date;
          $timetable->time_am_pm = $request->time_am_pm;
          if ($request->event_message) {
            $timetable->event_message = $request->event_message;
        }
          $timetable->save();
        return array(
            "status"  => "ok",
            "message" => "timetable Record Update Successfully",
            "result"  => $timetable
        );
    }
    public function sessionCompleted(Request $request){
        $timetable = TimeTable::where('id',$request->timetable_id)->first();
        $timetable->completed = $request->completed;
        $timetable->completeNowNote = $request->completeNowNote;
        $timetable->save();

        return array(
            "status"  => "ok",
            "message" => "save Successfully"
        );
        // return parent::destroy($request->id);
    }
    public function notCompletedSession(Request $request){
        $session = TimeTable::where('id',$request->timetable_id)->first();
        $teacherIds = TimeTable::where('id',$request->timetable_id)->pluck('teacher_id');
        $timetable = TimeTable::whereIn('teacher_id',$teacherIds)->whereDate('start_date', '<=', Carbon::now())->where('completed','<=',1)->where('session_id',$session->session_id)->get();
        return array(
            "status"  => "ok",
            "message" => "Successfully",
            "result"  => $timetable
        );
    }
    public function upcommingSession(Request $request){
        $teacherIds = TimeTable::where('id',$request->timetable_id)->pluck('teacher_id');
        $timetable = TimeTable::whereIn('teacher_id',$teacherIds)
        ->whereDate('start_date', '>', Carbon::now())
        ->whereDate('start_date', '<=', Carbon::now()->addDay(8))
        ->get();
        return array(
            "status"  => "ok",
            "message" => "Successfully",
            "result"  => $timetable
        );
    }
    public function completedSession(Request $request){
        $teacherIds = TimeTable::where('id',$request->timetable_id)->pluck('teacher_id');
        $timetable = TimeTable::whereIn('teacher_id',$teacherIds)->whereDate('start_date', '<=', Carbon::now())->where('completed','=',2)->get();
        return array(
            "status"  => "ok",
            "message" => "Successfully",
            "result"  => $timetable
        );
    }
    public function deleteSingleTimetable(Request $request)
    {
        $timetable = TimeTable::where('id','=',$request->id)->delete();
        
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $timetable
        ); 
    }
    
    public function deleteTimeTable(Request $request){
        // $timetable = TimeTable::where('id',$request->id)->first();
        $timetableIds = TimeTable::where('session_id',$request->session_id)->pluck('id');
        StudentSession::whereIn('timetable_id',$timetableIds)->delete();
        TimeTable::where('session_id',$request->session_id)->delete();

        return array(
            "status"  => "ok",
            "message" => "timetable Record delete Successfully"
        );
        // return parent::destroy($request->id);
    }
} 
