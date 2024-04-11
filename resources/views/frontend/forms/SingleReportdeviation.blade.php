<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>VidyaGxP - Software</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
</head>

<style>
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        min-height: 100vh;
    }

    .w-10 {
        width: 10%;
    }

    .w-20 {
        width: 20%;
    }

    .w-25 {
        width: 25%;
    }

    .w-30 {
        width: 30%;
    }

    .w-40 {
        width: 40%;
    }

    .w-50 {
        width: 50%;
    }

    .w-60 {
        width: 60%;
    }

    .w-70 {
        width: 70%;
    }

    .w-80 {
        width: 80%;
    }

    .w-90 {
        width: 90%;
    }

    .w-100 {
        width: 100%;
    }

    .h-100 {
        height: 100%;
    }

    header table,
    header th,
    header td,
    footer table,
    footer th,
    footer td,
    .border-table table,
    .border-table th,
    .border-table td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.9rem;
        vertical-align: middle;
    }

    table {
        width: 100%;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    footer .head,
    header .head {
        text-align: center;
        font-weight: bold;
        font-size: 1.2rem;
    }

    @page {
        size: A4;
        margin-top: 160px;
        margin-bottom: 60px;
    }

    header {
        position: fixed;
        top: -140px;
        left: 0;
        width: 100%;
        display: block;
    }

    footer {
        width: 100%;
        position: fixed;
        display: block;
        bottom: -40px;
        left: 0;
        font-size: 0.9rem;
    }

    footer td {
        text-align: center;
    }

    .inner-block {
        padding: 10px;
    }

    .inner-block tr {
        font-size: 0.8rem;
    }

    .inner-block .block {
        margin-bottom: 30px;
    }

    .inner-block .block-head {
        font-weight: bold;
        font-size: 1.1rem;
        padding-bottom: 5px;
        border-bottom: 2px solid #4274da;
        margin-bottom: 10px;
        color: #4274da;
    }

    .inner-block th,
    .inner-block td {
        vertical-align: baseline;
    }

    .table_bg {
        background: #4274da57;
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                   Deviation Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://navin.mydemosoftware.com/public/user/images/logo.png" alt="" class="w-100">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong> Deviation No.</strong>
                </td>
                <td class="w-40">
                   {{ Helpers::divisionNameForQMS($data->division_id) }}/{{ Helpers::year($data->created_at) }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <div class="inner-block">
        <div class="content-table">
            <div class="block">
                <div class="block-head">
                    General Information
                </div>
                <table>
                    <tr>  {{ $data->created_at }} added by {{ $data->originator }}
                        <th class="w-20">Site/Location Code</th>
                        <td class="w-30"> {{ Helpers::getDivisionName(session()->get('division')) }}</td>
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ Helpers::getInitiatorName($data->initiator_id) }}</td>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Date of Initiation</th>
                        {{-- <td class="w-30">@if{{ Helpers::getdateFormat($data->intiation_date) }} @else Not Applicable @endif</td> --}}
                        {{-- <td class="w-30">@if (Helpers::getdateFormat($data->intiation_date)) {{ Helpers::getdateFormat($data->intiation_date) }} @else Not Applicable @endif</td> --}}
                        <td class="w-30">{{ $data->created_at ? $data->created_at->format('d-M-Y') : ''  }} </td>

                        <th class="w-20">Due Date</th>
                        <td class="w-30"> @if($data->due_date){{ $data->due_date }} @else Not Applicable @endif</td>
                        
                    </tr>
                    <tr>
                        <th class="w-20">Department</th>    
                        <td class="w-30">  @if($data->Initiator_Group){{ Helpers::getFullDepartmentName($data->Initiator_Group) }} @else Not Applicable @endif</td>
                        <th class="w-20">Department Code</th>
                        <td class="w-30">@if($data->initiator_group_code){{ $data->initiator_group_code }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-30"> @if($data->short_description){{ $data->short_description }}@else Not Applicable @endif</td>
                        <th class="w-20"> Nature of Repeat?</th>
                        <td class="w-30">@if($data->short_description_required){{ $data->short_description_required }} @else Not Applicable @endif</td>

                    </tr>
                    <tr>
                        <th class="w-20"> Repeat Nature</th>
                        <td class="w-30">@if($data->nature_of_repeat){{ $data->nature_of_repeat }} @else Not Applicable @endif</td>
                        <th class="w-20"> Deviation Observed On</th>
                        <td class="w-30">@if($data->Deviation_date){{ $data->Deviation_date }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20"> Deviation Observed On (Time)</th>
                        <td class="w-30">@if($data->deviation_time){{ $data->deviation_time }} @else Not Applicable @endif</td>
                        <th class="w-20">Deviation Observed by</th>
                        @php
                        $facilityIds = explode(',', $data->Facility);
                        $users = $facilityIds ? DB::table('users')->whereIn('id', $facilityIds)->get() : [];
                    @endphp
                    
                    <td>
                        @if($facilityIds && count($users) > 0)
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
                            @endforeach
                        @else
                            Not Applicable
                        @endif
                    </td>
                    
                        {{-- <td class="w-30">@if($data->Facility){{ $data->Facility }} @else Not Applicable @endif</td> --}}
                        
                    </tr>
                    <tr>
                        <th class="w-20">Deviation Reported On </th>
                        <td class="w-30">@if($data->Deviation_reported_date){{ $data->Deviation_reported_date }} @else Not Applicable @endif</td>
                        <th class="w-20">Deviation Related To</th>
                        <td class="w-30">@if($data->audit_type){{ $data->audit_type }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                       
                        <th class="w-20"> Others</th>
                        <td class="w-30">@if($data->others){{ $data->others }}@else Not Applicable @endif</td>                       
                    </tr>
                    <tr>
            
                            <th class="w-20">Facility/ Equipment/ Instrument/ System Details Required?</th>
                            <td class="w-30">@if($data->Facility_Equipment){{ $data->Facility_Equipment }}@else Not Applicable @endif</td>
                            <th class="w-20">Document Details Required?</th>
                            <td class="w-30">@if($data->Document_Details_Required){{ $data->Document_Details_Required }}@else Not Applicable @endif</td>


                    </tr>


                    <tr>
                        <th class="w-20">Name of Product & Batch No</th>
                        <td class="w-30">@if($data->Product_Batch){{ ($data->Product_Batch) }} @else Not Applicable @endif</td>
                        <th class="w-20">Description of Deviation</th>
                        <td class="w-30">@if($data->Description_Deviation){{ $data->Description_Deviation }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                       
                        
                    </tr>
                    <tr>
                        <th class="w-20">Immediate Action (if any)</th>
                        <td class="w-30">@if($data->Immediate_Action){{ $data->Immediate_Action }}@else Not Applicable @endif</td>
                        <th class="w-20">Preliminary Impact of Deviation</th>
                        <td class="w-30">@if($data->Preliminary_Impact){{ $data->Preliminary_Impact }}@else Not Applicable @endif</td>
                    </tr>
                    
                </table>  
                    <div class="block">
                        <div class="block-head">
                            Facility/ Equipment/ Instrument/ System Details
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                <th class="w-25">SR no.</th>
                                    <th class="w-25">Name</th>
                                    <th class="w-25">ID Number</th>
                                    <th class="w-25">Remarks</th>
                                
                                </tr>
                                @if(!empty($grid_data->IDnumber))
                                    @foreach (unserialize($grid_data->IDnumber) as $key => $dataDemo)
                                        <tr>
                                            <td class="w-15">{{ $loop->index + 1 }}</td>
                                            <td class="w-15">{{ unserialize($grid_data->facility_name)[$key] ?  unserialize($grid_data->facility_name)[$key]: "Not Applicable"}}</td>
                                            <td class="w-15">{{unserialize($grid_data->IDnumber)[$key] ?  unserialize($grid_data->IDnumber)[$key] : "Not Applicable" }}</td>
                                            <td class="w-15">{{unserialize($grid_data->Remarks)[$key] ?  unserialize($grid_data->Remarks)[$key] : "Not Applicable" }}</td>
                                        
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr>
                                            <td>Not Applicable</td>
                                            <td>Not Applicable</td>
                                            <td>Not Applicable</td>
                                            <td>Not Applicable</td>
                                        
                                        </tr>
                                @endif
                            </table>
                        </div>
                    </div>

                    <div class="block">
                        <div class="block-head">
                            Document Details 
                        </div>
                        <div class="border-table">
                            <table>
                                <tr class="table_bg">
                                <th class="w-25">SR no.</th>
                                    <th class="w-25">Number</th>
                                    <th class="w-25">Reference Document Name</th>
                                    <th class="w-25">Remarks</th>
                                
                                </tr>
                                @if(!empty($grid_data1->Number))
                                @foreach (unserialize($grid_data1->Number) as $key => $dataDemo)
                                <tr>
                                    <td class="w-15">{{ $loop->index + 1 }}</td>
                                    <td class="w-15">{{ unserialize($grid_data1->Number)[$key] ?  unserialize($grid_data1->Number)[$key]: "Not Applicable"}}</td>
                                    <td class="w-15">{{unserialize($grid_data1->ReferenceDocumentName)[$key] ?  unserialize($grid_data1->ReferenceDocumentName)[$key] : "Not Applicable" }}</td>
                                    <td class="w-15">{{unserialize($grid_data1->Document_Remarks)[$key] ?  unserialize($grid_data1->Document_Remarks)[$key] : "Not Applicable" }}</td>
                                   
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                    <td>Not Applicable</td>
                                   
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
        

                       
         
            <div class="block">
                    <div class="block-head">
                        HOD Review
                    </div>
                    <table>
                        <tr>
                            <th class="w-30">HOD Remarks</th>
                            <td class="w-20">@if($data->HOD_Remarks){{ $data->HOD_Remarks }}@else Not Applicable @endif</td>
                        </tr>
                    </table>
                        <div class="border-table">
                            <div class="block-head">
                                HOD Attachments
                            </div>
                            <table>
            
                                <tr class="table_bg">
                                    <th class="w-20">S.N.</th>
                                    <th class="w-60">Attachment</th>
                                </tr>
                                    @if($data->Audit_file)
                                    @foreach(json_decode($data->Audit_file) as $key => $file)
                                        <tr>
                                            <td class="w-20">{{ $key + 1 }}</td>
                                            <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                        </tr>
                                    @endforeach
                                    @else
                                <tr>
                                    <td class="w-20">1</td>
                                    <td class="w-20">Not Applicable</td>
                                </tr>
                                @endif
            
                            </table>
                        </div>
                       
                       
                             
                </div>
            </div>
 
            <div class="block">
                <div class="block-head">
                    QA Initial Review
                </div>
                <table>
                   
                    <tr>
                        <th class="w-20">Initial Deviation category</th>
                        <td class="w-30">@if($data->Deviation_category){{ ($data->Deviation_category) }}@else Not Applicable @endif</td>
                        <th class="w-20">Justification for categorization</th>
                        <td class="w-30">@if($data->Justification_for_categorization){{ $data->Justification_for_categorization }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Investigation Required?</th>
                        <td class="w-30">@if($data->Investigation_required){{ $data->Investigation_required }}@else Not Applicable @endif</td>
                        <th class="w-20">Investigation Details</th>
                        <td class="w-30">@if($data->Investigation_Details){{ $data->Investigation_Details }}@else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Customer Notification Required ?</th>
                        <td class="w-30">@if($data->Customer_notification){{$data->Customer_notification}}@else Not Applicable @endif</td>
                        <th class="w-20">Customers</th>
                        {{-- <td class="w-30">@if($data->customers){{ $data->customers }}@else Not Applicable @endif</td> --}}
                        @php
                            $customer = DB::table('customer-details')->where('id', $data->customers)->first();
                            $customer_name = $customer ? $customer->customer_name : 'Not Applicable';
                        @endphp
                    
                    <td>
                        @if($data->customers)
                            {{ $customer_name }}
                        @else
                            Not Applicable
                        @endif
                    </td>
                    </tr>

                    <tr>
                        <th class="w-20">Related Records</th>
                        <td class="w-30">@if($data->related_records){{$data->related_records }}@else Not Applicable @endif</td>
                        <th class="w-20">QA Initial Remarks</th>
                        <td class="w-30">@if($data->QAInitialRemark){{$data->QAInitialRemark }}@else Not Applicable @endif</td>
                        
                    </tr>

                </table>
            </div>    
            
            <div class="border-table">
                <div class="block-head">
                    QA Initial Attachments
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                        @if($data->Initial_attachment)
                        @foreach(json_decode($data->Initial_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                            </tr>
                        @endforeach
                        @else
                    <tr>
                        <td class="w-20">1</td>
                        <td class="w-20">Not Applicable</td>
                    </tr>
                    @endif

                </table>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                      CFT
                    </div>
                    <div class="head">
                        <div class="block-head">
                            Production
                        </div>
                     <table>

                                <tr>
                            
                                    <th class="w-20">Production Review Required ?
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if($data1->Production_Review){{ $data1->Production_Review }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Production Person</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data1->Production_person){{ $data1->Production_person }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                
                                
                                <tr>
                            
                                    <th class="w-20">Impact Assessment (By Production)</</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data1->Production_assessment){{ $data1->Production_assessment }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Production Feedback</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data1->Production_feedback){{ $data1->Production_feedback }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                            
                                    <th class="w-20">Production Review Completed By</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data1->Production_Review_Completed_By){{ $data1->production_by }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Production Review Completed On</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data1->production_on){{ $data1->production_on }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                               
                    </table>
                 </div>  
            <div class="border-table">
                <div class="block-">
                    Production Attachments 
                </div>                                     
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                        @if($data1->production_attachment)
                        @foreach(json_decode($data1->production_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                            </tr>
                        @endforeach
                        @else
                    <tr>
                        <td class="w-20">1</td>
                        <td class="w-20">Not Applicable</td>
                    </tr>
                    @endif

                </table>
            </div>
            
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Warehouse
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Warehouse Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Warehouse_review){{ $data1->Warehouse_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Warehouse Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Warehouse_notification){{ $data1->Warehouse_notification }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Warehouse)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Warehouse_assessment){{ $data1->Warehouse_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Warehouse Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Warehouse_feedback){{ $data1->Warehouse_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Warehouse Review Completed By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Warehouse_by){{ $data1->Warehouse_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Warehouse Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Warehouse_Review_Completed_On){{ $data1->Warehouse_Review_Completed_On }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Production Attachments 2
                    </div>                                    
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Warehouse_attachment)
                            @foreach(json_decode($data1->Warehouse_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div>    
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Quality Control
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Quality Control Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Quality_review){{ $data1->Quality_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Quality Control Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Quality_Control_Person){{ $data1->Quality_Control_Person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Quality Control)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Quality_Control_assessment){{ $data1->Quality_Control_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Quality Control Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Quality_Control_feedback){{ $data1->Quality_Control_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Quality Review Completed By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->QualityAssurance__by){{ $data1->QualityAssurance__by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Quality Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Quality_Control_on){{ $data1->Quality_Control_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Quality Control Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Quality_Control_attachment)
                            @foreach(json_decode($data1->Quality_Control_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div>  
           
            
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Quality Assurance
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Quality Assurance Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Quality_Assurance){{ $data1->Quality_Assurance }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Quality Assurance Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->QualityAssurance_person){{ $data1->QualityAssurance_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Quality Assurance)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->QualityAssurance_assessment){{ $data1->QualityAssurance_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Quality Assurance feedback Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Quality_Assurance_feedback){{ $data1->Quality_Assurance_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Quality Assurance Review Completed By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->QualityAssurance_by){{ $data1->QualityAssurance_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Quality Assurance Review Completed  On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->QualityAssurance_on){{ $data1->QualityAssurance_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Quality Assurance Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Quality_Assurance_attachment)
                            @foreach(json_decode($data1->Quality_Assurance_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div>   
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Engineering 
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Engineering Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Engineering_review){{ $data1->Engineering_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Engineering Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Engineering_person){{ $data1->Engineering_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Engineering)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Engineering_assessment){{ $data1->Engineering_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Engineering Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Engineering_feedback){{ $data1->Engineering_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Engineering Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Engineering_by){{ $data1->Engineering_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Engineering Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Engineering_on){{ $data1->Engineering_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Engineering Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Engineering_attachment)
                            @foreach(json_decode($data1->Engineering_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Analytical Development Laboratory
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Analytical Development Laboratory Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Analytical_Development_review){{ $data1->Analytical_Development_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Analytical Development Laboratory Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Analytical_Development_person){{ $data1->Analytical_Development_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Analytical Development Laboratory)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Analytical_Development_assessment){{ $data1->Analytical_Development_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Analytical Development Laboratory  Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Analytical_Development_feedback){{ $data1->Analytical_Development_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Analytical Development Laboratory Review Completed By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Analytical_Development_by){{ $data1->Analytical_Development_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Analytical Development Laboratory Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Analytical_Development_on){{ $data1->Analytical_Development_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Analytical Development Laboratory Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Analytical_Development_attachment)
                            @foreach(json_decode($data1->Analytical_Development_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Process Development Laboratory / Kilo Lab
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Process Development Laboratory / Kilo Lab Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Kilo_Lab_review){{ $data1->Kilo_Lab_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Process Development Laboratory / Kilo Lab Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Kilo_Lab_person){{ $data1->Kilo_Lab_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Process Development Laboratory / Kilo Lab)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Kilo_Lab_assessment){{ $data1->Kilo_Lab_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Process Development Laboratory / Kilo Lab  Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Kilo_Lab_feedback){{ $data1->Kilo_Lab_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Process Development Laboratory / Kilo Lab Review Completed By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Kilo_Lab_attachment_by){{ $data1->Kilo_Lab_attachment_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Process Development Laboratory / Kilo Lab Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Kilo_Lab_attachment_on){{ $data1->Kilo_Lab_attachment_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Process Development
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Kilo_Lab_attachment)
                            @foreach(json_decode($data1->Kilo_Lab_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div>
            
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Technology Transfer / Design 
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Technology Transfer / Design Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Technology_transfer_review){{ $data1->Technology_transfer_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Technology Transfer / Design Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Technology_transfer_person){{ $data1->Technology_transfer_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Technology Transfer / Design)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Technology_transfer_assessment){{ $data1->Technology_transfer_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Technology Transfer / Design Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Technology_transfer_feedback){{ $data1->Technology_transfer_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Technology Transfer / Design Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Technology_transfer_by){{ $data1->Technology_transfer_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Technology Transfer / Design Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Technology_transfer_on){{ $data1->Technology_transfer_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Technology Transfer / Design Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Technology_transfer_attachment)
                            @foreach(json_decode($data1->Technology_transfer_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
        
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Environment, Health & Safety 
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Environment, Health & Safety Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Environment_Health_review){{ $data1->Environment_Health_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Environment, Health & Safety Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Environment_Health_Safety_person){{ $data1->Environment_Health_Safety_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By  Environment, Health & Safety)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Health_Safety_assessment){{ $data1->Health_Safety_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Environment, Health & Safety Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Health_Safety_feedback){{ $data1->Health_Safety_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Environment, Health & Safety Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->production_by){{ $data1->Human_Resource_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Environment, Health & Safety Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Human_Resource_on){{ $data1->Human_Resource_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Environment, Health & Safety Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Human_Resource_attachment)
                            @foreach(json_decode($data1->Human_Resource_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Human Resource & Administration 
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Human Resource & Administration Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Human_Resource_review){{ $data1->Human_Resource_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Human Resource & Administration Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Human_Resource_person){{ $data1->Human_Resource_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Human Resource & Administration)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Human_Resource_assessment){{ $data1->Human_Resource_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Human Resource & Administration Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Human_Resource_feedback){{ $data1->Human_Resource_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Human Resource & Administration Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Human_Resource_by){{ $data1->production_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Human Resource & Administration Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->production_on){{ $data1->production_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Human Resource & Administration Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Initial_attachment)
                            @foreach(json_decode($data1->Initial_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
            ---
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Information Technology
 
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Information Technology Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Information_Technology_review){{ $data1->Information_Technology_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Information Technology Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Information_Technology_person){{ $data1->Information_Technology_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Information Technology)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Information_Technology_assessment){{ $data1->Information_Technology_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Information Technology Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Information_Technology_feedback){{ $data1->Information_Technology_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Information Technology Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Information_Technology_by){{ $data1->Information_Technology_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Information Technology Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Information_Technology_on){{ $data1->Information_Technology_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Information Technology Attachments 
                     </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Information_Technology_attachment)
                            @foreach(json_decode($data1->Information_Technology_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
            
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Project Management
 
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Project Management Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Project_management_review){{ $data1->Project_management_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Project Management Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Project_management_person){{ $data1->Project_management_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Project Management)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Project_management_assessment){{ $data1->Project_management_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Project Management Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Project_management_feedback){{ $data1->Project_management_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Project Management Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Project_management_by){{ $data1->Project_management_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Project Management Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Project_management_on){{ $data1->Project_management_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Project Management Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Project_management_attachment)
                            @foreach(json_decode($data1->Project_management_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 1 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Other's 1 Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other1_review){{ $data1->Other1_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 1 Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other1_person){{ $data1->Other1_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 1 Department</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other1_Department_person){{ $data1->Other1_Department_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Other's 1)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other1_assessment){{ $data1->Other1_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 1 Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other1_feedback){{ $data1->Other1_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Other's 1 Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other1_by){{ $data1->Other1_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Other's 1 Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other1_on){{ $data1->Other1_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Other's 1 Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Other1_attachment)
                            @foreach(json_decode($data1->Other1_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 2 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Other's 2 Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other2_review){{ $data1->Other2_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 2 Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other2_person){{ $data1->Other2_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 2 Department</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other2_Department_person){{ $data1->Other2_Department_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Other's 2)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other2_assessment){{ $data1->Other2_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 2 Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other2_feedback){{ $data1->Other2_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Other's 2 Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other2_by){{ $data1->Other2_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Other's 2 Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other2_on){{ $data1->Other2_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Other's 2 Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Other2_attachment)
                            @foreach(json_decode($data1->Other2_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 3 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Other's 3 Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other3_review){{ $data1->Other3_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 3 Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other3_person){{ $data1->Other3_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 3 Department</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other3_Department_person){{ $data1->Other3_Department_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Other's 3)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other3_assessment){{ $data1->Other3_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 3 Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other3_feedback){{ $data1->Other3_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Other's 3 Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other3_by){{ $data1->Other3_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Other's 3 Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other3_on){{ $data1->Other3_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Other's 3 Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Other3_attachment)
                            @foreach(json_decode($data1->Other3_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">4</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 4 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Other's 4 Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other4_review){{ $data1->Other4_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 4 Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other4_person){{ $data1->Other4_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 4 Department</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other4_Department_person){{ $data1->Other4_Department_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Other's 4)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other4_assessment){{ $data1->Other4_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 4 Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other4_feedback){{ $data1->Other4_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Other's 4 Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other4_by){{ $data1->Other4_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Other's 4 Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other4_on){{ $data1->Other4_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Other's 4 Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Other4_attachment)
                            @foreach(json_decode($data1->Other4_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Other's 5 ( Additional Person Review From Departments If Required)
                    </div>
                    <table>

                            <tr>
                        
                                <th class="w-20">Other's 5 Review Required ?
                                </th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other5_review){{ $data1->Other5_review }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 5 Person</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other5_person){{ $data1->Other5_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 5 Department</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other5_Department_person){{ $data1->Other5_Department_person }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            
                            <tr>
                        
                                <th class="w-20">Impact Assessment (By Other's 5)</</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other5_assessment){{ $data1->Other5_assessment }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20">Other's 5 Feedback</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other5_feedback){{ $data1->Other5_feedback }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                            <tr>
                        
                                <th class="w-20">Other's 5 Review Completed  By</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other5_by){{ $data1->Other5_by }}@else Not Applicable @endif
                                    </div>
                                </td>
                                <th class="w-20"> Other's 5 Review Completed On</th>
                                <td class="w-30">
                                    <div>
                                        @if($data1->Other5_on){{ $data1->Other5_on }}@else Not Applicable @endif
                                    </div>
                                </td>
                            </tr>
                    </table>
                    </div>  
                  <div class="border-table">
                    <div class="block-">
                        Other's 5 Attachments 
                    </div>                                   
                    <table>
    
                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data1->Other5_attachment)
                            @foreach(json_decode($data1->Other5_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif
    
                    </table>
                </div>
            </div> 
    
   
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        Investigation & CAPA
                    </div>
                    <table>

                                <tr>
                            
                                    <th class="w-20">Investigation Summary
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->Investigation_Summary){{ $data->Investigation_Summary }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Impact Assessment</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->Impact_assessment){{ $data->Impact_assessment }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th class="w-20">Root cause</th>
                                    <td class="w-80">
                                        <div>
                                            @if($data->Root_cause){{ $data->Root_cause }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                
                                <tr>
                            
                                    <th class="w-20">CAPA Required ?</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->CAPA_Rquired){{ $data->CAPA_Rquired }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">CAPA Type?</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->capa_type){{ $data->capa_type }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                            
                                    <th class="w-20">CAPA Description</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->CAPA_Description){{ $data->CAPA_Description }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    <th class="w-20">Post Categorization Of Deviationt</th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->Post_Categorization){{ $data->Post_Categorization }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                            
                                    <th class="w-20">Revised Categorization Justification
                                    </th>
                                    <td class="w-30">
                                        <div>
                                            @if($data->Investigation_Of_Review){{ $data->Investigation_Of_Review }}@else Not Applicable @endif
                                        </div>
                                    </td>
                                    
                                </tr>
                 </table>
            </div>  
            <div class="border-table">
                <div class="block-head">
                    Investigation Attachment
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                        @if($data->Investigation_attachment)
                        @foreach(json_decode($data->Investigation_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                            </tr>
                        @endforeach
                        @else
                    <tr>
                        <td class="w-20">1</td>
                        <td class="w-20">Not Applicable</td>
                    </tr>
                    @endif

                </table>
            </div>
            <div class="border-table">
                <div class="block-head">
                    CAPA Attachment
                </div>
                <table>

                    <tr class="table_bg">
                        <th class="w-20">S.N.</th>
                        <th class="w-60">Attachment</th>
                    </tr>
                        @if($data->Capa_attachment)
                        @foreach(json_decode($data->Capa_attachment) as $key => $file)
                            <tr>
                                <td class="w-20">{{ $key + 1 }}</td>
                                <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                            </tr>
                        @endforeach
                        @else
                    <tr>
                        <td class="w-20">1</td>
                        <td class="w-20">Not Applicable</td>
                    </tr>
                    @endif

                </table>
            </div>
                
            <div class="block">
                <div class="block-head">
                    QA Final Review
                </div>
                <table>

                        <tr>
                        <th class="w-20">QA Feedbacks</th>
                        <td class="w-30">@if($data->QA_Feedbacks){{ $data->QA_Feedbacks }}@else Not Applicable @endif</td>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        QA Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data->QA_attachments)
                            @foreach(json_decode($data->QA_attachments) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif

                    </table>
                </div>
            </div>
            <div class="block">
                <div class="block-head">
                    QAH/Designee Approval
                </div>
                <table>

                        <tr>
                        <th class="w-20">Closure Comments</th>
                        <td class="w-30">@if($data->Closure_Comments){{ $data->Closure_Comments }}@else Not Applicable @endif</td>
                        <th class="w-20">Disposition of Batch</th>
                        <td class="w-30">@if($data->Disposition_Batch){{ $data->Disposition_Batch }}@else Not Applicable @endif</td>
                        
                    </table>
                </div>
                <div class="border-table">
                    <div class="block-head">
                        Closure Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                            @if($data->closure_attachment)
                            @foreach(json_decode($data->closure_attachment) as $key => $file)
                                <tr>
                                    <td class="w-20">{{ $key + 1 }}</td>
                                    <td class="w-20"><a href="{{ asset('upload/' . $file) }}" target="_blank"><b>{{ $file }}</b></a> </td>
                                </tr>
                            @endforeach
                            @else
                        <tr>
                            <td class="w-20">1</td>
                            <td class="w-20">Not Applicable</td>
                        </tr>
                        @endif

                    </table>
                </div>
            </div>  
        </div>          
                

            <div class="block">
                <div class="block-head">
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submit By</th>
                        <td class="w-30">{{ $data->submit_by }}</td>
                        <th class="w-20">Submit On</th>
                        <td class="w-30">{{ $data->submit_on }}</td>
                        <th class="w-20">Submit Comments</th>
                        <td class="w-30">{{ $data->submit_comment }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">HOD Review Complete By</th>
                        <td class="w-30">{{ $data->HOD_Review_Complete_By}}</td>
                        <th class="w-20">HOD Review Complete On</th>
                        <td class="w-30">{{ $data->HOD_Review_Complete_On }}</td>
                        <th class="w-20">HOD Review Comments</th>
                        <td class="w-30">{{ $data->HOD_Review_Comments }}</td> 
                    </tr>
                    <tr>
                        <th class="w-20">QA Initial Review Complete by</th>
                        <td class="w-30">{{ $data->QA_Initial_Review_Complete_By }}</td>
                        <th class="w-20">QA Initial Review Complete On</th>
                        <td class="w-30">{{ Helpers::getdateFormat($data->QA_Initial_Review_Complete_On) }}</td>
                        <th class="w-20">QA Initial Review Comments</th>
                        <td class="w-30">{{ $data->QA_Initial_Review_Comments }}</td> 
                    </tr>
                    <tr>
                        <th class="w-20">CFT Review Complete By</th>
                        <td class="w-30">{{ $data->CFT_Review_Complete_By }}</td>
                        <th class="w-20">CFT Review Complete On</th>
                        <td class="w-30">{{ $data->CFT_Review_Complete_On }}</td>
                        <th class="w-20">CFT Review Comments</th>
                        <td class="w-30">{{ $data->CFT_Review_Comments }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">QA Final Review Complete By</th>
                        <td class="w-30">{{ $data->QA_Final_Review_Complete_By }}</td>
                        <th class="w-20">QA Final Review Complete On</th>
                        <td class="w-30">{{ $data->QA_Final_Review_Complete_On }}</td>
                        <th class="w-20">QA Final Review Comments</th>
                        <td class="w-30">{{ $data->QA_Final_Review_Comments }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Approved By</th>
                        <td class="w-30">{{ $data->Approved_By }}</td>
                        <th class="w-20">Approved ON</th>
                        <td class="w-30">{{ $data->Approved_On }}</td>
                        <th class="w-20">Approved Comments</th>
                        <td class="w-30">{{ $data->Approved_Comments }}</td>
                   


                </table>
            </div>
        </div>
    
    </div>

    <footer>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Printed On :</strong> {{ date('d-M-Y') }}
                </td>
                <td class="w-40">
                    <strong>Printed By :</strong> {{ Auth::user()->name }}
                </td>
                {{-- <td class="w-30">
                    <strong>Page :</strong> 1 of 1
                </td> --}}
            </tr>
        </table>
    </footer>

</body>

</html>
