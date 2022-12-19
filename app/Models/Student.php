<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $table = 'students';

    public function parent()
    {
        return $this->belongsToMany(Guardian::class, 'parent_students', 'student_id', 'parent_id');
    }

    public function teacher()
    {
        return $this->belongsToMany(Teacher::class, 'student_teachers', 'student_id','teacher_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->belongsToMany(Subject::class, 'student_subject','student_id' ,'subject_id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }
    public function allotedclass()
    {
        return $this->hasMany(AllotedClasses::class,'student_id');
    }
    public function timetable()
    {
        return $this->belongsToMany(TimeTable::class, 'student_sessions','student_id' ,'timetable_id');
    }
}
