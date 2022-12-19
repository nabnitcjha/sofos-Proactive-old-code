<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;
    protected $table = 'assessment';

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    
    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function assessmentsolution()
    {
        return $this->hasOne(AssignmentSolution::class,'assessment_id');
    }

}
