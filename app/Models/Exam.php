<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $fillable=[
        'total_subject',
        'questions_per_subject',
        'exam_Intruction',
        'exam_date',
        'student_delay',
        'randomize_questions',
        'randomize_answer',
        'exam_end_instruction',
        'year',
        'school_id',
    ];

    public function school(){
        return $this->belongsTo(School::class);
    }

    public function courses(){
        return $this->hasMany(Course::class);
    }

    public function students(){
        return $this->hasMany(Student::class);
    }

}
