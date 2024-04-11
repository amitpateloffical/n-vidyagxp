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
                    Change Control Single Report
                </td>
                <td class="w-30">
                    <div class="logo">
                        <img src="https://development.vidyagxp.com/public/user/images/logo.png" alt="" class="w-100">
                    </div>
                </td>
            </tr>
        </table>
        <table>
            <tr>
                <td class="w-30">
                    <strong>Change Control No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::getDivisionName($data->division_id) }}/CC/{{ date('Y') }}/{{ str_pad($data->record, 4, '0', STR_PAD_LEFT) }}
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
                    <tr>  On {{ Helpers:: getDateFormat($data->created_at) }} added by {{ $data->originator }}
                        <th class="w-20">Initiator</th>
                        <td class="w-30">{{ $data->originator }}</td>
                        <th class="w-20">Date Initiation</th>
                        <td class="w-30">23-12-2302</td>
                    </tr>
                    <tr>
                        <th class="w-20">Initiator Group</th>
                        <td class="w-30">@if($data->Inititator_Group){{ $data->Inititator_Group }} @else Not Applicable @endif</td>
                        <th class="w-20">Due Date</th>
                        <td class="w-30" colspan="3"> @if($data->due_date){{ $data->due_date }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Assigned To</th>
                        <td class="w-30">@if($data->assign_to) {{ Helpers::getInitiatorName($data->assign_to) }} @else Not Applicable @endif</td>
                        <th class="w-20">Initiator Group Code</th>
                        <td class="w-30" colspan="3"> @if($data->initiator_group_code){{ $data-> initiator_group_code}} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">CFT</th>
                        <td class="w-30">{{ $info->Microbiology }}</td>
                        <th class="w-20">CFT Person</th>
                        <td class="w-30">{{ $info->Microbiology_Person }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Severity Level</th>
                        <td class="w-30">@if($data->severity_level1){{ $data-> severity_level1}} @else Not Applicable @endif</td>
                        <th class="w-20">Initiated Through</th>
                        <td class="w-30" colspan="3"> @if($data->initiated_through){{ $data->initiated_through }} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Others</th>
                        <td class="w-30">@if($data->initiated_through_req){{ $data->initiated_through_req }} @else Not Applicable @endif</td>
                        <th class="w-20">Repeat</th>
                        <td class="w-30" colspan="3"> @if($data->repeat){{ $data-> repeat}} @else Not Applicable @endif</td>
                    </tr>
                    <tr>
                        <th class="w-20">Repeat Nature</th>
                        <td class="w-30">@if($data->repeat_nature){{ $data-> repeat_nature}} @else Not Applicable @endif</td>
                        <th class="w-20">Division Code</th>
                        <td class="w-30" colspan="3"> @if($data->div_code){{ $data->div_code }} @else Not Applicable @endif</td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Short Description</th>
                        <td class="w-80" colspan="3">
                            @if($data->short_description){{ $data->short_description }}@else Not Applicable @endif
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Nature of Change</th>
                        <td class="w-30">@if($data->doc_change){{ $data->doc_change }}@else Not Applicable @endif</td>
                        <th class="w-20">If Others</th>
                        <td class="w-30">@if($data->If_Others){{ $data->If_Others }}@else Not Applicable @endif</td>
                    </tr>
                </table>
                <div class="border-table">
                    <div class="block-head">
                        Initial Attachment
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if($data->in_attachment)
                            @foreach(json_decode($data->in_attachment) as $key => $file)
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
                    Change Details
                </div>
                <div class="border-table">
                    <table>
                        <tr class="table_bg">
                            <th class="w-25">Current Document No.</th>
                            <th class="w-25">Current Version No.</th>
                            <th class="w-25">New Document No.</th>
                            <th class="w-25">New Version No.</th>
                        </tr>
                        @foreach(unserialize($docdetail->current_doc_no) as $key => $docdetails)
                        <tr>
                            <td class="w-25">@if($docdetails){{ $docdetails }}@else Not Applicable @endif</td>
                            <td class="w-25">{{unserialize($docdetail->current_version_no)[$key] }}</td>
                            <td class="w-25">{{ unserialize($docdetail->new_doc_no)[$key] }}</td>
                            <td class="w-25">{{ unserialize($docdetail->new_version_no)[$key] }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <table>
                    <tr>
                        <th class="w-20">Current Practice</th>
                        <td>
                            <div><strong>On {{ Helpers:: getDateFormat($docdetail->created_at) }} added by {{ $data->originator }}</strong></div>
                            <div>
                                @if($docdetail->current_practice){{ $docdetail->current_practice }}@else Not Applicable @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Proposed Change</th>
                        <td>
                            <div><strong>On {{ Helpers:: getDateFormat($docdetail->created_at) }} added by {{ $data->originator }}</strong></div>
                            <div>
                                @if($docdetail->proposed_change){{ $docdetail->proposed_change }}@else Not Applicable @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Reason For Change</th>
                        <td>
                            <div><strong>On {{ Helpers:: getDateFormat($docdetail->created_at) }} added by {{ $data->originator }}</strong></div>
                            <div>
                                @if($docdetail->reason_change){{ $docdetail->reason_change }}@else Not Applicable @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Supervisor Comments</th>
                        <td>
                            <div><strong>On {{ Helpers:: getDateFormat($docdetail->created_at) }} added by {{ $data->originator }}</strong></div>
                            <div>
                                @if($docdetail->supervisor_comment){{ $docdetail->supervisor_comment }}@else Not Applicable @endif
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Any Other Comments</th>
                        <td>
                            <div><strong>On {{ Helpers:: getDateFormat($docdetail->created_at) }} added by {{ $data->originator }}</strong></div>
                            <div>
                                @if($docdetail->other_comment){{ $docdetail->other_comment }}@else Not Applicable @endif
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="block">
                <div class="head">
                    <div class="block-head">
                        QA Review
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">Type of Change</th>
                            <td class="w-80">{{ $review->type_chnage }}</td>
                        </tr>
                        <tr>
                            <th class="w-20">QA Review Comments</th>
                            <td>
                                <div><strong>On {{ Helpers:: getDateFormat($review->created_at) }} added by {{ $data->originator }}</strong></div>
                                <div>
                                    {{ $review->qa_comments }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Related Records</th>
                            <td class="w-80">{{ $review->related_records }}</td>
                        </tr>
                        <tr>
                            <th class="w-20">QA Attachments</th>
                            <td class="w-80">{{ $review->qa_attachments}}</td>
                        </tr>


                    </table>
                    <div class="border-table">
                        <div class="block-head">
                            QA Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
                            </tr>
                            @if($review->qa_head)
                                @foreach(json_decode($review->qa_head) as $key => $file)
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
                <div class="head">
                    <div class="block-head">
                        Evaluation Details
                    </div>
                    <table>
                        <tr>
                            <th class="w-20">QA Evaluation Comments</th>
                            <td>
                                <div><strong>On {{ Helpers:: getDateFormat($evaluation->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $evaluation->qa_eval_comments }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">QA Evaluation Attachments </th>
                            <td>
                                <div><strong>On {{ Helpers:: getDateFormat($evaluation->qa_evaluation_attachments) }} added by {{ $data->qa_evaluation_attachments}}</strong>
                                </div>
                                <div>
                                    {{ $evaluation->qa_evaluation_attachments }}
                                </div>
                            </td>
                        </tr>


                        <tr>
                            <th class="w-20">Training Required</th>
                            <td class="w-80"> {{ $evaluation->training_required }}</td>
                        </tr>
                        <tr>
                            <th class="w-20">Training Comments</th>
                            <td>
                                <div><strong>On {{ Helpers:: getDateFormat($evaluation->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $evaluation->train_comments }}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            {{-- <div class="block">
                 <div class="block-head">
                    Additional Information
                </div>
                <table>
                    <tr>
                        <th class="w-50" colspan="2">Is Group Review Required</th>
                        <td class="w-50" colspan="2">{{ $info->goup_review }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Production</th>
                        <td class="w-30">{{ $info->Production }}</td>
                        <th class="w-20">Production Person</th>
                        <td class="w-30">{{ $info->Production_Person }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Quality Approver</th>
                        <td class="w-30">{{ $info->Quality_Approver }}</td>
                        <th class="w-20">Quality Approver Person</th>
                        <td class="w-30">{{ $info->Quality_Approver_Person }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">CFT</th>
                        <td class="w-30">{{ $info->Microbiology }}</td>
                        <th class="w-20">CFT Person</th>
                        <td class="w-30">{{ $info->Microbiology_Person }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Others</th>
                        <td class="w-30">{{ $info->bd_domestic }}</td>
                        <th class="w-20">Others Person</th>
                        <td class="w-30">{{ $info->Bd_Person }}</td>
                    </tr>

                </table> 
                <div class="border-table">
                    <div class="block-head">
                        Addition Attachments
                    </div>
                    <table>
                    <tr>
                        <th class="w-20">CFT Reviewer</th>
                        <td class="w-30">{{ $info->Microbiology }}</td>
                        <th class="w-20">CFT Reviewer Person </th>
                        <td class="w-30">{{ $info->Microbiology_Person }}</td>
                    </tr>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if($info->additional_attachments)
                            @foreach(json_decode($info->additional_attachments) as $key => $file)
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
            </div> --}}
            <div class="block">
                <div class="head">
                    <div class="block-head">
                      Comments
                    </div>
                    <table>
                    <tr>
                        <th class="w-20">Comments</th>
                        <td class="w-30">{{ $info->cft_comments }}</td>
                        <th class="w-20">Attachment </th>
                        <td class="w-30">{{ $info->cft_attachment }}</td>
                    </tr>
                        <tr>
                            <th class="w-20">QA Comments</th>
                            <td class="w-80">
                                <div><strong>On {{ Helpers:: getDateFormat($comments->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $comments->qa_comments }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">QA Head Designee Comments</th>
                            <td class="w-80">
                                <div><strong>On {{ Helpers:: getDateFormat($comments->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $comments->designee_comments }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Warehouse Comments</th>
                            <td class="w-80">
                                <div><strong>On {{ Helpers:: getDateFormat($comments->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $comments->Warehouse_comments }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Engineering Comments</th>
                            <td class="w-80">
                                <div><strong>On {{ Helpers:: getDateFormat($comments->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $comments->Engineering_comments }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Instrumentation Comments</th>
                            <td class="w-80">
                                <div><strong>On {{ Helpers:: getDateFormat($comments->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $comments->Instrumentation_comments }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Validation Comments</th>
                            <td class="w-80">
                                <div><strong>On {{ Helpers:: getDateFormat($comments->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $comments->Validation_comments }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Others Comments</th>
                            <td class="w-80">
                                <div><strong>On {{ Helpers:: getDateFormat($comments->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $comments->Others_comments }}
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th class="w-20">Comments</th>
                            <td class="w-80">
                                <div><strong>On {{ Helpers:: getDateFormat($comments->created_at) }} added by {{ $data->originator }}</strong>
                                </div>
                                <div>
                                    {{ $comments->Group_comments }}
                                </div>
                            </td>
                        </tr>


                    </table>
                    <div class="border-table">
                        <div class="block-head">
                           Attachments
                        </div>
                        <table>

                            <tr class="table_bg">
                                <th class="w-20">S.N.</th>
                                <th class="w-60">Attachment</th>
                            </tr>
                            @if($comments->group_attachments)
                                @foreach(json_decode($comments->group_attachments) as $key => $file)
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
                    Risk Assessment
                </div>
                <table>
                    <tr>
                        <th class="w-20">Risk Identification</th>
                        <td class="w-80" colspan="3">
                            <div><strong>On {{ Helpers:: getDateFormat($assessment->created_at) }} added by {{ $data->originator }}</strong></div>
                            <div>
                                {{ $assessment->risk_identification }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Severity</th>
                        <td class="w-30"> {{ $assessment->severity }}</td>
                        <th class="w-20">Occurance</th>
                        <td class="w-30"> {{ $assessment->Occurance }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Detection</th>
                        <td class="w-30"> {{ $assessment->Detection }}</td>
                        <th class="w-20">RPN</th>
                        <td class="w-30"> {{ $assessment->RPN }}</td>
                    </tr>
                    <tr>
                        <th class="w-20">Risk Evaluation</th>
                        <td class="w-80" colspan="3">
                            <div><strong>On {{ Helpers:: getDateFormat($assessment->created_at) }} added by {{ $data->originator }}</strong></div>
                            <div>
                                {{ $assessment->risk_evaluation }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Mitigation Action</th>
                        <td class="w-80" colspan="3">
                            <div><strong>On {{ Helpers:: getDateFormat($assessment->created_at) }} added by {{ $data->originator }}</strong></div>
                            <div>
                                {{ $assessment->migration_action }}
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="block">
                <div class="block-head">
                    QA Approval Comments
                </div>
                <table>
                    <tr>
                        <th class="w-20">QA Approval Comments</th>
                        <td class="w-80">
                            <div><strong>On {{ Helpers:: getDateFormat($approcomments->created_at) }} added by {{ $data->originator }}</strong>
                            </div>
                            <div>
                                {{ $approcomments->risk_identification }}
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Training Feedback</th>
                        <td class="w-80">
                            <div><strong>On {{ Helpers:: getDateFormat($approcomments->created_at) }} added by {{ $data->originator }}</strong>
                            </div>
                            <div>
                                {{ $approcomments->feedback }}
                            </div>
                        </td>
                    </tr>

                </table>
                <div class="border-table">
                    <div class="block-head">
                        Training Attachments
                    </div>
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if($approcomments->tran_attach)
                            @foreach(json_decode($approcomments->tran_attach) as $key => $file)
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
                Change Closure
                </div>
                <table>
                    <!-- <tr>
                        <th class="w-20">Affected Documents+</th>
                        <td class="w-80">
                            <div><strong>On {{ Helpers:: getDateFormat($approcomments->created_at) }} added by {{ $data->originator }}</strong>
                            </div>
                            <div>
                                {{ $approcomments->risk_identification }}
                            </div>
                        </td>
                    </tr> -->
                    <tr>
                        <th class="w-20">QA Closure Comments</th>
                        <td class="w-30"> {{ $assessment->qa_closure_comments }}</td>
                        <th class="w-20">List Of Attachments</th>
                        <td class="w-30"> {{ $assessment->list_of_attachment }}</td>
                    </tr>
                    

                </table>
                <!-- <div class="border-table">
                    <div class="block-head">
                        Training Attachments
                    </div> -->
                    <table>

                        <tr class="table_bg">
                            <th class="w-20">S.N.</th>
                            <th class="w-60">Attachment</th>
                        </tr>
                        @if($approcomments->tran_attach)
                            @foreach(json_decode($approcomments->tran_attach) as $key => $file)
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
                    Activity Log
                </div>
                <table>
                    <tr>
                        <th class="w-20">Submitted By</th>
                        <td class="w-30">
                        @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 2)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->user_name }}</div>
                        @endforeach</td>

                        <th class="w-20">Submitted On</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 2)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->created_at }}</div>
                        @endforeach
                        </td>
                    </tr>
                    
                    <tr>
                        <th class="w-20">Cancelled By</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 0)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->user_name }}</div>
                        @endforeach
                        </td>
                        <th class="w-20">Cancelled On</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 0)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->created_at }}</div>
                        @endforeach
                        </td>
                    </tr>
                    {{-- <tr>
                        <th class="w-20">More Information Required By</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('status', 'More-info Required')
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->user_name }}</div>
                        @endforeach
                        </td>
                        <th class="w-20">More Information Required On</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('status', 'More-info Required')
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->created_at }}</div>
                        @endforeach
                        </td>
                    </tr> --}}
                    <tr>
                        <th class="w-20">HOD Review Complete By</th>
                        <td class="w-30"> @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 3)
                                ->get();
                            @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->user_name }}</div>
                        @endforeach </td>
                        <th class="w-20">HOD Review Complete On</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 3)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->created_at }}</div>
                        @endforeach
                        </td>
                    </tr>
                    {{-- <tr>
                        <th class="w-20">More Information Req. By</th>
                        <td class="w-30">Piyush Sahu</td>
                        <th class="w-20">More Information Req. On</th>
                        <td class="w-30">12-12-2203</td>
                    </tr> --}}
                    <tr>
                        <th class="w-20">Send to CFT/SME/QA Review By</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id',$data->id)
                                ->where('stage_id', 4)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->user_name }}</div>
                        @endforeach
                        </td>
                        <th class="w-20">Send to CFT/SME/QA Review On</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 4)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->created_at }}</div>
                        @endforeach
                        </td>
                    </tr>
                    <!-- <tr>
                        <th class="w-20">More Info Req. By</th>
                        <td class="w-30">Piyush Sahu</td>
                        <th class="w-20">More Info Req. On</th>
                        <td class="w-30">12-12-2203</td>
                    </tr> -->
                    <tr>
                        <th class="w-20">CFT/SME/QA Review Not required By</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 6)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->user_name }}</div>
                        @endforeach
                        </td>
                        <th class="w-20">CFT/SME/QA Review Not required On</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 6)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->created_at }}</div>
                        @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Review Completed By</th>
                        <td class="w-30">
                            @php
                                $submit = DB::table('c_c_stage_histories')
                                      ->where('type', 'Change-Control')
                                      ->where('doc_id', $data->id)
                                      ->where('stage_id', 7)
                                      ->get();
                            @endphp
                            @foreach ($submit as $temp)
                                <div class="static">{{ $temp->user_name }}</div>
                            @endforeach 
                        </td>
                        <th class="w-20">Review Completed On</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 7)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->created_at }}</div>
                        @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th class="w-20">Implemented By</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 9)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->user_name }}</div>
                        @endforeach
                        </td>
                        <th class="w-20">Implemented On</th>
                        <td class="w-30">
                            @php
                            $submit = DB::table('c_c_stage_histories')
                                ->where('type', 'Change-Control')
                                ->where('doc_id', $data->id)
                                ->where('stage_id', 9)
                                ->get();
                        @endphp
                        @foreach ($submit as $temp)
                            <div class="static">{{ $temp->created_at }}</div>
                        @endforeach
                        </td>
                    </tr>
                    {{-- <tr>
                        <th class="w-20">Change Implemented By</th>
                        <td class="w-30">Piyush Sahu</td>
                        <th class="w-20">Change Implemented On</th>
                        <td class="w-30">12-12-2203</td>
                    </tr> --}}
                    <!-- <tr>
                        <th class="w-20">QA More Information Required By</th>
                        <td class="w-30">Piyush Sahu</td>
                        <th class="w-20">QA More Information Required On</th>
                        <td class="w-30">12-12-2203</td>
                    </tr> -->
                    {{-- <tr>
                        <th class="w-20">QA Final Review Completed By</th>
                        <td class="w-30">Piyush Sahu</td>
                        <th class="w-20">QA Final Review Completed On</th>
                        <td class="w-30">12-12-2203</td>
                    </tr> --}}
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

            </tr>
        </table>
    </footer>

</body>

</html>
