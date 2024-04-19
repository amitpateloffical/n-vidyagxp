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
        // $Trainer->record_number=$request->record_number;
        // $Trainer->division_code=$request->division_code;
        // $Trainer->Initiator_id=$request->record_number;
        // $Trainer->intiation_date=$request->intiation_date;
        // $Trainer->assign_to=$request->assign_to;
        // $Trainer->due_date=$request->record_number;
        // $Trainer->short_description=$request->short_description;
        // $Trainer->trainer_name=$request->trainer_name;
        // $Trainer->qualification=$request->qualification;
        // $Trainer->designation=$request->designation;
        // $Trainer->department=$request->department;
        // $Trainer->Experience=$request->Experience;
        // $Trainer->priority_level=$request->priority_level;
        // $Trainer->initiated_through=$request->initiated_through;
        // $Trainer->initiated_if_other=$request->initiated_if_other;
        // $Trainer->external_agencies=$request->external_agencies;
        // $Trainer->trainer_skill_set=$request->trainer_skill_set;
        // $Trainer->serial_number=$request->serial_number;

        // $Trainer->title_of_document=$request->title_of_document;
        // $Trainer->supporting_document=$request->supporting_document;
        // $Trainer->remarks=$request->remarks;
        // $Trainer->trainingQualificationStatus=$request->trainingQualificationStatus;
        // $Trainer->Q_comment=$request->Q_comment;
        // $Trainer->inv_attachment=$request->inv_attachment;
        // $Trainer->Save();       

    }

    public  function show($id)
    {
        $Trainer = TrainerQualification::find($id);
        dd($Trainer->all());
        return view('forntend.TMS.trainer_qualification_view', compact('Trainer'));
    }

    public  function update(Request $request, $id)
    {
        // dd($request->all());
        $Trainer = TrainerQualification::find($id);
        if ($Trainer) {
            $Trainer->record_number = $request->record_number;
            $Trainer->division_code = $request->division_code;
            $Trainer->Initiator_id = $request->Initiator_id;
            $Trainer->intiation_date = $request->intiation_date;
            $Trainer->assign_to = $request->assign_to;
            $Trainer->due_date = $request->due_date;
            $Trainer->short_description = $request->short_description;
            $Trainer->retrainer_namecord_number = $request->trainer_name;
            $Trainer->qualification = $request->qualification;
            $Trainer->designation = $request->designation;
            $Trainer->department = $request->department;
            $Trainer->Experience = $request->Experience;
            $Trainer->priority_level = $request->priority_level;
            $Trainer->initiated_through = $request->initiated_through;
            $Trainer->initiated_if_other = $request->initiated_if_other;
            $Trainer->external_agencies = $request->external_agencies;
            $Trainer->trainer_skill_set = $request->trainer_skill_set;
            $Trainer->serial_number = $request->serial_number;
            $Trainer->title_of_document = $request->title_of_document;
            $Trainer->supporting_document = $request->supporting_document;
            $Trainer->remarks = $request->remarks;
            $Trainer->trainingQualificationStatus = $request->trainingQualificationStatus;
            $Trainer->Q_comment = $request->Q_comment;
            $Trainer->inv_attachment = $request->inv_attachment;

            $Trainer->update();
        } else {
        }
    }
}
