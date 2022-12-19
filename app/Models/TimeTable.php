<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeTable extends Model
{
    use HasFactory;
    protected $table = 'timetable';

    public function grade()
    {
        return $this->belongsTo(Grade::class,'class_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function alloted_classes()
    {
        return $this->hasOne(AllotedClasses::class,'slot_id');
    }
    public function used_slot()
    {
        return $this->hasOne(Grade::class,'slot_id');
    }
    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_sessions','timetable_id' ,'student_id');
    }


}
 