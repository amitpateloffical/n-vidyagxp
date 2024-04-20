<?php

namespace App\Http\Controllers\tms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainerQualification;
use Illuminate\Support\Facades\Auth;

class TrainerQualificationController extends Controller
{
    public function index()
    {
        return view('frontend.TMS.trainer_qualification');
    }


    public function store(Request $request)
    {
        // if (!$request->short_description) {
        //     toastr()->error("Short description is required");
        //     return response()->redirect()->back()->withInput();
        // }

        $Trainer = new TrainerQualification();
       
        //dd($Trainer->all());
        // $Trainer->record_number=  ((RecordNumber::first()->value('counter')) + 1);
        $Trainer->division_code=$request->division_code;
        $Trainer->Initiator_id= Auth::user()->id;
        $Trainer->intiation_date=$request->intiation_date;
        $Trainer->assign_to=$request->assign_to;
        $Trainer->due_date=$request->record_number;
        $Trainer->short_description=$request->short_description;
        $Trainer->trainer_name=$request->trainer_name;
        $Trainer->qualification=$request->qualification;
        $Trainer->designation=$request->designation;
        $Trainer->department=$request->department;
        $Trainer->Experience=$request->Experience;
        $Trainer->priority_level=$request->priority_level;
        $Trainer->initiated_through=$request->initiated_through;
        $Trainer->initiated_if_other=$request->initiated_if_other;
        $Trainer->external_agencies=$request->external_agencies;
        $Trainer->trainer_skill_set = is_array($request->trainer_skill_set) ? implode(',', $request->trainer_skill_set) : $request->trainer_skill_set;

        $Trainer->serial_number = is_array($request->serial_number) ? implode(',', $request->serial_number) : $request->serial_number;
        
        $Trainer->title_of_document = is_array($request->title_of_document) ? implode(',', $request->title_of_document) : $request->title_of_document;
        
        $Trainer->supporting_document = is_array($request->supporting_document) ? implode(',', $request->supporting_document) : $request->supporting_document;
        
        $Trainer->remarks = is_array($request->remarks) ? implode(',', $request->remarks) : $request->remarks;
        $Trainer->trainingQualificationStatus = is_array($request->trainingQualificationStatus) ? implode(',', $request->trainingQualificationStatus) : $request->trainingQualificationStatus;
        
       // $Trainer->trainingQualificationStatus=$request->trainingQualificationStatus;
        $Trainer->Q_comment=$request->Q_comment;
        if (!empty ($request->inv_attachment)) {
            $files = [];
            if ($request->hasfile('inv_attachment')) {
                foreach ($request->file('inv_attachment') as $file) {
                    $name = $request->name . 'inv_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Trainer->inv_attachment = json_encode($files);
        }
        $Trainer->Save();       

    }


   

    public function show($id)
    {
        $trainer = TrainerQualification::find($id);
        return view('frontend.TMS.trainer_qualification_view', compact('trainer'));
    }
  
    public function update(Request $request, $id)
    {


        $Trainer = TrainerQualification::find($id);
        $Trainer->division_code=$request->division_code;
        $Trainer->intiation_date=$request->intiation_date;
        $Trainer->assign_to=$request->assign_to;
        $Trainer->due_date=$request->record_number;
        $Trainer->short_description=$request->short_description;
        $Trainer->trainer_name=$request->trainer_name;
        $Trainer->qualification=$request->qualification;
        $Trainer->designation=$request->designation;
        $Trainer->department=$request->department;
        $Trainer->Experience=$request->Experience;
        $Trainer->priority_level=$request->priority_level;
        $Trainer->initiated_through=$request->initiated_through;
        $Trainer->initiated_if_other=$request->initiated_if_other;
        $Trainer->external_agencies=$request->external_agencies;
        $Trainer->trainer_skill_set = is_array($request->trainer_skill_set) ? implode(',', $request->trainer_skill_set) : $request->trainer_skill_set;

        $Trainer->serial_number = is_array($request->serial_number) ? implode(',', $request->serial_number) : $request->serial_number;
        
        $Trainer->title_of_document = is_array($request->title_of_document) ? implode(',', $request->title_of_document) : $request->title_of_document;
        
        $Trainer->supporting_document = is_array($request->supporting_document) ? implode(',', $request->supporting_document) : $request->supporting_document;
        
        $Trainer->remarks = is_array($request->remarks) ? implode(',', $request->remarks) : $request->remarks;
        $Trainer->trainingQualificationStatus = is_array($request->trainingQualificationStatus) ? implode(',', $request->trainingQualificationStatus) : $request->trainingQualificationStatus;
        
       // $Trainer->trainingQualificationStatus=$request->trainingQualificationStatus;
        $Trainer->Q_comment=$request->Q_comment;
        if (!empty ($request->inv_attachment)) {
            $files = [];
            if ($request->hasfile('inv_attachment')) {
                foreach ($request->file('inv_attachment') as $file) {
                    $name = $request->name . 'inv_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Trainer->inv_attachment = json_encode($files);
        }
        $Trainer->update();       




    }



}
