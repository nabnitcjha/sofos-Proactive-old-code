<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;
    protected $table = 'teachers';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function student()
    {
        return $this->belongsToMany(Student::class, 'student_teachers','teacher_id' ,'student_id');
    }

    public function grade()
    {
        return $this->belongsToMany(Grade::class, 'gradeteacher','teacher_id' ,'grade_id');
    }

    public function subject()
    {
        return $this->belongsToMany(Subject::class,'subject_teacher','teacher_id' ,'subject_id');
    }
    
}
 