@extends('frontend.layout.main')
@section('container')
    @php
        $users = DB::table('users')
            ->select('id', 'name')
            ->get();

    @endphp
    <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script>
        $(function() {
            $("#datepicker").datepicker();
        });
    </script>

    <script>
        function otherController(value, checkValue, blockID) {
            let block = document.getElementById(blockID)
            let blockTextarea = block.getElementsByTagName('textarea')[0];
            let blockLabel = block.querySelector('label span.text-danger');
            if (value === checkValue) {
                blockLabel.classList.remove('d-none');
                blockTextarea.setAttribute('required', 'required');
            } else {
                blockLabel.classList.add('d-none');
                blockTextarea.removeAttribute('required');
            }
        }
    </script>
    <script>
        function addAuditAgenda(tableId) {
            var table = document.getElementById(tableId);
            var currentRowCount = table.rows.length;
            var newRow = table.insertRow(currentRowCount);
            newRow.setAttribute("id", "row" + currentRowCount);
            var cell1 = newRow.insertCell(0);
            cell1.innerHTML = currentRowCount;

            var cell2 = newRow.insertCell(1);
            cell2.innerHTML = "<input type='text'>";

            var cell3 = newRow.insertCell(2);
            cell3.innerHTML = "<input type='date'>";

            var cell4 = newRow.insertCell(3);
            cell4.innerHTML = "<input type='time'>";

            var cell5 = newRow.insertCell(4);
            cell5.innerHTML = "<input type='date'>";

            var cell6 = newRow.insertCell(5);
            cell6.innerHTML = "<input type='time'>";

            var cell7 = newRow.insertCell(6);
            cell7.innerHTML =
                // '<select name="auditor"><option value="">-- Select --</option><option value="1">Amit Guru</option></select>'

            var cell8 = newRow.insertCell(7);
            cell8.innerHTML =
                // '<select name="auditee"><option value="">-- Select --</option><option value="1">Amit Guru</option></select>'

            var cell9 = newRow.insertCell(8);
            cell9.innerHTML = "<input type='text'>";
            for (var i = 1; i < currentRowCount; i++) {
                var row = table.rows[i];
                row.cells[0].innerHTML = i;
            }
        }
    </script>
  
    <script>
        $(document).ready(function() {
            $('#List_Attachments_details').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);

                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                        '<td><input type="text" name="Title_Document[]"></td>'+
                        '<td><input type="text" name="Supporting_Documents[]"></td>'+

                        '<td><input type="text" name="Remarks[]"></td>'+

                    // for (var i = 0; i < users.length; i++) {
                    //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    // }

                        '</tr>';

                    return html;
                }

                var tableBody = $('#List_Attachments_details_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>

<script>
    $(document).ready(function() {
        $('#Agenda_details').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                    '<td><input type="text" name="date[]"></td>'+
                    '<td><input type="text" name="start_time[]"></td>'+
                    '<td><input type="text" name="end_time[]"></td>'+
                    '<td><input type="text" name="topic[]"></td>'+
                    '<td><input type="text" name="responsible_person[]"></td>'+
                   '<td><input type="text" name="Supporting_Documents[]"></td>'+
                    '<td><input type="text" name="status[]"></td>'+
                    '<td><input type="text" name="Remarks[]"></td>'+

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                    '</tr>';

                return html;
            }

            var tableBody = $('#Agenda_details_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#Attendees_Information').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                    '<td><input type="text" name="TrainingTopic[]"></td>'+
                    '<td><input type="text" name="TrainersMultipersonField[]"></td>'+
                    '<td><input type="text" name="AttendeeName[]"></td>'+
                    '<td><input type="text" name="Department[]"></td>'+
                    '<td><input type="text" name="TrainingAttended[]"></td>'+
                    '<td><input type="text" name="Training_ModeOnline_Classroom[]"></td>'+
                    '<td><input type="text" name="Training_Completion_Date[]"></td>'+
                    '<td><input type="text" name="pass_fail[]"></td>'+
                    '<td><input type="text" name="No_Attempts[]"></td>'+
                    '<td><input type="text" name="Rating[]"></td>'+
                    '<td><input type="text" name="Supporting Document[]"></td>'+
                    '<td><input type="text" name="remarks[]"></td>'+

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                    '</tr>';

                return html;
            }

            var tableBody = $('#Attendees_Information_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('#surveys_Information').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                    '<td><input type="text" name="Title_Document[]"></td>'+
                    '<td><input type="text" name="Supporting_Document[]"></td>'+
                    '<td><input type="text" name="Remarks[]"></td>'+

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }

                    '</tr>';

                return html;
            }

            var tableBody = $('#surveys_Information_details tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>

    <style>
        .calenderauditee {
            position: relative;
        }

        .new-date-data-field input.hide-input {
            position: absolute;
            top: 0;
            left: 0;
            opacity: 0;
        }

        .new-date-data-field input {
            border: 1px solid grey;
            border-radius: 5px;
            padding: 5px 15px;
            display: block;
            width: 100%;
            background: white;
        }

        .calenderauditee input::-webkit-calendar-picker-indicator {
            width: 100%;
        }
    </style>
    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }} / ClassRoom Qualification
        </div>
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}




    <div id="change-control-fields">
        <div class="container-fluid">


            <!-- Tab links -->
            <div class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">ClassRoom Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
            </div>

            <form id="auditform" action="{{ route('createInternalAudit') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div id="step-form">

                    <!-- General information content -->
                    <div id="CCForm1" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                               <div class="sub-head">Basic Details</div>
                                @if (!empty($parent_id))
                                    <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                                    <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                                @endif
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                            value="">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code </b></label>
                                        <input readonly type="text" name="division_code"
                                            value="{{ Helpers::getDivisionName(session()->get('division')) }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        <input disabled type="text" value="{{ Auth::user()->name }}">

                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input disabled type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="intiation_date">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="search">
                                            Assigned To <span class="text-danger"></span>
                                        </label>
                                        <select id="select-state" placeholder="Select..." name="assign_to">
                                            <option value="">Select a value</option>
                                            @foreach ($users as $data)
                                                <option value="{{ $data->id }}">{{ $data->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('assign_to')
                                            <p class="text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                              
                                
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due">Due Date</label>
                                        {{-- <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small>
                                        </div> --}}
                                        <div class="calenderauditee">
                                            <input type="text" id="due_date" readonly
                                                placeholder="DD-MMM-YYYY" />
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input"
                                                oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>
                                
                                
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                                class="text-danger">*</span></label><span id="rchars">255</span>
                                        characters remaining
                                        <input id="docname" type="text" name="short_description" maxlength="255" required>
                                    </div>
                                </div>  
                                
                                
                                <div class="col-lg-12">
                                    <div class="group-input" id="initiated_through_req">
                                        <label for="If Other">Class/Session  Information
                                            <span class="text-danger d-none">*</span></label>
                                        <textarea name="Class_Session_information"></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit_type">Trainer Name</label>
                                        <select name="Trainer_Name">
                                            <option value="">Enter Your Selection Here</option>
                                            <option value="R&D">Nilesh</option>
                                           
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit_type">Registration Start Date
                                            </label>
                                      <input type="date" name="registrationend_date" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit_type">Registration End Date
                                            </label>
                                      <input type="date" name="registrationend_date" type="text">
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit_type">Training Topic
                                            </label>
                                      <input type="text" name="Training_Topic" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit_type">Scheduled Start Date

                                            </label>
                                      <input type="date" name="Scheduled_Start_date" type="text">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit_type">Scheduled End Date

                                            </label>
                                      <input type="date" name="Scheduled_End_date" type="text">
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Initial Comments">Description</label>
                                        <textarea name="initial_comments"></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                           List Of Attachments
                                            <button type="button" name="audit-agenda-grid"
                                                id="List_Attachments_details">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="List_Attachments_details_details"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width:7%;">Row#</th>
                                                        <th>Title Of Document</th>
                                                      
                                                        <th>Supporting Documents</th>
                                                      
                                                        <th>Remarks</th>
                                                       
                                                      
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    <td><input disabled type="text" name="serial_number[]" value="1">
                                                    </td>
                                                <td><input type="text" name="Title_Document[]"></td>
                                                <td><input type="text" name="Supporting_Documents[]"></td>

                                                <td><input type="text" name="Remarks[]"></td>


                                                  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> 
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                         Agenda
                                            <button type="button" name="audit-agenda-grid"
                                                id="Agenda_details">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="Agenda_details_details"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width:7%;">Row#</th>
                                                        <th>Date</th>
                                                      
                                                        <th>Start Time </th>
                                                      
                                                        <th>End Time</th>
                                                        <th>Topic</th>
                                                      
                                                        <th>Responsible Person</th>
                                                        <th>Supporting Documents</th>

                                                        <th>status</th>
                                                      
                                                        <th>Remarks</th>
                                                       
                                                      
                                                        
                                                    </tr>
                                                </thead>
                                                <tbody >
                                                    <td><input disabled type="text" name="serial_number[]" value="1">
                                                    </td>
                                                <td><input type="text" name="date[]"></td>
                                                <td><input type="text" name="start_time[]"></td>
                                                <td><input type="text" name="end_time[]"></td>
                                                <td><input type="text" name="topic[]"></td>
                                                <td><input type="text" name="responsible_person[]"></td>
                                                <td><input type="text" name="Supporting_Documents[]"></td>
                                                <td><input type="text" name="status[]"></td>
                                                <td><input type="text" name="Remarks[]"></td>


                                                  
                                                </tbody>
                                            </table>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Inv Attachments">Training Material</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        {{-- <input type="file" id="myfile" name="inv_attachment[]" multiple> --}}
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="audit_file_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="training_material[]"
                                                    oninput="addMultipleFiles(this, 'audit_file_attachment')" multiple>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" id="ChangesaveButton" class="saveButton">Save</button>
                                <button type="button" id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- classroom information -->
                    <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                 
                                <div class="col-12">

                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                          Attendees Information
                                            <button type="button" name="audit-agenda-grid"
                                                id="Attendees_Information">+</button>
                                        </label>
                                        <div class="table-responsive">
                                        <table class="table table-bordered" id="Attendees_Information_details">
                                            <thead>
                                                <tr>
                                                    <th>Row#</th>
                                                    <th>Training Topic</th>
                                                    <th>Trainers Multiperson Field</th>
                                                    <th>Attendee Name</th>
                                                    <th>Department</th>
                                                    <th>Training Attended?</th>
                                                    <th>Training Mode(Online/Classroom)</th>
                                                    <th>Training Completion Date</th>
                                                    <th>Pass Fail?</th>
                                                    <th>No Of Attempts Taken</th>
                                                    <th>Rating</th>
                                                    <th>Supporting Document</th>

                                                    <th>Remarks</th>

                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="serial_number[]" value="1">
                                                </td>
                                                <td><input type="text" name="TrainingTopic[]"></td>
                                                <td><input type="text" name="TrainersMultipersonField[]"></td>
                                                <td><input type="text" name="AttendeeName[]"></td>
                                                <td><input type="text" name="Department[]"></td>
                                                <td><input type="text" name="TrainingAttended[]"></td>
                                                <td><input type="text" name="Training_ModeOnline_Classroom[]"></td>
                                                <td><input type="text" name="Training_Completion_Date[]"></td>
                                                <td><input type="text" name="pass_fail[]"></td>
                                                <td><input type="text" name="No_Attempts[]"></td>
                                                <td><input type="text" name="Rating[]"></td>
                                                <td><input type="text" name="Supporting Document[]"></td>
                                                <td><input type="text" name="remarks[]"></td>


                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                                
                                <div class="col-12">

                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                         surveys
                                            <button type="button" name="audit-agenda-grid"
                                                id="surveys_Information">+</button>
                                        </label>
                                        <div class="table-responsive">
                                        <table class="table table-bordered" id="surveys_Information_details">
                                            <thead>
                                                <tr>
                                                    <th style="width:7%;">Row#</th>
                                                    <th>Title Of Document</th>
                                                    <th>Supporting Document</th>
                                                    <th>Remarks</th>
                                                   
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <td><input disabled type="text" name="serial_number[]" value="1">
                                                </td>
                                                <td><input type="text" name="Title_Document[]"></td>
                                                <td><input type="text" name="Supporting_Document[]"></td>
                                                <td><input type="text" name="Remarks[]"></td>
                                                


                                            </tbody>
                                        </table>
                                    </div>
                                    </div>
                                </div>
                                
                              
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Product/Material Name">Feedback</label>
                                        <textarea name="Feedback" id="" cols="30" ></textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Comments(If Any)">Comments</label>
                                        <textarea name="if_comments"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                              <a href="/rcms/qms-dashboard">
                                        <button type="button" class="backButton">Back</button>
                                    </a>
                                <button type="button" class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>

                   
                    <!-- Activity Log content -->
                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Schedule On">Audit Schedule By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Schedule On">Audit Schedule On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Cancelled By">Cancelled By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Cancelled On">Cancelled On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Preparation Completed On">Audit Preparation Completed By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Preparation Completed On">Audit Preparation Completed On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Mgr.more Info Reqd By">Audit Mgr.more Info Reqd By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Mgr.more Info Reqd On">Audit Mgr.more Info Reqd On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Observation Submitted By">Audit Observation Submitted By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Observation Submitted On">Audit Observation Submitted On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Lead More Info Reqd By">Audit Lead More Info Reqd By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Lead More Info Reqd On">Audit Lead More Info Reqd On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Response Completed By">Audit Response Completed By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Audit Response Completed On">Audit Response Completed On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Response Feedback Verified By">Response Feedback Verified By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Response Feedback Verified On">Response Feedback Verified On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for=" Rejected By">Rejected By</label>
                                        <div class="static"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Rejected On">Rejected On</label>
                                        <div class="static"></div>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit" class="saveButton">Save</button>
                                    <a href="/rcms/qms-dashboard">
                                        <button type="button" class="backButton">Back</button>
                                    </a>
                                <button type="submit">Submit</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>


    <style>
        #step-form>div {
            display: none
        }

        #step-form>div:nth-child(1) {
            display: block;
        }
    </style>
    <script>
        document.getElementById('myfile').addEventListener('change', function() {
            var fileListDiv = document.querySelector('.file-list');
            fileListDiv.innerHTML = ''; // Clear previous entries

            for (var i = 0; i < this.files.length; i++) {
                var file = this.files[i];
                var listItem = document.createElement('div');
                listItem.textContent = file.name;
                fileListDiv.appendChild(listItem);
            }
        });
    </script>


    <script>
        VirtualSelect.init({
             ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record'
        });

        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";
        }



        function openCity(evt, cityName) {
            var i, cctabcontent, cctablinks;
            cctabcontent = document.getElementsByClassName("cctabcontent");
            for (i = 0; i < cctabcontent.length; i++) {
                cctabcontent[i].style.display = "none";
            }
            cctablinks = document.getElementsByClassName("cctablinks");
            for (i = 0; i < cctablinks.length; i++) {
                cctablinks[i].className = cctablinks[i].className.replace(" active", "");
            }
            document.getElementById(cityName).style.display = "block";
            evt.currentTarget.className += " active";

            // Find the index of the clicked tab button
            const index = Array.from(cctablinks).findIndex(button => button === evt.currentTarget);

            // Update the currentStep to the index of the clicked tab
            currentStep = index;
        }

        const saveButtons = document.querySelectorAll(".saveButton");
        const nextButtons = document.querySelectorAll(".nextButton");
        const form = document.getElementById("step-form");
        const stepButtons = document.querySelectorAll(".cctablinks");
        const steps = document.querySelectorAll(".cctabcontent");
        let currentStep = 0;

        function nextStep() {
            // Check if there is a next step
            if (currentStep < steps.length - 1) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show next step
                steps[currentStep + 1].style.display = "block";

                // Add active class to next button
                stepButtons[currentStep + 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep++;
            }
        }

        function previousStep() {
            // Check if there is a previous step
            if (currentStep > 0) {
                // Hide current step
                steps[currentStep].style.display = "none";

                // Show previous step
                steps[currentStep - 1].style.display = "block";

                // Add active class to previous button
                stepButtons[currentStep - 1].classList.add("active");

                // Remove active class from current button
                stepButtons[currentStep].classList.remove("active");

                // Update current step
                currentStep--;
            }
        }
    </script>

    <script>
        document.getElementById('initiator_group').addEventListener('change', function() {
            var selectedValue = this.value;
            document.getElementById('initiator_group_code').value = selectedValue;
        });
    </script>
      <script>
        var maxLength = 255;
        $('#docname').keyup(function() {
            var textlen = maxLength - $(this).val().length;
            $('#rchars').text(textlen);});
    </script>

@endsection
