<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $table = 'subject';

    public function grade()
    {
        return $this->belongsToMany(Grade::class, 'gradesubject','subject_id' ,'grade_id');
    }

    public function teacher()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher','subject_id' ,'teacher_id');
        // return $this->hasMany(Teacher::class,'subject_id');
    }

} 
