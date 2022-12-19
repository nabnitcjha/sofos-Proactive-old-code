<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    use HasFactory;
    protected $table = 'grade';

    public function subject()
    {
        return $this->belongsTo(Subject::class,'subject_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    public function timetable()
    {
        return $this->belongsTo(TimeTable::class,'slot_id');
    }
}
