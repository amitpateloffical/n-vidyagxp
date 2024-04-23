<?php

namespace App\Http\Controllers\tms;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrainerQualification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use Carbon\Carbon;
class TrainerQualificationController extends Controller
{
    public function index()
    {
        return view('frontend.TMS.trainer_qualification');
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'short_description' => 'required|string|max:255',
        ]);
        
  
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }



        $Trainer = new TrainerQualification();
       
        //dd($Trainer->all());
        // $Trainer->record_number=  ((RecordNumber::first()->value('counter')) + 1);
        $Trainer->division_id="7";
        $Trainer->Initiator_id= Auth::user()->id;
        $Trainer->intiation_date=$request->intiation_date;
        $Trainer->assign_to=$request->assign_to;
        $Trainer->due_date=$request->due_date;
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

        $Trainer->status = 'Opened';
        $Trainer->Stage = 1;
        $Trainer->Save();       
     return redirect()->route('TMS.index')->with('success', 'Data successfully stored!');

    }


   

    public function show($id)
    {
        $trainer = TrainerQualification::find($id);
        return view('frontend.TMS.trainer_qualification_view', compact('trainer'));
    }
  
    public function update(Request $request, $id)
    {


        $Trainer = TrainerQualification::find($id);
        $Trainer->division_id="7";
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
        //return redirect()->with('success', 'Data successfully stored!');
        return back();



    }




    public function trainer_send_stage(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $trainer = TrainerQualification::find($id);

            
            if ($trainer->Stage == 1) {

                if ($trainer->status !== 'Opened') 
                {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'General Information Tab is yet to be filled'
                    ]);

                    return redirect()->back();
                } else {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Sent for HOD review state'
                    ]);
                }

                

                

                $trainer->Stage = "2";
                $trainer->status = "HOD Review";
                $trainer->submit_by = Auth::user()->name;
                $trainer->submit_on = Carbon::now()->format('Y-m-d'); // Corrected date format
                $trainer->submit_comment = $request->comment;





                // $history = new DeviationAuditTrail();
                // $history->deviation_id = $id;
                // $history->activity_type = 'Activity Log';
                // $history->previous = "";
                // $history->action='Submit';
                // $history->current = $deviation->submit_by;
                // $history->comment = $request->comment;
                // $history->user_id = Auth::user()->id;
                // $history->user_name = Auth::user()->name;
                // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                // $history->origin_state = $lastDocument->status;
                // $history->change_to =   "HOD Review";
                // $history->change_from = $lastDocument->status;
                // $history->stage = 'Plan Proposed';
                // $history->save();


                // $list = Helpers::getHodUserList();
                // foreach ($list as $u) {
                //     if ($u->q_m_s_divisions_id == $deviation->division_id) {
                //         $email = Helpers::getInitiatorEmail($u->user_id);
                //         if ($email !== null) {

                //             try {
                //                 Mail::send(
                //                     'mail.view-mail',
                //                     ['data' => $deviation],
                //                     function ($message) use ($email) {
                //                         $message->to($email)
                //                             ->subject("Activity Performed By " . Auth::user()->name);
                //                     }
                //                 );
                //             } catch (\Exception $e) {
                //                 //log error
                //             }
                //         }
                //     }
                // }

                // $list = Helpers::getHeadoperationsUserList();
                // foreach ($list as $u) {
                //     if ($u->q_m_s_divisions_id == $deviation->division_id) {
                //         $email = Helpers::getInitiatorEmail($u->user_id);
                //         if ($email !== null) {

                //             Mail::send(
                //                 'mail.Categorymail',
                //                 ['data' => $deviation],
                //                 function ($message) use ($email) {
                //                     $message->to($email)
                //                         ->subject("Activity Performed By " . Auth::user()->name);
                //                 }
                //             );
                //         }
                //     }
                // }

                


                $trainer->update();

                
                return back();
            }
            if ($trainer->Stage == 2) {
            

                $trainer->Stage = "3";
                $trainer->status = "closed-Done";
                $trainer->HOD_Review_Complete_By = Auth::user()->name;
                $trainer->HOD_Review_Complete_On = Carbon::now()->format('Y-m-d');
                $trainer->HOD_Review_Comments = $request->comment;


                $trainer->update();
                toastr()->success('Document Sent');
                return back();
            }

           


















        }

        return "test";
    }


    



    public function trainer_reject(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
        $trainer = TrainerQualification::find($id);

      

            if ($trainer->Stage == 2) {

                $trainer->Stage = "1";
                $trainer->status = "Opened";
                $trainer->rejected_by = Auth::user()->name;
                $trainer->rejected_on = Carbon::now()->format('Y-m-d');
                $trainer->update();
               
                toastr()->success('Document Sent');
                return back();
            }

            // if ($trainer->Stage == 3) {
            //     $trainer->Stage = "2";
            //     $trainer->status = "HOD Review  Qualified";
            //     $trainer->form_progress = 'hod';

            //     $trainer->qa_more_info_required_by = Auth::user()->name;
            //     $trainer->qa_more_info_required_on = Carbon::now()->format('d-M-Y');

            //     $deviation->update();
               




    }
    }
}
