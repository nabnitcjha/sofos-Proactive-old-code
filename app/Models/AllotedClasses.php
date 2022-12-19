<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AllotedClasses extends Model
{
    use HasFactory;
    protected $table = 'alloted_classes';

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class,'teacher_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
    public function slot()
    {
        return $this->belongsTo(TimeTable::class,'slot_id');
    }
    public function grade()
    {
        return $this->belongsTo(Grade::class,'grade_id');
    }
}
