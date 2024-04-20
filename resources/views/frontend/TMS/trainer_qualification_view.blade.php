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
        $('#internalaudit-table').click(function(e) {

            function generateTableRow(serialNumber) {
                var users = @json($users);

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="audit[]"></td>' +
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_start_date' + serialNumber + '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_start_date[]" id="scheduled_start_date' + serialNumber + '_checkdate" min="{{ \Carbon\Carbon::now()->format('
                Y - m - d ') }}"  class="hide-input" oninput="handleDateInput(this, `scheduled_start_date' + serialNumber + '`);checkDate(`scheduled_start_date' + serialNumber + '_checkdate`,`scheduled_end_date' + serialNumber + '_checkdate`)" /></div></div></div></td>' +
                    '<td><input type="time" name="scheduled_start_time[]"></td>' +
                    '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_end_date' + serialNumber + '" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_end_date[]" id="scheduled_end_date' + serialNumber + '_checkdate"  min="{{ \Carbon\Carbon::now()->format('
                Y - m - d ') }}"class="hide-input" oninput="handleDateInput(this, `scheduled_end_date' + serialNumber + '`);checkDate(`scheduled_start_date' + serialNumber + '_checkdate`,`scheduled_end_date' + serialNumber + '_checkdate`)" /></div></div></div></td>' +
                    '<td><input type="time" name="scheduled_end_time[]"></td>' +
                    '<td><select name="auditor[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +
                    '<td><select name="auditee[]">' +
                    '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }
                html += '</select></td>' +
                    '<td><input type="text" name="remarks[]"></td>' +
                    '</tr>';

                return html;
            }

            var tableBody = $('#internalaudit tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>


<script>
    $(document).ready(function() {
        $('#attachmentgrid-table').click(function(e) {

            function generateTableRow(serialNumber) {
                var users = @json($users);

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="title_of document[]"></td>' +
                    '<td><input type="text" name="supporting_document[]"></td>' +
                    '<td><input type="text" name="remarks[]"></td>' +
                    '</tr>';

                // for (var i = 0; i < users.length; i++) {
                //     html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                // }


                '</tr>';

                return html;
            }

            var tableBody = $('#attachmentgrid tbody');
            var rowCount = tableBody.children('tr').length;
            var newRow = generateTableRow(rowCount + 1);
            tableBody.append(newRow);
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('#ObservationAdd').click(function(e) {
            function generateTableRow(serialNumber) {
                var users = @json($users);

                var html =
                    '<tr>' +
                    '<td><input disabled type="text" name="serial[]" value="' + serialNumber +
                    '"></td>' +
                    '<td><input type="text" name="observation_id[]"></td>' +

                    +'<option value="">Select a value</option>';


                html += '</select></td>' +

                    '<td><input type="text" name="observation_description[]"></td>' +
                    '<td><input type="text" name="area[]"></td>' +
                    '<td><input type="text" name="auditee_response[]"></td>'

                '<option value="">Select a value</option>';

                for (var i = 0; i < users.length; i++) {
                    html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                }

                html += '</select></td>' +

                    '</tr>';

                return html;
            }

            var tableBody = $('#onservation-field-table tbody');
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

    .progress-bars {
        display: flex;
    }

    .progress-bars div.active {
        background: #1fa51f;
        font-weight: bold;
    }


    .progress-bars div {
        flex: 1 1 auto;
        border: 1px solid grey;
        padding: 5px;
        text-align: center;
        position: relative;
        border-right: none;
    }

    .progress-bars div:nth-child(1) {
        border-radius: 20px 0 0 20px;
    }

    .progress-bars div:nth-last-child(1) {
        border-radius: 0 20px 20px 0;
    }

    .main-head1 {
        font-size: 1.2rem;
        font-weight: bold;
        color: black;
        margin-bottom: 20px;
    }
</style>
<div class="form-field-head">

    <div class="division-bar">
        <strong>Site Division/Project</strong> :
        {{ Helpers::getDivisionName(session()->get('division')) }} Trainer Qualification
    </div>
</div>



{{-- ======================================
                    DATA FIELDS
    ======================================= --}}




<div id="change-control-fields">
    <div class="container-fluid">
        <div class="inner-block state-block">
            <div class="d-flex justify-content-between align-items-center">
                <div class="main-head1">Record Workflow </div>

                <div class="d-flex" style="gap:20px;">

                    {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                    <button class="button_theme1"> <a class="text-white" href=""> {{-- add here url for auditTrail i.e. href="{{ url('CapaAuditTrial', $data->id) }}" --}}
                            Audit Trail </a> </button>


                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Submit
                    </button>
                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                        Cancel
                    </button>
                    {{-- <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                            </button> --}}





                    <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                        Approved
                    </button>
                    <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                        </a> </button>


                </div>

            </div>
            <div class="status">
                <div class="head">Current Status</div>

                {{-- <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div> --}}

                <div class="progress-bars">

                    {{-- @if ($data->stage >= 1) --}}
                    <div class="active">Opened</div>
                    {{-- @else --}}
                    {{-- <div class="">Opened</div> --}}
                    {{-- @endif --}}

                    {{-- @if ($data->stage >= 2) --}}
                    {{-- <div class="active">Pending HOD Review </div> --}}
                    {{-- @else --}}
                    <div class="">Pending HOD Review</div>
                    {{-- @endif --}}


                    {{-- @if ($data->stage >= 3) --}}
                    {{-- <div class="active">Closed - Completed</div> --}}
                    {{-- @else --}}
                    <div class="">Closed - Completed</div>
                    {{-- @endif --}}


                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>

        <!-- Tab links -->
        <div class="cctab">
            <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>

            <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
        </div>

        <form id="auditform" action="{{ route('trainer_qualification_update',$trainerQualifications->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            <div id="step-form">

                <!-- General information content -->
                <div id="CCForm1" class="inner-block cctabcontent">
                    <div class="inner-block-content">
                        <div class="row">

                            @if (!empty($parent_id))
                            <input type="hidden" name="parent_id" value="{{ $parent_id }}">
                            <input type="hidden" name="parent_type" value="{{ $parent_type }}">
                            @endif
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="RLS Record Number"><b>Record Number</b></label>
                                    <input disabled type="text" name="record_number" value="">
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Division Code"><b>Site/Location Code </b></label>
                                    <input readonly type="text" name="division_code" value="{{ Helpers::getDivisionName(session()->get('division')) }}">
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
                            <div class="col-md-6">
                                <div class="group-input">
                                    <label for="search">
                                        Assigned To <span class="text-danger"></span>
                                    </label>
                                    <select id="select-state" placeholder="Select..." name="assign_to">
                                        <option value="">Select</option>
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
                                    <div class="calenderauditee">
                                        <input type="text" id="due_date" readonly placeholder="DD-MMM-YYYY" value="{{ Helpers::getdateFormat($trainerQualifications->due_date) }}" />
                                        <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                    </div>
                                </div>
                            </div>


                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Short Description">Short Description</label><span id="rchars">255</span>
                                    characters remaining
                                    <input id="short_description" type="text" value="{{$trainerQualifications->short_description}}" name="short_description" maxlength="255">
                                </div>
                            </div>

                            <div class="sub-head">
                                Trainer Information
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="trainer">Trainer Name</label>
                                    <select name="trainer_name" id="trainer_name">
                                        <option value="">Select</option>
                                        <option value="trainer1" @if ($trainerQualifications->trainer_name == 'trainer1') selected @endif>Trainer 1</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="qualification">Qualification</label>
                                    <input id="qualification" type="text" name="qualification" value="{{$trainerQualifications->qualification}}" maxlength="255">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Designation">Designation</label>
                                    <select name="designation" id="designation">
                                        <option value="">Select</option>
                                        <option value="Lead Trainer" @if ($trainerQualifications->designation == 'Lead Trainer') selected @endif>Lead Trainer</option>
                                        <option value="Senior Trainer" @if ($trainerQualifications->designation == 'Senior Trainer') selected @endif>Senior Trainer</option>
                                        <option value="Instructor" @if ($trainerQualifications->designation == 'Instructor') selected @endif>Instructor</option>
                                        <option value="Evaluator" @if ($trainerQualifications->designation == 'Evaluator') selected @endif>Evaluator</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Department">Department</label>
                                    <select name="department" id="department">
                                        <option value="">Select</option>
                                        <option value="quality_assurance" @if ($trainerQualifications->department == 'quality_assurance') selected @endif>Quality Assurance (QA)</option>
                                        <option value="operations" @if ($trainerQualifications->department == 'operations') selected @endif>Operations</option>
                                        <option value="learning_deve" @if ($trainerQualifications->department == 'learning_deve') selected @endif>Learning and Development (L&D)</option>
                                        <option value="Information Technology (IT)" @if ($trainerQualifications->department == 'Information Technology (IT)') selected @endif>Information Technology (IT)</option>
                                        <option value="Finance" @if ($trainerQualifications->department == 'Finance') selected @endif>Finance</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Experience">Experience (No. of Years)</label>
                                    <select name="Experience" id="Experience">
                                        <option value="">Select </option>
                                        @for ($i = 1; $i <= 70; $i++) <option value="{{ $i }}" @if($trainerQualifications->Experience == $i) selected @endif>{{ $i }}</option>
                                            @endfor
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="group-input">
                                    <label for="priority-level">Priority Level</label>
                                    <span class="text-primary">Priority levels in TMS can be tailored to suit the specific needs of the institution in managing the training program.</span>
                                    <select name="priority_level" id="priority_level">
                                        <option value="">-- Select --</option>
                                        <option value="low" @if ($trainerQualifications->priority_level == 'low') selected @endif>Low Priority</option>
                                        <option value="medium" @if ($trainerQualifications->priority_level == 'medium') selected @endif>Medium Priority</option>
                                        <option value="high" @if ($trainerQualifications->priority_level == 'high') selected @endif>High Priority</option>
                                    </select>
                                </div>
                            </div>





                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Initiator Group">Initiated Through</label>
                                    <div><small class="text-primary">Please select related information</small></div>
                                    <select name="initiated_through" onchange="otherController(this.value, 'others', 'initiated_through_req')">
                                        <option value="">-- select --</option>
                                        <option value="Recall" @if ($trainerQualifications->initiated_through == 'Recall') selected @endif>Recall</option>
                                        <option value="Return" @if ($trainerQualifications->initiated_through == 'Return') selected @endif>Return</option>
                                        <option value="Deviation" @if ($trainerQualifications->initiated_through == 'Deviation') selected @endif>Deviation</option>
                                        <option value="Complaint" @if ($trainerQualifications->initiated_through == 'Complaint') selected @endif>Complaint</option>
                                        <option value="Regulatory" @if ($trainerQualifications->initiated_through == 'Regulatory') selected @endif>Regulatory</option>
                                        <option value="Lab Incident" @if ($trainerQualifications->initiated_through == 'Lab Incident') selected @endif>Lab Incident</option>
                                        <option value="improvement" @if ($trainerQualifications->initiated_through == 'improvement') selected @endif>Improvement</option>
                                        <option value="Others" @if ($trainerQualifications->initiated_through == 'Others') selected @endif>Others</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input" id="initiated_through_req">
                                    <label for="If Other">Others<span class="text-danger d-none">*</span></label>
                                    <textarea name="initiated_if_other">{{$trainerQualifications->initiated_if_other}}</textarea>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="external_agencies">External Agencies</label>
                                    <select name="external_agencies" id="external_agencies" onchange="otherController(this.value, 'others', 'external_agencies_req')">
                                        <option value="">-- Select --</option>
                                        <option value="Jordan FDA" @if ($trainerQualifications->external_agencies == 'Jordan FDA')selected @endif>Jordan FDA</option>
                                        <option value="USFDA" @if ($trainerQualifications->external_agencies == 'USFDA')selected @endif>USFDA</option>
                                        <option value="MHRA" @if ($trainerQualifications->external_agencies == 'MHRA')selected @endif>MHRA</option>
                                        <option value="ANVISA" @if ($trainerQualifications->external_agencies == 'Others')selected @endif>ANVISA</option>
                                        <option value="ISO" @if ($trainerQualifications->external_agencies == 'ISO')selected @endif>ISO</option>
                                        <option value="WHO" @if ($trainerQualifications->external_agencies == 'WHO')selected @endif>WHO</option>
                                        <option value="Local FDA" @if ($trainerQualifications->external_agencies == 'Local FDA')selected @endif>Local FDA</option>
                                        <option value="TGA" @if ($trainerQualifications->external_agencies == 'TGA')selected @endif>TGA</option>
                                        <option value="others" @if ($trainerQualifications->external_agencies == 'Others')selected @endif>Others</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-6">
                                <div class="group-input">
                                    <label for="trainer_skill_set">Trainer Skill Set</label>
                                    <select multiple name="trainer_skill_set[]" id="trainerSkillSet">
                                        <option value="">-- Select --</option>
                                        <option value="Production" @if ($trainerQualifications->trainer_skill_set == 'Production')selected @endif>Production</option>
                                        <option value="QC" @if ($trainerQualifications->trainer_skill_set == 'QC')selected @endif>QC</option>
                                        <option value="QA" @if ($trainerQualifications->trainer_skill_set == 'QA')selected @endif>QA</option>
                                        <option value="RA" @if ($trainerQualifications->trainer_skill_set == 'RA')selected @endif>RA</option>
                                        <option value="Warehouse" @if ($trainerQualifications->trainer_skill_set == 'Warehouse')selected @endif>Warehouse</option>
                                        <option value="IT" @if ($trainerQualifications->trainer_skill_set == 'IT')selected @endif>IT</option>
                                    </select>
                                </div>
                            </div>

                            <div class="group-input">
                                <label for="audit-agenda-grid">
                                    List of Attachments<button type="button" name="audit-agenda-grid" id="attachmentgrid-table">+</button>
                                </label>
                                <table class="table table-bordered" id="attachmentgrid">
                                    <thead>
                                        <tr>
                                            <th>Row#</th>
                                            <th>Title of Document</th>
                                            <th>Supporting Document</th>
                                            <th>Remarks</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <td><input disabled type="text" name="serial_number[]" value="1">
                                        </td>
                                        <td><input type="text" name="title_of_document[]" value="{{$trainerQualifications->title_of_document}}"></td>
                                        <td><input type="text" name="supporting_document[]" value="{{$trainerQualifications->supporting_document}}"></td>

                                        <td><input type="text" name="remarks[]" value="{{$trainerQualifications->remarks}}"></td>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="group-input">
                                <label for="trainingQualificationStatus">Training Qualification Status ?</label>
                                <select name="trainingQualificationStatus[]" id="trainingQualificationStatus">
                                    <option value="">-- Select --</option>
                                    <option value="Qualified" @if ($trainerQualifications->trainingQualificationStatus == 'Qualified')selected @endif>Qualified</option>
                                    <option value="Not Qualified" @if ($trainerQualifications->trainingQualificationStatus == 'Not Qualified')selected @endif>Not Qualified</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Q_comment">Qualification Comments</label>
                                <textarea class="summernote" name="Q_comment" id="summernote-1">
                                {{$trainerQualifications->Q_comment}}
                                </textarea>
                            </div>
                        </div>



                        <script>
                            VirtualSelect.init({
                                ele: '#reference_record, #notify_to'
                            });

                            $('#summernote').summernote({
                                toolbar: [
                                    ['style', ['style']],
                                    ['font', ['bold', 'underline', 'clear', 'italic']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['table', ['table']],
                                    ['insert', ['link', 'picture', 'video']],
                                    ['view', ['fullscreen', 'codeview', 'help']]
                                ]
                            });

                            $('.summernote').summernote({
                                toolbar: [
                                    ['style', ['style']],
                                    ['font', ['bold', 'underline', 'clear', 'italic']],
                                    ['color', ['color']],
                                    ['para', ['ul', 'ol', 'paragraph']],
                                    ['table', ['table']],
                                    ['insert', ['link', 'picture', 'video']],
                                    ['view', ['fullscreen', 'codeview', 'help']]
                                ]
                            });

                            let referenceCount = 1;

                            function addReference() {
                                referenceCount++;
                                let newReference = document.createElement('div');
                                newReference.classList.add('row', 'reference-data-' + referenceCount);
                                newReference.innerHTML = `
            <div class="col-lg-6">
                <input type="text" name="reference-text">
            </div>
            <div class="col-lg-6">
                <input type="file" name="references" class="myclassname">
            </div><div class="col-lg-6">
                <input type="file" name="references" class="myclassname">
            </div>
        `;
                                let referenceContainer = document.querySelector('.reference-data');
                                referenceContainer.parentNode.insertBefore(newReference, referenceContainer.nextSibling);
                            }
                        </script>

                        <script>
                            function removeHtmlTags() {
                                var textarea = document.getElementById("summernote-16");
                                var cleanValue = textarea.value.replace(/<[^>]*>?/gm, ''); // Remove HTML tags
                                textarea.value = cleanValue;
                            }
                        </script>



                        <div class="col-12">
                            <div class="group-input">
                                <label for="Inv Attachments">Initial Attachment</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting
                                        documents</small></div>
                                {{-- <input type="file" id="myfile" name="inv_attachment[]" multiple> --}}
                                <div class="file-attachment-field">
                                    <div class="file-attachment-list" id="audit_file_attachment">
                                        @if (!empty($Trainer->inv_attachment))
                                        @foreach (json_decode($Trainer->inv_attachment) as $attachment)
                                        <div>{{ $attachment->inv_attachment }}</div>
                                        @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input type="file" id="myfile" name="inv_attachment[]" oninput="addMultipleFiles(this, 'audit_file_attachment')" multiple>
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
        ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record, #trainerSkillSet'
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
        $('#rchars').text(textlen);
    });
</script>

@endsection