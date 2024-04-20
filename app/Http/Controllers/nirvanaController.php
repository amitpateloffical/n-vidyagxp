<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\nirvana;
use Illuminate\Support\Facades\Auth;


class nirvanaController extends Controller
{
    public function store(Request $request)
    {
      //  dd($request->all());
       
        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return response()->redirect()->back()->withInput();
        }

        $nirvana = new nirvana();
       // $nirvana->form_type = "nirvana";
       // $nirvana->record = ((RecordNumber::first()->value('counter')) + 1);
       //dd($request);

        # -------------new--------------------------------
        $nirvana->parent_id = $request->parent_id;
          $nirvana->record_number = $request->record_number;
        $nirvana->division_id = $request->division_id;
        $nirvana->assign_to = $request->assign_to;
        $nirvana->due_date = $request->due_date;
        $nirvana->intiation_date = $request->intiation_date;
        $nirvana->short_description = $request->short_description;
        $nirvana->Class_Session_information = $request->Class_Session_information;
        $nirvana->Trainer_Name = $request->Trainer_Name;
        $nirvana->audit_type = $request->audit_type;
        $nirvana->registrationend_date = $request->registrationend_date;
        $nirvana->Training_Topic = $request->Training_Topic;
        $nirvana->Scheduled_Start_date = $request->Scheduled_Start_date;
        $nirvana->Scheduled_End_date= $request->Scheduled_End_date;
        $nirvana->initial_comments = $request->initial_comments;
      //  $nirvana->audit-agenda-grid = $request->audit-agenda-grid;
      $nirvana->serial_number = $request->serial_number;
    
    
        $nirvana->Title_Document = $request->Title_Document;
        $nirvana->Remarks = $request->Remarks;
        $nirvana->date = $request->date;
        $nirvana->start_time = $request->start_time;
        $nirvana->end_time = $request->end_time;
        $nirvana->topic = $request->topic;
        $nirvana->responsible_person = $request->responsible_person;
        $nirvana->Supporting_Documents = $request->Supporting_Documents;
      //  $nirvana->inv_attachment = $request->inv_attachment;
       // $nirvana->No_Attempts = $request->No_Attempts;
       // $nirvana->audit_file_attachment = $request->audit_file_attachment;
      //  $nirvana->Rating = $request->Rating;

//=============================Attendance Information====================================

       // $nirvana->TrainingTopic = $request->TrainingTopic;
        $nirvana->TrainersMultipersonField= $request->TrainersMultipersonField;
        $nirvana->AttendeeName = $request->AttendeeName;
        $nirvana->Department = $request->Department;
        $nirvana->TrainingAttended = $request->TrainingAttended;
        $nirvana->Training_ModeOnline_Classroom = $request->Training_ModeOnline_Classroom;
        $nirvana->Training_Completion_Date= $request->Training_Completion_Date;
        $nirvana->pass_fail = $request->pass_fail;
        $nirvana->No_Attempts = $request->No_Attempts;
        $nirvana->Rating = $request->Rating;
     //  $nirvana->Supporting_Document = $request->Supporting Document;
        $nirvana->remarks_2 = $request->remarks_2;
        $nirvana->Title_Document = $request->Title_Document;
        $nirvana->Department = $request->Department;

       // $nirvana->Supporting_Document= $request->Supporting_Document;
        $nirvana->Remarks_3 = $request->Remarks_3;
        $nirvana->Feedback = $request->Feedback;
        $nirvana->if_comments = $request->if_comments;
        $nirvana->TrainingTopic = $request->TrainingTopic;
        $nirvana->save();
       // return redirect()->route('')->with('success', 'Data saved successfully!');
        

}
     public function classroomdetails($id){
        $nirvana = nirvana::find($id);
    // dd($data);
        return view('frontend.TMS.classroom_training_view', compact('nirvana'));

}
 public function update(Request $request, $id)
        {
        // dd($request->all());
            if (!$request->short_description) {
                toastr()->error("Short description is required");
                return redirect()->back();
            }
            $nirvana = nirvana::find($id);

            $nirvana->TrainersMultipersonField = $request->TrainersMultipersonField;
            $nirvana->AttendeeName = $request->AttendeeName;
            $nirvana->Department = $request->Department;
            $nirvana->due_date = $request->due_date;
            $nirvana->TrainingAttended = $request->TrainingAttended;
            $nirvana->Training_ModeOnline_Classroom = $request->Training_ModeOnline_Classroom;
            $nirvana->Training_Completion_Date = $request->Training_Completion_Date;
            $nirvana->pass_fail = $request->pass_fail;
            $nirvana->No_Attempts = $request->No_Attempts;
            $nirvana->Rating = $request->Rating;
            // $nirvana->Supporting Document_2 = $request->Supporting Document_2;
            $nirvana->remarks_2= $request->remarks_2;
            $nirvana->Title_Document_2= $request->Title_Document_2;
            // $nirvana->Supporting_Document-3= $request->Supporting_Document-3;
            $nirvana->Remarks_3= $request->Remarks_3;
            $nirvana->Feedback= $request->Feedback;
            $nirvana->if_comments= $request->if_comments;
            $nirvana->parent_id = $request->parent_id;
            $nirvana->record_number = $request->record_number;
          $nirvana->division_id = $request->division_id;
          $nirvana->assign_to = $request->assign_to;
          $nirvana->due_date = $request->due_date;
          $nirvana->intiation_date = $request->intiation_date;
          $nirvana->short_description = $request->short_description;
          $nirvana->Class_Session_information = $request->Class_Session_information;
          $nirvana->Trainer_Name = $request->Trainer_Name;
          $nirvana->audit_type = $request->audit_type;
          $nirvana->registrationend_date = $request->registrationend_date;
          $nirvana->Training_Topic = $request->Training_Topic;
          $nirvana->Scheduled_Start_date = $request->Scheduled_Start_date;
          $nirvana->Scheduled_End_date= $request->Scheduled_End_date;
          $nirvana->initial_comments = $request->initial_comments;
          $nirvana->date =$request->date;
        //  $nirvana->audit-agenda-grid = $request->audit-agenda-grid;
        $nirvana->serial_number = $request->serial_number;
      
      
          $nirvana->Title_Document = $request->Title_Document;
          $nirvana->Remarks = $request->Remarks;
          $nirvana->date = $request->date;
          $nirvana->start_time = $request->start_time;
          $nirvana->end_time = $request->end_time;
          $nirvana->topic = $request->topic;
          $nirvana->responsible_person = $request->responsible_person;
          $nirvana->Supporting_Documents = $request->Supporting_Documents;
        //  $nirvana->inv_attachment = $request->inv_attachment;
         // $nirvana->No_Attempts = $request->No_Attempts;
         // $nirvana->audit_file_attachment = $request->audit_file_attachment;
        //  $nirvana->Rating = $request->Rating;
  
  //=============================Attendance Information====================================
  
          $nirvana->TrainingTopic = $request->TrainingTopic;
         // $nirvana->TrainingTopic = $request->TrainingTopic;
            
            $nirvana->update();



          // return back('nirvanastore')->with('data update success');
         return back()->with('success', 'Data update successful');

        
          }

            

//         }


}
