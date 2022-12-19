<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSolution extends Model
{
    use HasFactory;
    protected $table = 'assessment_solution';

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }
}
