<?php

namespace App\Http\Controllers\Forms;

use App\Models\User;
use App\Models\Grade;
use App\Models\Subject;
use App\Models\TimeTable;
use App\Models\StudentSession;
use App\Models\Parent_students;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\GradeSubject;
use App\Models\Student_Teacher;
use App\Models\AllotedClasses;
// use App\Events\TaskCreatedEvent;
use App\Events\TaskCreatedEvent;
use App\Models\GradeTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Forms\BaseController;
use Carbon\Carbon;


class GradeController extends BaseController
{

    public $model_name = "App\Models\Grade";

    public function getGrades(Request $request)
    {

        if ($request->allowPagination != null) {
            if (str_contains($request->allowPagination, 'false')) {
                $obj = DB::table('grade')
                    ->select('grade.name', 'grade.id')
                    ->get();
                return array(
                    "status"  => "ok",
                    "message" => "",
                    "result"  => $obj
                );
            }
        } else {
            $grade = Grade::with(['subject' => function ($q) {
                $q->select('subject.id', 'subject.name');
            }])->with(['teacher' => function ($q) {
                $q->select('teachers.id', 'teachers.first_name', 'teachers.middle_name', 'teachers.last_name');
            }])
                ->paginate(20);

            return array(
                "status"  => "ok",
                "message" => "",
                "result"  => $grade
            );
            // return parent::index($request); 
        }
    }
    public function getStudentClass(Request $request)
    {

        $timetable = TimeTable::with('teacher')
            ->with('subject')
            ->where('id', '=', $request->timetable_id)->get();

        foreach ($timetable as $key => $value) {
            // $date = Carbon::parse($value->start_date)->format('Y-m-d H:i:s');
            // $todayDate = Carbon::now()->format('Y-m-d H:i:s');

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
            } else {
                $value->isToday = 'no';
            }
        }

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $timetable
        );
    }
    public function getTeacherClass(Request $request)
    {

        $timetable = TimeTable::with('teacher')
            ->with('subject')
            ->where('id', '=', $request->timetable_id)->orderBy('start_date', 'ASC')->paginate(1);
        $studentIds = StudentSession::where('id', '=', $request->timetable_id)->groupBy('student_id')->pluck('student_id');

        foreach ($timetable as $key => $value) {
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $timetable
        );
    }

    public function getClassessAccordingParent($id)
    {
        $studentIds = Parent_students::where('parent_id', $id)->groupBy('student_id')->pluck('student_id');
        $timetableIds = StudentSession::whereIn('student_id', $studentIds)->groupBy('timetable_id')->pluck('timetable_id');
        // $alotClass = TimeTable::with('teacher')->with('subject')->whereIn('id',$timetableIds)->get();

        $sub = TimeTable::orderBy('id', 'DESC');
        $timetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            ->groupBy('session_id')
            ->whereIn('id', $timetableIds)->get();

        foreach ($timetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }
        }

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $timetable
        );
    }


    public function getParentClassess($id)
    {
        $studentIds = Parent_students::where('parent_id', $id)->pluck('student_id');

        $timetableIds = StudentSession::whereIn('student_id', $studentIds)->groupBy('timetable_id')->pluck('timetable_id');
        // $alotClass = TimeTable::with('teacher')->with('subject')->whereIn('id',$timetableIds)->get();

        $sub = TimeTable::orderBy('id', 'DESC');
        $todayTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->whereIn('id', $timetableIds)
            ->where('start_date', 'like', Carbon::today()->toDateString() . '%')
            // ->where('start_date', '=', Carbon::today()->toDateString())
            ->orderBy('start_date', 'ASC')
            ->get();

        $previousTimeTable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->whereIn('id', $timetableIds)
            ->where('start_date', '<', Carbon::today())
            // ->where('start_date', '=', Carbon::today()->toDateString())
            ->orderBy('start_date', 'ASC')
            ->get();

        //    return $todayTimetable;
        $weeklyTimetable = TimeTable::whereDate('start_date', '>', Carbon::now())
            ->whereDate('start_date', '<=', Carbon::now()->addDay(8))
            ->where(function ($query) use ($timetableIds) {
                $query->whereIn('id', $timetableIds);
            })
            ->orderBy('start_date', 'ASC')
            ->get();

        // ->whereIn('id','=',$timetableIds)

        foreach ($todayTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);

            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }
        foreach ($previousTimeTable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);

            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }
        foreach ($weeklyTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);

            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
                $value->teacherInfo = $teacher;
            } else {
                $value->teacherName = null;
                $value->teacherInfo = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }

        return array(
            "status"  => "ok",
            "message" => "",
            "todayTimetable"  => $todayTimetable,
            "weeklyTimetable"  => $weeklyTimetable,
            "previousTimeTable"  => $previousTimeTable
        );
    }


    public function getStudentClassess($id)
    {
        $timetableIds = StudentSession::where('student_id', $id)->groupBy('timetable_id')->pluck('timetable_id');
        // $alotClass = TimeTable::with('teacher')->with('subject')->whereIn('id',$timetableIds)->get();

        $sub = TimeTable::orderBy('id', 'DESC');
        $todayTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->whereIn('id', $timetableIds)
            ->where('start_date', 'like', Carbon::today()->toDateString() . '%')
            // ->where('start_date', '=', Carbon::today()->toDateString())
            ->orderBy('start_date', 'ASC')
            ->paginate(6);

        $previousTimeTable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->whereIn('id', $timetableIds)
            ->where('start_date', '<', Carbon::today())
            // ->where('start_date', '=', Carbon::today()->toDateString())
            ->orderBy('start_date', 'ASC')
            ->paginate(6);

        //    return $todayTimetable;
        $weeklyTimetable = TimeTable::whereDate('start_date', '>', Carbon::now())
            ->whereDate('start_date', '<=', Carbon::now()->addDay(8))
            ->where(function ($query) use ($timetableIds) {
                $query->whereIn('id', $timetableIds);
            })
            ->orderBy('start_date', 'ASC')
            ->paginate(6);

        // ->whereIn('id','=',$timetableIds)

        foreach ($todayTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);

            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }
        foreach ($previousTimeTable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);

            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }
        foreach ($weeklyTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);

            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
                $value->teacherInfo = $teacher;
            } else {
                $value->teacherName = null;
                $value->teacherInfo = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }

        return array(
            "status"  => "ok",
            "message" => "",
            "todayTimetable"  => $todayTimetable,
            "weeklyTimetable"  => $weeklyTimetable,
            "previousTimeTable"  => $previousTimeTable
        );
    }

    public function getSessionDetail(Request $request)
    {
        $timetable = [];
        $timetable = TimeTable::with('teacher')
            ->with('subject')
            ->where('id', $request->timetable_id)->get();

        foreach ($timetable as $key => $value) {
            if ($value->start_date < Carbon::today()) {
                $historyDate = 'true';
            } else {
                $historyDate = 'false';
            }
            $value->historyDate = $historyDate;
            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
            } else {
                $value->isToday = 'no';
            }
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $timetable
        );
    }

    public function getClassesList(Request $request)
    {
        $sessions = TimeTable::where('id', $request->timetable_id)->first();
        $timetable = [];
        if ($request->mode == 'new') {
            $timetable = TimeTable::with('teacher')
                ->with('student')
                ->with('subject')
                ->where('id', '=', $request->timetable_id)->get();
        } else {
            $timetable = TimeTable::with('teacher')
                ->with('student')
                ->with('subject')
                ->where('session_id', '=', $sessions->session_id)->where('start_date', '<', Carbon::today())->orderBy('start_date', 'ASC')->paginate(1);
        }
        foreach ($timetable as $key => $value) {
            // $date = Carbon::parse($value->start_date)->format('Y-m-d H:i:s');
            // $todayDate = Carbon::now()->format('Y-m-d H:i:s');

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
            } else {
                $value->isToday = 'no';
            }
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $timetable
        );
    }
    public function getStudentSessionDetail(Request $request)
    {

        $timetable = TimeTable::with('teacher')
            ->with('subject')
            ->where('id', $request->timetable_id)->get();
        foreach ($timetable as $key => $value) {
            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
            } else {
                $value->isToday = 'no';
            }
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $timetable
        );
    }
    public function getSessionDetails(Request $request)
    {

        $timetable = TimeTable::with('teacher')
            ->with('student')
            ->with('subject')
            ->where('id', $request->timetable_id)->get();
        foreach ($timetable as $key => $value) {
            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
            } else {
                $value->isToday = 'no';
            }
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $timetable
        );
    }

    public function getTeacherClassess($id)
    {
        $sub = TimeTable::orderBy('id', 'DESC');
        $todayTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->where('teacher_id', '=', $id)
            ->where('start_date', 'like', Carbon::today()->toDateString() . '%')
            // ->where('start_date', '=', Carbon::today()->toDateString())
            ->orderBy('start_date', 'ASC')
            ->get();

        $previousTimeTable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->where('teacher_id', '=', $id)
            ->where('start_date', '<', Carbon::today())
            ->orderBy('start_date', 'ASC')
            ->get();

        $weeklyTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->where('teacher_id', '=', $id)
            // ->whereDate('start_date', '>=', Carbon::now()->subDays(8))->whereDate('start_date', '>', Carbon::now())
            ->whereDate('start_date', '>', Carbon::now())
            ->whereDate('start_date', '<=', Carbon::now()->addDay(8))
            ->orderBy('start_date', 'ASC')
            ->get();

        // return $todayTimetable;
        foreach ($todayTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            $studentIds = StudentSession::where('timetable_id', $value->id)->pluck('student_id');
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }
        foreach ($previousTimeTable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            $studentIds = StudentSession::where('timetable_id', $value->id)->pluck('student_id');
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }
        foreach ($weeklyTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            $studentIds = StudentSession::where('timetable_id', $value->id)->pluck('student_id');
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
                $value->teacherInfo = $teacher;
            } else {
                $value->teacherName = null;
                $value->teacherInfo = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }

        return array(
            "status"  => "ok",
            "message" => "",
            "todayTimetable"  => $todayTimetable,
            "weeklyTimetable"  => $weeklyTimetable,
            "previousTimeTable"  => $previousTimeTable
        );
    }
    public function getTodayClassess(Request $request)
    {
        $sub = TimeTable::orderBy('id', 'DESC');
        $todayTimetable ="";
        if ($request->mode == 'student') {
            $timetableIds = StudentSession::where('student_id',$request->student_id)->groupBy('timetable_id')->pluck('timetable_id');
            $todayTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->where('start_date', 'like', Carbon::today()->toDateString() . '%')
            ->whereIn('id', $timetableIds)
            ->orderBy('start_date', 'ASC')
            ->paginate(6);
            // return $this->getStudentClassess($request->student_id);
        } else if ($request->mode == 'teacher') {
            $todayTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                // ->groupBy('session_id')
                ->where('start_date', 'like', Carbon::today()->toDateString() . '%')
                ->where('id', '=',$request->teacher_id)
                ->orderBy('start_date', 'ASC')
                ->paginate(6);
            // return $this->getTeacherClassess($request->teacher_id);
        } else {
            $todayTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
                // ->groupBy('session_id')
                ->where('start_date', 'like', Carbon::today()->toDateString() . '%')
                // ->where('start_date', '=', Carbon::today()->toDateString())
                ->orderBy('start_date', 'ASC')
                ->paginate(6);
        }

        foreach ($todayTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            $studentIds = StudentSession::where('timetable_id', $value->id)->pluck('student_id');
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "todayTimetable"  => $todayTimetable
        );
    }
    public function getWeeklyClassess(Request $request)
    {
        $sub = TimeTable::orderBy('id', 'DESC');
        $weeklyTimetable = "";
        if ($request->mode == 'student') {
            $timetableIds = StudentSession::where('student_id',$request->student_id)->groupBy('timetable_id')->pluck('timetable_id');
            $weeklyTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
        // ->groupBy('session_id')
        // ->whereDate('start_date', '>=', Carbon::now()->subDays(8))->whereDate('start_date', '>', Carbon::now())
        ->whereDate('start_date', '>', Carbon::now())
        ->whereDate('start_date', '<=', Carbon::now()->addDay(8))
        ->whereIn('id', $timetableIds)
        ->orderBy('start_date', 'ASC')
        ->paginate(6);
            // return $this->getStudentClassess($request->student_id);
        } else if ($request->mode == 'teacher') {
            $weeklyTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
        // ->groupBy('session_id')
        // ->whereDate('start_date', '>=', Carbon::now()->subDays(8))->whereDate('start_date', '>', Carbon::now())
        ->whereDate('start_date', '>', Carbon::now())
        ->whereDate('start_date', '<=', Carbon::now()->addDay(8))
        ->where('teacher_id',$request->teacher_id)
        ->orderBy('start_date', 'ASC')
        ->paginate(6);
            // return $this->getTeacherClassess($request->teacher_id);
        } else {
            $weeklyTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            // ->whereDate('start_date', '>=', Carbon::now()->subDays(8))->whereDate('start_date', '>', Carbon::now())
            ->whereDate('start_date', '>', Carbon::now())
            ->whereDate('start_date', '<=', Carbon::now()->addDay(8))
            ->orderBy('start_date', 'ASC')
            ->paginate(6);
        }


        foreach ($weeklyTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            $studentIds = StudentSession::where('timetable_id', $value->id)->pluck('student_id');
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
                $value->teacherInfo = $teacher;
            } else {
                $value->teacherName = null;
                $value->teacherInfo = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }

        return array(
            "status"  => "ok",
            "message" => "",
            "weeklyTimetable"  => $weeklyTimetable
        );
    }
    public function getPreviousClassess(Request $request)
    {
        $sub = TimeTable::orderBy('id', 'DESC');
        $previousTimeTable = '';
        if ($request->mode == 'student') {
            $timetableIds = StudentSession::where('student_id',$request->student_id)->groupBy('timetable_id')->pluck('timetable_id');
            $previousTimeTable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->whereIn('id',$timetableIds)
            ->where('start_date', '<', Carbon::today())
            ->orderBy('start_date', 'ASC')
            ->paginate(6);
        } else if ($request->mode == 'teacher') {
            $previousTimeTable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
        // ->groupBy('session_id')
        ->where('id',$request->teacher_id)
        ->where('start_date', '<', Carbon::today())
        ->orderBy('start_date', 'ASC')
        ->paginate(6);
        } else {
            $previousTimeTable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->where('start_date', '<', Carbon::today())
            ->orderBy('start_date', 'ASC')
            ->paginate(6);
        }

       
        
        foreach ($previousTimeTable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            $studentIds = StudentSession::where('timetable_id', $value->id)->pluck('student_id');
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
                $value->teacherInfo = $teacher;
            } else {
                $value->teacherName = null;
                $value->teacherInfo = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }

        return array(
            "status"  => "ok",
            "message" => "",
            "previousTimeTable" => $previousTimeTable
        );
    }

    public function getAllClassess(Request $request)
    {
        $sub = TimeTable::orderBy('id', 'DESC');
        $todayTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->where('start_date', 'like', Carbon::today()->toDateString() . '%')
            // ->where('start_date', '=', Carbon::today()->toDateString())
            ->orderBy('start_date', 'ASC')
            ->paginate(20);

        $previousTimeTable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            ->where('start_date', '<', Carbon::today())
            ->orderBy('start_date', 'ASC')
            ->paginate(20);

        $weeklyTimetable = DB::table(DB::raw("({$sub->toSql()}) as sub"))
            // ->groupBy('session_id')
            // ->whereDate('start_date', '>=', Carbon::now()->subDays(8))->whereDate('start_date', '>', Carbon::now())
            ->whereDate('start_date', '>', Carbon::now())
            ->whereDate('start_date', '<=', Carbon::now()->addDay(8))
            ->orderBy('start_date', 'ASC')
            ->paginate(20);
        // return $todayTimetable;
        foreach ($todayTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            $studentIds = StudentSession::where('timetable_id', $value->id)->pluck('student_id');
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
            } else {
                $value->teacherName = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }

        foreach ($weeklyTimetable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            $studentIds = StudentSession::where('timetable_id', $value->id)->pluck('student_id');
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
                $value->teacherInfo = $teacher;
            } else {
                $value->teacherName = null;
                $value->teacherInfo = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }
        foreach ($previousTimeTable as $key => $value) {
            $subject = Subject::find($value->subject_id);
            $teacher = Teacher::find($value->teacher_id);
            $studentIds = StudentSession::where('timetable_id', $value->id)->pluck('student_id');
            $students = Student::whereIn('id', $studentIds)->get();
            $value->students = $students;
            if ($subject) {
                $value->subjectName = $subject->name;
            } else {
                $value->subjectName = null;
            }
            if ($teacher) {
                $value->teacherName = $teacher->first_name . ' ' . $teacher->middle_name . ' ' . $teacher->last_name;
                $value->teacherInfo = $teacher;
            } else {
                $value->teacherName = null;
                $value->teacherInfo = null;
            }

            $date = Carbon::parse($value->start_date)->format('Y-m-d');
            $todayDate = Carbon::now()->format('Y-m-d');
            $time = Carbon::parse($value->end_time)->format('h:i:s A');

            if ($date == $todayDate) {
                $value->isToday = 'yes';
                $value->classEndTime = $time;
            } else {
                $value->isToday = 'no';
                $value->classEndTime = $time;
            }
        }
        return array(
            "status"  => "ok",
            "message" => "",
            "todayTimetable"  => $todayTimetable,
            "weeklyTimetable"  => $weeklyTimetable,
            "previousTimeTable" => $previousTimeTable
        );
    }
    public function getGrade($id)
    {
        $grade = Grade::with(['subject' => function ($q) {
            $q->select('subject.id', 'subject.name');
        }])->with(['teacher' => function ($q) {
            $q->select('teachers.id', 'teachers.first_name', 'teachers.middle_name', 'teachers.last_name');
        }])->with(['timetable' => function ($q) {
            $q->select('timetable.id', 'timetable.time_am_pm');
        }])
            ->where('id', '=', $id)->first();

        return array(
            "status"  => "ok",
            "message" => "",
            "result"  => $grade
        );
    }

    public function addGrade(Request $request)
    {

        $validator =  Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'ClassType' => 'required',
            ]
        );


        if ($validator->fails()) {
            return $this->getError($validator->errors()->all());
        }
        $grade = new Grade();
        $grade->name = $request->name;
        $grade->ClassType = $request->ClassType;
        $grade->subject_id = $request->subject_id;
        $grade->teacher_id = $request->teacher_id;
        $grade->slot_id = $request->slot_id;
        $grade->save();

        //   foreach ($request->selectedSubjects as $key => $value) {
        //     $gradesubject = new GradeSubject();
        //     $gradesubject->grade_id = $grade->id;
        //     $gradesubject->subject_id = $value['id'];
        //     $gradesubject->save();
        // }

        // event(new TaskCreatedEvent($grade));
        //   $grade =  Grade::find(1);
        broadcast(new TaskCreatedEvent($grade));

        return array(
            "status"  => "ok",
            "message" => "Stored",
            "result"  => '$grade'
        );
    }
    public function updateGrade(Request $request, $id)
    {
        $grade = Grade::where('id', $id)->first();
        $grade->name = $request->name;
        $grade->ClassType = $request->ClassType;
        $grade->subject_id = $request->subject_id;
        $grade->teacher_id = $request->teacher_id;
        $grade->slot_id = $request->slot_id;
        $grade->save();

        return array(
            "status"  => "ok",
            "message" => "grade Record Update Successfully",
            "result"  => $grade
        );
    }
    public function deleteGrade(Request $request)
    {
        $grdTeacher = GradeTeacher::where('grade_id', $request->id)->delete();
        $grdSubject = GradeSubject::where('grade_id', $request->id)->delete();
        return parent::destroy($request->id);
    }
}
