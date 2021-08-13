<?php

namespace App\Http\Controllers;
use App\Models\Exam;
use Illuminate\Http\Response;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    
    public function index()
    {
       return Exam::all();
    }

    
    public function store(Request $request)
    {
        $data = $this->validatedExamRequests();

        $exam = new Exam();
        $exam->total_subject = $data['total_subject'];
        $exam->questions_per_subject = $data['questions_per_subject'];
        $exam->exam_Intruction = $data['exam_Intruction'];
        $exam->exam_date = $data['exam_date'];
        $exam->student_delay = $data['student_delay'];
        $exam->randomize_questions = $data['randomize_questions'];
        $exam->randomize_answer = $data['randomize_answer'];
        $exam->exam_end_instruction = $data['exam_end_instruction'];
        $exam->year = $data['year'];
        $exam->save();

        return $exam;
      
    }

    
     
    public function show($id)
    {
       
        return Exam::find($id);
    }

 
    
    public function update(Request $request, $id)
    {
        $exam = Exam::find($id);
        $exam -> update($request->all());
        return $exam;
    }

     
    public function search($SchoolName)
    {return Exam::where('SchoolName', 'like', '%'.$SchoolName.'%')->get();
    }

   
    public function destroy($id)
    {
        return Exam::destroy($id);
    }


    public function validatedExamRequests(){
        return $examRequests = request()->validate([
            'total_subject' => 'required',
            'questions_per_subject' => 'required',
            'exam_Intruction' =>  'required',
            'exam_date' => 'required',
            'student_delay' => 'required',
            'randomize_questions' => 'required',
            'randomize_answer' => 'required',
            'exam_end_instruction' => 'required',
            'year' => 'required',
        ]);
    }
}
