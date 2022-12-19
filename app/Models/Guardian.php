<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guardian extends Model
{
    use HasFactory;
    protected $table = 'parents';

    public function student()
    {
        return $this->belongsToMany(Student::class, 'parent_students','parent_id' ,'student_id');
    }

}
