<?php

namespace App\Http\Controllers\rcms;

use App\Models\DeviationCftsResponse;
use App\Models\RootCauseAnalysis;
use App\Http\Controllers\Controller;
use App\Models\EffectivenessCheck;
use App\Models\CC;
use App\Models\ActionItem;
use App\Models\Deviation;
use App\Models\Extension;
use App\Models\DeviationAuditTrail;
use App\Models\DeviationGrid;
use App\Models\DeviationHistory;
use App\Models\DeviationCft;
use App\Models\AuditReviewersDetails;
use App\Models\UserRole;
use Illuminate\Http\Request;
use App\Models\Capa;
use App\Models\Customer;
use Carbon\Carbon;
use App\Models\RecordNumber;
use App\Models\RoleGroup;
use App\Models\User;
use Helpers;
use Illuminate\Pagination\Paginator;
use PDF;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class DeviationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deviation()
    {
        $old_record = Deviation::select('id', 'division_id', 'record')->get();
        $record_number = (RecordNumber::first()->value('counter')) + 1;
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $pre = Deviation::all();
        return response()->view('frontend.forms.deviation_new', compact('record_number', 'formattedDate', 'due_date', 'old_record', 'pre'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(request $request)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request;
        
        $form_progress = null; // initialize form progress

        if ($request->form_name == 'general')
        {
            $validator = Validator::make($request->all(), [
                'Initiator_Group' => 'required',
                'short_description' => 'required'
                
            ], [
                'Initiator_Group.required' => 'Department field required!',
                'short_description_required.required' => 'Nature of repeat field required!'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $form_progress = 'general';
            }
        }
        
        // if ($request->form_name == 'hod')
        // {
        //     $this->validate($request, [
        //         'HOD_Remarks' => 'required'
                
        //     ]);
        // }
        
        // // QA INITAL FORM VALIDATION
        // if ($request->form_name == 'qa')
        // {
        //     $this->validate($request, [
        //         'Deviation_category' => 'required',
        //         'Justification_for_categorization' => 'required',
        //         'Investigation_required' => 'required',
        //         'Investigation_Details' => 'required_if:Investigation_required,1',
        //     ]);
        // }


        if (!$request->short_description) {
            toastr()->error("Short description is required");
            return response()->redirect()->back()->withInput();
        }

        $deviation = new Deviation();
        $deviation->form_type = "Deviation";
        
        $deviation->record = ((RecordNumber::first()->value('counter')) + 1);
        $deviation->initiator_id = Auth::user()->id;

        $deviation->form_progress = isset($form_progress) ? $form_progress : null;

        # -------------new-----------
        //  $deviation->record_number = $request->record_number;
        $deviation->division_id = $request->division_id;
        $deviation->assign_to = $request->assign_to;
        $deviation->due_date = $request->due_date;
        $deviation->intiation_date = $request->intiation_date;
        $deviation->Initiator_Group = $request->Initiator_Group;
        $deviation->due_date = Carbon::now()->addDays(30)->format('d-M-Y');
        $deviation->initiator_group_code = $request->initiator_group_code;
        $deviation->short_description = $request->short_description;
        $deviation->Deviation_date = $request->Deviation_date;
        $deviation->deviation_time = $request->deviation_time;
        $deviation->Deviation_reported_date = $request->Deviation_reported_date;
        $deviation->Facility = implode(',', $request->Facility);
        // $deviation->Observed_by = $request->Observed_by;
        if (is_array($request->audit_type)) {
            $deviation->audit_type = implode(',', $request->audit_type);
        }
        $deviation->short_description_required = $request->short_description_required;
        $deviation->nature_of_repeat = $request->nature_of_repeat;
        $deviation->others = $request->others;

        $deviation->Product_Batch = $request->Product_Batch;




        $deviation->Description_Deviation = implode(',', $request->Description_Deviation);

        // $deviation->Related_Records1 =  implode(',', $request->related_records);
        $deviation->Immediate_Action = implode(',', $request->Immediate_Action);
        $deviation->Preliminary_Impact = implode(',', $request->Preliminary_Impact);
        $deviation->Product_Details_Required = $request->Product_Details_Required;

        $deviation->HOD_Remarks = $request->HOD_Remarks;
        $deviation->Deviation_category = $request->Deviation_category;
        if($request->Deviation_category=='')
        $deviation->Justification_for_categorization = $request->Justification_for_categorization;
        $deviation->Investigation_required = $request->Investigation_required;


        $deviation->Investigation_Details = $request->Investigation_Details;
        $deviation->Customer_notification = $request->Customer_notification;
        $deviation->customers = $request->customers;
        $deviation->QAInitialRemark = $request->QAInitialRemark;


        $deviation->Investigation_Summary = $request->Investigation_Summary;
        $deviation->Impact_assessment = $request->Impact_assessment;
        $deviation->Root_cause = $request->Root_cause;
        // $deviation->due_date_extension = $request->due_date_extension; 
        $deviation->CAPA_Rquired = $request->CAPA_Rquired;
        $deviation->capa_type = $request->capa_type;
        $deviation->CAPA_Description = $request->CAPA_Description;
        $deviation->Post_Categorization = $request->Post_Categorization;
        $deviation->Investigation_Of_Review = $request->Investigation_Of_Review;
        $deviation->QA_Feedbacks = $request->QA_Feedbacks;
        $deviation->Closure_Comments = $request->Closure_Comments;
        $deviation->Disposition_Batch = $request->Disposition_Batch;
        $deviation->Facility_Equipment = $request->Facility_Equipment;
        $deviation->Document_Details_Required = $request->Document_Details_Required;
        //$deviation->production_byy = $request->CFT_Review_Complete_By;

        
            // // Get the current date
            // $due_date = new Deviation();

            // // Threshold for sending notification (e.g., 7 days)
            // $threshold_days = 30;

            // // Iterate through the CEO user list
            // $list = Helpers::getCEOUserList();
            // foreach ($list as $u) {
            //     if ($u->q_m_s_divisions_id == $deviation->division_id) {
            //         $email = Helpers::getInitiatorEmail($u->user_id);
            //         if ($email !== null) {
            //             // Calculate remaining days until due date
            //             $due_date = new Deviation($deviation->due_date);
            //             $remaining_days = $due_date->diff($due_date)->days;

            //             // Check if remaining days are within the threshold
            //             if ($remaining_days <= $threshold_days) {
            //                 // Send email notification
            //                 Mail::send(
            //                     'mail.duedateapproaching',
            //                     ['data' => $deviation],
            //                     function ($message) use ($email) {
            //                         $message->to($email)
            //                             ->subject("Activity Performed By " . Auth::user()->name);
            //                     }
            //                 );
            //             }
            //         }
            //     }
            // }
        


        if ($request->Deviation_category == 'major' || $request->Deviation_category == 'minor' || $request->Deviation_category == 'critical') {
            $list = Helpers::getHeadoperationsUserList();
                    foreach ($list as $u) {
                        if ($u->q_m_s_divisions_id == $deviation->division_id) {
                            $email = Helpers::getInitiatorEmail($u->user_id);
                            if ($email !== null) {
                                 // Add this if statement
                                try {
                                    Mail::send(
                                        'mail.Categorymail',
                                        ['data' => $deviation],
                                        function ($message) use ($email) {
                                            $message->to($email)
                                                ->subject("Activity Performed By " . Auth::user()->name);
                                        }
                                    );
                                } catch (\Exception $e) {
                                    //log error
                                }
                                
                            }
                        }
                    }
                }

                
                if ($request->Deviation_category == 'major' || $request->Deviation_category == 'minor' || $request->Deviation_category == 'critical') {
                    $list = Helpers::getCEOUserList();
                            foreach ($list as $u) {
                                if ($u->q_m_s_divisions_id == $deviation->division_id) {
                                    $email = Helpers::getInitiatorEmail($u->user_id);
                                    if ($email !== null) {
                                         // Add this if statement
                                         try {
                                                Mail::send(
                                                    'mail.Categorymail',
                                                    ['data' => $deviation],
                                                    function ($message) use ($email) {
                                                        $message->to($email)
                                                            ->subject("Activity Performed By " . Auth::user()->name);
                                                    }
                                                );
                                            } catch (\Exception $e) {
                                                //log error
                                            }
                                        
                                    }
                                }
                            }
                        }
                        if ($request->Deviation_category == 'major' || $request->Deviation_category == 'minor' || $request->Deviation_category == 'critical') {
                            $list = Helpers::getCorporateEHSHeadUserList();
                                    foreach ($list as $u) {
                                        if ($u->q_m_s_divisions_id == $deviation->division_id) {
                                            $email = Helpers::getInitiatorEmail($u->user_id);
                                            if ($email !== null) {
                                                 // Add this if statement
                                                 try {
                                                        Mail::send(
                                                            'mail.Categorymail',
                                                            ['data' => $deviation],
                                                            function ($message) use ($email) {
                                                                $message->to($email)
                                                                    ->subject("Activity Performed By " . Auth::user()->name);
                                                            }
                                                        );
                                                    } catch (\Exception $e) {
                                                        //log error
                                                    }
                                                
                                            }
                                        }
                                    }
                                }                
      
                                if ($request->Post_Categorization == 'major' || $request->Post_Categorization == 'minor' || $request->Post_Categorization == 'critical') {
                                    $list = Helpers::getHeadoperationsUserList();
                                            foreach ($list as $u) {
                                                if ($u->q_m_s_divisions_id == $deviation->division_id) {
                                                    $email = Helpers::getInitiatorEmail($u->user_id);
                                                    if ($email !== null) {
                                                         // Add this if statement
                                                         try {
                                                            Mail::send(
                                                                'mail.Categorymail',
                                                                ['data' => $deviation],
                                                                function ($message) use ($email) {
                                                                    $message->to($email)
                                                                        ->subject("Activity Performed By " . Auth::user()->name);
                                                                }
                                                            );
                                                        } catch (\Exception $e) {
                                                            //log error
                                                        }
                                                        
                                                    }
                                                }
                                            }
                                        }
                                        if ($request->Post_Categorization == 'major' || $request->Post_Categorization == 'minor' || $request->Post_Categorization == 'critical') {
                                            $list = Helpers::getCEOUserList();
                                                    foreach ($list as $u) {
                                                        if ($u->q_m_s_divisions_id == $deviation->division_id) {
                                                            $email = Helpers::getInitiatorEmail($u->user_id);
                                                            if ($email !== null) {
                                                                 // Add this if statement
                                                                 try {
                                                                        Mail::send(
                                                                            'mail.Categorymail',
                                                                            ['data' => $deviation],
                                                                            function ($message) use ($email) {
                                                                                $message->to($email)
                                                                                    ->subject("Activity Performed By " . Auth::user()->name);
                                                                            }
                                                                        );
                                                                    } catch (\Exception $e) {
                                                                        //log error
                                                                    }
                                                                
                                                            }
                                                        }
                                                    }
                                                }
                                                if ($request->Post_Categorization == 'major' || $request->Post_Categorization == 'minor' || $request->Post_Categorization == 'critical') {
                                                    $list = Helpers::getCorporateEHSHeadUserList();
                                                            foreach ($list as $u) {
                                                                if ($u->q_m_s_divisions_id == $deviation->division_id) {
                                                                    $email = Helpers::getInitiatorEmail($u->user_id);
                                                                    if ($email !== null) {
                                                                         // Add this if statement
                                                                         try {
                                                                                Mail::send(
                                                                                    'mail.Categorymail',
                                                                                    ['data' => $deviation],
                                                                                    function ($message) use ($email) {
                                                                                        $message->to($email)
                                                                                            ->subject("Activity Performed By " . Auth::user()->name);
                                                                                    }
                                                                                );
                                                                            } catch (\Exception $e) {
                                                                                //log error
                                                                            }
                                                                        
                                                                    }
                                                                }
                                                            }
                                                        }                            

        if (!empty ($request->Audit_file)) {
            $files = [];
            if ($request->hasfile('Audit_file')) {
                foreach ($request->file('Audit_file') as $file) {
                    $name = $request->name . 'Audit_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->Audit_file = json_encode($files);
        }
        //dd($request->Initial_attachment);
        if (!empty ($request->Initial_attachment)) {
            $files = [];
            if ($request->hasfile('Initial_attachment')) {
                foreach ($request->file('Initial_attachment') as $file) {
                    $name = $request->name . 'Initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->Initial_attachment = json_encode($files);
        }

        if (!empty ($request->QA_attachment)) {
            $files = [];
            if ($request->hasfile('QA_attachment')) {
                foreach ($request->file('QA_attachment') as $file) {
                    $name = $request->name . 'QA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->QA_attachment = json_encode($files);
        }
        if (!empty ($request->Investigation_attachment)) {
            $files = [];
            if ($request->hasfile('Investigation_attachment')) {
                foreach ($request->file('Investigation_attachment') as $file) {
                    $name = $request->name . 'Investigation_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->Investigation_attachment = json_encode($files);
        }
        if (!empty ($request->Capa_attachment)) {
            $files = [];
            if ($request->hasfile('Capa_attachment')) {
                foreach ($request->file('Capa_attachment') as $file) {
                    $name = $request->name . 'Capa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->Capa_attachment = json_encode($files);
        }

        if (!empty ($request->QA_attachments)) {
            $files = [];
            if ($request->hasfile('QA_attachments')) {
                foreach ($request->file('QA_attachments') as $file) {
                    $name = $request->name . 'QA_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->QA_attachments = json_encode($files);
        }

        if (!empty ($request->closure_attachment)) {
            $files = [];
            if ($request->hasfile('closure_attachment')) {
                foreach ($request->file('closure_attachment') as $file) {
                    $name = $request->name . 'closure_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->closure_attachment = json_encode($files);
        }
       
        $record = RecordNumber::first();
        $record->counter = ((RecordNumber::first()->value('counter')) + 1);
        $record->update(); 


        
        $deviation->status = 'Opened';
        $deviation->stage = 1;

        $deviation->save();

        $data3 = new DeviationGrid();
        $data3->deviation_grid_id = $deviation->id;
        $data3->type = "Deviation";
        if (!empty($request->facility_name)) {
            $data3->facility_name = serialize($request->facility_name);
        }
        if (!empty($request->IDnumber)) {
            $data3->IDnumber = serialize($request->IDnumber);
        }
        
        if (!empty($request->Remarks)) {
            $data3->Remarks = serialize($request->Remarks);
        }
        $data3->save();
        $data4 = new DeviationGrid();
        $data4->deviation_grid_id = $deviation->id;
        $data4->type = "Document ";
        if (!empty($request->Number)) {
            $data4->Number = serialize($request->Number);
        }
        if (!empty($request->ReferenceDocumentName)) {
            $data4->ReferenceDocumentName = serialize($request->ReferenceDocumentName);
        }
        
        if (!empty($request->Document_Remarks)) {
            $data4->Document_Remarks = serialize($request->Document_Remarks);
        }
        $data4->save();
        


        $Cft = new DeviationCft();
        $Cft->deviation_id = $deviation->id;
        $Cft->Production_Review = $request->Production_Review;
        $Cft->Production_person = $request->Production_person;
        $Cft->Production_assessment = $request->Production_assessment;
        $Cft->Production_feedback = $request->Production_feedback;
        $Cft->production_on = $request->production_on;
        $Cft->production_by = $request->production_by; 

        $Cft->Warehouse_review = $request->Warehouse_review;
        $Cft->Warehouse_notification = $request->Warehouse_notification;
        $Cft->Warehouse_assessment = $request->Warehouse_assessment;
        $Cft->Warehouse_feedback = $request->Warehouse_feedback;
        $Cft->Warehouse_by = $request->Warehouse_Review_Completed_By;
        $Cft->Warehouse_on = $request->Warehouse_on;

        $Cft->Quality_review = $request->Quality_review;
        $Cft->Quality_Control_Person = $request->Quality_Control_Person;
        $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
        $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;
        $Cft->Quality_Control_by = $request->Quality_Control_by;
        $Cft->Quality_Control_on = $request->Quality_Control_on;

        $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
        $Cft->QualityAssurance_person = $request->QualityAssurance_person;
        $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
        $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;
        $Cft->QualityAssurance_by = $request->QualityAssurance_by;
        $Cft->QualityAssurance_on = $request->QualityAssurance_on;

        $Cft->Engineering_review = $request->Engineering_review;
        $Cft->Engineering_person = $request->Engineering_person;
        $Cft->Engineering_assessment = $request->Engineering_assessment;
        $Cft->Engineering_feedback = $request->Engineering_feedback;
        $Cft->Engineering_by = $request->Engineering_by;
        $Cft->Engineering_on = $request->Engineering_on;

        $Cft->Analytical_Development_review = $request->Analytical_Development_review;
        $Cft->Analytical_Development_person = $request->Analytical_Development_person;
        $Cft->Analytical_Development_assessment = $request->Analytical_Development_assessment;
        $Cft->Analytical_Development_feedback = $request->Analytical_Development_feedback;
        $Cft->Analytical_Development_by = $request->Analytical_Development_by;
        $Cft->Analytical_Development_on = $request->Analytical_Development_on;

        $Cft->Kilo_Lab_review = $request->Kilo_Lab_review;
        $Cft->Kilo_Lab_person = $request->Kilo_Lab_person;
        $Cft->Kilo_Lab_assessment = $request->Kilo_Lab_assessment;
        $Cft->Kilo_Lab_feedback = $request->Kilo_Lab_feedback;
        $Cft->Kilo_Lab_attachment_by = $request->Kilo_Lab_attachment_by;
        $Cft->Kilo_Lab_attachment_on = $request->Kilo_Lab_attachment_on;

        $Cft->Technology_transfer_review = $request->Technology_transfer_review;
        $Cft->Technology_transfer_person = $request->Technology_transfer_person;
        $Cft->Technology_transfer_assessment = $request->Technology_transfer_assessment;
        $Cft->Technology_transfer_feedback = $request->Technology_transfer_feedback;
        $Cft->Technology_transfer_by = $request->Technology_transfer_by;
        $Cft->Technology_transfer_on = $request->Technology_transfer_on;

        $Cft->Environment_Health_review = $request->Environment_Health_review;
        $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person;
        $Cft->Health_Safety_assessment = $request->Health_Safety_assessment;
        $Cft->Health_Safety_feedback = $request->Health_Safety_feedback;
        $Cft->Environment_Health_Safety_by = $request->Environment_Health_Safety_by;
        $Cft->Environment_Health_Safety_on = $request->Environment_Health_Safety_on;

        $Cft->Human_Resource_review = $request->Human_Resource_review;
        $Cft->Human_Resource_person = $request->Human_Resource_person;
        $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
        $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
        $Cft->Human_Resource_by = $request->Human_Resource_by;
        $Cft->Human_Resource_on = $request->Human_Resource_on;

        $Cft->Information_Technology_review = $request->Information_Technology_review;
        $Cft->Information_Technology_person = $request->Information_Technology_person;
        $Cft->Information_Technology_assessment = $request->Information_Technology_assessment;
        $Cft->Information_Technology_feedback = $request->Information_Technology_feedback;
        $Cft->Information_Technology_by = $request->Information_Technology_by;
        $Cft->Information_Technology_on = $request->Information_Technology_on;

        $Cft->Project_management_review = $request->Project_management_review;
        $Cft->Project_management_person = $request->Project_management_person;
        $Cft->Project_management_assessment = $request->Project_management_assessment;
        $Cft->Project_management_feedback = $request->Project_management_feedback;
        $Cft->Project_management_by = $request->Project_management_by;
        $Cft->Project_management_on = $request->Project_management_on;

        $Cft->Other1_review = $request->Other1_review;
        $Cft->Other1_person = $request->Other1_person;
        $Cft->Other1_Department_person = $request->Other1_Department_person;
        $Cft->Other1_assessment = $request->Other1_assessment;
        $Cft->Other1_feedback = $request->Other1_feedback;
        $Cft->Other1_by = $request->Other1_by;
        $Cft->Other1_on = $request->Other1_on;

        $Cft->Other2_review = $request->Other2_review;
        $Cft->Other2_person = $request->Other2_person;
        $Cft->Other2_Department_person = $request->Other2_Department_person;
        $Cft->Other2_Assessment = $request->Other2_Assessment;
        $Cft->Other2_feedback = $request->Other2_feedback;
        $Cft->Other2_by = $request->Other2_by;
        $Cft->Other2_on = $request->Other2_on;

        $Cft->Other3_review = $request->Other3_review;
        $Cft->Other3_person = $request->Other3_person;
        $Cft->Other3_Department_person = $request->Other3_Department_person;
        $Cft->Other3_Assessment = $request->Other3_Assessment;
        $Cft->Other3_feedback = $request->Other3_feedback;
        $Cft->Other3_by = $request->Other3_by;
        $Cft->Other3_on = $request->Other3_on;

        $Cft->Other4_review = $request->Other4_review;
        $Cft->Other4_person = $request->Other4_person;
        $Cft->Other4_Department_person = $request->Other4_Department_person;
        $Cft->Other4_Assessment = $request->Other4_Assessment;
        $Cft->Other4_feedback = $request->Other4_feedback;
        $Cft->Other4_by = $request->Other4_by;
        $Cft->Other4_on = $request->Other4_on;

        $Cft->Other5_review = $request->Other5_review;
        $Cft->Other5_person = $request->Other5_person;
        $Cft->Other5_Department_person = $request->Other5_Department_person;
        $Cft->Other5_Assessment = $request->Other5_Assessment;
        $Cft->Other5_feedback = $request->Other5_feedback;
        $Cft->Other5_by = $request->Other5_by;
        $Cft->Other5_on = $request->Other5_on;

        if (!empty ($request->production_attachment)) {
            $files = [];
            if ($request->hasfile('production_attachment')) {
                foreach ($request->file('production_attachment') as $file) {
                    $name = $request->name . 'production_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->production_attachment = json_encode($files);
        }
        if (!empty ($request->Warehouse_attachment)) {
            $files = [];
            if ($request->hasfile('Warehouse_attachment')) {
                foreach ($request->file('Warehouse_attachment') as $file) {
                    $name = $request->name . 'Warehouse_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Warehouse_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Control_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Control_attachment')) {
                foreach ($request->file('Quality_Control_attachment') as $file) {
                    $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Quality_Control_attachment = json_encode($files);
        }
        if (!empty ($request->Quality_Assurance_attachment)) {
            $files = [];
            if ($request->hasfile('Quality_Assurance_attachment')) {
                foreach ($request->file('Quality_Assurance_attachment') as $file) {
                    $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Quality_Assurance_attachment = json_encode($files);
        }
        if (!empty ($request->Engineering_attachment)) {
            $files = [];
            if ($request->hasfile('Engineering_attachment')) {
                foreach ($request->file('Engineering_attachment') as $file) {
                    $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Engineering_attachment = json_encode($files);
        }
        if (!empty ($request->Analytical_Development_attachment)) {
            $files = [];
            if ($request->hasfile('Analytical_Development_attachment')) {
                foreach ($request->file('Analytical_Development_attachment') as $file) {
                    $name = $request->name . 'Analytical_Development_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Analytical_Development_attachment = json_encode($files);
        }
        if (!empty ($request->Kilo_Lab_attachment)) {
            $files = [];
            if ($request->hasfile('Kilo_Lab_attachment')) {
                foreach ($request->file('Kilo_Lab_attachment') as $file) {
                    $name = $request->name . 'Kilo_Lab_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Kilo_Lab_attachment = json_encode($files);
        }
        if (!empty ($request->Technology_transfer_attachment)) {
            $files = [];
            if ($request->hasfile('Technology_transfer_attachment')) {
                foreach ($request->file('Technology_transfer_attachment') as $file) {
                    $name = $request->name . 'Technology_transfer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Technology_transfer_attachment = json_encode($files);
        }
        if (!empty ($request->Environment_Health_Safety_attachment)) {
            $files = [];
            if ($request->hasfile('Environment_Health_Safety_attachment')) {
                foreach ($request->file('Environment_Health_Safety_attachment') as $file) {
                    $name = $request->name . 'Environment_Health_Safety_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Environment_Health_Safety_attachment = json_encode($files);
        }
        if (!empty ($request->Human_Resource_attachment)) {
            $files = [];
            if ($request->hasfile('Human_Resource_attachment')) {
                foreach ($request->file('Human_Resource_attachment') as $file) {
                    $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Human_Resource_attachment = json_encode($files);
        }
        if (!empty ($request->Information_Technology_attachment)) {
            $files = [];
            if ($request->hasfile('Information_Technology_attachment')) {
                foreach ($request->file('Information_Technology_attachment') as $file) {
                    $name = $request->name . 'Information_Technology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Information_Technology_attachment = json_encode($files);
        }
        if (!empty ($request->Project_management_attachment)) {
            $files = [];
            if ($request->hasfile('Project_management_attachment')) {
                foreach ($request->file('Project_management_attachment') as $file) {
                    $name = $request->name . 'Project_management_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Project_management_attachment = json_encode($files);
        }
        if (!empty ($request->Other1_attachment)) {
            $files = [];
            if ($request->hasfile('Other1_attachment')) {
                foreach ($request->file('Other1_attachment') as $file) {
                    $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other1_attachment = json_encode($files);
        }
        if (!empty ($request->Other2_attachment)) {
            $files = [];
            if ($request->hasfile('Other2_attachment')) {
                foreach ($request->file('Other2_attachment') as $file) {
                    $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other2_attachment = json_encode($files);
        }
        if (!empty ($request->Other3_attachment)) {
            $files = [];
            if ($request->hasfile('Other3_attachment')) {
                foreach ($request->file('Other3_attachment') as $file) {
                    $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other3_attachment = json_encode($files);
        }
        if (!empty ($request->Other4_attachment)) {
            $files = [];
            if ($request->hasfile('Other4_attachment')) {
                foreach ($request->file('Other4_attachment') as $file) {
                    $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other4_attachment = json_encode($files);
        }
        if (!empty ($request->Other5_attachment)) {
            $files = [];
            if ($request->hasfile('Other5_attachment')) {
                foreach ($request->file('Other5_attachment') as $file) {
                    $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $Cft->Other5_attachment = json_encode($files);
        }


        $Cft->save();

        $data4 = new DeviationGrid();
        $data4->Number = $deviation->id;
        $data4->type = "Deviation";
        if (!empty ($request->Number)) {
            $data4->Number = serialize($request->Number);
        }
        if (!empty ($request->ReferenceDocumentName)) {
            $data4->ReferenceDocumentName = serialize($request->ReferenceDocumentName);
        }
        $data4->save();

        $data5 = new DeviationGrid();
        $data5->nameofproduct = $deviation->id;
        $data5->type = "Deviation";
        if (!empty ($request->nameofproduct)) {
            $data5->nameofproduct = serialize($request->nameofproduct);
        }
        if (!empty ($request->ExpiryDate)) {
            $data5->ExpiryDate = serialize($request->ExpiryDate);
        }
        $data5->save();

        $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Initiator';
            $history->previous = "Null";
            $history->current = Auth::user()->name;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Due Date';
            $history->previous = "Null";
            $history->current = $deviation->due_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Date of Initiation';
            $history->previous = "Null";
            $history->current = Carbon::now()->format('d-M-Y');
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();

        if (!empty ($request->short_description)){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Short Description';
            $history->previous = "Null";
            $history->current = $deviation->short_description;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
            
        if (!empty ($request->Initiator_Group)){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Department';
            $history->previous = "Null";
            $history->current = $deviation->Initiator_Group;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->Deviation_date)){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Deviation Observed';
            $history->previous = "Null";
            $history->current = $deviation->Deviation_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if ($request->Facility[0] !== null){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Observed by';
            $history->previous = "Null";
            $history->current = $deviation->Facility;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->Deviation_reported_date)){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Deviation Reported on';
            $history->previous = "Null";
            $history->current = $deviation->Deviation_reported_date;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if ($request->audit_type[0] !== null){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Deviation Related To';
            $history->previous = "Null";
            $history->current = $deviation->audit_type;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->others)){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Others';
            $history->previous = "Null";
            $history->current = $deviation->others;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->action_name = 'Create';
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->save();
        }
        if (!empty ($request->Facility_Equipment)){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Facility/ Equipment/ Instrument/ System Details Required?';
            $history->previous = "Null";
            $history->current = $deviation->Facility_Equipment;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->Document_Details_Required)){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Document Details Required';
            $history->previous = "Null";
            $history->current = $deviation->Document_Details_Required;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->action_name = 'Create';
            $history->save();
        }
        if (!empty ($request->Product_Batch)){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Name of Product & Batch No';
            $history->previous = "Null";
            $history->current = $deviation->Product_Batch;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->action_name = 'Create';
            $history->save();
        }
        if ($request->Description_Deviation[0] !== null){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Description of Deviation';
            $history->previous = "Null";
            $history->current = $deviation->Description_Deviation;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->action_name = 'Create';
            $history->save();
        }
        if ($request->Immediate_Action[0] !== null){
            $history = new DeviationAuditTrail();
        $history->deviation_id = $deviation->id;
        $history->activity_type = 'Immediate Action (if any)';
        $history->previous = "Null";
        $history->current = $deviation->Immediate_Action;
        $history->comment = "Not Applicable";
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->change_to =   "Opened";
            $history->change_from = "Initiator";
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $deviation->status;
        $history->action_name = 'Create';
        $history->save();
        }
        if ($request->Preliminary_Impact[0] !== null){
            $history = new DeviationAuditTrail();
            $history->deviation_id = $deviation->id;
            $history->activity_type = 'Preliminary Impact of Deviation';
            $history->previous = "Null";
            $history->current = $deviation->Preliminary_Impact;
            $history->comment = "Not Applicable";
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->change_to =   "Opened";
            $history->change_from = "Initiator";
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->action_name = 'Create';
            $history->save();
        }

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'HOD Remarks';
        // $history->previous = "Null";
        // $history->current = $deviation->HOD_Remarks;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Initial Deviation Category';
        // $history->previous = "Null";
        // $history->current = $deviation->Deviation_category;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Justification for Categorization';
        // $history->previous = "Null";
        // $history->current = $deviation->Justification_for_categorization;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Investigation Is required ?';
        // $history->previous = "Null";
        // $history->current = $deviation->Investigation_required;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Investigation Details';
        // $history->previous = "Null";
        // $history->current = $deviation->Investigation_Details;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Customer Notification Required ?';
        // $history->previous = "Null";
        // $history->current = $deviation->Customer_notification;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Customer';
        // $history->previous = "Null";
        // $history->current = $deviation->customers;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'QA Initial Remarks';
        // $history->previous = "Null";
        // $history->current = $deviation->QAInitialRemark;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Investigation Summary';
        // $history->previous = "Null";
        // $history->current = $deviation->Investigation_Summary;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Impact Assessment';
        // $history->previous = "Null";
        // $history->current = $deviation->Impact_assessment;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Root Cause';
        // $history->previous = "Null";
        // $history->current = $deviation->Root_cause;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'CAPA Required ?';
        // $history->previous = "Null";
        // $history->current = $deviation->CAPA_Rquired;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'CAPA Type?';
        // $history->previous = "Null";
        // $history->current = $deviation->capa_type;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'CAPA Description';
        // $history->previous = "Null";
        // $history->current = $deviation->CAPA_Description;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Post Categorization Of Deviation';
        // $history->previous = "Null";
        // $history->current = $deviation->Post_Categorization;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Investigation Of Revised Categorization';
        // $history->previous = "Null";
        // $history->current = $deviation->Investigation_Of_Review;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'QA Feedbacks';
        // $history->previous = "Null";
        // $history->current = $deviation->QA_Feedbacks;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Closure Comments';
        // $history->previous = "Null";
        // $history->current = $deviation->Closure_Comments;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();

        // $history = new DeviationAuditTrail();
        // $history->deviation_id = $deviation->id;
        // $history->activity_type = 'Disposition of Batch';
        // $history->previous = "Null";
        // $history->current = $deviation->Disposition_Batch;
        // $history->comment = "Not Applicable";
        // $history->user_id = Auth::user()->id;
        // $history->user_name = Auth::user()->name;
        // $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        // $history->origin_state = $deviation->status;
        // $history->action_name = 'Submit';
        // $history->save();


        toastr()->success("Record is created Successfully");
        return redirect(url('rcms/qms-dashboard'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function devshow($id)
    {
        $old_record = Deviation::select('id', 'division_id', 'record')->get();
        $data = Deviation::find($id);
        $data1 = DeviationCft::where('deviation_id', $id)->latest()->first();
        $data->record = str_pad($data->record, 4, '0', STR_PAD_LEFT);
        $data->assign_to_name = User::where('id', $data->assign_id)->value('name');
        $grid_data = DeviationGrid::where('deviation_grid_id', $id)->where('type', "Deviation")->first();
        $grid_data1 = DeviationGrid::where('deviation_grid_id', $id)->where('type', "Document")->first();
    //    dd( $grid_data1);
        // dd($grid_data );
        $data->initiator_name = User::where('id', $data->initiator_id)->value('name');
        $pre = Deviation::all();
        $divisionName = DB::table('q_m_s_divisions')->where('id', $data->division_id)->value('name');

        return view('frontend.forms.deviation_view', compact('data', 'old_record', 'pre', 'data1', 'divisionName','grid_data','grid_data1'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // return $request;
        // if (!$request->short_description) {
        //     toastr()->error("Short description is required");
        //     return redirect()->back();
        // }
        
        $form_progress = null;

        $lastDeviation = deviation::find($id);
        $deviation = deviation::find($id);

        // return $deviation;

        if ($request->Deviation_category == 'major' || $request->Deviation_category == 'critical')
        {
            $request->merge([
                'Investigation_required' => 'yes',
                'Customer_notification' => 'yes'
            ]);
        } 
        
        if ($request->form_name == 'general-open') 
        {
            $validator = Validator::make($request->all(), [
                'short_description_required' => 'required|in:Recurring,Non_Recurring',
                'nature_of_repeat' => 'required_if:short_description_required,Recurring',
                'Deviation_date' => 'required',
                'deviation_time' => 'required',
                'Facility' => [
                    'required',
                    'array',
                    function($attribute, $value, $fail) {
                        if (count($value) === 1 && reset($value) === null) {
                            return $fail('Facility must contain some values.');
                        }
                    },
                ],
                'audit_type' => [
                    'required',
                    'array',
                    function($attribute, $value, $fail) {
                        if (count($value) === 1 && reset($value) === null) {
                            return $fail($attribute.' must not contain only null values.');
                        }
                    },
                ],
                'Deviation_reported_date' => 'required',
                'Facility_Equipment' => 'required|in:yes,no',
                'facility_name' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('Facility_Equipment') === 'yes' && (count($value) === 1 && reset($value) === null)) {
                            $fail('The Facility name is required when Facility Equipment is yes.');
                        }
                    },
                ],
                'IDnumber' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('Facility_Equipment') === 'yes' && (count($value) === 1 && reset($value) === null)) {
                            $fail('The ID Number field is required when Facility Equipment is yes.');
                        }
                    },
                ],
                'Document_Details_Required' => 'required|in:yes,no',
                'Number' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('Document_Details_Required') === 'yes' && (count($value) === 1 && reset($value) === null)) {
                            $fail('The Document Number field is required when Document Details Required is yes.');
                        }
                    },
                ],
                'ReferenceDocumentName' => [
                    function ($attribute, $value, $fail) use ($request) {
                        if ($request->input('Document_Details_Required') === 'yes' && (count($value) === 1 && reset($value) === null)) {
                            $fail('The Referrence Document Number field is required when Document Details Required is yes.');
                        }
                    },
                ],
                'Product_Batch' => 'required',
                'Description_Deviation' => [
                    'required',
                    'array',
                    function($attribute, $value, $fail) {
                        if (count($value) === 1 && reset($value) === null) {
                            return $fail('Description of deviation must not be empty!.');
                        }
                    },
                ],
                'Immediate_Action' => [
                    'required',
                    'array',
                    function($attribute, $value, $fail) {
                        if (count($value) === 1 && reset($value) === null) {
                            return $fail('Immediate Action field must not be empty!.');
                        }
                    },
                ],
                'Preliminary_Impact' => [
                    'required',
                    'array',
                    function($attribute, $value, $fail) {
                        if (count($value) === 1 && reset($value) === null) {
                            return $fail('Preliminary Impact field must not be empty!.');
                        }
                    },
                ],
            ], [
                'short_description_required.required' => 'Nature of Repeat required!',
                'nature_of_repeat.required' =>  'The nature of repeat field is required when nature of repeat is Recurring.',
                'audit_type' => 'Deviation related to field required!'
            ]);

            $validator->sometimes('others', 'required|string|min:1', function ($input) {
                return in_array('Anyother(specify)', explode(',', $input->audit_type[0]));
            });

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $form_progress = 'general-open';
            }
        }
        if ($request->form_name == 'qa')
        {
            $validator = Validator::make($request->all(), [
                'Deviation_category' => 'required|not_in:0',
                'Justification_for_categorization' => 'required',
                'Investigation_required' => 'required|in:yes,no|not_in:0',
                'Investigation_Details' => 'required_if:Investigation_required,yes',
                'Customer_notification' => 'required|not_in:0',
                'customers' => [
                    'required_if:Customer_notification,yes', 
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value === '0' && $request->Customer_notification == 'yes') {
                            $fail('The customers field must not be empty when Customer Notification is set to yes.');
                        }
                    },
                ],
                'QAInitialRemark' => 'required'
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $form_progress = 'qa';
            }
        }
        
        if ($request->form_name == 'capa')
        {
            $validator = Validator::make($request->all(), [
                'Investigation_Summary' => 'required',
                'Impact_assessment' => 'required',
                'Root_cause' => 'required',
                'CAPA_Rquired' => 'required|in:yes,no|not_in:0',
                'Post_Categorization' => 'required',
                'capa_type' => [
                    'required_if:CAPA_Rquired,yes',
                    function ($attribute, $value, $fail) use ($request) {
                        if ($value === '0' && $request->CAPA_Rquired == 'yes') {
                            $fail('The capa type field is required when CAPA required is set to yes.');
                        }
                    }
                ],
                'CAPA_Description' => 'required_if:CAPA_Rquired,yes',
            ],  [
                'CAPA_Rquired.required' => 'Capa required field cannot be empty!',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $form_progress = 'capa';
            }
        }
        
        if ($request->form_name == 'qa-final')
        {
            // $validator = Validator::make($request->all(), [
            //     'Investigation_Summary' => 'required|string|regex:/\S/',
            //     'QA_Feedbacks' => 'required'
            // ], [
            //     'QA_Feedbacks.required' => 'The QA Feedbacks field is required!'
            // ]);

            // if ($validator->fails()) {
            //     return back()
            //         ->withErrors($validator)
            //         ->withInput();
            // } else {
                $form_progress = 'capa';
            // }
        }

        if ($request->form_name == 'qah')
        {
            $validator = Validator::make($request->all(), [
                'Closure_Comments' => 'required',
                'Disposition_Batch' => 'required',
            ]);

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $form_progress = 'qah';
            }
        }

       
        // $deviation->Customer_notification = $request->Customer_notification;
        //$deviation->parent_id = $request->parent_id;
        //$deviation->parent_type = $request->parent_type;
        //$deviation->division_id = $request->division_id;
        //$deviation->text = $request->text;
        $deviation->assign_to = $request->assign_to;
        //$deviation->due_date = $request->due_date;
        //$deviation->intiation_date = $request->intiation_date;
        $deviation->Initiator_Group = $request->Initiator_Group;
        //$deviation->due_date = $request->due_date;

        //$deviation->initiator_Group= $request->initiator_Group;
        if ($deviation->stage < 3) {
            $deviation->short_description = $request->short_description;
        } else {
            $deviation->short_description = $deviation->short_description;
        }
        $deviation->initiator_group_code = $request->initiator_group_code;
        $deviation->Deviation_reported_date = $request->Deviation_reported_date;
        $deviation->Deviation_date = $request->Deviation_date;
        $deviation->deviation_time = $request->deviation_time;
        $deviation->audit_type = implode(',', $request->audit_type);
        $deviation->short_description_required = $request->short_description_required;
        $deviation->nature_of_repeat = $request->nature_of_repeat;
        $deviation->others = $request->others;
        $deviation->Product_Batch = $request->Product_Batch;

        $deviation->Description_Deviation = implode(',', $request->Description_Deviation);
        if ($request->related_records) {
            $deviation->Related_Records1 =  implode(',', $request->related_records);
        }
        $deviation->Facility = implode(',', $request->Facility);  


        $deviation->Immediate_Action = implode(',', $request->Immediate_Action);
        $deviation->Preliminary_Impact = implode(',', $request->Preliminary_Impact);
        $deviation->Product_Details_Required = $request->Product_Details_Required;
        
        $deviation->HOD_Remarks = $request->HOD_Remarks;
        $deviation->Justification_for_categorization = !empty($request->Justification_for_categorization) ? $request->Justification_for_categorization : $deviation->Justification_for_categorization;

        $deviation->Investigation_Details = !empty($request->Investigation_Details) ? $request->Investigation_Details : $deviation->Investigation_Details;

        $deviation->QAInitialRemark = $request->QAInitialRemark;
        $deviation->Investigation_Summary = $request->Investigation_Summary;
        $deviation->Impact_assessment = $request->Impact_assessment;
        $deviation->Root_cause = $request->Root_cause;
        
        if ($deviation->stage < 6) {
            $deviation->CAPA_Rquired = $request->CAPA_Rquired;
        } 

        if ($deviation->stage < 6) {
            $deviation->capa_type = $request->capa_type;
        }

        $deviation->CAPA_Description = !empty($request->CAPA_Description) ? $request->CAPA_Description : $deviation->CAPA_Description;
        $deviation->Post_Categorization = !empty($request->Post_Categorization) ? $request->Post_Categorization : $deviation->Post_Categorization; 
        $deviation->Investigation_Of_Review = $request->Investigation_Of_Review;
        $deviation->QA_Feedbacks = $request->has('QA_Feedbacks') ? $request->QA_Feedbacks : $deviation->QA_Feedbacks;
        $deviation->Closure_Comments = $request->Closure_Comments;
        $deviation->Disposition_Batch = $request->Disposition_Batch;
        $deviation->Facility_Equipment = $request->Facility_Equipment;
        $deviation->Document_Details_Required = $request->Document_Details_Required;
        //$deviation->production_byy = $request->CFT_Review_Complete_By;

        if ($deviation->stage == 3) 
        {
            $deviation->Customer_notification = $request->Customer_notification;
            $deviation->Investigation_required = $request->Investigation_required;
            $deviation->Deviation_category = $request->Deviation_category;
            $deviation->customers = $request->customers;
        }

        if($deviation->stage == 3 || $deviation->stage == 4 ){
    

            if (!$form_progress) {
                $form_progress = 'cft';
            }

            $Cft = DeviationCft::withoutTrashed()->where('deviation_id', $id)->first();
            if($Cft && $deviation->stage == 4 ){ 
                $Cft->Production_Review = $request->Production_Review == null ? $Cft->Production_Review : $request->Production_Review;
                $Cft->Production_person = $request->Production_person == null ? $Cft->Production_person : $request->Production_Review;
                $Cft->Warehouse_review = $request->Warehouse_review == null ? $Cft->Warehouse_review : $request->Warehouse_review;
                $Cft->Warehouse_notification = $request->Warehouse_notification == null ? $Cft->Warehouse_notification : $request->Warehouse_notification;
                $Cft->Quality_review = $request->Quality_review == null ? $Cft->Quality_review : $request->Quality_review;;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person == null ? $Cft->Quality_Control_Person : $request->Quality_Control_Person;
                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review == null ? $Cft->Quality_Assurance_Review : $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person == null ? $Cft->QualityAssurance_person : $request->QualityAssurance_person;
    
                $Cft->Engineering_review = $request->Engineering_review == null ? $Cft->Engineering_review : $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person == null ? $Cft->Engineering_person : $request->Engineering_person;
                $Cft->Analytical_Development_review = $request->Analytical_Development_review == null ? $Cft->Analytical_Development_review : $request->Analytical_Development_review;
                $Cft->Analytical_Development_person = $request->Analytical_Development_person == null ? $Cft->Analytical_Development_person : $request->Analytical_Development_person;
                $Cft->Kilo_Lab_review = $request->Kilo_Lab_review == null ? $Cft->Kilo_Lab_review : $request->Kilo_Lab_review;
                $Cft->Kilo_Lab_person = $request->Kilo_Lab_person == null ? $Cft->Kilo_Lab_person : $request->Kilo_Lab_person;
                $Cft->Technology_transfer_review = $request->Technology_transfer_review == null ? $Cft->Technology_transfer_review : $request->Technology_transfer_review;
                $Cft->Technology_transfer_person = $request->Technology_transfer_person == null ? $Cft->Technology_transfer_person : $request->Technology_transfer_person;
                $Cft->Environment_Health_review = $request->Environment_Health_review == null ? $Cft->Environment_Health_review : $request->Environment_Health_review;
                $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person == null ? $Cft->Environment_Health_Safety_person : $request->Environment_Health_Safety_person;
                $Cft->Human_Resource_review = $request->Human_Resource_review == null ? $Cft->Human_Resource_review : $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person == null ? $Cft->Human_Resource_person : $request->Human_Resource_person;
                $Cft->Project_management_review = $request->Project_management_review == null ? $Cft->Project_management_review : $request->Project_management_review;
                $Cft->Project_management_person = $request->Project_management_person == null ? $Cft->Project_management_person : $request->Project_management_person;
                $Cft->Information_Technology_review = $request->Information_Technology_review == null ? $Cft->Information_Technology_review : $request->Information_Technology_review;
                $Cft->Information_Technology_person = $request->Information_Technology_person == null ? $Cft->Information_Technology_person : $request->Information_Technology_person;
                $Cft->Other1_review = $request->Other1_review  == null ? $Cft->Other1_review : $request->Other1_review;
                $Cft->Other1_person = $request->Other1_person  == null ? $Cft->Other1_person : $request->Other1_person;
                $Cft->Other1_Department_person = $request->Other1_Department_person  == null ? $Cft->Other1_Department_person : $request->Other1_Department_person;
                $Cft->Other2_review = $request->Other2_review  == null ? $Cft->Other2_review : $request->Other2_review;
                $Cft->Other2_person = $request->Other2_person  == null ? $Cft->Other2_person : $request->Other2_person;
                $Cft->Other2_Department_person = $request->Other2_Department_person  == null ? $Cft->Other2_Department_person : $request->Other2_Department_person;
                $Cft->Other3_review = $request->Other3_review  == null ? $Cft->Other3_review : $request->Other3_review;
                $Cft->Other3_person = $request->Other3_person  == null ? $Cft->Other3_person : $request->Other3_person;
                $Cft->Other3_Department_person = $request->Other3_Department_person  == null ? $Cft->Other3_Department_person : $request->Other3_Department_person;
                $Cft->Other4_review = $request->Other4_review  == null ? $Cft->Other4_review : $request->Other4_review;
                $Cft->Other4_person = $request->Other4_person  == null ? $Cft->Other4_person : $request->Other4_person;
                $Cft->Other4_Department_person = $request->Other4_Department_person  == null ? $Cft->Other4_Department_person : $request->Other4_Department_person;
                $Cft->Other5_review = $request->Other5_review  == null ? $Cft->Other5_review : $request->Other5_review;
                $Cft->Other5_person = $request->Other5_person  == null ? $Cft->Other5_person : $request->Other5_person;
                $Cft->Other5_Department_person = $request->Other5_Department_person  == null ? $Cft->Other5_Department_person : $request->Other5_Department_person;
            }
            else{
                $Cft->Production_Review = $request->Production_Review;
                $Cft->Production_person = $request->Production_person;
                $Cft->Warehouse_review = $request->Warehouse_review;
                $Cft->Warehouse_notification = $request->Warehouse_notification;
                $Cft->Quality_review = $request->Quality_review;
                $Cft->Quality_Control_Person = $request->Quality_Control_Person;
                $Cft->Quality_Assurance_Review = $request->Quality_Assurance_Review;
                $Cft->QualityAssurance_person = $request->QualityAssurance_person;
                $Cft->Engineering_review = $request->Engineering_review;
                $Cft->Engineering_person = $request->Engineering_person;
                $Cft->Analytical_Development_review = $request->Analytical_Development_review;
                $Cft->Analytical_Development_person = $request->Analytical_Development_person;
                $Cft->Kilo_Lab_review = $request->Kilo_Lab_review;
                $Cft->Kilo_Lab_person = $request->Kilo_Lab_person;
                $Cft->Technology_transfer_review = $request->Technology_transfer_review;
                $Cft->Technology_transfer_person = $request->Technology_transfer_person;
                $Cft->Environment_Health_review = $request->Environment_Health_review;
                $Cft->Environment_Health_Safety_person = $request->Environment_Health_Safety_person;
                $Cft->Human_Resource_review = $request->Human_Resource_review;
                $Cft->Human_Resource_person = $request->Human_Resource_person;
                $Cft->Project_management_review = $request->Project_management_review;
                $Cft->Project_management_person = $request->Project_management_person;
                $Cft->Information_Technology_review = $request->Information_Technology_review;
                $Cft->Information_Technology_person = $request->Information_Technology_person;
                $Cft->Other1_review = $request->Other1_review;
                $Cft->Other1_person = $request->Other1_person;
                $Cft->Other1_Department_person = $request->Other1_Department_person;
                $Cft->Other2_review = $request->Other2_review;
                $Cft->Other2_person = $request->Other2_person;
                $Cft->Other2_Department_person = $request->Other2_Department_person;
                $Cft->Other3_review = $request->Other3_review;
                $Cft->Other3_person = $request->Other3_person;
                $Cft->Other3_Department_person = $request->Other3_Department_person;
                $Cft->Other4_review = $request->Other4_review;
                $Cft->Other4_person = $request->Other4_person;
                $Cft->Other4_Department_person = $request->Other4_Department_person;
                $Cft->Other5_review = $request->Other5_review;
                $Cft->Other5_person = $request->Other5_person;
                $Cft->Other5_Department_person = $request->Other5_Department_person;
            }
            // dd($request->Production_Review, $request->Production_person);
            $Cft->Production_assessment = $request->Production_assessment;
            $Cft->Production_feedback = $request->Production_feedback;
            $Cft->Warehouse_assessment = $request->Warehouse_assessment;
            $Cft->Warehouse_feedback = $request->Warehouse_feedback;
            $Cft->Quality_Control_assessment = $request->Quality_Control_assessment;
            $Cft->Quality_Control_feedback = $request->Quality_Control_feedback;
            $Cft->QualityAssurance_assessment = $request->QualityAssurance_assessment;
            $Cft->QualityAssurance_feedback = $request->QualityAssurance_feedback;
            $Cft->Engineering_assessment = $request->Engineering_assessment;
            $Cft->Engineering_feedback = $request->Engineering_feedback;
            $Cft->Analytical_Development_assessment = $request->Analytical_Development_assessment;
            $Cft->Analytical_Development_feedback = $request->Analytical_Development_feedback;
            $Cft->Kilo_Lab_assessment = $request->Kilo_Lab_assessment;
            $Cft->Kilo_Lab_feedback = $request->Kilo_Lab_feedback;            
            $Cft->Technology_transfer_assessment = $request->Technology_transfer_assessment;
            $Cft->Technology_transfer_feedback = $request->Technology_transfer_feedback;
            $Cft->Health_Safety_assessment = $request->Health_Safety_assessment;
            $Cft->Health_Safety_feedback = $request->Health_Safety_feedback;
            $Cft->Human_Resource_assessment = $request->Human_Resource_assessment;
            $Cft->Human_Resource_feedback = $request->Human_Resource_feedback;
            $Cft->Information_Technology_assessment = $request->Information_Technology_assessment;
            $Cft->Information_Technology_feedback = $request->Information_Technology_feedback;
            $Cft->Project_management_assessment = $request->Project_management_assessment;
            $Cft->Project_management_feedback = $request->Project_management_feedback;      
            $Cft->Other1_assessment = $request->Other1_assessment;
            $Cft->Other1_feedback = $request->Other1_feedback;
            $Cft->Other2_Assessment = $request->Other2_Assessment;
            $Cft->Other2_feedback = $request->Other2_feedback;
            $Cft->Other3_Assessment = $request->Other3_Assessment;
            $Cft->Other3_feedback = $request->Other3_feedback;            
            $Cft->Other4_Assessment = $request->Other4_Assessment;
            $Cft->Other4_feedback = $request->Other4_feedback;
            $Cft->Other5_Assessment = $request->Other5_Assessment;
            $Cft->Other5_feedback = $request->Other5_feedback;
            

            if (!empty ($request->production_attachment)) {
                $files = [];
                if ($request->hasfile('production_attachment')) {
                    foreach ($request->file('production_attachment') as $file) {
                        $name = $request->name . 'production_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->production_attachment = json_encode($files);
            }
            if (!empty ($request->Warehouse_attachment)) {
                $files = [];
                if ($request->hasfile('Warehouse_attachment')) {
                    foreach ($request->file('Warehouse_attachment') as $file) {
                        $name = $request->name . 'Warehouse_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Warehouse_attachment = json_encode($files);
            }
            if (!empty ($request->Quality_Control_attachment)) {
                $files = [];
                if ($request->hasfile('Quality_Control_attachment')) {
                    foreach ($request->file('Quality_Control_attachment') as $file) {
                        $name = $request->name . 'Quality_Control_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Quality_Control_attachment = json_encode($files);
            }
            if (!empty ($request->Quality_Assurance_attachment)) {
                $files = [];
                if ($request->hasfile('Quality_Assurance_attachment')) {
                    foreach ($request->file('Quality_Assurance_attachment') as $file) {
                        $name = $request->name . 'Quality_Assurance_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Quality_Assurance_attachment = json_encode($files);
            }
            if (!empty ($request->Engineering_attachment)) {
                $files = [];
                if ($request->hasfile('Engineering_attachment')) {
                    foreach ($request->file('Engineering_attachment') as $file) {
                        $name = $request->name . 'Engineering_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Engineering_attachment = json_encode($files);
            }
            if (!empty ($request->Analytical_Development_attachment)) {
                $files = [];
                if ($request->hasfile('Analytical_Development_attachment')) {
                    foreach ($request->file('Analytical_Development_attachment') as $file) {
                        $name = $request->name . 'Analytical_Development_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Analytical_Development_attachment = json_encode($files);
            }
            if (!empty ($request->Kilo_Lab_attachment)) {
                $files = [];
                if ($request->hasfile('Kilo_Lab_attachment')) {
                    foreach ($request->file('Kilo_Lab_attachment') as $file) {
                        $name = $request->name . 'Kilo_Lab_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Kilo_Lab_attachment = json_encode($files);
            }
            if (!empty ($request->Technology_transfer_attachment)) {
                $files = [];
                if ($request->hasfile('Technology_transfer_attachment')) {
                    foreach ($request->file('Technology_transfer_attachment') as $file) {
                        $name = $request->name . 'Technology_transfer_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Technology_transfer_attachment = json_encode($files);
            }
            if (!empty ($request->Environment_Health_Safety_attachment)) {
                $files = [];
                if ($request->hasfile('Environment_Health_Safety_attachment')) {
                    foreach ($request->file('Environment_Health_Safety_attachment') as $file) {
                        $name = $request->name . 'Environment_Health_Safety_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Environment_Health_Safety_attachment = json_encode($files);
            }
            if (!empty ($request->Human_Resource_attachment)) {
                $files = [];
                if ($request->hasfile('Human_Resource_attachment')) {
                    foreach ($request->file('Human_Resource_attachment') as $file) {
                        $name = $request->name . 'Human_Resource_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Human_Resource_attachment = json_encode($files);
            }
            if (!empty ($request->Information_Technology_attachment)) {
                $files = [];
                if ($request->hasfile('Information_Technology_attachment')) {
                    foreach ($request->file('Information_Technology_attachment') as $file) {
                        $name = $request->name . 'Information_Technology_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Information_Technology_attachment = json_encode($files);
            }
            if (!empty ($request->Project_management_attachment)) {
                $files = [];
                if ($request->hasfile('Project_management_attachment')) {
                    foreach ($request->file('Project_management_attachment') as $file) {
                        $name = $request->name . 'Project_management_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Project_management_attachment = json_encode($files);
            }
            if (!empty ($request->Other1_attachment)) {
                $files = [];
                if ($request->hasfile('Other1_attachment')) {
                    foreach ($request->file('Other1_attachment') as $file) {
                        $name = $request->name . 'Other1_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Other1_attachment = json_encode($files);
            }
            if (!empty ($request->Other2_attachment)) {
                $files = [];
                if ($request->hasfile('Other2_attachment')) {
                    foreach ($request->file('Other2_attachment') as $file) {
                        $name = $request->name . 'Other2_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Other2_attachment = json_encode($files);
            }
            if (!empty ($request->Other3_attachment)) {
                $files = [];
                if ($request->hasfile('Other3_attachment')) {
                    foreach ($request->file('Other3_attachment') as $file) {
                        $name = $request->name . 'Other3_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Other3_attachment = json_encode($files);
            }
            if (!empty ($request->Other4_attachment)) {
                $files = [];
                if ($request->hasfile('Other4_attachment')) {
                    foreach ($request->file('Other4_attachment') as $file) {
                        $name = $request->name . 'Other4_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Other4_attachment = json_encode($files);
            }
            if (!empty ($request->Other5_attachment)) {
                $files = [];
                if ($request->hasfile('Other5_attachment')) {
                    foreach ($request->file('Other5_attachment') as $file) {
                        $name = $request->name . 'Other5_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $Cft->Other5_attachment = json_encode($files);
            }


        $Cft->save();
                $IsCFTRequired = DeviationCftsResponse::withoutTrashed()->where(['is_required' => 1, 'deviation_id' => $id])->latest()->first();
                $cftUsers = DB::table('deviationcfts')->where(['deviation_id' => $id])->first();
                // Define the column names
                $columns = ['Production_person', 'Warehouse_notification', 'Quality_Control_Person', 'QualityAssurance_person', 'Engineering_person', 'Analytical_Development_person', 'Kilo_Lab_person', 'Technology_transfer_person', 'Environment_Health_Safety_person', 'Human_Resource_person', 'Information_Technology_person', 'Project_management_person','Other1_person','Other2_person','Other3_person','Other4_person','Other5_person'];
                
                // Initialize an array to store the values
                $valuesArray = [];

                foreach ($columns as $index => $column) {
                    $value = $cftUsers->$column;
                    // Check if the value is not null and not equal to 0
                    if ($value != null && $value != 0) {
                        $valuesArray[] = $value;
                    }
                }
                // Remove duplicates from the array
                $valuesArray = array_unique($valuesArray);

                // Convert the array to a re-indexed array
                $valuesArray = array_values($valuesArray);

                foreach ($valuesArray as $u) {
                        $email = Helpers::getInitiatorEmail($u);
                        if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("CFT Assgineed by " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }                        
                    }
                }
            
        
            if (!empty ($request->Initial_attachment)) {
                $files = [];
                
                if ($deviation->Initial_attachment) {
                    $files = is_array(json_decode($deviation->Initial_attachment)) ? $deviation->Initial_attachment : [];
                }

                if ($request->hasfile('Initial_attachment')) {
                    foreach ($request->file('Initial_attachment') as $file) {
                        $name = $request->name . 'Initial_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                        $file->move('upload/', $name);
                        $files[] = $name;
                    }
                }


                $deviation->Initial_attachment = json_encode($files);
            }
        }
        
        

        if (!empty ($request->Audit_file)) {
            
            $files = [];
            
            if ($deviation->Audit_file) {
                $files = is_array(json_decode($deviation->Audit_file)) ? $deviation->Audit_file : [];
            }

            if ($request->hasfile('Audit_file')) {
                foreach ($request->file('Audit_file') as $file) {
                    $name = $request->name . 'Audit_file' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }
            $deviation->Audit_file = json_encode($files);
        }

        if (!empty ($request->QA_attachment)) {
            $files = [];

            if ($deviation->QA_attachment) {
                $files = is_array(json_decode($deviation->QA_attachment)) ? $deviation->QA_attachment : [];
            }

            if ($request->hasfile('QA_attachment')) {
                foreach ($request->file('QA_attachment') as $file) {
                    $name = $request->name . 'QA_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->QA_attachment = json_encode($files);
        }
            
        if (!empty ($request->Investigation_attachment)) {
            
            $files = [];

            if ($deviation->Investigation_attachment) {
                $files = is_array(json_decode($deviation->QA_attachment)) ? $deviation->QA_attachment : [];
            }

            if ($request->hasfile('Investigation_attachment')) {
                foreach ($request->file('Investigation_attachment') as $file) {
                    $name = $request->name . 'Investigation_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->Investigation_attachment = json_encode($files);
        }

        if (!empty ($request->Capa_attachment)) {
            
            $files = [];

            if ($deviation->Capa_attachment) {
                $files = is_array(json_decode($deviation->Capa_attachment)) ? $deviation->Capa_attachment : [];
            }

            if ($request->hasfile('Capa_attachment')) {
                foreach ($request->file('Capa_attachment') as $file) {
                    $name = $request->name . 'Capa_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->Capa_attachment = json_encode($files);
        }

        if (!empty ($request->QA_attachments)) {
            
            $files = [];

            if ($deviation->QA_attachments) {
                $files = is_array(json_decode($deviation->QA_attachments)) ? $deviation->QA_attachments : [];
            }

            if ($request->hasfile('QA_attachments')) {
                foreach ($request->file('QA_attachments') as $file) {
                    $name = $request->name . 'QA_attachments' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->QA_attachments = json_encode($files);
        }

        if (!empty ($request->closure_attachment)) {
            
            $files = [];
            
            if ($deviation->closure_attachment) {
                $files = is_array(json_decode($deviation->closure_attachment)) ? $deviation->closure_attachment : [];
            }
            
            if ($request->hasfile('closure_attachment')) {
                foreach ($request->file('closure_attachment') as $file) {
                    $name = $request->name . 'closure_attachment' . rand(1, 100) . '.' . $file->getClientOriginalExtension();
                    $file->move('upload/', $name);
                    $files[] = $name;
                }
            }


            $deviation->closure_attachment = json_encode($files);
        }

        $deviation->form_progress = isset($form_progress) ? $form_progress : null;
        $deviation->update();
        // grid
         $data3=DeviationGrid::where('deviation_grid_id', $deviation->id)->where('type', "Deviation")->first();
                if (!empty($request->IDnumber)) {
                    $data3->IDnumber = serialize($request->IDnumber);
                }
                if (!empty($request->facility_name)) {
                    $data3->facility_name = serialize($request->facility_name);
                }

                if (!empty($request->Remarks)) {
                    $data3->Remarks = serialize($request->Remarks);
                }
               
                $data3->update();
                // dd($request->Remarks);


            $data4=DeviationGrid::where('deviation_grid_id', $deviation->id)->where('type', "Document")->first();
            if (!empty($request->Number)) {
                $data4->Number = serialize($request->Number);
            }
            if (!empty($request->ReferenceDocumentName)) {
                $data4->ReferenceDocumentName = serialize($request->ReferenceDocumentName);
            }
            
            if (!empty($request->Document_Remarks)) {
                $data4->Document_Remarks = serialize($request->Document_Remarks);
            }
            $data4->update();
            

        if ($lastDeviation->short_description != $deviation->short_description || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Short Description';
             $history->previous = $lastDeviation->short_description;
            $history->current = $deviation->short_description;
            $history->comment = $deviation->submit_comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = $history->origin_state;
            $history->save();
        }
        if ($lastDeviation->Initiator_Group != $deviation->Initiator_Group || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Initiator Group';
            $history->previous = $lastDeviation->Initiator_Group;
            $history->current = $deviation->Initiator_Group;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Deviation_date != $deviation->Deviation_date || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Deviation Observed';
            $history->previous = $lastDeviation->Deviation_date;
            $history->current = $deviation->Deviation_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Observed_by != $deviation->Observed_by || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Observed by';
            $history->previous = $lastDeviation->Observed_by;
            $history->current = $deviation->Observed_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Deviation_reported_date != $deviation->Deviation_reported_date || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Deviation Reported on';
            $history->previous = $lastDeviation->Deviation_reported_date;
            $history->current = $deviation->Deviation_reported_date;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->audit_type != $deviation->audit_type || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Deviation Related To';
            $history->previous = $lastDeviation->audit_type;
            $history->current = $deviation->audit_type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Others != $deviation->Others || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Others';
            $history->previous = $lastDeviation->Others;
            $history->current = $deviation->Others;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Facility_Equipment != $deviation->Facility_Equipment || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Facility/ Equipment/ Instrument/ System Details Required?';
            $history->previous = $lastDeviation->Facility_Equipment;
            $history->current = $deviation->Facility_Equipment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Document_Details_Required != $deviation->Document_Details_Required || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Document Details Required';
            $history->previous = $lastDeviation->Document_Details_Required;
            $history->current = $deviation->Document_Details_Required;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Product_Batch != $deviation->Product_Batch || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Name of Product & Batch No';
            $history->previous = $lastDeviation->Product_Batch;
            $history->current = $deviation->Product_Batch;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Description_Deviation != $deviation->Description_Deviation || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Description of Deviation';
            $history->previous = $lastDeviation->Description_Deviation;
            $history->current = $deviation->Description_Deviation;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Immediate_Action != $deviation->Immediate_Action || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Immediate Action (if any)';
            $history->previous = $lastDeviation->Immediate_Action;
            $history->current = $deviation->Immediate_Action;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Preliminary_Impact != $deviation->Preliminary_Impact || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Preliminary Impact of Deviation';
            $history->previous = $lastDeviation->Preliminary_Impact;
            $history->current = $deviation->Preliminary_Impact;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->HOD_Remarks != $deviation->HOD_Remarks || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'HOD Remarks';
            $history->previous = $lastDeviation->HOD_Remarks;
            $history->current = $deviation->HOD_Remarks;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Deviation_category != $deviation->Deviation_category || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Initial Deviation Category';
            $history->previous = $lastDeviation->Deviation_category;
            $history->current = $deviation->Deviation_category;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Justification_for_categorization != $deviation->Justification_for_categorization || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Justification for Categorization';
            $history->previous = $lastDeviation->Justification_for_categorization;
            $history->current = $deviation->Justification_for_categorization;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Investigation_required != $deviation->Investigation_required || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Investigation Is required ?';
            $history->previous = $lastDeviation->Investigation_required;
            $history->current = $deviation->Investigation_required;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Investigation_Details != $deviation->Investigation_Details || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Investigation Details';
            $history->previous = $lastDeviation->Investigation_Details;
            $history->current = $deviation->Investigation_Details;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Customer_notification != $deviation->Customer_notification || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Customer Notification Required ?';
            $history->previous = $lastDeviation->Customer_notification;
            $history->current = $deviation->Customer_notification;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->customers != $deviation->customers || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Customer';
            $history->previous = $lastDeviation->customers;
            $history->current = $deviation->customers;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->QAInitialRemark != $deviation->QAInitialRemark || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'QA Initial Remarks';
            $history->previous = $lastDeviation->QAInitialRemark;
            $history->current = $deviation->QAInitialRemark;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Investigation_Summary != $deviation->Investigation_Summary || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Investigation Summary';
            $history->previous = $lastDeviation->Investigation_Summary;
            $history->current = $deviation->Investigation_Summary;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->save();
        }

        if ($lastDeviation->Impact_assessment != $deviation->Impact_assessment || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Impact Assessment';
            $history->previous = $lastDeviation->Impact_assessment;
            $history->current = $deviation->Impact_assessment;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Root_cause != $deviation->Root_cause || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Root Cause';
            $history->previous = $lastDeviation->Root_cause;
            $history->current = $deviation->Root_cause;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->CAPA_Rquired != $deviation->CAPA_Rquired || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'CAPA Required ?';
            $history->previous = $lastDeviation->CAPA_Rquired;
            $history->current = $deviation->CAPA_Rquired;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->capa_type != $deviation->capa_type || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'CAPA Type?';
            $history->previous = $lastDeviation->capa_type;
            $history->current = $deviation->capa_type;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->CAPA_Description != $deviation->CAPA_Description || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'CAPA Description';
            $history->previous = $lastDeviation->CAPA_Description;
            $history->current = $deviation->CAPA_Description;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Post_Categorization != $deviation->Post_Categorization || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Post Categorization Of Deviation';
            $history->previous = $lastDeviation->Post_Categorization;
            $history->current = $deviation->Post_Categorization;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Investigation_Of_Review != $deviation->Investigation_Of_Review || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Investigation Of Revised Categorization';
            $history->previous = $lastDeviation->Investigation_Of_Review;
            $history->current = $deviation->Investigation_Of_Review;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->QA_Feedbacks != $deviation->QA_Feedbacks || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'QA Feedbacks';
            $history->previous = $lastDeviation->QA_Feedbacks;
            $history->current = $deviation->QA_Feedbacks;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Closure_Comments != $deviation->Closure_Comments || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Closure Comments';
            $history->previous = $lastDeviation->Closure_Comments;
            $history->current = $deviation->Closure_Comments;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        if ($lastDeviation->Disposition_Batch != $deviation->Disposition_Batch || !empty ($request->comment)) {
            // return 'history';
            $history = new DeviationAuditTrail;
            $history->deviation_id = $id;
            $history->activity_type = 'Disposition of Batch';
            $history->previous = $lastDeviation->Disposition_Batch;
            $history->current = $deviation->Disposition_Batch;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDeviation->status;
            $history->change_to =   "Not Applicable";
            $history->change_from = $lastDeviation->status;
            $history->action_name = 'Update';
            $history->save();
        }

        toastr()->success('Record is Update Successfully');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function deviation_send_stage(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $updateCFT = DeviationCft::where('deviation_id', $id)->latest()->first();
            $lastDocument = Deviation::find($id);
            $cftDetails = DeviationCftsResponse::withoutTrashed()->where(['status' => 'In-progress', 'deviation_id' => $id])->distinct('cft_user_id')->count();
            
            if ($deviation->stage == 1) {

                if ($deviation->form_progress !== 'general-open') 
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

                $deviation->stage = "2";
                $deviation->status = "HOD Review";
                $deviation->submit_by = Auth::user()->name;
                $deviation->submit_on = Carbon::now()->format('d-M-Y');
                $deviation->submit_comment = $request->comment;

                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->action='Submit';
                $history->current = $deviation->submit_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "HOD Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Proposed';
                $history->save();


                $list = Helpers::getHodUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {

                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }

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

                


                $deviation->update();

                
                return back();
            }
            if ($deviation->stage == 2) {
                
                // Check HOD remark value
                if (!$deviation->HOD_Remarks) {
                    
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields Required!',
                        'message' => 'HOD Remarks is yet to be filled!',
                        'type' => 'warning',
                    ]);

                    return redirect()->back();
                } else {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Sent for QA initial review state'
                    ]);
                }

                $deviation->stage = "3";
                $deviation->status = "QA Initial Review";
                $deviation->HOD_Review_Complete_By = Auth::user()->name;
                $deviation->HOD_Review_Complete_On = Carbon::now()->format('d-M-Y');
                $deviation->HOD_Review_Comments = $request->comment;
                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $deviation->HOD_Review_Complete_By;
                $history->comment = $request->comment;
                $history->action= 'HOD Review Complete';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "QA Initial Review";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Plan Approved';
                $history->save();
                // dd($history->action);
                $list = Helpers::getQAUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                

                $deviation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($deviation->stage == 3) {
                if ($deviation->form_progress !== 'cft') 
                {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'QA initial review / CFT Mandatory Tab is yet to be filled!'
                    ]);

                    return redirect()->back();
                } else {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Sent for CFT review state'
                    ]);
                }

                $deviation->stage = "4";
                $deviation->status = "CFT Review";

                // Code for the CFT required 
                $stage = new DeviationCftsResponse();
                $stage->deviation_id = $id;
                $stage->cft_user_id = Auth::user()->id;
                $stage->status = "CFT Required";
                // $stage->cft_stage = ;
                $stage->comment = $request->comment;
                $stage->is_required = 1;
                $stage->save();

                $deviation->QA_Initial_Review_Complete_By = Auth::user()->name;
                $deviation->QA_Initial_Review_Complete_On = Carbon::now()->format('d-M-Y');
                $deviation->QA_Initial_Review_Comments = $request->comment;
                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->action= 'QA Initial Review Complete';
                $history->current = $deviation->QA_Initial_Review_Complete_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->change_to =   "CFT Review";
                $history->change_from = $lastDocument->status;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Completed';
                $history->save();
                $list = Helpers::getQAUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }

                if ($request->Deviation_category == 'major' || $request->Deviation_category == 'minor' || $request->Deviation_category == 'critical') {
                    $list = Helpers::getHeadoperationsUserList();
                            foreach ($list as $u) {
                                if ($u->q_m_s_divisions_id == $deviation->division_id) {
                                    $email = Helpers::getInitiatorEmail($u->user_id);
                                    if ($email !== null) {
                                         // Add this if statement
                                         try {
                                                Mail::send(
                                                    'mail.Categorymail',
                                                    ['data' => $deviation],
                                                    function ($message) use ($email) {
                                                        $message->to($email)
                                                            ->subject("Activity Performed By " . Auth::user()->name);
                                                    }
                                                );
                                            } catch (\Exception $e) {
                                                //log error
                                            }
                                        
                                    }
                                }
                            }
                        }
                        if ($request->Deviation_category == 'major' || $request->Deviation_category == 'minor' || $request->Deviation_category == 'critical') {
                            $list = Helpers::getCEOUserList();
                                    foreach ($list as $u) {
                                        if ($u->q_m_s_divisions_id == $deviation->division_id) {
                                            $email = Helpers::getInitiatorEmail($u->user_id);
                                            if ($email !== null) {
                                                 // Add this if statement
                                                 try {
                                                        Mail::send(
                                                            'mail.Categorymail',
                                                            ['data' => $deviation],
                                                            function ($message) use ($email) {
                                                                $message->to($email)
                                                                    ->subject("Activity Performed By " . Auth::user()->name);
                                                            }
                                                        );
                                                    } catch (\Exception $e) {
                                                        //log error
                                                    }
                                                
                                            }
                                        }
                                    }
                                }
                                if ($request->Deviation_category == 'major' || $request->Deviation_category == 'minor' || $request->Deviation_category == 'critical') {
                                    $list = Helpers::getCorporateEHSHeadUserList();
                                            foreach ($list as $u) {
                                                if ($u->q_m_s_divisions_id == $deviation->division_id) {
                                                    $email = Helpers::getInitiatorEmail($u->user_id);
                                                    if ($email !== null) {
                                                         // Add this if statement
                                                         try {
                                                                Mail::send(
                                                                    'mail.Categorymail',
                                                                    ['data' => $deviation],
                                                                    function ($message) use ($email) {
                                                                        $message->to($email)
                                                                            ->subject("Activity Performed By " . Auth::user()->name);
                                                                    }
                                                                );
                                                            } catch (\Exception $e) {
                                                                //log error
                                                            }
                                                        
                                                    }
                                                }
                                            }
                                        }

                $deviation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($deviation->stage == 4) {

                // CFT review state update form_progress
                if ($deviation->form_progress !== 'cft') 
                {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'CFT Tab is yet to be filled'
                    ]);

                    return redirect()->back();
                } else {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Sent for Investigation and CAPA review state'
                    ]);
                }


                $IsCFTRequired = DeviationCftsResponse::withoutTrashed()->where(['is_required' => 1, 'deviation_id' => $id])->latest()->first();
                $cftUsers = DB::table('deviationcfts')->where(['deviation_id' => $id])->first();
                // Define the column names
                $columns = ['Production_person', 'Warehouse_notification', 'Quality_Control_Person', 'QualityAssurance_person', 'Engineering_person', 'Analytical_Development_person', 'Kilo_Lab_person', 'Technology_transfer_person', 'Environment_Health_Safety_person', 'Human_Resource_person', 'Information_Technology_person', 'Project_management_person','Other1_person','Other2_person','Other3_person','Other4_person','Other5_person'];
                // $columns2 = ['Production_review', 'Warehouse_review', 'Quality_Control_review', 'QualityAssurance_review', 'Engineering_review', 'Analytical_Development_review', 'Kilo_Lab_review', 'Technology_transfer_review', 'Environment_Health_Safety_review', 'Human_Resource_review', 'Information_Technology_review', 'Project_management_review'];

                // Initialize an array to store the values
                $valuesArray = [];

                // Iterate over the columns and retrieve the values
                foreach ($columns as $index => $column) {
                    $value = $cftUsers->$column;
                    if($index == 0 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Production_by = Auth::user()->name;
                        $updateCFT->production_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 1 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Warehouse_by = Auth::user()->name;
                        $updateCFT->Warehouse_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 4 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Engineering_by = Auth::user()->name;
                        $updateCFT->Engineering_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 2 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Quality_Control_by = Auth::user()->name;
                        $updateCFT->Quality_Control_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 3 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->QualityAssurance_by = Auth::user()->name;
                        $updateCFT->QualityAssurance_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 5 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Analytical_Development_by = Auth::user()->name;
                        $updateCFT->Analytical_Development_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 6 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Kilo_Lab_attachment_by = Auth::user()->name;
                        $updateCFT->Kilo_Lab_attachment_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 7 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Technology_transfer_by = Auth::user()->name;
                        $updateCFT->Technology_transfer_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 8 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Environment_Health_Safety_by = Auth::user()->name;
                        $updateCFT->Environment_Health_Safety_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 9 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Human_Resource_by = Auth::user()->name;
                        $updateCFT->Human_Resource_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 10 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Information_Technology_by = Auth::user()->name;
                        $updateCFT->Information_Technology_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 11 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Project_management_by = Auth::user()->name;
                        $updateCFT->Project_management_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 12 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other1_by = Auth::user()->name;
                        $updateCFT->Other1_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 13 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other2_by = Auth::user()->name;
                        $updateCFT->Other2_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 14 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other3_by = Auth::user()->name;
                        $updateCFT->Other3_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 15 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other4_by = Auth::user()->name;
                        $updateCFT->Other4_on = Carbon::now()->format('Y-m-d');
                    }
                    if($index == 16 && $cftUsers->$column == Auth::user()->id){
                        $updateCFT->Other5_by = Auth::user()->name;
                        $updateCFT->Other5_on = Carbon::now()->format('Y-m-d');
                    }
                    $updateCFT->update();

                    // Check if the value is not null and not equal to 0
                    if ($value != null && $value != 0) {
                        $valuesArray[] = $value;
                    }
                }
                // dd($valuesArray, count(array_unique($valuesArray)), ($cftDetails+1));
                if ($IsCFTRequired) {
                    if (count(array_unique($valuesArray)) == ($cftDetails + 1)) {
                        $stage = new DeviationCftsResponse();
                        $stage->deviation_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "Completed";
                        // $stage->cft_stage = ;
                        $stage->comment = $request->comment;
                        $stage->save();
                    } else {
                        $stage = new DeviationCftsResponse();
                        $stage->deviation_id = $id;
                        $stage->cft_user_id = Auth::user()->id;
                        $stage->status = "In-progress";
                        // $stage->cft_stage = ;
                        $stage->comment = $request->comment; 
                        $stage->save();
                    }
                }

                $checkCFTCount = DeviationCftsResponse::withoutTrashed()->where(['status' => 'Completed', 'deviation_id' => $id])->count();
                // dd(count(array_unique($valuesArray)), $checkCFTCount);
                

                if (!$IsCFTRequired || $checkCFTCount) {

                    $deviation->stage = "5";
                    $deviation->status = "QA Final Review";
                    $deviation->CFT_Review_Complete_By = Auth::user()->name;
                    $deviation->CFT_Review_Complete_On = Carbon::now()->format('d-M-Y');
                    $deviation->CFT_Review_Comments = $request->comment;

                    $history = new DeviationAuditTrail();
                    $history->deviation_id = $id;
                    $history->activity_type = 'Activity Log';
                    $history->previous = "";
                    $history->action='CFT Review Complete';
                    $history->current = $deviation->CFT_Review_Complete_By;
                    $history->comment = $request->comment;
                    $history->user_id = Auth::user()->id;
                    $history->user_name = Auth::user()->name;
                    $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                    $history->origin_state = $lastDocument->status;
                    $history->change_to =   "QA Final Review";
                    $history->change_from = $lastDocument->status;
                    $history->stage = 'Complete';
                    $history->save();
                    $list = Helpers::getQAUserList();
                    foreach ($list as $u) {
                        if ($u->q_m_s_divisions_id == $deviation->division_id) {
                            $email = Helpers::getInitiatorEmail($u->user_id);
                            if ($email !== null) {
                                try {
                                    Mail::send(
                                        'mail.view-mail',
                                        ['data' => $deviation],
                                        function ($message) use ($email) {
                                            $message->to($email)
                                                ->subject("Activity Performed By " . Auth::user()->name);
                                        }
                                    );
                                } catch (\Exception $e) {
                                    //log error
                                }
                            }
                        }
                    }
                    $deviation->update();
                }
                toastr()->success('Document Sent');
                return back();
            }

            if ($deviation->stage == 5) {

                if ($deviation->form_progress === 'capa' && !empty($deviation->QA_Feedbacks)) 
                {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Sent for QA Final review state'
                    ]);

                } else {
                    Session::flash('swal', [
                        'type' => 'warning',
                        'title' => 'Mandatory Fields!',
                        'message' => 'Investigation and CAPA / QA Final review Tab is yet to be filled!'
                    ]);

                    return redirect()->back();
                }

                
                $deviation->stage = "6";
                $deviation->status = "QA Head/Manager Designee Approval";
                $deviation->QA_Final_Review_Complete_By = Auth::user()->name;
                $deviation->QA_Final_Review_Complete_On = Carbon::now()->format('d-M-Y');
                $deviation->QA_Final_Review_Comments = $request->comment;

                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $deviation->QA_Final_Review_Complete_By;
                $history->comment = $request->comment;
                $history->action ='QA Final Review Complete';
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "QA Head/Manager Designee Approval";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Approved';
                $history->save();
                $list = Helpers::getQAUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                $deviation->update();
                toastr()->success('Document Sent');
                return back();
            }
            if ($deviation->stage == 6) {

                if ($deviation->form_progress !== 'qah')  
                {
                    
                    Session::flash('swal', [
                        'title' => 'Mandatory Fields!',
                        'message' => 'QAH/Designee Approval Tab is yet to be filled!',
                        'type' => 'warning',
                    ]);

                    return redirect()->back();
                } else {
                    Session::flash('swal', [
                        'type' => 'success',
                        'title' => 'Success',
                        'message' => 'Deviation sent to Closed/Done state'
                    ]);
                }

                $extension = Extension::where('parent_id', $deviation->id)->first();

                $rca = RootCauseAnalysis::where('parent_record', str_pad($deviation->id, 4, 0, STR_PAD_LEFT))->first();

                if ($extension && $extension->status !== 'Closed-Done') {
                    Session::flash('swal', [
                        'title' => 'Extension record pending!',
                        'message' => 'There is an Extension record which is yet to be closed/done!',
                        'type' => 'warning',
                    ]);

                    return redirect()->back();
                }

                if ($rca && $rca->status !== 'Closed-Done') {
                    Session::flash('swal', [
                        'title' => 'RCA record pending!',
                        'message' => 'There is an Root Cause Analysis record which is yet to be closed/done!',
                        'type' => 'warning',
                    ]);

                    return redirect()->back();
                }

                // return "PAUSE";

                $deviation->stage = "7";
                $deviation->status = "Closed - Done";
                $deviation->Approved_By = Auth::user()->name;
                $deviation->Approved_On = Carbon::now()->format('d-M-Y');
                $deviation->Approved_Comments = $request->comment;

                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->action ='Approved';
                $history->current = $deviation->Approved_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->change_to =   "Closed - Done";
                $history->change_from = $lastDocument->status;
                $history->stage = 'Completed';
                $history->save();
                $list = Helpers::getQAUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                $deviation->update();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    public function cftnotreqired(Request $request, $id)
    {


        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);
            $cftDetails = DeviationCftsResponse::withoutTrashed()->where(['status' => 'In-progress', 'deviation_id' => $id])->distinct('cft_user_id')->count();

                $deviation->stage = "5";
                $deviation->status = "QA Final Review";
                $deviation->QA_Final_Review_Complete_By = Auth::user()->name;
                $deviation->QA_Final_Review_Complete_On = Carbon::now()->format('d-M-Y');
                $deviation->QA_Final_Review_Comments = $request->comment;

                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->action ='QA Final Review Complete';
                $history->current = $deviation->QA_Final_Review_Complete_By;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'Approved';
                $history->save();
                $list = Helpers::getQAUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                $deviation->update();
                toastr()->success('Document Sent');
                return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function deviationCancel(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);


            $deviation->stage = "0";
            $deviation->status = "Closed-Cancelled";
            $deviation->cancelled_by = Auth::user()->name;
            $deviation->cancelled_on = Carbon::now()->format('d-M-Y');
            $history = new DeviationAuditTrail();
            $history->deviation_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->current = $deviation->cancelled_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $deviation->status;
            $history->stage = 'Cancelled';
            $history->save();
            $deviation->update();
            $history = new DeviationHistory();
            $history->type = "Deviation";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $deviation->stage;
            $history->status = $deviation->status;
            $history->save();

            $list = Helpers::getInitiatorUserList();
            foreach ($list as $u) {
                if ($u->q_m_s_divisions_id == $deviation->division_id) {
                    $email = Helpers::getInitiatorEmail($u->user_id);
                    if ($email !== null) {

                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $deviation],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Activity Performed By " . Auth::user()->name);
                                }
                            );
                        } catch (\Exception $e) {
                            //log error
                        }
                    }
                }
            }

            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function deviationIsCFTRequired(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);
            $list = Helpers::getInitiatorUserList();
            $deviation->stage = "5";
            $deviation->status = "QA Final Review";
            $deviation->CFT_Review_Complete_By = Auth::user()->name;
            $deviation->CFT_Review_Complete_On = Carbon::now()->format('d-M-Y');
            $history = new DeviationAuditTrail();
            $history->deviation_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->current = $deviation->CFT_Review_Complete_By;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage = 'Send to HOD';
            foreach ($list as $u) {
                if ($u->q_m_s_divisions_id == $deviation->division_id) {
                    $email = Helpers::getInitiatorEmail($u->user_id);
                    if ($email !== null) {

                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $deviation],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Activity Performed By " . Auth::user()->name);
                                }
                            );
                        } catch (\Exception $e) {
                            //log error
                        }
                    }
                }
            }
            $history->save();
            $deviation->update();
            $history = new DeviationHistory();
            $history->type = "Deviation";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $deviation->stage;
            $history->status = $deviation->status;
            $history->save();

            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function cftReview(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);
            $list = Helpers::getInitiatorUserList();
            $deviation->stage = "2";
            $deviation->status = "HOD Review";
            $deviation->qa_more_info_required_by = Auth::user()->name;
            $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
            $history = new DeviationAuditTrail();
            $history->deviation_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->current = $deviation->qa_more_info_required_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage = 'Send to HOD';
            foreach ($list as $u) {
                if ($u->q_m_s_divisions_id == $deviation->division_id) {
                    $email = Helpers::getInitiatorEmail($u->user_id);
                    if ($email !== null) {

                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $deviation],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Activity Performed By " . Auth::user()->name);
                                }
                            );
                        } catch (\Exception $e) {
                            //log error
                        }
                    }
                }
            }
            $history->save();
            $deviation->update();
            $history = new DeviationHistory();
            $history->type = "Deviation";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $deviation->stage;
            $history->status = "Send to HOD";
            $history->save();

            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }
    public function sendToQA(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);
            $list = Helpers::getInitiatorUserList();
            $cftResponse = DeviationCftsResponse::withoutTrashed()->where(['deviation_id' => $id])->get();

            // Soft delete all records
            $cftResponse->each(function ($response) {
                $response->delete();
            });

            $deviation->stage = "3";
            $deviation->status = "QA Initial Review";
            $deviation->qa_more_info_required_by = Auth::user()->name;
            $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
            $history = new DeviationAuditTrail();
            $history->deviation_id = $id;
            $history->activity_type = 'Activity Log';
            $history->previous = "";
            $history->current = $deviation->qa_more_info_required_by;
            $history->comment = $request->comment;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
            $history->origin_state = $lastDocument->status;
            $history->stage = 'Send to QA Initial Review';
            foreach ($list as $u) {
                if ($u->q_m_s_divisions_id == $deviation->division_id) {
                    $email = Helpers::getInitiatorEmail($u->user_id);
                    if ($email !== null) {

                        try {
                            Mail::send(
                                'mail.view-mail',
                                ['data' => $deviation],
                                function ($message) use ($email) {
                                    $message->to($email)
                                        ->subject("Activity Performed By " . Auth::user()->name);
                                }
                            );
                        } catch (\Exception $e) {
                            //log error
                        }
                    }
                }
            }
            $history->save();
            $deviation->update();
            $history = new DeviationHistory();
            $history->type = "Deviation";
            $history->doc_id = $id;
            $history->user_id = Auth::user()->id;
            $history->user_name = Auth::user()->name;
            $history->stage_id = $deviation->stage;
            $history->status = "Send to QA Initial Review";
            $history->save();

            toastr()->success('Document Sent');
            return back();
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }


    public function deviation_qa_more_info(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);

            if ($deviation->stage == 2) {
                $deviation->stage = "2";
                $deviation->status = "Opened";
                $deviation->qa_more_info_required_by = Auth::user()->name;
                $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->current = $deviation->qa_more_info_required_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'HOD Review';
                $history->save();
                $deviation->update();
                $history = new DeviationHistory();
                $history->type = "Deviation";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $deviation->stage;
                $history->status = $deviation->status;
                $history->save();
                $list = Helpers::getHodUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                toastr()->success('Document Sent');
                return back();
            }
            if ($deviation->stage == 3) {
                $deviation->stage = "2";
                $deviation->status = "HOD Review";
                $deviation->qa_more_info_required_by = Auth::user()->name;
                $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->action='More Information Required';
                $history->current = $deviation->qa_more_info_required_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'More Info Required';
                $history->save();
                $deviation->update();
                $history = new DeviationHistory();
                $history->type = "Deviation";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $deviation->stage;
                $history->status = $deviation->status;
                $history->save();
                $list = Helpers::getHodUserList();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {
                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                toastr()->success('Document Sent');
                return back();
            }

            if ($deviation->stage == 4) {
                $deviation->stage = "3";
                $deviation->status = "QA Initial Review";
                $deviation->qa_more_info_required_by = Auth::user()->name;
                $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->action='More Information Required';
                $history->current = $deviation->qa_more_info_required_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'More Info Required';
                $history->save();
                $deviation->update();
                $history = new DeviationHistory();
                $history->type = "Deviation";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $deviation->stage;
                $history->status = $deviation->status;
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }
        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function check(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);
            $cftResponse = DeviationCftsResponse::withoutTrashed()->where(['deviation_id' => $id])->get();
            $list = Helpers::getInitiatorUserList();
           // Soft delete all records
           $cftResponse->each(function ($response) {
            $response->delete();
        });


        $deviation->stage = "1";
        $deviation->status = "Opened";
        $deviation->qa_more_info_required_by = Auth::user()->name;
        $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
        $history = new DeviationAuditTrail();
        $history->deviation_id = $id;
        $history->activity_type = 'Activity Log';
        $history->previous = "";
        $history->current = $deviation->qa_more_info_required_by;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->stage = 'Send to Initiator';
        $history->save();
        $deviation->update();
        $history = new DeviationHistory();
        $history->type = "Deviation";
        $history->doc_id = $id;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->stage_id = $deviation->stage;
        $history->status = "Send to Initiator";
        $history->save();
        foreach ($list as $u) {
            if ($u->q_m_s_divisions_id == $deviation->division_id) {
                $email = Helpers::getInitiatorEmail($u->user_id);
                if ($email !== null) {

                    try {
                        Mail::send(
                            'mail.view-mail',
                            ['data' => $deviation],
                            function ($message) use ($email) {
                                $message->to($email)
                                    ->subject("Activity Performed By " . Auth::user()->name);
                            }
                        );
                    } catch (\Exception $e) {
                        //log error
                    }
                }
            }
        }
        $deviation->update();
        toastr()->success('Document Sent');
        return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function check2(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);
            $cftResponse = DeviationCftsResponse::withoutTrashed()->where(['deviation_id' => $id])->get();
            $list = Helpers::getInitiatorUserList();

        // Soft delete all records
        $cftResponse->each(function ($response) {
            $response->delete();
        });
        $deviation->stage = "2";
        $deviation->status = "HOD Review";
        $deviation->qa_more_info_required_by = Auth::user()->name;
        $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
        $history = new DeviationAuditTrail();
        $history->deviation_id = $id;
        $history->activity_type = 'Activity Log';
        $history->previous = "";
        $history->current = $deviation->qa_more_info_required_by;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->stage = 'Send to HOD';
        $history->save();
        $deviation->update();
        $history = new DeviationHistory();
        $history->type = "Deviation";
        $history->doc_id = $id;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->stage_id = $deviation->stage;
        $history->status = "Send to HOD Review";
        $history->save();
        foreach ($list as $u) {
            if ($u->q_m_s_divisions_id == $deviation->division_id) {
                $email = Helpers::getInitiatorEmail($u->user_id);
                if ($email !== null) {

                    try {
                        Mail::send(
                            'mail.view-mail',
                            ['data' => $deviation],
                            function ($message) use ($email) {
                                $message->to($email)
                                    ->subject("Activity Performed By " . Auth::user()->name);
                            }
                        );
                    } catch (\Exception $e) {
                        //log error
                    }
                }
            }
        }
        $deviation->update();
        toastr()->success('Document Sent');
        return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function check3(Request $request, $id)
    {
        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);
            $cftResponse = DeviationCftsResponse::withoutTrashed()->where(['deviation_id' => $id])->get();
            $list = Helpers::getInitiatorUserList();

        // Soft delete all records
        $cftResponse->each(function ($response) {
            $response->delete();
        });
        $deviation->stage = "3";
            $deviation->status = "QA Initial Review";
            $deviation->qa_more_info_required_by = Auth::user()->name;
            $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
        $history = new DeviationAuditTrail();
        $history->deviation_id = $id;
        $history->activity_type = 'Activity Log';
        $history->previous = "";
        $history->current = $deviation->qa_more_info_required_by;
        $history->comment = $request->comment;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
        $history->origin_state = $lastDocument->status;
        $history->stage = 'Send to HOD';
        $history->save();
        $deviation->update();
        $history = new DeviationHistory();
        $history->type = "Deviation";
        $history->doc_id = $id;
        $history->user_id = Auth::user()->id;
        $history->user_name = Auth::user()->name;
        $history->stage_id = $deviation->stage;
        $history->status = "Send to QA Initial Review";
        $history->save();
        foreach ($list as $u) {
            if ($u->q_m_s_divisions_id == $deviation->division_id) {
                $email = Helpers::getInitiatorEmail($u->user_id);
                if ($email !== null) {

                    try {
                        Mail::send(
                            'mail.view-mail',
                            ['data' => $deviation],
                            function ($message) use ($email) {
                                $message->to($email)
                                    ->subject("Activity Performed By " . Auth::user()->name);
                            }
                        );
                    } catch (\Exception $e) {
                        //log error
                    }
                }
            }
        }
        $deviation->update();
        toastr()->success('Document Sent');
        return back();

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function deviation_reject(Request $request, $id)
    {

        if ($request->username == Auth::user()->email && Hash::check($request->password, Auth::user()->password)) {
            // return $request;
            $deviation = Deviation::find($id);
            $lastDocument = Deviation::find($id);
            $list = Helpers::getInitiatorUserList();


            if ($deviation->stage == 2) {

                $deviation->stage = "1";
                $deviation->status = "Opened";
                $deviation->rejected_by = Auth::user()->name;
                $deviation->rejected_on = Carbon::now()->format('d-M-Y');
                $deviation->update();
                $history = new DeviationHistory();
                $history->type = "Deviation";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $deviation->stage;
                $history->status = "Opened";
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {

                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                $history->save();

                toastr()->success('Document Sent');
                return back();
            }
            if ($deviation->stage == 3) {
                $deviation->stage = "2";
                $deviation->status = "HOD Review";
                $deviation->form_progress = 'hod';
                $deviation->qa_more_info_required_by = Auth::user()->name;
                $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->action='More Information Required';
                $history->current = $deviation->qa_more_info_required_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'More Info Required';
                $history->save();
                $deviation->update();
                $history = new DeviationHistory();
                $history->type = "Deviation";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $deviation->stage;
                $history->status = "More Info Required";
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {

                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                $history->save();

                toastr()->success('Document Sent');
                return back();
            }
            if ($deviation->stage == 4) {

                $cftResponse = DeviationCftsResponse::withoutTrashed()->where(['deviation_id' => $id])->get();

                // Soft delete all records
                $cftResponse->each(function ($response) {
                    $response->delete();
                });

                $stage = new DeviationCftsResponse();
                $stage->deviation_id = $id;
                $stage->cft_user_id = Auth::user()->id;
                $stage->status = "More Info Required";
                // $stage->cft_stage = ;
                $stage->comment = $request->comment;
                $stage->save();

                $deviation->stage = "3";
                $deviation->status = "QA Initial Review";
                $deviation->form_progress = 'qa';

                $deviation->qa_more_info_required_by = Auth::user()->name;
                $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->action='More Information Required';
                $history->current = $deviation->qa_more_info_required_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'More Info Required';
                $history->save();
                $deviation->update();
                $history = new DeviationHistory();
                $history->type = "Deviation";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $deviation->stage;
                $history->status = "More Info Required";
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {

                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }

            if ($deviation->stage == 6) {
                $deviation->stage = "5";
                $deviation->status = "QA Final Review";
                $deviation->form_progress = 'capa';

                $deviation->qa_more_info_required_by = Auth::user()->name;
                $deviation->qa_more_info_required_on = Carbon::now()->format('d-M-Y');
                $history = new DeviationAuditTrail();
                $history->deviation_id = $id;
                $history->activity_type = 'Activity Log';
                $history->previous = "";
                $history->action='More Information Required';
                $history->current = $deviation->qa_more_info_required_by;
                $history->comment = $request->comment;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->user_role = RoleGroup::where('id', Auth::user()->role)->value('name');
                $history->origin_state = $lastDocument->status;
                $history->stage = 'More Info Required';
                // dd();
                foreach ($list as $u) {
                    if ($u->q_m_s_divisions_id == $deviation->division_id) {
                        $email = Helpers::getInitiatorEmail($u->user_id);
                        if ($email !== null) {

                            try {
                                Mail::send(
                                    'mail.view-mail',
                                    ['data' => $deviation],
                                    function ($message) use ($email) {
                                        $message->to($email)
                                            ->subject("Activity Performed By " . Auth::user()->name);
                                    }
                                );
                            } catch (\Exception $e) {
                                //log error
                            }
                        }
                    }
                }
                $history->save();
                $deviation->update();
                $history = new DeviationHistory();
                $history->type = "Deviation";
                $history->doc_id = $id;
                $history->user_id = Auth::user()->id;
                $history->user_name = Auth::user()->name;
                $history->stage_id = $deviation->stage;
                $history->status = "More Info Required";
                $history->save();
                toastr()->success('Document Sent');
                return back();
            }

        } else {
            toastr()->error('E-signature Not match');
            return back();
        }
    }

    public function deviation_child_1(Request $request, $id)
    {

        $cft = [];
        $parent_id = $id;
        $parent_type = "Audit_Program";
        $record_number = ((RecordNumber::first()->value('counter')) + 1);
        $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
        $currentDate = Carbon::now();
        $formattedDate = $currentDate->addDays(30);
        $due_date = $formattedDate->format('d-M-Y');
        $parent_record = Deviation::where('id', $id)->value('record');
        $parent_record = str_pad($parent_record, 4, '0', STR_PAD_LEFT);
        $parent_division_id = Deviation::where('id', $id)->value('division_id');
        $parent_initiator_id = Deviation::where('id', $id)->value('initiator_id');
        $parent_intiation_date = Deviation::where('id', $id)->value('intiation_date');
        $parent_created_at = Deviation::where('id', $id)->value('created_at');
        $parent_short_description = Deviation::where('id', $id)->value('short_description');
        $hod = User::where('role', 4)->get();
        if ($request->child_type == "extension") {
            $parent_due_date = "";
            $parent_id = $id;
            $parent_name = $request->parent_name;
            if ($request->due_date) {
                $parent_due_date = $request->due_date;
            }

            $record_number = ((RecordNumber::first()->value('counter')) + 1);
            $record_number = str_pad($record_number, 4, '0', STR_PAD_LEFT);
            $Extensionchild = Deviation::find($id);
            $Extensionchild->Extensionchild = $record_number;
            $Extensionchild->save();
            return view('frontend.forms.extension', compact('parent_id','parent_record', 'parent_name', 'record_number', 'parent_due_date', 'due_date', 'parent_created_at'));
        }
        $old_record = Deviation::select('id', 'division_id', 'record')->get();
        // dd($request->child_type)
        if ($request->child_type == "capa") {
            $parent_name = "CAPA";
            $Capachild = Deviation::find($id);
            $Capachild->Capachild = $record_number;
            $Capachild->save();
        
            return view('frontend.forms.capa', compact('parent_id', 'parent_record','parent_type', 'record_number', 'due_date', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record', 'old_record', 'cft'));
        } elseif ($request->child_type == "Action_Item")
         {
            $parent_name = "CAPA";
            $actionchild = Deviation::find($id);
            $actionchild->actionchild = $record_number;
            $parent_id = $id;
            $actionchild->save();
        
            return view('frontend.forms.action-item', compact('old_record', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record', 'record_number', 'due_date', 'parent_id', 'parent_type'));
        }
        elseif ($request->child_type == "effectiveness_check")
         {
            $parent_name = "CAPA";
            $effectivenesschild = Deviation::find($id);
            $effectivenesschild->effectivenesschild = $record_number;
            
            $effectivenesschild->save();
        return view('frontend.forms.effectiveness-check', compact('old_record','parent_short_description','parent_record', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id',  'record_number', 'due_date', 'parent_id', 'parent_type'));
        }
        elseif ($request->child_type == "Change_control") {
            $parent_name = "CAPA";
            $Changecontrolchild = Deviation::find($id);
            $Changecontrolchild->Changecontrolchild = $record_number;

            $Changecontrolchild->save();
            
            return view('frontend.change-control.new-change-control', compact('cft','pre','hod','parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_division_id',  'record_number', 'due_date', 'parent_id', 'parent_type'));
        }
        else {
            $parent_name = "Root";
            $Rootchild = Deviation::find($id);
            $Rootchild->Rootchild = $record_number;
            $Rootchild->save();
            return view('frontend.forms.root-cause-analysis', compact('parent_id', 'parent_record','parent_type', 'record_number', 'due_date', 'parent_short_description', 'parent_initiator_id', 'parent_intiation_date', 'parent_name', 'parent_division_id', 'parent_record', ));
        }
    }

    public function DeviationAuditTrial($id)
    {
        // $audit = DeviationAuditTrail::where('deviation_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $audit = DeviationAuditTrail::where('deviation_id', $id)
        ->orderByDesc('id')
        ->paginate(5);

        // dd($audit);
        $today = Carbon::now()->format('d-m-y');
        $document = Deviation::where('id', $id)->first();
        // dd( $document);

        $document->initiator = User::where('id', $document->initiator_id)->value('name');


        // return $audit;

        return view('frontend.forms.deviation_audit', compact('audit', 'document', 'today'));
    }
    public function rootAuditTrial($id)
    {
        $audit = RootAuditTrial::where('root_id', $id)->orderByDESC('id')->get()->unique('activity_type');
        $today = Carbon::now()->format('d-m-y');
        $document = RootCauseAnalysis::where('id', $id)->first();
        $document->initiator = User::where('id', $document->initiator_id)->value('name');

        return view("frontend.root-cause-analysis.root-audit-trail", compact('audit', 'document', 'today'));
    }

    public function DeviationAuditTrialDetails($id)
    {
        $detail = DeviationAuditTrail::find($id);
        $detail_data = DeviationAuditTrail::where('activity_type', $detail->activity_type)->where('deviation_id', $detail->deviation_id)->latest()->get();
        $doc = Deviation::where('id', $detail->deviation_id)->first();
        $doc->origiator_name = User::find($doc->initiator_id);
        return view('frontend.forms.audit-trial-deviation-inner', compact('detail', 'doc', 'detail_data'));
    }
    public static function singleReport($id)
    {
        $data = Deviation::find($id);
        // return $data;
        $data1 =  DeviationCft::where('deviation_id', $id)->first();
        if (!empty ($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $grid_data = DeviationGrid::where('deviation_grid_id', $id)->where('type', "Deviation")->first();
            $grid_data1 = DeviationGrid::where('deviation_grid_id', $id)->where('type', "Document")->first();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.forms.SingleReportdeviation', compact('data','grid_data','grid_data1', 'data1'))
                ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('Deviation' . $id . '.pdf');
        }
    }
    public static function parentchildReport($id)
    {
        $data = Deviation::find($id);
        $data4 =  DeviationCft::where('deviation_id', $id)->first();
        $Capachild = $data->Capachild;
        $Rootchild = $data->Rootchild;
       
        $Extensionchild = $data->Extensionchild;
        $data1 = Capa::where('record', $Capachild)->first();
        $data2 = RootCauseAnalysis::where('record', $Rootchild)->first();

        $data3 = Extension::where('record', $Extensionchild)->first();
        if (!empty ($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $grid_data = DeviationGrid::where('deviation_grid_id', $id)->where('type', "Deviation")->first();
           
            $grid_data1 = DeviationGrid::where('deviation_grid_id', $id)->where('type', "Document")->first();
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.forms.deviationparentchildReport', compact('data', 'data1', 'data2', 'data3','data4','grid_data1','grid_data'))
                ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('Deviation' . $id . '.pdf');
        }
    }
    public static function deviationfamilyReport($id)
    {
        $data = Deviation::find($id);
        $data7 =  DeviationCft::where('deviation_id', $id)->first();
        $Capachild = $data->Capachild;
        
        $Rootchild = $data->Rootchild;
        $Extensionchild = $data->Extensionchild;
         $actionchild=$data->actionchild;
         $effectivenesschild=$data->effectivenesschild;
         $Changecontrolchild=$data->Changecontrolchild;
        //  dd($Changecontrolchild);
        $data1 = Capa::where('record', $Capachild)->first();
        $data2 = RootCauseAnalysis::where('record', $Rootchild)->first();
        $data3 = Extension::where('record', $Extensionchild)->first();
        $data4 = ActionItem::where('record', $actionchild)->first();
        $data5 = EffectivenessCheck::where('record', $effectivenesschild)->first();
        $data6 = CC::where('record', $Changecontrolchild)->first();
        
        // $data4 = CC::find($id);

        if (!empty ($data)) {
            $data->originator = User::where('id', $data->initiator_id)->value('name');
            $pdf = App::make('dompdf.wrapper');
            $grid_data = DeviationGrid::where('deviation_grid_id', $id)->where('type', "Deviation")->first();
           
            $grid_data1 = DeviationGrid::where('deviation_grid_id', $id)->where('type', "Document")->first();
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.forms.DeviationFamily', compact('data', 'data1', 'data2', 'data3','data4','data5','data6','grid_data1','grid_data','data7'))
                ->setOptions([
                'defaultFont' => 'sans-serif',
                'isHtml5ParserEnabled' => true,
                'isRemoteEnabled' => true,
                'isPhpEnabled' => true,
            ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $data->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('Deviation' . $id . '.pdf');
        }
    }

    public static function auditReport($id)
    {
        $doc = Deviation::find($id);
        if (!empty($doc)) {
            $doc->originator_id = User::where('id', $doc->initiator_id)->value('name');
            $data = DeviationAuditTrail::where('deviation_id', $id)->get();
            $pdf = App::make('dompdf.wrapper');
            $time = Carbon::now();
            $pdf = PDF::loadview('frontend.forms.auditReport', compact('data', 'doc'))
                ->setOptions([
                    'defaultFont' => 'sans-serif',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'isPhpEnabled' => true,
                ]);
            $pdf->setPaper('A4');
            $pdf->render();
            $canvas = $pdf->getDomPDF()->getCanvas();
            $height = $canvas->get_height();
            $width = $canvas->get_width();
            $canvas->page_script('$pdf->set_opacity(0.1,"Multiply");');
            $canvas->page_text($width / 4, $height / 2, $doc->status, null, 25, [0, 0, 0], 2, 6, -20);
            return $pdf->stream('Deviation' . $id . '.pdf');
        }
    }

    public function store_audit_review(Request $request, $id)
    {
            $history = new AuditReviewersDetails;
            $history->deviation_id = $id;
            $history->user_id = Auth::user()->id;
            $history->reviewer_comment = $request->reviewer_comment;
            $history->reviewer_comment_by = Auth::user()->name;
            $history->reviewer_comment_on = Carbon::now()->toDateString();
            $history->save();

        return redirect()->back();
    }
}
