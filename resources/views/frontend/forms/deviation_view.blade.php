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
 <style>
        textarea.note-codable {
            display: none !important;
        }

        header {
            display: none;
        }

        .sub-main-head {
        display: flex;
        justify-content: space-evenly;
    } 

    .Activity-type {
        margin-bottom: 7px;
    }

    /* .sub-head {
        margin-left: 280px;
        margin-right: 280px;
        color: #4274da;
        border-bottom: 2px solid #4274da;
        padding-bottom: 5px;
        margin-bottom: 20px;
        font-weight: bold;
        font-size: 1.2rem;

    } */

    .create-entity {
        background: #323c50;
        padding: 10px 15px;
        color: white;
        margin-bottom: 20px;

    }

    .bottom-buttons {
        display: flex;
        justify-content: flex-end;
        margin-right: 300px;
        margin-top: 50px;
        gap: 20px;
    }
    .text-danger{
            margin-top: -22px;
            padding: 4px;
            margin-bottom: 3px;
        }
        /* .saveButton:disabled{
            background: black!important;
            border:  black!important;

        } */

        .main-danger-block{
            display: flex;
        }
        .swal-modal {
            scale: 0.7!important;
        }
        .swal-icon {
            scale: 0.8!important;
        }
    </style>
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
     <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
     @if (Session::has('swal'))
     <script>
        swal ( "{{ Session::get('swal')['title'] }}" ,  "{{ Session::get('swal')['message'] }}" ,  "{{ Session::get('swal')['type'] }}" )
     </script>
     @endif
    
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
                    console.log(users);
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial_number[]" value="' + serialNumber +
                        '"></td>' +
                        '<td><input type="text" name="audit[]"></td>' +
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_start_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_start_date[]" id="scheduled_start_date' + serialNumber +'_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  class="hide-input" oninput="handleDateInput(this, `scheduled_start_date' + serialNumber +'`);checkDate(`scheduled_start_date' + serialNumber +'_checkdate`,`scheduled_end_date' + serialNumber +'_checkdate`)" /></div></div></div></td>' +

                        '<td><input type="time" name="scheduled_start_time[]"></td>' +
                        '<td><div class="group-input new-date-data-field mb-0"><div class="input-date "><div class="calenderauditee"> <input type="text" id="scheduled_end_date' + serialNumber +'" readonly placeholder="DD-MMM-YYYY" /><input type="date" name="scheduled_end_date[]" id="scheduled_end_date'+ serialNumber +'_checkdate" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, `scheduled_end_date' + serialNumber +'`);checkDate(`scheduled_start_date' + serialNumber +'_checkdate`,`scheduled_end_date' + serialNumber +'_checkdate`)" /></div></div></div></td>' +
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
            $('#ObservationAdd').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);
                    
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                        '<td> <select name="facility_name[]" id="facility_name"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>  <option value="">-- Select --</option>  <option value="Facility">Facility</option>  <option value="Equipment"> Equipment</option> <option value="Instrument">Instrument</option></select> </td>'+
                        '<td><input type="text" name="IDnumber[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}></td>'+
                        '<td><input type="text" name="Remarks[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}></td>'+
                        '</tr>';

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
    
<script>
        $(document).ready(function() {
            $('#ReferenceDocument').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);
                    
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                        '<td><input type="text" name="Number[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}></td>'+
                        '<td><input type="text" name="ReferenceDocumentName[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}></td>'+
                        '<td><input type="text" name="Document_Remarks[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}></td>'+
                        
                        '</tr>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' + 
                  
                        '</tr>';

                    return html;
                }

                var tableBody = $('#ReferenceDocument_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#ProductDetails').click(function(e) {
                function generateTableRow(serialNumber) {
                    var users = @json($users);
                    
                    var html =
                        '<tr>' +
                        '<td><input disabled type="text" name="serial[]" value="' + serialNumber +'"></td>' +
                        '<td><input type="text" name="Product_Name[]"></td>'+
                        '<td><input type="text" name=" Batch_No[]"></td>'+
                        '<td><input type="text" name="Remarks[]"></td>'+
                        '</tr>';

                    for (var i = 0; i < users.length; i++) {
                        html += '<option value="' + users[i].id + '">' + users[i].name + '</option>';
                    }

                    html += '</select></td>' + 
                  
                        '</tr>';

                    return html;
                }

                var tableBody = $('#ProductDetails_details tbody');
                var rowCount = tableBody.children('tr').length;
                var newRow = generateTableRow(rowCount + 1);
                tableBody.append(newRow);
            });
        });

        $(document).on('click', '.remove-file', function() {
            $(this).closest('div').remove()
        })
    </script>
    <div class="form-field-head">

        <div class="division-bar">
            <strong>Site Division/Project</strong> :
            {{ Helpers::getDivisionName(session()->get('division')) }}/Deviation
        </div>
    </div>



    {{-- ======================================
                    DATA FIELDS
    ======================================= --}}


    <div id="change-control-view">
        <div class="container-fluid">

            <div class="inner-block state-block">
                <div class="d-flex justify-content-between align-items-center"> 
                    <div class="main-head">Record Workflow </div>

                    <div class="d-flex" style="gap:20px;">
                        @php
                            $userRoles = DB::table('user_roles')->where(['user_id' => Auth::user()->id, 'q_m_s_divisions_id' => $data->division_id])->get();
                            $userRoleIds = $userRoles->pluck('q_m_s_roles_id')->toArray();
                            $cftRolesAssignUsers = collect($userRoleIds); //->contains(fn ($roleId) => $roleId >= 22 && $roleId <= 33);
                            $cftUsers = DB::table('deviationcfts')->where(['deviation_id' => $data->id])->first();

                            // Define the column names
                            $columns = ['Production_person', 'Warehouse_notification', 'Quality_Control_Person', 'QualityAssurance_person', 'Engineering_person', 'Analytical_Development_person', 'Kilo_Lab_person', 'Technology_transfer_person', 'Environment_Health_Safety_person', 'Human_Resource_person', 'Information_Technology_person', 'Project_management_person'];

                            // Initialize an array to store the values
                            $valuesArray = [];

                            // Iterate over the columns and retrieve the values
                            foreach ($columns as $column) {
                                $value = $cftUsers->$column;
                                // Check if the value is not null and not equal to 0
                                if ($value !== null && $value != 0) {
                                    $valuesArray[] = $value;
                                }
                            }
                            $cftCompleteUser = DB::table('deviationcfts_response')
                            ->whereIn('status', ['In-progress', 'Completed'])
                                ->where('deviation_id',$data->id)
                                ->where('cft_user_id', Auth::user()->id)
                                ->whereNull('deleted_at')
                                ->first();
                            // dd($cftCompleteUser);
                        @endphp
                        {{-- <button class="button_theme1" onclick="window.print();return false;"
                            class="new-doc-btn">Print</button> --}}
                         <button class="button_theme1"> <a class="text-white" href="{{ url('DeviationAuditTrial', $data->id) }}"> {{-- add here url for auditTrail i.e. href="{{ url('CapaAuditTrial', $data->id) }}" --}}
                                Audit Trail </a> </button>

                        @if ($data->stage == 1 && (in_array(3, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Submit
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 2 && (in_array(4, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                HOD Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cancel-modal">
                                Cancel
                            </button>
                        @elseif($data->stage == 3 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                               <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                              More Info Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Initial Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#cft-not-reqired">
                                CFT Review Not Required
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 4 && (in_array(5, $userRoleIds) || in_array(18, $userRoleIds) || in_array(Auth::user()->id, $valuesArray)))
                        @if(!$cftCompleteUser)
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                            More Info Required
                            </button>
                                <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                    CFT Review Complete
                                </button>
                            @endif 
                        @elseif($data->stage == 5 && (in_array(7, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#sendToInitiator">
                                Send to Initiator
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#hodsend">
                                Send to HOD
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#qasend">
                                Send to QA Initial Review
                            </button>
                             <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                QA Final Review Complete
                            </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#child-modal">
                                Child
                            </button>
                        @elseif($data->stage == 6 && (in_array(39, $userRoleIds) || in_array(18, $userRoleIds)))
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#more-info-required-modal">
                                More Info Required
                                </button>
                            <button class="button_theme1" data-bs-toggle="modal" data-bs-target="#signature-modal">
                                Approved
                            </button>
                        @endif 
                        <button class="button_theme1"> <a class="text-white" href="{{ url('rcms/qms-dashboard') }}"> Exit
                            </a> </button>


                    </div>

                </div>
                <div class="status">
                    <div class="head">Current Status</div>
                    @if ($data->stage == 0)
                        <div class="progress-bars">
                            <div class="bg-danger">Closed-Cancelled</div>
                        </div>
                    @else
                        <div class="progress-bars">
                            @if ($data->stage >= 1)
                                <div class="active">Opened</div>
                            @else
                                <div class="">Opened</div>
                            @endif

                            @if ($data->stage >= 2)
                                <div class="active">HOD Review </div>
                            @else
                                <div class="">HOD Review</div>
                            @endif

                            @if ($data->stage >= 3)
                                <div class="active">QA Initial Review</div>
                            @else
                                <div class="">QA Initial Review</div>
                            @endif

                            @if ($data->stage >= 4)
                                <div class="active">CFT Review</div>
                            @else
                                <div class="">CFT Review</div>
                            @endif


                            @if ($data->stage >= 5)
                                <div class="active">QA Final Review</div>
                            @else
                                <div class="">QA Final Review</div>
                            @endif
                            @if ($data->stage >= 6)
                                <div class="active">QA Head/Manager Designee</div>
                            @else
                                <div class="">QA Head Designee Approval</div>
                            @endif
                            @if ($data->stage >= 7)
                                <div class="bg-danger">Closed - Done</div>
                            @else
                                <div class="">Closed - Done</div>
                            @endif
                    @endif


                </div>
                {{-- @endif --}}
                {{-- ---------------------------------------------------------------------------------------- --}}
            </div>
        </div>
<script>
    console.log('Script working')

    $(document).ready(function() {
        
            
        function submitForm() {

            let auditForm = document.getElementById('auditForm');


            console.log('sumitting form')
            
            document.querySelectorAll('.saveAuditFormBtn').forEach(function(button) {
                button.disabled = true;
            })

            document.querySelectorAll('.auditFormSpinner').forEach(function(spinner) {
                spinner.style.display = 'flex';
            })

            auditForm.submit();
        }

        $('#ChangesaveButton01').click(function() {
            document.getElementById('formNameField').value = 'general-open';
            submitForm();
        });
        
        $('#ChangesaveButton02').click(function() {
            document.getElementById('formNameField').value = 'hod';
            submitForm();
        });

        $('#ChangesaveButton03').click(function() {
            document.getElementById('formNameField').value = 'qa';
            submitForm();
        });
        
        $('#ChangesaveButton04').click(function() {
            document.getElementById('formNameField').value = 'capa';
            submitForm();
        });
        
        $('#ChangesaveButton05').click(function() {
            document.getElementById('formNameField').value = 'qa-final';
            submitForm();
        });
        
        $('#ChangesaveButton06').click(function() {
            document.getElementById('formNameField').value = 'qah';
            submitForm();
        });

        $('#signatureModalButton').click(function() {

        });
        
        
    });

    document.addEventListener('DOMContentLoaded', function () {
        var signatureForm = document.getElementById('signatureModalForm');

        signatureForm.addEventListener('submit', function (e) {

            var submitButton = signatureForm.querySelector('.signatureModalButton');
            var spinner = signatureForm.querySelector('.signatureModalSpinner');

            submitButton.disabled = true;

            spinner.style.display = 'inline-block';
        });
    });


// =========================
wow = new WOW(
                      {
                      boxClass:     'wow',      // default
                      animateClass: 'animated', // default
                      offset:       0,          // default
                      mobile:       true,       // default
                      live:         true        // default
                    }
                    )
                    wow.init();
</script>

    <div style="background: #e0903230;" id="change-control-fields">
        <div class="container-fluid">

            <!-- Tab links -->
            <div  class="cctab">
                <button class="cctablinks active" onclick="openCity(event, 'CCForm1')">General Information</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm8')">HOD Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm2')">QA Initial Review</button>
                <button class="cctablinks " onclick="openCity(event, 'CCForm7')">CFT</button>

                <button class="cctablinks" onclick="openCity(event, 'CCForm3')">Investigation & CAPA</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm4')">QA Final Review</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm5')">QAH/Designee Approval</button>
                <button class="cctablinks" onclick="openCity(event, 'CCForm6')">Activity Log</button>
            </div>

            <form id="auditForm"  action="{{ route('deviationupdate', $data->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="form_name" id="formNameField" value="">
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
                                        @if ($data->stage >= 3)
                                        <input disabled type="text" name="record_number"
                                        value="{{ Helpers::getDivisionName($data->division_id) }}/DEV/{{ Helpers::year($data->created_at) }}/{{ $data->record }}"> 
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> --}}
                                        @else
                                        <input disabled type="text" name="record_number"> 
                                        @endif
                                    </div>
                                </div>
                    
                                {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="RLS Record Number"><b>Record Number</b></label>
                                        <input disabled type="text" name="record_number"
                                        value="{{ Helpers::getDivisionName($data->division_id) }}/DEV/{{ Helpers::year($data->created_at) }}/{{ $data->record }}"> 
                                        {{-- <div class="static">QMS-EMEA/CAPA/{{ date('Y') }}/{{ $record_number }}</div> 
                                    </div>
                                </div> --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Division Code"><b>Site/Location Code</b></label>
                                        <input readonly type="text" name="division_code"
                                            value="{{ $divisionName }}">
                                        <input type="hidden" name="division_id" value="{{ session()->get('division') }}">
                                        {{-- <div class="static">QMS-North America</div> --}}
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator"><b>Initiator</b></label>
                                        {{-- <div class="static">{{ Auth::user()->name }}</div> --}}
                                        <input disabled type="text" value="{{ $data->initiator_name }}">

                                    </div>
                                </div>
                                <?php
                                // Calculate the due date (30 days from the initiation date)
                                $initiationDate = date('Y-m-d'); // Current date as initiation date
                                $dueDate = date('Y-m-d', strtotime($initiationDate . '+30 days')); // Due date
                                ?>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Date of Initiation"><b>Date of Initiation</b></label>
                                        <input readonly type="text" value="{{ date('d-M-Y') }}" name="initiation_date" id="initiation_date">
                                        <input type="hidden" value="{{ date('Y-m-d') }}" name="initiation_date_hidden">
                                    </div>
                                </div>

                                <div class="col-lg-12 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Due Date">Due Date</label>
                                        <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small></div>
                                        <div class="calenderauditee">
                                            <input readonly type="text"
                                            value="{{ Helpers::getdateFormat($data->due_date) }}" name="due_date"/>
                                            <input type="date" name="due_date" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" class="hide-input" oninput="handleDateInput(this, 'due_date')" />
                                        </div>
                                    </div>
                                </div>

                                <script>
                                    // Format the due date to DD-MM-YYYY
                                    var dueDateFormatted = new Date("{{$dueDate}}").toLocaleDateString('en-GB', {
                                        day: '2-digit',
                                        month: '2-digit',
                                        year: 'numeric'
                                    }).split('/').join('-');

                                    // Set the formatted due date value to the input field
                                    document.getElementById('due_date').value = dueDateFormatted;
                                </script>


                                {{-- <div class="col-lg-6">
                                    <div class="group-input ">
                                        <label for="Date Due"><b>Date of Initiation</b></label>
                                        <input readonly type="text" value="{{ date('d-M-Y') }}" name="intiation_date">
                                        <input type="hidden" value="{{ date('d-m-Y') }}" name="intiation_date">
                                    </div>
                                </div>

                                <div class="col-lg-12 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Date Due">Due Date</label>
                                        <div><small class="text-primary">If revising Due Date, kindly mention revision reason in "Due Date Extension Justification" data field.</small>
                                        </div>
                                        <input readonly type="text"
                                            value="{{ Helpers::getdateFormat($data->due_date) }}"
                                            name="due_date"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : ''}}>
                                        {{-- <input type="text" value="{{ $data->due_date }}" name="due_date">
                                        {{-- <div class="static"> {{ $due_date }}</div> 

                                    </div>
                                </div> --}}

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group"><b>Department</b> <span
                                            class="text-danger">*</span></label>
                                        <select name="Initiator_Group" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                             id="initiator_group">
                                             <option value="">Enter Your Selection Here</option>
                                            <option value="CQA"
                                                @if ($data->Initiator_Group == 'CQA') selected @endif>Corporate
                                                Quality Assurance</option>
                                            <option value="QAB"
                                                @if ($data->Initiator_Group == 'QAB') selected @endif>Quality
                                                Assurance Biopharma</option>
                                            <option value="CQC"
                                                @if ($data->Initiator_Group == 'CQC') selected @endif>Central
                                                Quality Control</option>
                                            <option value="MANU"
                                                @if ($data->Initiator_Group == 'MANU') selected @endif>Manufacturing
                                            </option>
                                            <option value="PSG"
                                                @if ($data->Initiator_Group == 'PSG') selected @endif>Plasma
                                                Sourcing Group</option>
                                            <option value="CS"
                                                @if ($data->Initiator_Group == 'CS') selected @endif>Central
                                                Stores</option>
                                            <option value="ITG"
                                                @if ($data->Initiator_Group == 'ITG') selected @endif>Information
                                                Technology Group</option>
                                            <option value="MM"
                                                @if ($data->Initiator_Group == 'MM') selected @endif>Molecular
                                                Medicine</option>
                                            <option value="CL"
                                                @if ($data->Initiator_Group == 'CL') selected @endif>Central
                                                Laboratory</option>
                                            <option value="TT"
                                                @if ($data->Initiator_Group == 'TT') selected @endif>Tech
                                                team</option>
                                            <option value="QA"
                                                @if ($data->Initiator_Group == 'QA') selected @endif>Quality
                                                Assurance</option>
                                            <option value="QM"
                                                @if ($data->Initiator_Group == 'QM') selected @endif>Quality
                                                Management</option>
                                            <option value="IA"
                                                @if ($data->Initiator_Group == 'IA') selected @endif>IT
                                                Administration</option>
                                            <option value="ACC"
                                                @if ($data->Initiator_Group == 'ACC') selected @endif>Accounting
                                            </option>
                                            <option value="LOG"
                                                @if ($data->Initiator_Group == 'LOG') selected @endif>Logistics
                                            </option>
                                            <option value="SM"
                                                @if ($data->Initiator_Group == 'SM') selected @endif>Senior
                                                Management</option>
                                            <option value="BA"
                                                @if ($data->Initiator_Group == 'BA') selected @endif>Business
                                                Administration</option>

                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group Code">Department Code</label>
                                        <input type="text" name="initiator_group_code"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                            value="{{ $data->Initiator_Group }}" id="initiator_group_code"
                                            readonly>

                                    </div>
                                </div>
                            
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Short Description">Short Description<span
                                            class="text-danger"> *</span></label><span id="rchars">255</span>characters remaining
                                    <textarea name="short_description"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}   id="docname" type="text"    maxlength="255" required  {{ $data->stage == 0 || $data->stage == 6 ? "disabled" : "" }}>{{ $data->short_description }}</textarea>
                                 </div>
                                </div>  
                                <div class="col-lg-6 new-date-data-field">
                                    <div class="group-input input-date">
                                        <label for="Short Description required">Nature of Repeat? <span
                                            class="text-danger">*</span></label>
                                        <select name="short_description_required"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="short_description_required" onchange="checkRecurring(this)" value="{{ $data->short_description_required }}">
                                            <option value="0">-- Select --</option>
                                            <option value="Recurring" @if ($data->short_description_required == 'Recurring' || old('short_description_required') == 'Recurring') selected @endif>Recurring</option>
                                            <option value="Non_Recurring" @if ($data->short_description_required == 'Non_Recurring' || old('short_description_required') == 'Non_Recurring') selected @endif>Non Recurring</option>
                                        </select>
                                    </div>
                                    @error('short_description_required')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input" id="nature_of_repeat">
                                        <label for="nature_of_repeat">Repeat Nature <span id="asteriskInviRecurring" style="display: {{ $data->short_description_required == 'Recurring' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea class="nature_of_repeat" name="nature_of_repeat"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="nature_of_repeat" class="nature_of_repeat">{{ $data->nature_of_repeat }}</textarea>
                                    </div>
                                    @error('nature_of_repeat')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        var selectField = document.getElementById('short_description_required');
                                        var inputsToToggle = [];

                                        // Add elements with class 'facility-name' to inputsToToggle
                                        var facilityNameInputs = document.getElementsByClassName('nature_of_repeat');
                                        for (var i = 0; i < facilityNameInputs.length; i++) {
                                            inputsToToggle.push(facilityNameInputs[i]);
                                        }

                                                                        
                                        selectField.addEventListener('change', function () {
                                            var isRequired = this.value === 'Recurring';

                                            inputsToToggle.forEach(function (input) {
                                                input.required = isRequired;
                                                console.log(input.required, isRequired, 'input req');
                                            });

                                            // Show or hide the asterisk icon based on the selected value
                                            var asteriskIcon = document.getElementById('asteriskInviRecurring');
                                            asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                        });
                                    });
                                    </script>
                                <script>
                                    function checkRecurring(selectElement) {
                                        var repeatNatureField = document.getElementById('nature_of_repeat');
                                        if (selectElement.value === 'Recurring') {
                                            repeatNatureField.setAttribute('required', 'required');
                                        } else {
                                            repeatNatureField.removeAttribute('required');
                                        }
                                    }
                                </script>
                             <div class="col-6" >
                                    <div class="group-input">
                                        <label for="severity-level">Deviation Observed On <span
                                            class="text-danger">*</span></label>
                                        <!-- <span class="text-primary">Severity levels in a QMS record gauge issue seriousness, guiding priority for corrective actions. Ranging from low to high, they ensure quality standards and mitigate critical risks.</span> -->
                                       <input type="date" id="Deviation_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"  name="Deviation_date"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="{{ old('Deviation_date') ? old('Deviation_date') : $data->Deviation_date }}">
                                       @error('Deviation_date')
                                           <div class="text-danger">{{ $message }}</div>
                                       @enderror
                                    </div>
                                </div>
                                <div class="col-lg-6 new-time-data-field">
                                    <div class="group-input input-time">
                                        <label for="deviation_time">Deviation Observed On (Time) <span
                                            class="text-danger">*</span></label>
                                        <input type="text" name="deviation_time"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="deviation_time" value="{{ old('deviation_time') ? old('deviation_time') : $data->deviation_time }}">
                                        @error('deviation_time')
                                           <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <script>
                                    flatpickr("#deviation_time", {
                                        enableTime: true,
                                        noCalendar: true,
                                        dateFormat: "h:i K", // Format time as 12-hour with AM/PM
                                        minuteIncrement: 1 // Set minute increment to 1

                                    });
                                </script>
                              {{--  <div class="col-lg-6">
                                    <div class="group-input">
                                        @php
                                            $users = DB::table('users')->get();
                                            $facilities = $data->Facility;
                                        @endphp
                                        <label for="If Other">Deviation Observed By<span class="text-danger d-none">*</span></label>
                                        <select multiple name="Facility[]" placeholder="Select Facility Name"
                                            data-search="false" data-silent-initial-value-set="true" id="Facility">
                                            @foreach ($users as $user)
                                                <option value="{{ $user->id }}" @if (in_array($user->id, explode(',', $data->Facility))) selected @endif>{{ $user->name }}</option>
                                            @endforeach                                           
                                        </select>
                                    </div>
                                </div> --}}
                                 {{-- <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Deviation Reported On</label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input type="date"id="Deviation_reported_date" name="Deviation_reported_date" value="{{ $data->Deviation_reported_date }}" >
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit type">Deviation Related To </label>
                                        <select  name="audit_type" id="audit_type"  value="{{ $data->audit_type }}">
                                            <option value="">Enter Your Selection Here</option>
                                            <option @if ($data->audit_type == 'Facility') selected @endif
                                                value="Facility">Facility</option>
                                                <option @if ($data->audit_type == 'Equipment/Instrument') selected @endif
                                                    value="Equipment/Instrument">Equipment/Instrument</option>
                                                    <option @if ($data->audit_type == 'Documentationerror') selected @endif
                                                        value="Documentationerror">Documentation error</option>
                                                        <option @if ($data->audit_type == 'STP/ADS_instruction') selected @endif
                                                            value="STP/ADS_instruction">STP/ADS instruction</option>
                                                            <option @if ($data->audit_type == 'Packaging&Labelling') selected @endif
                                                                value="Packaging&Labelling">Packaging & Labelling</option>
                                                                <option @if ($data->audit_type == 'Material_System') selected @endif
                                                                    value="Material_System">Material System</option>
                                                                    <option @if ($data->audit_type == 'Laboratory_Instrument/System') selected @endif
                                                                        value="Laboratory_Instrument/System">Laboratory_Instrument/System</option>
                                                                        <option @if ($data->audit_type == 'Utility_System') selected @endif
                                                                            value="Utility_System">Utility System</option>
                                                                            <option @if ($data->audit_type == 'Computer_System') selected @endif
                                                                                value="Computer_System">Computer System</option>
                                                                                <option @if ($data->audit_type == 'Document') selected @endif
                                                                                    value="Document">Document</option>
                                                                                    <option @if ($data->audit_type == 'Data integrity') selected @endif
                                                                                        value="Data integrity">Data integrity</option>
                                                                                        <option @if ($data->audit_type == 'SOP Instruction') selected @endif
                                                                                            value="SOP Instruction">SOP Instruction</option>
                                                                                            <option @if ($data->audit_type == 'BMR/ECR Instruction') selected @endif
                                                                                                value="BMR/ECR Instruction">BMR/ECR Instruction</option>
                                                                                        <option @if ($data->audit_type == 'Anyother(specify)') selected @endif
                                                                                            value="Anyother(specify)">Anyother(specify)</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="others">Others</label>
                                        <input type="text" id="others" name="others">
                                    </div>
                                </div> 
                               <div>  --}}
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        @php
                                            $users = DB::table('users')->get();
                                            $selectedFacilities = explode(',', $data->Facility); // Convert to array if it's not already
                                            $inputFacilities = [];
                                            // if ( old('Facility') ) {
                                            //     $inputFacilities = explode(',', old('Facility'));
                                            // }
                                        @endphp
                                        <label for="If Other">Deviation Observed By<span class="text-danger">*</span></label>
                                        <select multiple name="Facility[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} placeholder="Select Facility Name" data-search="false" data-silent-initial-value-set="true" id="Facility">
                                            @foreach ($users as $user)
                                                <option {{ (in_array($user->id, $selectedFacilities) || in_array($user->id, $inputFacilities))  ? 'selected' : '' }} value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach                                           
                                        </select>
                                        @error('Facility')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div> 
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Initiator Group">Deviation Reported On <span
                                            class="text-danger">*</span></label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input type="date"id="Deviation_reported_date" max="{{ \Carbon\Carbon::now()->format('Y-m-d') }}" name="Deviation_reported_date"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $data->Deviation_reported_date }}" >
                                    </div>
                                    @error('Deviation_reported_date')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                             
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="audit type">Deviation Related To <span
                                            class="text-danger">*</span></label>
                                        <select multiple name="audit_type[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="audit_type">
                                            {{-- <option value="">Enter Your Selection Here</option> --}}
                                            <option value="Facility"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} {{ strpos($data->audit_type, 'Facility') !== false ? 'selected' : '' }}>Facility</option>
                                            <option value="Equipment/Instrument" {{ strpos($data->audit_type, 'Equipment/Instrument') !== false ? 'selected' : '' }}>Equipment/Instrument</option>
                                            <option value="Documentationerror" {{ strpos($data->audit_type, 'Documentationerror') !== false ? 'selected' : '' }}>Documentation error</option>
                                            <option value="STP/ADS_instruction" {{ strpos($data->audit_type, 'STP/ADS_instruction') !== false ? 'selected' : '' }}>STP/ADS instruction</option>
                                            <option value="Packaging&Labelling" {{ strpos($data->audit_type, 'Packaging&Labelling') !== false ? 'selected' : '' }}>Packaging & Labelling</option>
                                            <option value="Material_System" {{ strpos($data->audit_type, 'Material_System') !== false ? 'selected' : '' }}>Material System</option>
                                            <option value="Laboratory_Instrument/System" {{ strpos($data->audit_type, 'Laboratory_Instrument/System') !== false ? 'selected' : '' }}>Laboratory Instrument/System</option>
                                            <option value="Utility_System" {{ strpos($data->audit_type, 'Utility_System') !== false ? 'selected' : '' }}>Utility System</option>
                                            <option value="Computer_System" {{ strpos($data->audit_type, 'Computer_System') !== false ? 'selected' : '' }}>Computer System</option>
                                            <option value="Document" {{ strpos($data->audit_type, 'Document') !== false ? 'selected' : '' }}>Document</option>
                                            <option value="Data integrity" {{ strpos($data->audit_type, 'Data integrity') !== false ? 'selected' : '' }}>Data integrity</option>
                                            <option value="Water System" {{ strpos($data->audit_type, 'Water System') !== false ? 'selected' : '' }}>Water System</option>
                                            <option value="Anyother(specify)" {{ strpos($data->audit_type, 'Anyother(specify)') !== false ? 'selected' : '' }}>Anyother(specify)</option>
                                        </select>
                                    </div>
                                    @error('audit_type')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="others">Others <span id="asteriskInOther" style="display: {{ $data->audit_type == 'Anyother(specify)' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <input type="text" class="otherrr" name="others" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="others" value="{{ $data->others }}">
                                        @error('others')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                        var selectField = document.getElementById('audit_type');
                                        var inputsToToggle = [];

                                        // Add elements with class 'facility-name' to inputsToToggle
                                        var facilityNameInputs = document.getElementsByClassName('otherrr');
                                        for (var i = 0; i < facilityNameInputs.length; i++) {
                                            inputsToToggle.push(facilityNameInputs[i]);
                                        }

                                                                        
                                        selectField.addEventListener('change', function () {
                                            // var isRequired = this.value === 'Anyother(specify)';
                                            var isRequired = this.value.includes('Anyother(specify)');
                                            console.log('isRequired', isRequired)

                                            inputsToToggle.forEach(function (input) {
                                                input.required = isRequired;
                                                console.log(input.required, isRequired, 'input req');
                                            });

                                            // Show or hide the asterisk icon based on the selected value
                                            var asteriskIcon = document.getElementById('asteriskInOther');
                                            asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                        });
                                    });
                                    </script>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Facility/Equipment"> Facility/ Equipment/ Instrument/ System Details Required? <span
                                            class="text-danger">*</span></label>
                                        <select name="Facility_Equipment" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Facility_Equipment"  value="{{ $data->Facility_Equipment }}" >
                                            <option value="">-- Select --</option>
                                            <option @if ($data->Facility_Equipment == 'yes' || old('Facility_Equipment') == 'yes') selected @endif
                                             value="yes">Yes</option>
                                            <option  @if ($data->Facility_Equipment == 'no' || old('Facility_Equipment') == 'no') selected @endif 
                                            value="no">No</option>>
                                        </select>
                                        @error('Facility_Equipment')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="group-input">
                                        <label for="audit-agenda-grid">
                                            Facility/ Equipment/ Instrument/ System Details <span id="asteriskInvifaci" style="display: {{ $data->Facility_Equipment == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span>
                                            <button type="button" name="audit-agenda-grid"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="audit-agenda-grid"
                                                id="ObservationAdd">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#observation-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        {{-- <div class="table-responsive">
                                            <table class="table table-bordered" id="onservation-field-table"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">Row#</th>
                                                        <th style="width: 12%">Name</th>
                                                        <th style="width: 16%"> ID Number</th>
                                                         <th style="width: 15%">Remarks</th>                                                  
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if ($grid_data->Remarks)
                                                     @foreach (unserialize($grid_data->Remarks) as $key => $temps)
                                                        <td><input disabled type="text" name="serial[]" value="1"></td>
                                                        <td> <select name="name" id="facility_name" value="{{ unserialize($grid_data->facility_name)[$key] ? unserialize($grid_data->facility_name)[$key] : '' }}">  <option value="">-- Select --</option>  <option value="1">Facility</option>  <option value="2"> Equipment</option> <option value="3">Instrument</option></select> </td>
                                                        <td><input type="text" name="IDnumber[]"value="{{ unserialize($grid_data->IDnumber)[$key] ? unserialize($grid_data->IDnumber)[$key] : '' }}"></td>
                                                        <td><input type="text" name="Remarks[]"value="{{ unserialize($grid_data->Remarks)[$key] ? unserialize($grid_data->Remarks)[$key] : '' }}"></td>
                                                     @endforeach
                                                    @endif
                                                </tbody>

                                            </table>
                                        </div> --}}
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="onservation-field-table" style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 5%">Row#</th>
                                                        <th style="width: 12%">Name</th>
                                                        <th style="width: 16%">ID Number</th>
                                                        <th style="width: 15%">Remarks</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (!empty($grid_data->Remarks))
                                                        @foreach (unserialize($grid_data->Remarks) as $key => $temps)
                                                            <tr>
                                                                <td><input disabled type="text" name="serial[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                                    value="{{ $key + 1 }}"></td>
                                                                <td>
                                                                    <select class="facility-name" name="facility_name[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="facility_name">
                                                                        @if(isset($grid_data->facility_name))
                                                                             @php
                                                                                $facility_name = unserialize($grid_data->facility_name);
                                                                           @endphp
                                                                           <option value="">-- Select --</option>
                                                                             <option value="Facility" {{ (isset($facility_name[$key]) && $facility_name[$key] == "Facility") ? "selected" : "Facility" }}>Facility</option>
                                                                             <option value="Equipment" {{ (isset($facility_name[$key]) && $facility_name[$key] == "Facility") ? "selected" : "Equipment" }}>Equipment</option>
                                                                             <option value="Instrument" {{ (isset($facility_name[$key]) && $facility_name[$key] == "Instrument") ? "selected" : "Instrument" }}>Instrument</option>
                                                                         @endif

                                                                        
                                                                        {{-- <option value="1" {{ (unserialize($grid_data->facility_name)[$key] == "1")?"selected":"1"}}>Facility</option>                               
                                                                        <option value="2" {{ (unserialize($grid_data->facility_name)[$key] == "2")?"selected":"2"}}>Equipment</option>                               
                                                                        <option value="3" {{ (unserialize($grid_data->facility_name)[$key] == "3")?"selected":"2"}}>Instrument</option>--}}
                                                                    </select>
                                                                </td>
                                                                <td><input class="id-number" type="text" name="IDnumber[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="{{ isset(unserialize($grid_data->IDnumber)[$key]) ? unserialize($grid_data->IDnumber)[$key] : '' }}"></td>
                                                                <td><input class="remarks" type="text" name="Remarks[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="{{ unserialize($grid_data->Remarks)[$key] ? unserialize($grid_data->Remarks)[$key] : '' }}"></td>
                                                            </tr>
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>  
                                        <div class="main-danger-block">

                                  
                                            @error('facility_name')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                            @error('IDnumber')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
        
                                        </div>                                      
                                    </div>
                                    <script>

                                    document.addEventListener('DOMContentLoaded', function () {
                                        var selectField = document.getElementById('Facility_Equipment');
                                        var inputsToToggle = [];

                                        // Add elements with class 'facility-name' to inputsToToggle
                                        var facilityNameInputs = document.getElementsByClassName('facility-name');
                                        for (var i = 0; i < facilityNameInputs.length; i++) {
                                            inputsToToggle.push(facilityNameInputs[i]);
                                        }

                                        // Add elements with class 'id-number' to inputsToToggle
                                        var idNumberInputs = document.getElementsByClassName('id-number');
                                        for (var j = 0; j < idNumberInputs.length; j++) {
                                            inputsToToggle.push(idNumberInputs[j]);
                                        }

                                        // Add elements with class 'remarks' to inputsToToggle
                                        var remarksInputs = document.getElementsByClassName('remarks');
                                        for (var k = 0; k < remarksInputs.length; k++) {
                                            inputsToToggle.push(remarksInputs[k]);
                                        }

                                                                        
                                        selectField.addEventListener('change', function () {
                                            var isRequired = this.value === 'yes';
                                            console.log(this.value, isRequired, 'value');

                                            inputsToToggle.forEach(function (input) {
                                                input.required = isRequired;
                                                console.log(input.required, isRequired, 'input req');
                                            });

                                            // Show or hide the asterisk icon based on the selected value
                                            var asteriskIcon = document.getElementById('asteriskInvifaci');
                                            asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                        });
                                    });
                                    </script>
                                    <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Document Details Required">Document Details Required? <span
                                            class="text-danger">*</span></label>
                                        <select name="Document_Details_Required"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Document_Details_Required"  value="{{ $data->Document_Details_Required }}" >
                                            <option value="">-- Select --</option>
                                            <option @if ($data->Document_Details_Required == 'yes' || old('Document_Details_Required') == 'yes') selected @endif
                                             value="yes">Yes</option>
                                            <option  @if ($data->Document_Details_Required == 'no' || old('Document_Details_Required') == 'no') selected @endif 
                                            value="no">No</option>>
                                        </select>
                                    </div>
                                    @error('Document_Details_Required')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div> 
                                    <div class="group-input">
                                        <label for="audit-agenda-grid">
                                         Document Details <span id="asteriskInvidoc" style="display: {{ $data->Document_Details_Required == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span>
                                            <button type="button" name="audit-agenda-grid"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="audit-agenda-grid"
                                                id="ReferenceDocument">+</button>
                                            <span class="text-primary" data-bs-toggle="modal"
                                                data-bs-target="#document-details-field-instruction-modal"
                                                style="font-size: 0.8rem; font-weight: 400; cursor: pointer;">
                                                (Launch Instruction)
                                            </span>
                                        </label>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="ReferenceDocument_details"
                                                style="width: 100%;">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 4%">Row#</th>
                                                        <th style="width: 12%">Number</th>
                                                        
                                                        <th style="width: 16%"> Reference Document Name</th>
                                                        <th style="width: 16%"> Remarks</th>
                                                                                                         
                                                    </tr>
                                                </thead>
                                            <tbody>
                                                @if ($grid_data1->ReferenceDocumentName)
                                                    @foreach (unserialize($grid_data1->ReferenceDocumentName) as $key => $temps)
                                                        <tr>
                                                          <td><input disabled type="text" name="serial[]"{{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} value="{{ $key + 1 }}"></td>
                                                            <td><input class="numberDetail" type="text" name="Number[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="{{ unserialize($grid_data1->Number)[$key] ? unserialize($grid_data1->Number)[$key] : '' }}"></td>
                                                            <td><input class="ReferenceDocumentName" type="text" name="ReferenceDocumentName[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="{{ unserialize($grid_data1->ReferenceDocumentName)[$key] ? unserialize($grid_data1->ReferenceDocumentName)[$key] : '' }}"></td>
                                                            <td><input class="Document_Remarks" type="text" name="Document_Remarks[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="{{ unserialize($grid_data1->Document_Remarks)[$key] ? unserialize($grid_data1->Document_Remarks)[$key] : '' }}"></td>
                                                        </tr>           
                                                    @endforeach
                                               @endif
                                             </tbody>

                                            </table>
                                        </div>
                                        @error('Number')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        @error('ReferenceDocumentName')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            // note-codable

                                            var selectField = document.getElementById('Document_Details_Required');
                                            var inputsToToggle = [];

                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('numberDetail');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }

                                            // Add elements with class 'id-number' to inputsToToggle
                                            var idNumberInputs = document.getElementsByClassName('Document_Remarks');
                                            for (var j = 0; j < idNumberInputs.length; j++) {
                                                inputsToToggle.push(idNumberInputs[j]);
                                            }

                                            // Add elements with class 'remarks' to inputsToToggle
                                            var remarksInputs = document.getElementsByClassName('ReferenceDocumentName');
                                            for (var k = 0; k < remarksInputs.length; k++) {
                                                inputsToToggle.push(remarksInputs[k]);
                                            }

                                                                            
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
                                                console.log(this.value, isRequired, 'value');

                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                    console.log(input.required, isRequired, 'input req');
                                                });

                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asteriskInvidoc');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                        </script>
                                <div class="col-lg-12">
                                    <div class="group-input" id="external_agencies_req">
                                        <label for="others">Name of Product & Batch No<span class="text-danger">*</span></label>
                                        <input type="text" value="{{ old('Product_Batch') ? old('Product_Batch') : $data->Product_Batch}}" name="Product_Batch"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>
                                        
                                            <!-- <p class="text-danger">this field is required</p> -->
                                        @error('Product_Batch')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                      </div>
                               
                                {{-- <div class="col-6">
                                    <div class="group-input">
                                        <label for="Description Deviation">Description of Deviation</label>
                                        <textarea class="summernote"  name="Description_Deviation[]" value="{{$data->Description_Deviation}}"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Description Deviation">Description of Deviation <span class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Description_Deviation[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-1">{{ $data->Description_Deviation }}</textarea>
                                    </div>
                                    @error('Description_Deviation')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <!-- <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Production feedback">Production Feedback <span class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Production_feedback" id="summernote-18">{{ $data1->Production_feedback }}
                                    </textarea>
                                    </div>
                                </div> -->
                                {{-- <div class="col-6">
                                <div class="group-input">
                                        <label for="Initial Comments">Immediate Action (if any)</label>
                                        <textarea class="summernote" name="Immediate_Action[]" value="{{$data->Immediate_Action}}"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Immediate Action">Immediate Action (if any) <span class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Immediate_Action[]" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-2">{{ $data->Immediate_Action }}</textarea>
                                    </div>
                                    @error('Immediate_Action')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                               
                                {{-- <div class="col-6">
                                <div class="group-input">
                                        <label for="Initial Comments">Preliminary Impact of Deviation</label>
                                        <textarea class="summernote" name="Preliminary_Impact[]" value="{{$data->Preliminary_Impact}}"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Preliminary Impact">Preliminary Impact of Deviation <span class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Preliminary_Impact[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-3">{{ $data->Preliminary_Impact }}</textarea>
                                    </div>
                                    @error('Preliminary_Impact')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                            </div>
                            <div class="button-block">
                                <button type="submit"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="ChangesaveButton01" class="saveButton saveAuditFormBtn d-flex" style="align-items: center;">
                                    <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                      Save
                                </button>
                                <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}"  class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <!-- ----------hod Review-------- -->
                    <div id="CCForm8" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                    <div class="col-md-12">
                                        @if($data->stage == 2)
                                            <div class="group-input">
                                                <label for="HOD Remarks">HOD Remarks <span class="text-danger">*</span></label>
                                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                <textarea class="summernote" name="HOD_Remarks" id="summernote-4" required>{{ $data->HOD_Remarks }}</textarea>
                                            </div>
                                            @else
                                            <div class="group-input">
                                                <label for="HOD Remarks">HOD Remarks</label>
                                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                <textarea readonly class="summernote" name="HOD_Remarks" id="summernote-4">{{ $data->HOD_Remarks }}</textarea>
                                            </div>
                                        @endif 
                                        @error('HOD_Remarks')
                                            <div class="text-danger">{{  $message  }}</div>
                                        @enderror
                                </div>
                                 <div class="col-12">
                                    @if($data->stage == 2)
                                        <div class="group-input">
                                            <label for="Inv Attachments">HOD Attachments</label>
                                            <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                            <div class="file-attachment-field">
                                                <div disabled class="file-attachment-list" id="Audit_file">
                                                    @if ($data->Audit_file)
                                                        @foreach(json_decode($data->Audit_file) as $file)
                                                            <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                                <b>{{ $file }}</b>
                                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                                <a class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                            </h6>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                <div class="add-btn">
                                                    <div>Add</div>
                                                    <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="HOD_Attachments" name="Audit_file[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                        oninput="addMultipleFiles(this, 'Audit_file')"
                                                        multiple>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                    <div class="group-input">
                                        <label for="Inv Attachments">HOD Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Audit_file">
                                                @if ($data->Audit_file)
                                                    @foreach(json_decode($data->Audit_file) as $file)
                                                        <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                            <a class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input disabled {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="HOD_Attachments" name="Audit_file[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                    oninput="addMultipleFiles(this, 'Audit_file')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    {{-- <div class="group-input">
                                        <label for="Inv Attachments">HOD Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Audit_file">
                                                @if ($data->Audit_file)
                                                    @foreach(json_decode($data->Audit_file) as $file)
                                                        <h6 class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                            <a class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="HOD_Attachments" name="Audit_file[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                    oninput="addMultipleFiles(this, 'Audit_file')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div> --}}
                                </div>
                                
                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                        $(document).ready(function() {
                                            // Event listener for the remove file button
                                            $(document).on('click', '.remove-file', function() {
                                                $(this).closest('.file-container').remove();
                                            });
                                        });
                                    </script>


                            </div>
                            <div class="button-block">
                                
                                <button type="submit"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="saveButton saveAuditFormBtn d-flex" style="align-items: center;" id="ChangesaveButton02">
                                    <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                    Save
                                </button>
                                {{-- <a href="/rcms/qms-dashboard">
                                        <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="backButton">Back</button>
                                    </a> --}}
                                <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>
                       <!-- QA Initial reVIEW -->
                       <div id="CCForm2" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            @if($data->stage==3)
                            <div class="row">
                                <div style="margin-bottom: 0px;" class="col-lg-12 new-date-data-field ">
                                    <div class="group-input input-date">
                                             
                                            @if($data->stage == 3)
                                                <label for="Deviation category">Initial Deviation category <span class="text-danger">*</span></label>
                                                <select id="Deviation_category" name="Deviation_category"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  value="{{ $data->Deviation_category }}" required>
                                                    <option value="0">-- Select --</option>
                                                    <option @if ($data->Deviation_category == 'minor') selected @endif
                                                    value="minor">Minor</option>
                                                    <option  @if ($data->Deviation_category == 'major') selected @endif 
                                                    value="major">Major</option>
                                                    <option @if ($data->Deviation_category == 'critical') selected @endif
                                                    value="critical">Critical</option>
                                                </select>
                                            @else
                                                <label for="Deviation category">Initial Deviation category</label>
                                                <select id="Deviation_category" name="Deviation_category"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  value="{{ $data->Deviation_category }}" >
                                                    <option value="0">-- Select --</option>
                                                    <option @if ($data->Deviation_category == 'minor') selected @endif
                                                    value="minor">Minor</option>
                                                    <option  @if ($data->Deviation_category == 'major') selected @endif 
                                                    value="major">Major</option>
                                                    <option @if ($data->Deviation_category == 'critical') selected @endif
                                                    value="critical">Critical</option>
                                                </select>
                                            @endif 

                                            @error('Deviation_category')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                    </div>
                                </div>

                                        @if($data->stage == 3)
                                            <div class="col-md-12">
                                                <div class="group-input">
                                                    <label for="Justification for  categorization">Justification for categorization <span class="text-danger">*</span></label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="summernote Justification_for_categorization" name="Justification_for_categorization"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-5" required>{{ $data->Justification_for_categorization }}</textarea>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-12">
                                                <div class="group-input">
                                                    <label for="Justification for  categorization">Justification for categorization</label>
                                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                    <textarea class="summernote Justification_for_categorization" name="Justification_for_categorization"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-5">{{ $data->Justification_for_categorization }}</textarea>
                                                </div>
                                            </div>
                                        @endif 
                                        @error('Justification_for_categorization')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Investigation required">Investigation Required?  <span class="text-danger">*</span></label>
                                        <select name="Investigation_required"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Investigation_required"    value="{{ $data->Investigation_required }}" >
                                            <option value="0">-- Select --</option>
                                            <option @if ($data->Investigation_required == 'yes') selected @endif
                                             value='yes'>Yes</option>
                                            <option  @if ($data->Investigation_required == 'no') selected @endif 
                                            value='no'>No</option>
                                        </select>
                                        @error('Investigation_required')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                                <label for="Investigation Details">Investigation Details <span id="asteriskInviinvestication" style="display: {{ $data1->Investigation_required == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                <textarea class="summernote Investigation_Details" name="Investigation_Details"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="Investigation_Details" id="summernote-6">{{ $data->Investigation_Details }}</textarea>
                                                {{-- <span class="error-message" style="color: red; display: none;">Please fill out this field.</span> --}}
                                            
                                        <script>

                                            document.addEventListener('DOMContentLoaded', function () {
                                                var selectField = document.getElementById('Investigation_required');
                                                var inputsToToggle = [];
        
                                                // Add elements with class 'facility-name' to inputsToToggle
                                                var facilityNameInputs = document.getElementsByClassName('Investigation_Details');
                                                for (var i = 0; i < facilityNameInputs.length; i++) {
                                                    inputsToToggle.push(facilityNameInputs[i]);
                                                }
        
                                                                                
                                                selectField.addEventListener('change', function () {
                                                    var isRequired = this.value === 'yes';
        
                                                    inputsToToggle.forEach(function (input) {
                                                        input.required = isRequired;
                                                        console.log(input.required, isRequired, 'input req');
                                                    });
        
                                                    // Show or hide the asterisk icon based on the selected value
                                                    var asteriskIcon = document.getElementById('asteriskInviinvestication');
                                                    asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                                });
                                            });
                                        </script>  
                                        @error('Investigation_Details')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror                                    
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification">Customer Notification Required ? <span
                                            class="text-danger">*</span></label>
                                        <select name="Customer_notification"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Customer_notification" value="{{ $data->Customer_notification }}" >
                                            <option value="0">-- Select --</option>
                                            <option  @if ($data->Customer_notification == 'yes') selected @endif
                                             value="yes">Yes</option>
                                            <option  @if ($data->Customer_notification == 'no') selected @endif 
                                            value="no">No</option>
                                            <option  @if ($data->Customer_notification == 'na') selected @endif 
                                                value="na">Na</option>
                                        </select>
                                        @error('Customer_notification')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="group-input">
                                        @php
                                            $customers = DB::table('customer-details')->get();
                                            // dd($data->customer);
                                        @endphp
                                            <label for="customers">Customers <span id="asterikCustomer_notification" style="display: {{ $data->Customer_notification == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                            <select name="customers"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="customers" id="customers" required>
                                                <option value="0"> -- Select --</option>
                                                @foreach ($customers as $data1)
                                                <option  @if ($data->customers == $data1->id) selected @endif
                                                    value="{{ $data1->id }}">{{ $data1->customer_name }}</option>
                                                {{-- <option {{ $data->customers != null && $data->customers == $data->id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->customer_name }}</option> --}}
                                            @endforeach
                                            </select>
                                            @error('customers')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                    </div>
                                    <script>

                                        document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Customer_notification');
                                            var inputsToToggle = [];
    
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('customers');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
    
                                                                            
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
    
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                    console.log(input.required, isRequired, 'input req');
                                                });
    
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asterikCustomer_notification');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                    </script>                                      
    
                                </div>
                                <div class="col-1">
                                    <div class="group-input">
                                        <!-- <label for="Comments(If Any)">Customers</label> -->
                                        <button style="margin-top: 21px; border: 1px solid gray; background: #6f81dd; color: #fff;" type="button" class="btn b" data-bs-toggle="modal" data-bs-target="#myModal">
                                              Customer
                                    </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                        <div class="group-input">
                                            <label for="related_records">Related Records<span class="text-danger d-none"></span></label>
                                            <select  multiple id="related_records"  placeholder="Select Facility Name"
                                            data-search="false" data-silent-initial-value-set="true" name="related_records[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} >
                                                <option value="">--Select---</option>
                                                @foreach ($pre as $prix)
                                                    <option value="{{ $prix->id }}" {{ in_array($prix->id, explode(',', $data->Related_Records1)) ? 'selected' : '' }}>
                                                        {{ Helpers::getDivisionName($prix->division_id) }}/Deviation/{{ Helpers::year($prix->created_at) }}/{{ Helpers::record($prix->record) }}/{{$prix->short_description}}
                                                    </option>
                                                @endforeach                                         
                                            </select>
                                        </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="QAInitialRemark">QA Initial Remarks <span  class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea @if ($data->stage==3) required @endif class="summernote QAInitialRemark" name="QAInitialRemark"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-6">{{ $data->QAInitialRemark }}</textarea>
                                    </div>
                                    @error('QAInitialRemark')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="QA Initial Attachments">QA Initial Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Initial_attachment">
                                                @if ($data->Initial_attachment)
                                                    @foreach(json_decode($data->Initial_attachment) as $file)
                                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                            <b>{{ $file }}</b>
                                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                            <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                        </h6>
                                                    @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Initial_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                    oninput="addMultipleFiles(this, 'Initial_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            @else
                            <div class="row">
                                <div style="margin-bottom: 0px;" class="col-lg-12 new-date-data-field ">
                                    <div class="group-input input-date">
                                        @if($data->stage == 3)
                                            <label for="Deviation category">Initial Deviation category <span class="text-danger">*</span></label>
                                            <select disabled id="Deviation_category" name="Deviation_category"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  value="{{ $data->Deviation_category }}" >
                                                <option value="0">-- Select --</option>
                                                <option @if ($data->Deviation_category == 'minor') selected @endif
                                                value="minor">Minor</option>
                                                <option  @if ($data->Deviation_category == 'major') selected @endif 
                                                value="major">Major</option>
                                                <option @if ($data->Deviation_category == 'critical') selected @endif
                                                value="critical">Critical</option>
                                            </select>
                                            @else
                                            <div class="group-input">
                                                <label for="Deviation category">Initial Deviation category</label>
                                                <select disabled id="Deviation_category" name="Deviation_category"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  value="{{ $data->Deviation_category }}" >
                                                    <option value="0">-- Select --</option>
                                                    <option @if ($data->Deviation_category == 'minor') selected @endif
                                                    value="minor">Minor</option>
                                                    <option  @if ($data->Deviation_category == 'major') selected @endif 
                                                    value="major">Major</option>
                                                    <option @if ($data->Deviation_category == 'critical') selected @endif
                                                    value="critical">Critical</option>
                                                </select>
                                            </div>
                                        @endif 
                                        @error('Deviation_category')
                                            <div class="text-danger">{{  $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Justification for  categorization">Justification for  categorization</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea disabled class="summernote" name="Justification_for_categorization"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-5">{{ $data->Justification_for_categorization }}</textarea>
                                    </div>
                                    @error('Justification_for_categorization')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Investigation required">Investigation  Required?</label>
                                        <select disabled name="Investigation_required" id="Investigation_required"    value="{{ $data->Investigation_required }}" >
                                            <option value="0">-- Select --</option>
                                            <option @if ($data->Investigation_required == 'yes') selected @endif
                                             value='yes'>Yes</option>
                                            <option  @if ($data->Investigation_required == 'no') selected @endif 
                                            value='no'>No</option>
                                        </select>
                                        @error('Investigation_required')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                                <label for="Investigation Details">Investigation Details <span id="asteriskInviinvestication" style="display: none" class="text-danger">*</span></label>
                                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                                <textarea disabled class="summernote Investigation_Details" name="Investigation_Details"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="Investigation_Details" id="summernote-6">{{ $data->Investigation_Details }}</textarea>
                                                {{-- <span class="error-message" style="color: red; display: none;">Please fill out this field.</span> --}}
                                                @error('Investigation_Details')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                        <script>

                                            document.addEventListener('DOMContentLoaded', function () {
                                                var selectField = document.getElementById('Investigation_required');
                                                var inputsToToggle = [];
        
                                                // Add elements with class 'facility-name' to inputsToToggle
                                                // var facilityNameInputs = document.getElementsByClassName('Investigation_Details');
                                                // for (var i = 0; i < facilityNameInputs.length; i++) {
                                                //     inputsToToggle.push(facilityNameInputs[i]);
                                                // }
        
                                                                                
                                                selectField.addEventListener('change', function () {
                                                    var isRequired = this.value === 'yes';
        
                                                    // inputsToToggle.forEach(function (input) {
                                                    //     input.required = isRequired;
                                                    //     console.log(input.required, isRequired, 'input req');
                                                    // });
        
                                                    // Show or hide the asterisk icon based on the selected value
                                                    var asteriskIcon = document.getElementById('asteriskInviinvestication');
                                                    asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                                });
                                            });
                                        </script>                                      
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification">Customer Notification Required ? </label>
                                        <select disabled name="Customer_notification"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Customer_notification" value="{{ $data->Customer_notification }}" >
                                            <option value="0">-- Select --</option>
                                            <option  @if ($data->Customer_notification == 'yes') selected @endif
                                             value="yes">Yes</option>
                                            <option  @if ($data->Customer_notification == 'no') selected @endif 
                                            value="no">No</option>
                                            <option  @if ($data->Customer_notification == 'na') selected @endif 
                                                value="na">Na</option>
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="group-input">
                                        @php
                                            $customers = DB::table('customer-details')->get();
                                            // dd($data->customer);
                                        @endphp
                                            <label for="customers">Customers <span id="asterikCustomer_notification" style="display: none" class="text-danger">*</span></label>
                                            <select disabled name="customers"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="customers" required>
                                                <option value="0"> -- Select --</option>
                                                @foreach ($customers as $data1)
                                                <option  @if ($data->customers == $data1->id) selected @endif
                                                    value="{{ $data1->id }}">{{ $data1->customer_name }}</option>
                                                {{-- <option {{ $data->customers != null && $data->customers == $data->id ? 'selected' : '' }} value="{{ $data->id }}">{{ $data->customer_name }}</option> --}}
                                            @endforeach
                                            </select>
                                    </div>
                                    <script>

                                        document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Customer_notification');
                                            var inputsToToggle = [];
    
    
                                                                            
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
    
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asterikCustomer_notification');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                    </script>                                      
    
                                </div>
                                <div class="col-1">
                                    <div class="group-input">
                                        <!-- <label for="Comments(If Any)">Customers</label> -->
                                        <button disabled style="margin-top: 21px; border: 1px solid gray; background: #6f81dd; color: #fff;" type="button" class="btn b" data-bs-toggle="modal" data-bs-target="#myModal">
                                              Customer
                                    </button>
                                    </div>
                                </div>
                                <div class="col-12">
                                        <div class="group-input">
                                            <label for="related_records">Related Records<span class="text-danger d-none"></span></label>
                                            <select  multiple name="related_records[]" {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} placeholder="Select Facility Name"
                                                data-search="false" data-silent-initial-value-set="true" id="related_records" disabled>
                                                <option value="">--Select---</option>
                                                @foreach ($pre as $prix)
                                                    <option value="{{ $prix->id }}" {{ in_array($prix->id, explode(',', $data->Related_Records1)) ? 'selected' : '' }}>
                                                        {{ Helpers::getDivisionName($prix->division_id) }}/Deviation/{{ Helpers::year($prix->created_at) }}/{{ Helpers::record($prix->record) }}/{{$prix->short_description}}
                                                    </option>
                                                @endforeach                                         
                                            </select>
                                        </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="QAInitialRemark">QA Initial Remarks</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea readonly class="summernote" name="QAInitialRemark"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-6">{{ $data->QAInitialRemark }}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="QA Initial Attachments">QA Initial Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Initial_attachment">
                                                @if ($data->Initial_attachment)
                                                @foreach(json_decode($data->Initial_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input disabled type="file" id="myfile" name="Initial_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                    oninput="addMultipleFiles(this, 'Initial_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            <div class="button-block">
                                <button type="submit"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="ChangesaveButton03"  class="saveAuditFormBtn d-flex" style="align-items: center;">
                                    <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                      Save
                                </button>
                                    {{-- <a href="/rcms/qms-dashboard">
                                        <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="backButton">Back</button>
                                    </a> --}}
                                <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white"> Exit </a> </button>
                            </div>
                        </div>
                    </div>
                    <script>
                        var checkValue = false;
                        $(document).ready(function () {
                            $('#Deviation_category').change(function () {
                                if ( $(this).val() === 'major' || $(this).val() === 'critical' ) {
                                    checkValue = true;
                                    $('#Investigation_required').val('yes').prop('disabled', true);
                                    $('#Customer_notification').val('yes').prop('disabled', true);
                                    var asteriskIcon = document.getElementById('asteriskInviinvestication');
                                    var asteriskIcon2 = document.getElementById('asterikCustomer_notification');
                                                    asteriskIcon.style.display = 'inline';
                                                    asteriskIcon2.style.display = 'inline';
                                } else {
                                    $('#Customer_notification').prop('disabled', false);
                                    $('#Investigation_required').prop('disabled', false);
                                    var asteriskIcon = document.getElementById('asteriskInviinvestication');
                                    var asteriskIcon2 = document.getElementById('asterikCustomer_notification');
                                                    asteriskIcon.style.display =  'none';
                                                    asteriskIcon2.style.display =  'none';
                                }
                            });
                        });

                        // Enable the field before submitting the form
                        $('form').submit(function () {
                            $('#Investigation_required').prop('disabled', false);
                            $('#Customer_notification').prop('disabled', false);
                        });

                    </script>
                    
                    <!-- CFT -->
                    <div id="CCForm7" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                            <div class="sub-head">
                            Production
                           </div>
                           
                            @php
                                    $data1 = DB::table('deviationcfts')->where('deviation_id', $data->id)->first();
                            @endphp
                            @if($data->stage==3 || $data->stage==4)
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Review"> Production Review Required ? <span  class="text-danger">*</span></label>
                                    <select name="Production_Review" id="Production_Review" @if ($data->stage==4) disabled @endif @if ($data->stage==3) required @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Production_Review == 'yes') selected @endif
                                         value='yes'>Yes</option>
                                        <option  @if ($data1->Production_Review == 'no') selected @endif 
                                        value='no'>No</option>
                                        <option  @if ($data1->Production_Review == 'na') selected @endif 
                                            value='na'>NA</option>
                                    </select>
                              
                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production notification">Production Person  <span id="asteriskProduction" style="display: {{ $data1->Production_Review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span>
                                    </label>
                                    <select @if ($data->stage==4) disabled @endif name="Production_person" class="Production_person" id="Production_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if ($user->id == $data1->Production_person) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Production assessment">Impact Assessment (By Production)  <span id="asteriskProduction1" style="display: {{ $data1->Production_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea @if ($data1->Production_Review == 'yes' && $data->stage == 4) required @endif class="summernote Production_assessment"  @if ($data->stage==3 || Auth::user()->id != $data1->Production_person) readonly @endif name="Production_assessment" id="summernote-17">{{ $data1->Production_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Production feedback">Production Feedback  <span id="asteriskProduction2" style="display: {{ $data1->Production_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea class="summernote Production_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Production_person) readonly @endif name="Production_feedback" id="summernote-18" @if ($data1->Production_Review == 'yes' && $data->stage == 4) required @endif>{{ $data1->Production_feedback }}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="production attachment">Production Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="production_attachment">
                                            @if ($data1->production_attachment)
                                            @foreach(json_decode($data1->production_attachment) as $file)
                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                            </h6>
                                       @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="production_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}
                                                oninput="addMultipleFiles(this, 'production_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                               <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Production Review Completed By">Production Review Completed By</label>
                                    {{-- <input disabled type="text" name="production_by" id="production_by" placeholder="Production Review Completed By" value={{ $data1->Production_by }}> --}}
                                    <input readonly type="text" value="{{ $data1->Production_by }}" name="production_by"{{ $data->stage == 0 || $data->stage == 7 ? 'readonly' : '' }} id="production_by">

                                
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Review Completed On">Production Review Completed On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date"id="production_on" name="production_on"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} value="{{ $data1->production_on }}" >
                                </div>
                            </div>
                            <script>

                                document.addEventListener('DOMContentLoaded', function () {
                                    var selectField = document.getElementById('Production_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Production_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Production_feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                
                                    selectField.addEventListener('change', function () {
                                        var isRequired = this.value === 'yes';
                                        console.log(this.value, isRequired, 'value');

                                        inputsToToggle.forEach(function (input) {
                                            input.required = isRequired;
                                            console.log(input.required, isRequired, 'input req');
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskProduction');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                            </script>
                             {{-- Else conditon for other roles fields all fields disabled --}}
                             @else
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Review">Production Review Required ?</label>
                                    <select name="Production_Review" disabled id="Production_Review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Production_Review == 'yes') selected @endif
                                         value='yes'>Yes</option>
                                        <option  @if ($data1->Production_Review == 'no') selected @endif 
                                        value='no'>No</option>
                                        <option  @if ($data1->Production_Review == 'na') selected @endif 
                                            value='na'>NA</option>
                                    </select>
                              
                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 22, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production notification">Production Person  <span id="asteriskInvi11" style="display: none" class="text-danger">*</span></label>
                                    <select name="Production_person" disabled id="Production_person">
                                        <option value="0">-- Select --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" @if ($user->id == $data1->Production_person) selected @endif>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div> 
                            @if ($data->stage==4)
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Production assessment">Impact Assessment (By Production)  <span id="asteriskInvi12" style="display: none" class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea class="summernote" name="Production_assessment" id="summernote-17">{{ $data1->Production_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Production feedback">Production Feedback  <span id="asteriskInvi22" style="display: none" class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea class="summernote" name="Production_feedback" id="summernote-18">{{ $data1->Production_feedback }}</textarea>
                                </div>
                            </div>
                            @else
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Production assessment">Impact Assessment (By Production)  <span id="asteriskInvi12" style="display: none" class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea disabled class="summernote" name="Production_assessment" id="summernote-17">{{ $data1->Production_assessment }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Production feedback">Production Feedback  <span id="asteriskInvi22" style="display: none" class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea disabled class="summernote" name="Production_feedback" id="summernote-18">{{ $data1->Production_feedback }}</textarea>
                                </div>
                            </div>
                            @endif
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="production attachment">Production Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="production_attachment">
                                            @if ($data1->production_attachment)
                                            @foreach(json_decode($data1->production_attachment) as $file)
                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                            </h6>
                                       @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input disabled {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="production_attachment[]"
                                                oninput="addMultipleFiles(this, 'production_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3"> 
                                <div class="group-input">
                                    <label for="Production Review Completed By">Production Review Completed By</label>
                                    {{-- <input disabled type="text" name="production_by" id="production_by" placeholder="Production Review Completed By" value={{ $data1->Production_by }}> --}}
                                    <input readonly type="text" value="{{ $data1->Production_by }}" name="production_by" id="production_by">

                                
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Production Review Completed On">Production Review Completed On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input readonly type="date"id="production_on" name="production_on" value="{{ $data1->production_on }}" >
                                </div>
                            </div>
                            @endif
                            
                            {{-- Warehoure fields  --}}
                                <div class="sub-head">
                                Warehouse
                           </div>
                           @if($data->stage==3 || $data->stage==4)
                           <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Warehouse Review Required">Warehouse Review Required ? <span  class="text-danger">*</span></label>
                                <select @if ($data->stage==3) required @endif name="Warehouse_review" id="Warehouse_review"  @if ($data->stage==4) disabled @endif>
                                    <option value="0">-- Select --</option>
                                    <option @if ($data1->Warehouse_review == 'yes') selected @endif
                                        value="yes">Yes</option>
                                       <option  @if ($data1->Warehouse_review == 'no') selected @endif 
                                       value="no">No</option>
                                       <option  @if ($data1->Warehouse_review == 'na') selected @endif 
                                           value="na">NA</option>

                                </select>
                          
                            </div>
                        </div>
                        @php
                        $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 23, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('user_id')->toArray();
                        $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                    @endphp
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Warehouse Person">Warehouse Person  <span id="asteriskware" style="display: {{ $data1->Warehouse_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                <select name="Warehouse_notification" class="Warehouse_notification" id="Warehouse_notification" value="{{ $data1->Warehouse_notification}}" @if ($data->stage==4) disabled @endif>
                                    <option value=""> -- Select --</option>
                                    @foreach ($users as $user)
                                    <option {{ $data1->Warehouse_notification == $user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                          
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Impact Assessment1">Impact Assessment (By Warehouse) <span id="asteriskware2" style="display: {{ $data1->Warehouse_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea @if ($data1->Warehouse_review == 'yes' && $data->stage == 4) required @endif class="summernote Warehouse_assessment" name="Warehouse_assessment" id="summernote-19" @if ($data->stage==3  || Auth::user()->id != $data1->Warehouse_notification) readonly @endif>{{ $data1->Warehouse_assessment }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Warehouse Feedback">Warehouse Feedback <span id="asteriskware3" style="display: {{ $data1->Warehouse_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea @if ($data1->Warehouse_review == 'yes' && $data->stage == 4) required @endif class="summernote Warehouse_feedback" name="Warehouse_feedback" id="summernote-20" @if ($data->stage==3  || Auth::user()->id != $data1->Warehouse_notification) readonly @endif>{{ $data1->Warehouse_feedback }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Warehouse attachment">Warehouse Attachments</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="Warehouse_attachment">
                                        @if ($data1->Warehouse_attachment)
                                        @foreach(json_decode($data1->Warehouse_attachment) as $file)
                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                            <b>{{ $file }}</b>
                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                            <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                        </h6>
                                   @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Warehouse_attachment[]"
                                            oninput="addMultipleFiles(this, 'Warehouse_attachment')"
                                            multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                    var selectField = document.getElementById('Warehouse_review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Warehouse_notification');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                                    // var facilityNameInputs = document.getElementsByClassName('Warehouse_assessment');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                                    // var facilityNameInputs = document.getElementsByClassName('Warehouse_feedback');
                                    // for (var i = 0; i < facilityNameInputs.length; i++) {
                                    //     inputsToToggle.push(facilityNameInputs[i]);
                                    // }
                
                                    selectField.addEventListener('change', function () {
                                        var isRequired = this.value === 'yes';

                                        inputsToToggle.forEach(function (input) {
                                            input.required = isRequired;
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskware');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                        </script>
                        
                        <div class="col-md-6 mb-3">
                            <div class="group-input">
                                <label for="Warehouse Review Completed By">Warehouse Review Completed By</label>
                                <input disabled type="text" value="{{ $data1->Warehouse_by }}" name="Warehouse_by" id="Warehouse_by">
                                {{-- <input disabled   type="text" value={{ $data1->Warehouse_by }} name="Warehouse_by" placeholder="Warehouse Review Completed By" id="Warehouse_by" > --}}
                            
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <div class="group-input">
                                <label for="Warehouse Review Completed On">Warehouse Review Completed On</label>
                                <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                <input type="date"id="Warehouse_on" name="Warehouse_on" value="{{ $data1->Warehouse_on }}" >
                            </div>
                        </div>
                           @else
                           <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Warehouse Review Required">Warehouse Review Required ?</label>
                                <select disabled name="Warehouse_review" id="Warehouse_review">
                                    <option value="0">-- Select --</option>
                                    <option @if ($data1->Warehouse_review == 'yes') selected @endif
                                        value="yes">Yes</option>
                                       <option  @if ($data1->Warehouse_review == 'no') selected @endif 
                                       value="no">No</option>
                                       <option  @if ($data1->Warehouse_review == 'na') selected @endif 
                                           value="na">NA</option>

                                </select>
                          
                            </div>
                        </div>
                        @php
                        $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 23, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('user_id')->toArray();
                        $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                    @endphp
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Warehouse Person">Warehouse Person  </label>
                                <select disabled name="Warehouse_notification" id="Warehouse_notification" value="{{ $data1->Warehouse_notification}}" >
                                    <option value=""> -- Select --</option>
                                    @foreach ($users as $user)
                                    <option {{ $data1->Warehouse_notification == $user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                          
                            </div>
                        </div>
                       
                        @if ($data->stage==4)
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Impact Assessment1">Impact Assessment (By Warehouse)</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea class="summernote" name="Warehouse_assessment" id="summernote-19">{{ $data1->Warehouse_assessment }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Warehouse Feedback">Warehouse Feedback</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea class="summernote" name="Warehouse_feedback" id="summernote-20">{{ $data1->Warehouse_feedback }}</textarea>
                            </div>
                        </div>
                        </div>
                        @else
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Impact Assessment1">Impact Assessment (By Warehouse)</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea disabled class="summernote" name="Warehouse_assessment" id="summernote-19">{{ $data1->Warehouse_assessment }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Warehouse Feedback">Warehouse Feedback</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea disabled  class="summernote" name="Warehouse_feedback" id="summernote-20">{{ $data1->Warehouse_feedback }}</textarea>
                            </div>
                        </div>
                        @endif
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Warehouse attachment">Warehouse Attachments</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="Warehouse_attachment">
                                        @if ($data1->Warehouse_attachment)
                                        @foreach(json_decode($data1->Warehouse_attachment) as $file)
                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                            <b>{{ $file }}</b>
                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                            <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                        </h6>
                                   @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input disabled {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Warehouse_attachment[]"
                                            oninput="addMultipleFiles(this, 'Warehouse_attachment')"
                                            multiple>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                        <div class="col-md-6 mb-3">
                            <div class="group-input">
                                <label for="Warehouse Review Completed By">Warehouse Review Completed By</label>
                                <input disabled type="text" value="{{ $data1->Warehouse_by }}" name="Warehouse_by" id="Warehouse_by">
                                {{-- <input disabled   type="text" value={{ $data1->Warehouse_by }} name="Warehouse_by" placeholder="Warehouse Review Completed By" id="Warehouse_by" > --}}
                            
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Warehouse Review Completed On">Warehouse Review Completed On</label>
                                <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                <input disabled type="date"id="Warehouse_on" name="Warehouse_on" value="{{ $data1->Warehouse_on }}" >
                            </div>
                        </div>
                           @endif
                           
                                <div class="sub-head">
                                Quality Control
                           </div>
                           @if($data->stage==3 || $data->stage==4)
                           <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Control Review Required">Quality Control Review Required? <span  class="text-danger">*</span></label>
                                <select @if ($data->stage==3) required @endif name="Quality_review" id="Quality_review" @if ($data->stage==4) disabled @endif>
                                    <option value="">-- Select --</option>
                                    <option @if ($data1->Quality_review == 'yes') selected @endif
                                        value="yes">Yes</option>
                                       <option  @if ($data1->Quality_review == 'no') selected @endif 
                                       value="no">No</option>
                                       <option  @if ($data1->Quality_review == 'na') selected @endif 
                                           value="na">NA</option>

                                </select>
                          
                            </div>
                        </div>
                        @php
                        $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 24, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('user_id')->toArray();
                        $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                    @endphp
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Control Person">Quality Control Person <span id="asteriskQC" style="display: {{ $data1->Quality_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                <select name="Quality_Control_Person" class="Quality_Control_Person" id="Quality_Control_Person" @if ($data->stage==4) disabled @endif>
                                    <option value="">-- Select --</option>
                                    @foreach ($users as $user)
                                    <option {{ $data1->Quality_Control_Person == $user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach

                                </select>
                          
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Impact Assessment2">Impact Assessment (By Quality Control) <span id="asteriskQC1" style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea @if ($data1->Quality_review == 'yes' && $data->stage == 4) required @endif class="summernote Quality_Control_assessment" name="Quality_Control_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->Quality_Control_Person) readonly @endif id="summernote-21">{{ $data1->Quality_Control_assessment }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Quality Control Feedback">Quality Control Feedback <span id="asteriskQC2" style="display: {{ $data1->Quality_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea @if ($data1->Quality_review == 'yes' && $data->stage == 4) required @endif class="summernote Quality_Control_feedback" name="Quality_Control_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Quality_Control_Person) readonly @endif id="summernote-22">{{ $data1->Quality_Control_feedback }}</textarea>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                    var selectField = document.getElementById('Quality_review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('Quality_Control_Person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                            
                                    selectField.addEventListener('change', function () {
                                        var isRequired = this.value === 'yes';

                                        inputsToToggle.forEach(function (input) {
                                            input.required = isRequired;
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskQC');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                        </script>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Quality Control Attachments">Quality Control Attachments</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="Quality_Control_attachment">
                                        @if ($data1->Quality_Control_attachment)
                                        @foreach(json_decode($data1->Quality_Control_attachment) as $file)
                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                            <b>{{ $file }}</b>
                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                            <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                        </h6>
                                   @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Quality_Control_attachment[]"
                                            oninput="addMultipleFiles(this, 'Quality_Control_attachment')"
                                            multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="group-input">
                                <label for="Quality Control Review Completed By">Quality Control Review Completed By</label>
                                {{-- <input type="text" name="Quality_Control_by" id="Quality_Control_by" value="{{ $data1->Quality_Control_by }}" disabled> --}}
                                <input disabled type="text" value="{{ $data1->Quality_Control_by }}" name="Quality_Control_by" id="Quality_Control_by">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Control Review Completed On">Quality Control Review Completed On</label>
                                <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                <input type="date"id="Quality_Control_on" name="Quality_Control_on" value="{{ $data1->Quality_Control_on }}" >
                            </div>
                        </div>
                          <div class="sub-head">
                          Quality Assurance
                   </div>
                   <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Assurance Review Required">Quality Assurance Review Required ? <span  class="text-danger">*</span></label>
                                <select @if ($data->stage==3) required @endif name="Quality_Assurance_Review" id="Quality_Assurance_Review" @if ($data->stage==4) disabled @endif >
                                    <option value="">-- Select --</option>
                                    <option @if ($data1->Quality_Assurance_Review == 'yes') selected @endif
                                        value="yes">Yes</option>
                                       <option  @if ($data1->Quality_Assurance_Review == 'no') selected @endif 
                                       value="no">No</option>
                                       <option  @if ($data1->Quality_Assurance_Review == 'na') selected @endif 
                                           value="na">NA</option>
                                </select>
                            </div>
                        </div>
                        @php
                            $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 26, 'q_m_s_divisions_id' => $data->division_id])->get();
                            $userRoleIds = $userRoles->pluck('user_id')->toArray();
                            $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                        @endphp
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Assurance Person">Quality Assurance Person <span id="asteriskQQA" style="display: {{ $data1->Quality_Assurance_Review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                <select name="QualityAssurance_person" class="QualityAssurance_person" id="QualityAssurance_person" @if ($data->stage==4) disabled @endif>
                                    <option value="">-- Select --</option>
                                    @foreach ($users as $user)
                                    <option {{ $data1->QualityAssurance_person == $user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Impact Assessment3">Impact Assessment (By Quality Assurance) <span id="asteriskQQA1" style="display: {{ $data1->Quality_Assurance_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea @if ($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif class="summernote QualityAssurance_assessment" name="QualityAssurance_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->QualityAssurance_person) readonly @endif id="summernote-23">{{ $data1->QualityAssurance_assessment }}</textarea>
                            </div>
                        </div>   
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Quality Assurance Feedback">Quality Assurance Feedback <span id="asteriskQQA2" style="display: {{ $data1->Quality_Assurance_Review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea @if ($data1->Quality_Assurance_Review == 'yes' && $data->stage == 4) required @endif  class="summernote QualityAssurance_feedback" name="QualityAssurance_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->QualityAssurance_person) readonly @endif id="summernote-24">{{ $data1->QualityAssurance_feedback }}</textarea> 
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function () {
                                    var selectField = document.getElementById('Quality_Assurance_Review');
                                    var inputsToToggle = [];

                                    // Add elements with class 'facility-name' to inputsToToggle
                                    var facilityNameInputs = document.getElementsByClassName('QualityAssurance_person');
                                    for (var i = 0; i < facilityNameInputs.length; i++) {
                                        inputsToToggle.push(facilityNameInputs[i]);
                                    }
                
                                    selectField.addEventListener('change', function () {
                                        var isRequired = this.value === 'yes';

                                        inputsToToggle.forEach(function (input) {
                                            input.required = isRequired;
                                        });

                                        // Show or hide the asterisk icon based on the selected value
                                        var asteriskIcon = document.getElementById('asteriskQQA');
                                        asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                    });
                                });
                        </script>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Quality Assurance Attachments">Quality Assurance Attachments</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="Quality_Assurance_attachment">
                                        @if ($data1->Quality_Assurance_attachment)
                                        @foreach(json_decode($data1->Quality_Assurance_attachment) as $file)
                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                            <b>{{ $file }}</b>
                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                            <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                        </h6>
                                   @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Quality_Assurance_attachment[]"
                                            oninput="addMultipleFiles(this, 'Quality_Assurance_attachment')"
                                            multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="group-input">
                                <label for="Quality Assurance Review Completed By">Quality Assurance Review Completed By</label>
                                <input type="text" name="QualityAssurance_by" id="QualityAssurance_by" value="{{$data1->QualityAssurance_by}}" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Assurance Review Completed On">Quality Assurance Review Completed On</label>
                                <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                <input type="date"id="QualityAssurance_on" name="QualityAssurance_on" value="{{ $data1->QualityAssurance_on }}" >
                            </div>
                        </div>
                        <div class="sub-head">
                            Engineering
                       </div>
                       <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Customer notification">Engineering Review Required ? <span  class="text-danger">*</span></label>
                                    <select @if ($data->stage==3) required @endif name="Engineering_review"  id="Engineering_review" @if ($data->stage==4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Engineering_review == 'yes') selected @endif
                                            value="yes">Yes</option>
                                           <option  @if ($data1->Engineering_review == 'no') selected @endif 
                                           value="no">No</option>
                                           <option  @if ($data1->Engineering_review == 'na') selected @endif 
                                               value="na">NA</option>
                                    </select>
                              
                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 25, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Customer notification">Engineering Person <span id="asteriskEP" style="display: {{ $data1->Engineering_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                    <select name="Engineering_person" class="Engineering_person" id="Engineering_person" @if ($data->stage==4) disabled @endif>
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                        <option {{ $data1->Engineering_person == $user->id ? 'selected' : '' }}
                                            value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Impact Assessment4">Impact Assessment (By Engineering) <span id="asteriskEP1" style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif class="summernote Engineering_assessment" name="Engineering_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->Engineering_person) readonly @endif id="summernote-25" >{{$data1->Engineering_assessment}}</textarea>
                                </div>
                            </div>  
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Engineering Feedback">Engineering  Feedback <span id="asteriskEP2" style="display: {{ $data1->Engineering_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea @if ($data1->Engineering_review == 'yes' && $data->stage == 4) required @endif class="summernote Engineering_feedback" name="Engineering_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Engineering_person) readonly @endif id="summernote-26" >{{$data1->Engineering_feedback}}</textarea>
                                </div>
                            </div>
                            <script>
                                document.addEventListener('DOMContentLoaded', function () {
                                        var selectField = document.getElementById('Engineering_review');
                                        var inputsToToggle = [];
    
                                        // Add elements with class 'facility-name' to inputsToToggle
                                        var facilityNameInputs = document.getElementsByClassName('Engineering_person');
                                        for (var i = 0; i < facilityNameInputs.length; i++) {
                                            inputsToToggle.push(facilityNameInputs[i]);
                                        }
                    
                                        selectField.addEventListener('change', function () {
                                            var isRequired = this.value === 'yes';
    
                                            inputsToToggle.forEach(function (input) {
                                                input.required = isRequired;
                                            });
    
                                            // Show or hide the asterisk icon based on the selected value
                                            var asteriskIcon = document.getElementById('asteriskEP');
                                            asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                        });
                                    });
                            </script>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">Engineering  Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Engineering_attachment">
                                            @if ($data1->Engineering_attachment)
                                            @foreach(json_decode($data1->Engineering_attachment) as $file)
                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                            </h6>
                                       @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Engineering_attachment[]"
                                                oninput="addMultipleFiles(this, 'Engineering_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Engineering Review Completed By">Engineering Review Completed By</label>
                                    {{-- <input type="text" name="Engineering_by" id="Engineering_by" value="Engineering_by" disabled> --}}
                                    <input disabled type="text" value="{{ $data1->Engineering_by }}" name="Engineering_by" id="Engineering_by">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Engineering Review Completed On">Engineering Review Completed On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input type="date" id="Engineering_on" name="Engineering_on" value="{{ $data1->Engineering_on }}" >
                                </div>
                            </div>
                            <div class="sub-head">
                                Analytical Development Laboratory
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Review Required">Analytical Development Laboratory Review Required ? <span  class="text-danger">*</span></label>
                                        <select @if ($data->stage==3) required @endif name="Analytical_Development_review" id="Analytical_Development_review" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Analytical_Development_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Analytical_Development_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Analytical_Development_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 27, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Person"> Analytical Development Laboratory Person <span id="asteriskAD" style="display: {{ $data1->Analytical_Development_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Analytical_Development_person" class="Analytical_Development_person" id="Analytical_Development_person" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Analytical_Development_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment5">Impact Assessment (By Analytical Development Laboratory) <span id="asteriskAD1" style="display: {{ $data1->Analytical_Development_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Analytical_Development_review == 'yes' && $data->stage == 4) required @endif class="summernote Analytical_Development_assessment" name="Analytical_Development_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->Analytical_Development_person) readonly @endif id="summernote-27">{{$data1->Analytical_Development_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Feedback"> Analytical Development Laboratory Feedback <span id="asteriskAD2" style="display: {{ $data1->Analytical_Development_review == 'yes'  && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Analytical_Development_review == 'yes' && $data->stage == 4) required @endif class="summernote Analytical_Development_feedback" name="Analytical_Development_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Analytical_Development_person) readonly @endif id="summernote-28">{{$data1->Analytical_Development_feedback}}</textarea>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Analytical_Development_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Analytical_Development_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asteriskAD');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Analytical Development Laboratory Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Analytical_Development_attachment">
                                                @if ($data1->Analytical_Development_attachment)
                                                @foreach(json_decode($data1->Analytical_Development_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Analytical_Development_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Analytical_Development_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Review Completed By">Analytical Development Laboratory Review Completed By</label>
                                        {{-- <input type="text" name="Analytical_Development_by" id="Analytical_Development_by" value="Analytical_Development_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Analytical_Development_by }}" name="Analytical_Development_by" id="Analytical_Development_by">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Review Completed On">Analytical Development Laboratory Review Completed On</label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input type="date" id="Analytical_Development_on" name="Analytical_Development_on" value="{{ $data1->Analytical_Development_on }}" >
                                    </div>
                                </div>
                                <div class="sub-head">
                                Process Development Laboratory / Kilo Lab
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Process Development Laboratory"> Process Development Laboratory / Kilo Lab Review Required ? <span  class="text-danger">*</span></label>
                                        <select @if ($data->stage==3) required @endif name="Kilo_Lab_review" id="Kilo_Lab_review" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Kilo_Lab_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Kilo_Lab_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Kilo_Lab_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 28, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Process Development Laboratory"> Process Development Laboratory / Kilo Lab  Person <span id="asteriskPDL" style="display: {{ $data1->Kilo_Lab_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Kilo_Lab_person" class="Kilo_Lab_person" id="Kilo_Lab_person" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Kilo_Lab_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment6">Impact Assessment (By Process Development Laboratory / Kilo Lab) <span id="asteriskPDL1" style="display: {{ $data1->Kilo_Lab_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Kilo_Lab_review == 'yes' && $data->stage == 4) required @endif class="summernote Analytical_Development_assessment" name="Kilo_Lab_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->Kilo_Lab_person) readonly @endif id="summernote-29">{{$data1->Kilo_Lab_assessment}}</textarea>
                                    </div>
                                </div> 
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Kilo Lab Feedback"> Process Development Laboratory / Kilo Lab  Feedback <span id="asteriskPDL2" style="display: {{ $data1->Kilo_Lab_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Kilo_Lab_review == 'yes' && $data->stage == 4) required @endif class="summernote Analytical_Development_feedback" name="Kilo_Lab_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Kilo_Lab_person) readonly @endif id="summernote-30">{{$data1->Kilo_Lab_feedback}}</textarea>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Kilo_Lab_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Kilo_Lab_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asteriskPDL');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Process Development Laboratory / Kilo Lab Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Kilo_Lab_attachment">
                                                @if ($data1->Kilo_Lab_attachment)
                                                @foreach(json_decode($data1->Kilo_Lab_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Kilo_Lab_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Kilo_Lab_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Kilo Lab Review Completed By">Process Development Laboratory / Kilo Lab Review Completed By</label>
                                        {{-- <input type="text" name="Kilo_Lab_attachment_by" id="Kilo_Lab_attachment_by" value="Kilo_Lab_attachment_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Kilo_Lab_attachment_by }}" name="Kilo_Lab_attachment_by" id="Kilo_Lab_attachment_by">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Kilo Lab Review Completed On">Process Development Laboratory / Kilo Lab Review Completed On</label>
                                        <input type="date" id="Kilo_Lab_attachment_on" name="Kilo_Lab_attachment_on" value="{{ $data1->Kilo_Lab_attachment_on }}" >
                                    
                                    </div>
                                </div>
                                <div class="sub-head">
                                Technology Transfer / Design
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Design Review Required">Technology Transfer / Design Review Required ? <span  class="text-danger">*</span></label>
                                        <select @if ($data->stage==3) required @endif name="Technology_transfer_review" id="Technology_transfer_review" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Technology_transfer_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Technology_transfer_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Technology_transfer_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 29, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Design Person"> Technology Transfer / Design  Person <span id="asteriskTT" style="display: {{ $data1->Technology_transfer_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Technology_transfer_person" class="Technology_transfer_person" id="Technology_transfer_person" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Technology_transfer_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment7">Impact Assessment (By Technology Transfer / Design) <span id="asteriskTT1" style="display: {{ $data1->Technology_transfer_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Technology_transfer_review == 'yes' && $data->stage == 4) required @endif class="summernote Technology_transfer_assessment" name="Technology_transfer_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->Technology_transfer_person) readonly @endif id="summernote-31">{{$data1->Technology_transfer_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Design Feedback"> Technology Transfer / Design  Feedback <span id="asteriskTT2" style="display: {{ $data1->Technology_transfer_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Technology_transfer_review == 'yes' && $data->stage == 4) required @endif class="summernote Technology_transfer_feedback" name="Technology_transfer_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Technology_transfer_person) readonly @endif id="summernote-32">{{$data1->Technology_transfer_feedback}}</textarea>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Technology_transfer_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Technology_transfer_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asteriskTT');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Technology Transfer / Design Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Technology_transfer_attachment">
                                                @if ($data1->Technology_transfer_attachment)
                                                @foreach(json_decode($data1->Technology_transfer_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Technology_transfer_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Technology_transfer_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Technology Transfer / Design Review Completed By</label>
                                        {{-- <input type="text" name="Technology_transfer_by" id="Technology_transfer_by" value="Technology_transfer_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Technology_transfer_by }}" name="Technology_transfer_by" id="Technology_transfer_by">

                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Technology Transfer / Design Review Completed On</label>
                                        <input type="date" id="Technology_transfer_on" name="Technology_transfer_on" value="{{ $data1->Technology_transfer_on }}">
                                    </div>
                                </div>
                                <div class="sub-head">
                                Environment, Health & Safety
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Review Required">Environment, Health & Safety Review Required ? <span  class="text-danger">*</span></label>
                                        <select @if ($data->stage==3) required @endif name="Environment_Health_review" id="Environment_Health_review" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Environment_Health_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Environment_Health_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Environment_Health_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 30, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Person"> Environment, Health & Safety  Person <span id="asteriskEH" style="display: {{ $data1->Environment_Health_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Environment_Health_Safety_person" class="Environment_Health_Safety_person" id="Environment_Health_Safety_person" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Environment_Health_Safety_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment8">Impact Assessment (By Environment, Health & Safety) <span id="asteriskEH1" style="display: {{ $data1->Environment_Health_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Environment_Health_review == 'yes' && $data->stage == 4) required @endif class="summernote" name="Health_Safety_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->Environment_Health_Safety_person) readonly @endif id="summernote-33">{{$data1->Health_Safety_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Safety Feedback">Environment, Health & Safety  Feedback <span id="asteriskEH2" style="display: {{ $data1->Environment_Health_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Environment_Health_review == 'yes' && $data->stage == 4) required @endif class="summernote" name="Health_Safety_feedback" id="summernote-34" @if ($data->stage==3  || Auth::user()->id != $data1->Environment_Health_Safety_person) readonly @endif>{{$data1->Health_Safety_feedback}}</textarea>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Environment_Health_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Environment_Health_Safety_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asteriskEH');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">  Environment, Health & Safety Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Environment_Health_Safety_attachment">
                                                @if ($data1->Environment_Health_Safety_attachment)
                                                @foreach(json_decode($data1->Environment_Health_Safety_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Environment_Health_Safety_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Environment_Health_Safety_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Safety Review Completed By">Environment, Health & Safety Review Completed By</label>
                                        {{-- <input type="text" name="Environment_Health_Safety_by" id="Environment_Health_Safety_by" value="Environment_Health_Safety_by" disabled>                                         --}}
                                        <input disabled type="text" value="{{ $data1->Environment_Health_Safety_by }}" name="Environment_Health_Safety_by" id="Environment_Health_Safety_by">

                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Safety Review Completed On">Environment, Health & Safety Review Completed On</label>
                                        <input type="date" id="Environment_Health_Safety_on" name="Environment_Health_Safety_on" value="{{ $data1->Environment_Health_Safety_on }}">
                                    
                                    </div>
                                </div>
                                <div class="sub-head">
                                Human Resource & Administration
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification">Human Resource & Administration Review Required ? <span  class="text-danger">*</span></label>
                                        <select @if ($data->stage==3) required @endif name="Human_Resource_review" id="Human_Resource_review" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Human_Resource_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Human_Resource_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Human_Resource_review == 'na') selected @endif 
                                                   value="na">NA</option>
                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 31, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification"> Human Resource & Administration  Person <span id="asteriskHR" style="display: {{ $data1->Human_Resource_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Human_Resource_person" class="Human_Resource_person" id="Human_Resource_person" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Human_Resource_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Impact Assessment (By Human Resource & Administration ) <span id="asteriskHR1" style="display: {{ $data1->Human_Resource_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif class="summernote Human_Resource_assessment" name="Human_Resource_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->Human_Resource_person) readonly @endif id="summernote-35">{{$data1->Human_Resource_assessment}}</textarea>
                                    </div>
                                </div> 
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Human Resource & Administration  Feedback <span id="asteriskHR2" style="display: {{ $data1->Human_Resource_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Human_Resource_review == 'yes' && $data->stage == 4) required @endif class="summernote Human_Resource_feedback" name="Human_Resource_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Human_Resource_person) readonly @endif id="summernote-36">{{$data1->Human_Resource_feedback}}</textarea>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Human_Resource_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Human_Resource_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asteriskHR');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Human Resource & Administration Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Human_Resource_attachment">
                                                @if ($data1->Human_Resource_attachment)
                                                @foreach(json_decode($data1->Human_Resource_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Human_Resource_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Human_Resource_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Administration Review Completed By"> Human Resource & Administration Review Completed By</label>
                                        {{-- <input type="text" name="Human_Resource_by" id="Human_Resource_by" value="Human_Resource_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Human_Resource_by }}" name="Human_Resource_by" id="Human_Resource_by">

                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Administration Review Completed On"> Human Resource & Administration Review Completed On</label>
                                        <input type="date" id="Environment_Health_Safety_on" name="Environment_Health_Safety_on" value="{{ $data1->Environment_Health_Safety_on }}">
                                        {{-- <input disabled type="text" value="{{ $data1->Environment_Health_Safety_on }}" name="Environment_Health_Safety_on" id="Environment_Health_Safety_on"> --}}
                                    </div>
                                </div>
                                <div class="sub-head">
                                Information Technology
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Information Technology Review Required"> Information Technology Review Required ? <span  class="text-danger">*</span></label>
                                        <select @if ($data->stage==3) required @endif name=" Information_Technology_review" id=" Information_Technology_review" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Information_Technology_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Information_Technology_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Information_Technology_review == 'na') selected @endif 
                                                   value="na">NA</option>
                                        </select>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 32, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Information Technology Person"> Information Technology  Person <span id="asteriskITP" style="display: {{ $data1->Information_Technology_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name=" Information_Technology_person" class="Information_Technology_person" id=" Information_Technology_person" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Information_Technology_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment10">Impact Assessment (By Information Technology) <span id="asteriskITP" style="display: {{ $data1->Information_Technology_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Information_Technology_review == 'yes' && $data->stage == 4) required @endif class="summernote Information_Technology_assessment" name="Information_Technology_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->Information_Technology_person) readonly @endif id="summernote-37">{{$data1->Information_Technology_assessment}}</textarea>
                                    </div>
                                </div>  
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Information Technology Feedback">Information Technology Feedback <span id="asteriskITP" style="display: {{ $data1->Information_Technology_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Information_Technology_review == 'yes' && $data->stage == 4) required @endif class="summernote Information_Technology_feedback" name="Information_Technology_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Information_Technology_person) readonly @endif id="summernote-38">{{$data1->Information_Technology_feedback}}</textarea>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Information_Technology_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Information_Technology_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asteriskITP');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Information Technology Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Information_Technology_attachment">
                                                @if ($data1->Information_Technology_attachment)
                                                @foreach(json_decode($data1->Information_Technology_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} type="file" id="myfile" name="Information_Technology_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Information_Technology_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Information Technology Review Completed By"> Information Technology Review Completed By</label>
                                        {{-- <input type="text" name="Information_Technology_by" id="Information_Technology_by" value="Information_Tec/hnology_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Information_Technology_by }}" name="Information_Technology_by" id="Information_Technology_by">

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Information Technology Review Completed On">Information Technology Review Completed On</label>
                                        <input type="text" name="Information_Technology_on" id="Information_Technology_on" value={{$data1->Information_Technology_on}}>
                                    </div>
                                </div>
                                <div class="sub-head">
                                Project Management
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Project management Review Required"> Project management Review Required ? <span  class="text-danger">*</span></label>
                                        <select @if ($data->stage==3) required @endif name="Project_management_review" id="Project_management_review" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Project_management_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Project_management_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Project_management_review == 'na') selected @endif 
                                                   value="na">NA</option>
                                        </select>
                                    </div>
                           </div>
                                    @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 33, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Project management Person"> Project management Person <span id="asteriskPMP" style="display: {{ $data1->Project_management_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Project_management_person" class="Project_management_person" id="Project_management_person" @if ($data->stage==4) disabled @endif>
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Project_management_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment11">Impact Assessment (By  Project management ) <span id="asteriskPMP" style="display: {{ $data1->Project_management_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Project_management_review == 'yes' && $data->stage == 4) required @endif class="summernote Project_management_assessment" name="Project_management_assessment" id="summernote-39" @if ($data->stage==3  || Auth::user()->id != $data1->Project_management_person) readonly @endif>{{$data1->Project_management_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Project management Feedback"> Project management  Feedback <span id="asteriskPMP" style="display: {{ $data1->Project_management_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Project_management_review == 'yes' && $data->stage == 4) required @endif class="summernote Project_management_feedback" name="Project_management_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Project_management_person) readonly @endif id="summernote-40">{{$data1->Project_management_feedback}}</textarea>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Project_management_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Project_management_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asteriskPMP');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Project management Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Project_management_attachment">
                                                @if ($data1->Project_management_attachment)
                                                @foreach(json_decode($data1->Project_management_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Project_management_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Project_management_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Project management Review Completed By"> Project management Review Completed By</label>
                                        {{-- <input type="text" name="Project_management_by" id="Project_management_by" value="Project_management_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Project_management_by }}" name="Project_management_by" id="Project_management_by">

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Project management Review Completed On">Project management Review Completed On</label>
                                        <input type="date" name="Project_management_on" id="Project_management_on" value={{$data1->Project_management_on}} >

                                    
                                    </div>
                                </div>


                                {{-- ---------------------------------- else --}}
                           @else
                           <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Control Review Required">Quality Control Review Required?</label>
                                <select disabled name="Quality_review" id="Quality_review">
                                    <option value="">-- Select --</option>
                                    <option @if ($data1->Quality_review == 'yes') selected @endif
                                        value="yes">Yes</option>
                                       <option  @if ($data1->Quality_review == 'no') selected @endif 
                                       value="no">No</option>
                                       <option  @if ($data1->Quality_review == 'na') selected @endif 
                                           value="na">NA</option>

                                </select>
                          
                            </div>
                        </div>
                        @php
                        $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 24, 'q_m_s_divisions_id' => $data->division_id])->get();
                        $userRoleIds = $userRoles->pluck('user_id')->toArray();
                        $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                    @endphp
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Control Person">Quality Control Person</label>
                                <select disabled name="Quality_Control_Person" id="Quality_Control_Person">
                                    <option value="">-- Select --</option>
                                    @foreach ($users as $user)
                                    <option {{ $data1->Quality_Control_Person == $user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach

                                </select>
                          
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Impact Assessment2">Impact Assessment (By Quality Control)</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea class="summernote" name="Quality_Control_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-21">{{ $data1->Quality_Control_assessment }}</textarea>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Quality Control Feedback">Quality Control Feedback</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea class="summernote" name="Quality_Control_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-22">{{ $data1->Quality_Control_feedback }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Quality Control Attachments">Quality Control Attachments</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="Quality_Control_attachment">
                                        @if ($data1->Quality_Control_attachment)
                                        @foreach(json_decode($data1->Quality_Control_attachment) as $file)
                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                            <b>{{ $file }}</b>
                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                            <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                        </h6>
                                   @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Quality_Control_attachment[]"
                                            oninput="addMultipleFiles(this, 'Quality_Control_attachment')"
                                            multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="group-input">
                                <label for="Quality Control Review Completed By">Quality Control Review Completed By</label>
                                {{-- <input type="text" name="Quality_Control_by" id="Quality_Control_by" value="{{ $data1->Quality_Control_by }}" disabled> --}}
                                <input disabled type="text" value="{{ $data1->Quality_Control_by }}" name="Quality_Control_by" id="Quality_Control_by">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Control Review Completed On">Quality Control Review Completed On</label>
                                <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                <input disabled type="date"id="Quality_Control_on" name="Quality_Control_on" value="{{ $data1->Quality_Control_on }}" >
                            </div>
                        </div>
                          <div class="sub-head">
                          Quality Assurance
                   </div>
                   <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Assurance Review Required">Quality Assurance Review Required ?</label>
                                <select disabled name="Quality_Assurance_Review" id="Quality_Assurance_Review">
                                    <option @if ($data1->Quality_Assurance_Review == 'yes') selected @endif
                                        value="yes">Yes</option>
                                       <option  @if ($data1->Quality_Assurance_Review == 'no') selected @endif 
                                       value="no">No</option>
                                       <option  @if ($data1->Quality_Assurance_Review == 'na') selected @endif 
                                           value="na">NA</option>
                                </select>
                            </div>
                        </div>
                        @php
                            $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 26, 'q_m_s_divisions_id' => $data->division_id])->get();
                            $userRoleIds = $userRoles->pluck('user_id')->toArray();
                            $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                        @endphp
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Assurance Person">Quality Assurance Person</label>
                                <select disabled name="QualityAssurance_person" id="QualityAssurance_person">
                                    <option value="">-- Select --</option>
                                    @foreach ($users as $user)
                                    <option {{ $data1->QualityAssurance_person == $user->id ? 'selected' : '' }}
                                        value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Impact Assessment3">Impact Assessment (By Quality Assurance)</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea class="summernote" name="QualityAssurance_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-23">{{ $data1->QualityAssurance_assessment }}</textarea>
                            </div>
                        </div>   
                        <div class="col-md-12 mb-3">
                            <div class="group-input">
                                <label for="Quality Assurance Feedback">Quality Assurance Feedback</label>
                                <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                <textarea class="summernote" name="QualityAssurance_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-24">{{ $data1->QualityAssurance_feedback }}</textarea>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="group-input">
                                <label for="Quality Assurance Attachments">Quality Assurance Attachments</label>
                                <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                <div class="file-attachment-field">
                                    <div disabled class="file-attachment-list" id="Quality_Assurance_attachment">
                                        @if ($data1->Quality_Assurance_attachment)
                                        @foreach(json_decode($data1->Quality_Assurance_attachment) as $file)
                                        <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                            <b>{{ $file }}</b>
                                            <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                            <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                        </h6>
                                   @endforeach
                                        @endif
                                    </div>
                                    <div class="add-btn">
                                        <div>Add</div>
                                        <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Quality_Assurance_attachment[]"
                                            oninput="addMultipleFiles(this, 'Quality_Assurance_attachment')"
                                            multiple>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="group-input">
                                <label for="Quality Assurance Review Completed By">Quality Assurance Review Completed By</label>
                                {{-- <input type="text" name="QualityAssurance_by" id="QualityAssurance_by" value="{{$data1->QualityAssurance_by}}" disabled> --}}
                                <input disabled type="text" value="{{ $data1->QualityAssurance_by }}" name="QualityAssurance_by" id="QualityAssurance_by">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="group-input">
                                <label for="Quality Assurance Review Completed On">Quality Assurance Review Completed On</label>
                                <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                <input disabled type="date"id="QualityAssurance_on" name="QualityAssurance_on" value="{{ $data1->QualityAssurance_on }}" >
                            </div>
                        </div>
                        <div class="sub-head">
                            Engineering
                       </div>
                       <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Customer notification">Engineering Review Required ?</label>
                                    <select disabled name="Engineering_review" id="Engineering_review">
                                        <option value="">-- Select --</option>
                                        <option @if ($data1->Engineering_review == 'yes') selected @endif
                                            value="yes">Yes</option>
                                           <option  @if ($data1->Engineering_review == 'no') selected @endif 
                                           value="no">No</option>
                                           <option  @if ($data1->Engineering_review == 'na') selected @endif 
                                               value="na">NA</option>
                                    </select>
                              
                                </div>
                            </div>
                            @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 25, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Customer notification">Engineering  Person</label>
                                    <select disabled name="Engineering_person" id="Engineering_person">
                                        <option value="">-- Select --</option>
                                        @foreach ($users as $user)
                                        <option {{ $data1->Engineering_person == $user->id ? 'selected' : '' }}
                                            value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Impact Assessment4">Impact Assessment (By Engineering)</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea class="summernote" name="Engineering_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-25" >{{$data1->Engineering_assessment}}</textarea>
                                </div>
                            </div>  
                            <div class="col-md-12 mb-3">
                                <div class="group-input">
                                    <label for="Engineering Feedback">Engineering  Feedback</label>
                                    <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                    <textarea class="summernote" name="Engineering_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-26" >{{$data1->Engineering_feedback}}</textarea>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="group-input">
                                    <label for="Audit Attachments">Engineering  Attachments</label>
                                    <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                    <div class="file-attachment-field">
                                        <div disabled class="file-attachment-list" id="Engineering_attachment">
                                            @if ($data1->Engineering_attachment)
                                            @foreach(json_decode($data1->Engineering_attachment) as $file)
                                            <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                <b>{{ $file }}</b>
                                                <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                            </h6>
                                       @endforeach
                                            @endif
                                        </div>
                                        <div class="add-btn">
                                            <div>Add</div>
                                            <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Engineering_attachment[]"
                                                oninput="addMultipleFiles(this, 'Engineering_attachment')"
                                                multiple>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="group-input">
                                    <label for="Engineering Review Completed By">Engineering Review Completed By</label>
                                    {{-- <input type="text" name="Engineering_by" id="Engineering_by" value="Engineering_by" disabled> --}}
                                    <input disabled type="text" value="{{ $data1->Engineering_by }}" name="Engineering_by" id="Engineering_by">

                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="group-input">
                                    <label for="Engineering Review Completed On">Engineering Review Completed On</label>
                                    <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                    <input disabled type="date" id="Engineering_on" name="Engineering_on" value="{{ $data1->Engineering_on }}" >
                                </div>
                            </div>
                            <div class="sub-head">
                                Analytical Development Laboratory
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Review Required">Analytical Development Laboratory Review Required ?</label>
                                        <select disabled name="Analytical_Development_review" id="Analytical_Development_review">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Analytical_Development_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Analytical_Development_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Analytical_Development_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 27, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Person"> Analytical Development Laboratory Person</label>
                                        <select disabled name="Analytical_Development_person" id="Analytical_Development_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Analytical_Development_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment5">Impact Assessment (By Analytical Development Laboratory)</label>
                                        <textarea class="summernote" name="Analytical_Development_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-27">{{$data1->Analytical_Development_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Feedback"> Analytical Development Laboratory Feedback</label>
                                        <textarea class="summernote" name="Analytical_Development_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-28">{{$data1->Analytical_Development_feedback}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Analytical Development Laboratory Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Analytical_Development_attachment">
                                                @if ($data1->Analytical_Development_attachment)
                                                @foreach(json_decode($data1->Analytical_Development_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Analytical_Development_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Analytical_Development_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Review Completed By">Analytical Development Laboratory Review Completed By</label>
                                        {{-- <input type="text" name="Analytical_Development_by" id="Analytical_Development_by" value="Analytical_Development_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Analytical_Development_by }}" name="Analytical_Development_by" id="Analytical_Development_by">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Analytical Development Laboratory Review Completed On">Analytical Development Laboratory Review Completed On</label>
                                        <!-- <div><small class="text-primary">Please select related information</small></div> -->
                                        <input disabled type="date" id="Analytical_Development_on" name="Analytical_Development_on" value="{{ $data1->Analytical_Development_on }}" >
                                    </div>
                                </div>
                                <div class="sub-head">
                                Process Development Laboratory / Kilo Lab
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Process Development Laboratory"> Process Development Laboratory / Kilo Lab Review Required ?</label>
                                        <select disabled name="Kilo_Lab_review" id="Kilo_Lab_review">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Kilo_Lab_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Kilo_Lab_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Kilo_Lab_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 28, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Process Development Laboratory"> Process Development Laboratory / Kilo Lab  Person</label>
                                        <select disabled name="Kilo_Lab_person" id="Kilo_Lab_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Kilo_Lab_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment6">Impact Assessment (By Process Development Laboratory / Kilo Lab)</label>
                                        <textarea class="summernote" name="Kilo_Lab_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-29">{{$data1->Kilo_Lab_assessment}}</textarea>
                                    </div>
                                </div> 
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Kilo Lab Feedback"> Process Development Laboratory / Kilo Lab  Feedback</label>
                                        <textarea class="summernote" name="Kilo_Lab_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-30">{{$data1->Kilo_Lab_feedback}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Process Development Laboratory / Kilo Lab Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Kilo_Lab_attachment">
                                                @if ($data1->Kilo_Lab_attachment)
                                                @foreach(json_decode($data1->Kilo_Lab_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Kilo_Lab_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Kilo_Lab_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Kilo Lab Review Completed By">Process Development Laboratory / Kilo Lab Review Completed By</label>
                                        {{-- <input type="text" name="Kilo_Lab_attachment_by" id="Kilo_Lab_attachment_by" value="Kilo_Lab_attachment_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Kilo_Lab_attachment_by }}" name="Kilo_Lab_attachment_by" id="Kilo_Lab_attachment_by">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Kilo Lab Review Completed On">Process Development Laboratory / Kilo Lab Review Completed On</label>
                                        <input disabled type="date" id="Kilo_Lab_attachment_on" name="Kilo_Lab_attachment_on" value="{{ $data1->Kilo_Lab_attachment_on }}" >
                                    
                                    </div>
                                </div>
                                <div class="sub-head">
                                Technology Transfer / Design
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Design Review Required">Technology Transfer / Design Review Required ?</label>
                                        <select disabled name="Technology_transfer_review" id="Technology_transfer_review">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Technology_transfer_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Technology_transfer_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Technology_transfer_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 29, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Design Person"> Technology Transfer / Design  Person</label>
                                        <select disabled name="Technology_transfer_person" id="Technology_transfer_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Technology_transfer_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment7">Impact Assessment (By Technology Transfer / Design)</label>
                                        <textarea class="summernote" name="Technology_transfer_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-31">{{$data1->Technology_transfer_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Design Feedback"> Technology Transfer / Design  Feedback</label>
                                        <textarea class="summernote" name="Technology_transfer_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-32">{{$data1->Technology_transfer_feedback}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments"> Technology Transfer / Design Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Technology_transfer_attachment">
                                                @if ($data1->Technology_transfer_attachment)
                                                @foreach(json_decode($data1->Technology_transfer_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Technology_transfer_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Technology_transfer_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Technology Transfer / Design Review Completed By</label>
                                        {{-- <input type="text" name="Technology_transfer_by" id="Technology_transfer_by" value="Technology_transfer_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Technology_transfer_by }}" name="Technology_transfer_by" id="Technology_transfer_by">

                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Technology Transfer / Design Review Completed On</label>
                                        <input disabled type="date" id="Technology_transfer_on" name="Technology_transfer_on" value="{{ $data1->Technology_transfer_on }}">
                                    </div>
                                </div>
                                <div class="sub-head">
                                Environment, Health & Safety
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Review Required">Environment, Health & Safety Review Required ?</label>
                                        <select disabled name="Environment_Health_review" id="Environment_Health_review">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Environment_Health_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Environment_Health_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Environment_Health_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 30, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Safety Person"> Environment, Health & Safety  Person</label>
                                        <select disabled name="Environment_Health_Safety_person" id="Environment_Health_Safety_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Environment_Health_Safety_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment8">Impact Assessment (By Environment, Health & Safety)</label>
                                        <textarea class="summernote" name="Health_Safety_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-33">{{$data1->Health_Safety_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Safety Feedback">Environment, Health & Safety  Feedback</label>
                                        <textarea class="summernote" name="Health_Safety_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-34">{{$data1->Health_Safety_feedback}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">  Environment, Health & Safety Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Environment_Health_Safety_attachment">
                                                @if ($data1->Environment_Health_Safety_attachment)
                                                @foreach(json_decode($data1->Environment_Health_Safety_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Environment_Health_Safety_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Environment_Health_Safety_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Safety Review Completed By">Environment, Health & Safety Review Completed By</label>
                                        {{-- <input type="text" name="Environment_Health_Safety_by" id="Environment_Health_Safety_by" value="Environment_Health_Safety_by" disabled>                                         --}}
                                        <input disabled type="text" value="{{ $data1->Environment_Health_Safety_by }}" name="Environment_Health_Safety_by" id="Environment_Health_Safety_by">

                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Safety Review Completed On">Environment, Health & Safety Review Completed On</label>
                                        <input disabled type="date" id="Environment_Health_Safety_on" name="Environment_Health_Safety_on" value="{{ $data1->Environment_Health_Safety_on }}">
                                    
                                    </div>
                                </div>
                                <div class="sub-head">
                                Human Resource & Administration
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification">Human Resource & Administration Review Required ?</label>
                                        <select disabled name="Human_Resource_review" id="Human_Resource_review">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Human_Resource_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Human_Resource_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Human_Resource_review == 'na') selected @endif 
                                                   value="na">NA</option>
                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 31, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Customer notification"> Human Resource & Administration  Person</label>
                                        <select disabled name="Human_Resource_person" id="Human_Resource_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Human_Resource_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Impact Assessment (By Human Resource & Administration )</label>
                                        <textarea class="summernote" name="Human_Resource_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-35">{{$data1->Human_Resource_assessment}}</textarea>
                                    </div>
                                </div> 
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Human Resource & Administration  Feedback</label>
                                        <textarea class="summernote" name="Human_Resource_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-36">{{$data1->Human_Resource_feedback}}</textarea>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Human Resource & Administration Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Human_Resource_attachment">
                                                @if ($data1->Human_Resource_attachment)
                                                @foreach(json_decode($data1->Human_Resource_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} type="file" id="myfile" name="Human_Resource_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Human_Resource_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Administration Review Completed By"> Human Resource & Administration Review Completed By</label>
                                        {{-- <input type="text" name="Human_Resource_by" id="Human_Resource_by" value="Human_Resource_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Human_Resource_by }}" name="Human_Resource_by" id="Human_Resource_by">

                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Administration Review Completed On"> Human Resource & Administration Review Completed On</label>
                                        <input type="date" id="Environment_Health_Safety_on" name="Environment_Health_Safety_on" value="{{ $data1->Environment_Health_Safety_on }}">
                                        {{-- <input disabled type="text" value="{{ $data1->Environment_Health_Safety_on }}" name="Environment_Health_Safety_on" id="Environment_Health_Safety_on"> --}}
                                    </div>
                                </div>
                                <div class="sub-head">
                                Information Technology
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Information Technology Review Required"> Information Technology Review Required ?</label>
                                        <select disabled name=" Information_Technology_review" id=" Information_Technology_review">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Information_Technology_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Information_Technology_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Information_Technology_review == 'na') selected @endif 
                                                   value="na">NA</option>
                                        </select>

                                        </select>
                                  
                                    </div>
                                </div>
                                @php
                                $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 32, 'q_m_s_divisions_id' => $data->division_id])->get();
                                $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                            @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Information Technology Person"> Information Technology  Person</label>
                                        <select disabled name=" Information_Technology_person" id=" Information_Technology_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Information_Technology_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment10">Impact Assessment (By Information Technology)</label>
                                        <textarea class="summernote" name="Information_Technology_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-37">{{$data1->Information_Technology_assessment}}</textarea>
                                    </div>
                                </div>  
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Information Technology Feedback">Information Technology Feedback</label>
                                        <textarea class="summernote" name="Information_Technology_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-38">{{$data1->Information_Technology_feedback}}</textarea>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Information Technology Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Information_Technology_attachment">
                                                @if ($data1->Information_Technology_attachment)
                                                @foreach(json_decode($data1->Information_Technology_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Information_Technology_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Information_Technology_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Information Technology Review Completed By"> Information Technology Review Completed By</label>
                                        {{-- <input type="text" name="Information_Technology_by" id="Information_Technology_by" value="Information_Tec/hnology_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Information_Technology_by }}" name="Information_Technology_by" id="Information_Technology_by">

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Information Technology Review Completed On">Information Technology Review Completed On</label>
                                        <input disabled type="text" name="Information_Technology_on" id="Information_Technology_on" value={{$data1->Information_Technology_on}}>
                                    </div>
                                </div>
                                <div class="sub-head">
                                Project Management
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Project management Review Required"> Project management Review Required ?</label>
                                        <select disabled name="Project_management_review" id="Project_management_review">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Project_management_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Project_management_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Project_management_review == 'na') selected @endif 
                                                   value="na">NA</option>
                                        </select>
                                    </div>
                           </div>
                                    @php
                                    $userRoles = DB::table('user_roles')->where(['q_m_s_roles_id' => 33, 'q_m_s_divisions_id' => $data->division_id])->get();
                                    $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                    $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Project management Person"> Project management Person</label>
                                        <select disabled name="Project_management_person" id="Project_management_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Project_management_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment11">Impact Assessment (By  Project management )</label>
                                        <textarea class="summernote" name="Project_management_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-39">{{$data1->Project_management_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Project management Feedback"> Project management  Feedback</label>
                                        <textarea class="summernote" name="Project_management_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-40">{{$data1->Project_management_feedback}}</textarea>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Project management Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Project_management_attachment">
                                                @if ($data1->Project_management_attachment)
                                                @foreach(json_decode($data1->Project_management_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Project_management_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Project_management_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Project management Review Completed By"> Project management Review Completed By</label>
                                        {{-- <input type="text" name="Project_management_by" id="Project_management_by" value="Project_management_by" disabled> --}}
                                        <input disabled type="text" value="{{ $data1->Project_management_by }}" name="Project_management_by" id="Project_management_by">

                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Project management Review Completed On">Project management Review Completed On</label>
                                        <input disabled type="date" name="Project_management_on" id="Project_management_on" value={{$data1->Project_management_on}} >

                                    
                                    </div>
                                </div>
                           @endif
                           @if($data->stage==3 || $data->stage==4)
                           <div class="sub-head">
                                Other's 1 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Review Required1"> Other's 1 Review Required? </label>
                                        <select name="Other1_review" @if ($data->stage==4) disabled @endif id="Other1_review" value="{{ $data1->Other1_review }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other1_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Other1_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Other1_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                 @php
                                 $userRoles = DB::table('user_roles')->where(['q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person1"> Other's 1 Person <span id="asterisko1" style="display: {{ $data1->Other1_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other1_person" @if ($data->stage==4) disabled @endif id="Other1_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other1_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department1"> Other's 1 Department <span id="asteriskod1" style="display: {{ $data1->Other1_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other1_Department_person" @if ($data->stage==4) disabled @endif id="Other1_Department_person" value="{{ $data1->Other1_Department_person }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other1_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other1_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other1_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other1_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other1_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other1_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other1_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other1_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other1_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other1_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other1_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other1_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>  

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment12">Impact Assessment (By  Other's 1) <span id="" style="display: {{ $data1->Other1_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Other1_review == 'yes' && $data->stage == 4) required @endif class="summernote" name="Other1_assessment" @if ($data->stage==3  || Auth::user()->id != $data1->Other1_person) readonly @endif id="summernote-41">{{$data1->Other1_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Feedback1"> Other's 1 Feedback  <span id="" style="display: {{ $data1->Other1_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data1->Other1_review == 'yes' && $data->stage == 4) required @endif class="summernote" name="Other1_feedback" @if ($data->stage==3  || Auth::user()->id != $data1->Other1_person) readonly @endif id="summernote-42">{{$data1->Other1_feedback}}</textarea>
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Other1_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Other1_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                                            var facilityNameInputs = document.getElementsByClassName('Other1_Department_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asterisko1');
                                                var asteriskIcon1 = document.getElementById('asteriskod1');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                                asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 1 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other1_attachment">
                                                @if ($data1->Other1_attachment)
                                                @foreach(json_decode($data1->Other1_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other1_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other1_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By1"> Other's 1 Review Completed By</label>
                                        <input disabled type="text" value="{{ $data1->Other1_by }}" name="Other1_by" id="Other1_by">
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                        <input disabled type="date" name="Other1_on" id="Other1_on" value="{{ $data1->Other1_on }}">
                                    
                                    </div>
                                </div>
                                <div class="sub-head">
                                Other's 2 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review2"> Other's 2 Review Required ?</label>
                                        <select name="Other2_review"  @if ($data->stage==4) disabled @endif id="Other2_review" value="{{ $data1->Other2_review }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other2_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Other2_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Other2_review == 'na') selected @endif 
                                                   value="na">NA</option>
                                        </select>
                                  
                                    </div>
                                </div>
                               
                                 @php
                                 $userRoles = DB::table('user_roles')->where(['q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person2"> Other's 2 Person  <span id="asterisko2" style="display: {{ $data1->Other2_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other2_person"  @if ($data->stage==4) disabled @endif id="Other2_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other2_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department2"> Other's 2 Department  <span id="asteriskod2" style="display: {{ $data1->Other2_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other2_Department_person"  @if ($data->stage==4) disabled @endif id="Other2_Department_person">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other2_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other2_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other2_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other2_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other2_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other2_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other2_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other2_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other2_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other2_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other2_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other2_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>  
                                        
                                        </select>
                                  
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Other2_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Other2_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                                            var facilityNameInputs = document.getElementsByClassName('Other2_Department_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asterisko2');
                                                var asteriskIcon1 = document.getElementById('asteriskod2');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                                asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment13">Impact Assessment (By  Other's 2) <span id="" style="display: {{ $data1->Other2_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data->stage==3  || Auth::user()->id != $data1->Other2_person) readonly @endif class="summernote" name="Other2_Assessment" @if ($data1->Other2_review == 'yes' && $data->stage == 4) required @endif id="summernote-43">{{$data1->Other2_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Feedback2"> Other's 2 Feedback <span id="" style="display: {{ $data1->Other2_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data->stage==3  || Auth::user()->id != $data1->Other2_person) readonly @endif class="summernote" name="Other2_feedback" @if ($data1->Other2_review == 'yes' && $data->stage == 4) required @endif id="summernote-44">{{$data1->Other2_feedback}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 2 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other2_attachment">
                                                @if ($data1->Other2_attachment)
                                                @foreach(json_decode($data1->Other2_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other2_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other2_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By2"> Other's 2 Review Completed By</label>
                                        <input type="text" name="Other2_by" id="Other2_by" value="{{ $data1->Other2_by }}" disabled>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On2">Other's 2 Review Completed On</label>
                                        <input disabled type="date" name="Other2_on" id="Other2_on" value="{{ $data1->Other2_on }}">
                                    </div>
                                </div>

                                <div class="sub-head">
                                Other's 3 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review3"> Other's 3 Review Required ?</label>
                                        <select name="Other3_review"  @if ($data->stage==4) disabled @endif id="Other3_review" value="{{ $data1->Other3_review }}">
                                                <option value="0">-- Select --</option>
                                                <option @if ($data1->Other3_review == 'yes') selected @endif
                                                    value="yes">Yes</option>
                                                   <option  @if ($data1->Other3_review == 'no') selected @endif 
                                                   value="no">No</option>
                                                   <option  @if ($data1->Other3_review == 'na') selected @endif 
                                                       value="na">NA</option>
                                            </select>

                                        </select>
                                  
                                    </div>
                                </div>
                               
                                 @php
                                 $userRoles = DB::table('user_roles')->where(['q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person3">Other's 3 Person  <span id="asterisko3" style="display: {{ $data1->Other3_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other3_person"  @if ($data->stage==4) disabled @endif id="Other3_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other3_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department3">Other's 3 Department  <span id="asteriskod3" style="display: {{ $data1->Other3_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other3_Department_person"  @if ($data->stage==4) disabled @endif id="Other3_Department_person">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other3_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other3_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other3_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other3_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other3_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other3_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other3_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other3_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other3_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other3_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other3_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other3_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>
                                        </select>
                                  
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Other3_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Other3_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                                            var facilityNameInputs = document.getElementsByClassName('Other3_Department_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asterisko3');
                                                var asteriskIcon1 = document.getElementById('asteriskod3');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                                asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment14">Impact Assessment (By  Other's 3) <span id="" style="display: {{ $data1->Other3_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data->stage==3  || Auth::user()->id != $data1->Other3_person) readonly @endif class="summernote" name="Other3_Assessment" @if ($data1->Other3_review == 'yes' && $data->stage == 4) required @endif id="summernote-45">{{$data1->Other3_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="feedback3"> Other's 3 Feedback <span id="" style="display: {{ $data1->Other3_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data->stage==3  || Auth::user()->id != $data1->Other3_person) readonly @endif class="summernote" name="Other3_feedback" @if ($data1->Other3_review == 'yes' && $data->stage == 4) required @endif id="summernote-46">{{$data1->Other3_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 3 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other3_attachment">
                                                @if ($data1->Other3_attachment)
                                                @foreach(json_decode($data1->Other3_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other3_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other3_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 3 Review Completed By</label>
                                        <input type="text" name="Other3_by" id="Other3_by" value="{{ $data1->Other3_by }}" disabled>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Other's 3 Review Completed On</label>
                                        <input disabled type="date" name="Other3_on" id="Other3_on" value="{{$data1->Other3_on}}">
                                    </div>
                                </div>
                                <div class="sub-head">
                                Other's 4 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review4">Other's 4 Review Required ?</label>
                                        <select name="Other4_review"  @if ($data->stage==4) disabled @endif id="Other4_review" value="{{ $data1->Other4_review }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other4_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Other4_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Other4_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                
                                 @php
                                 $userRoles = DB::table('user_roles')->where(['q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person4"> Other's 4 Person  <span id="asterisko4" style="display: {{ $data1->Other4_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other4_person"  @if ($data->stage==4) disabled @endif id="Other4_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other4_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department4"> Other's 4 Department  <span id="asteriskod4" style="display: {{ $data1->Other4_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other4_Department_person"  @if ($data->stage==4) disabled @endif id="Other4_Department_person">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other4_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other4_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other4_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other4_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other4_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other4_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other4_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other4_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other4_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other4_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other4_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other4_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>  
                                        </select>
                                  
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Other4_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Other4_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                                            var facilityNameInputs = document.getElementsByClassName('Other4_Department_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asterisko4');
                                                var asteriskIcon1 = document.getElementById('asteriskod4');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                                asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment15">Impact Assessment (By  Other's 4) <span id="" style="display: {{ $data1->Other4_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data->stage==3  || Auth::user()->id != $data1->Other4_person) readonly @endif class="summernote" name="Other4_Assessment" @if ($data1->Other4_review == 'yes' && $data->stage == 4) required @endif id="summernote-47">{{$data1->Other4_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="feedback4"> Other's 4 Feedback <span id="" style="display: {{ $data1->Other4_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data->stage==3  || Auth::user()->id != $data1->Other4_person) readonly @endif class="summernote" name="Other4_feedback" @if ($data1->Other4_review == 'yes' && $data->stage == 4) required @endif id="summernote-48">{{$data1->Other4_feedback}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 4 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other4_attachment">
                                                @if ($data1->Other4_attachment)
                                                @foreach(json_decode($data1->Other4_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other4_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other4_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By4"> Other's 4 Review Completed By</label>
                                        <input type="text" name="Other4_by" id="Other4_by" value="{{ $data1->Other4_by }}" disabled>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On4">Other's 4 Review Completed On</label>
                                        <input disabled type="date" name="Other4_on" id="Other4_on" value="{{ $data1->Other4_on }}">
                                    
                                    </div>
                                </div>



                                <div class="sub-head">
                                Other's 5 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review5">Other's 5 Review Required ?</label>
                                        <select name="Other5_review" @if ($data->stage==4) disabled @endif id="Other5_review" value="{{ $data1->Other5_review }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other5_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Other5_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Other5_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                 @php
                                 $userRoles = DB::table('user_roles')->where(['q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person5">Other's 5 Person  <span id="asterisko5" style="display: {{ $data1->Other5_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other5_person" @if ($data->stage==4) disabled @endif id="Other5_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other5_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department5"> Other's 5 Department  <span id="asteriskod5" style="display: {{ $data1->Other5_review == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <select name="Other5_Department_person" @if ($data->stage==4) disabled @endif id="Other5_Department_person">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other5_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other5_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other5_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other5_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other5_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other5_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other5_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other5_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other5_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other5_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other5_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other5_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>  
                                        </select>
                                  
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('Other5_review');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('Other5_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                                            var facilityNameInputs = document.getElementsByClassName('Other5_Department_person');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon = document.getElementById('asterisko5');
                                                var asteriskIcon1 = document.getElementById('asteriskod5');
                                                asteriskIcon.style.display = isRequired ? 'inline' : 'none';
                                                asteriskIcon1.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment16">Impact Assessment (By  Other's 5) <span id="" style="display: {{ $data1->Other5_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data->stage==3  || Auth::user()->id != $data1->Other5_person) readonly @endif class="summernote" name="Other5_Assessment"@if ($data1->Other5_review == 'yes' && $data->stage == 4) required @endif id="summernote-49">{{$data1->Other5_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 5 Feedback <span id="" style="display: {{ $data1->Other5_review == 'yes' && $data->stage == 4 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <textarea @if ($data->stage==3  || Auth::user()->id != $data1->Other5_person) readonly @endif class="summernote" name="Other5_feedback"@if ($data1->Other5_review == 'yes' && $data->stage == 4) required @endif id="summernote-50">{{$data1->Other5_feedback}}</textarea>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 5 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other5_attachment">
                                                @if ($data1->Other5_attachment)
                                                @foreach(json_decode($data1->Other5_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other5_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other5_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By5"> Other's 5 Review Completed By</label>
                                        <input type="text" name="Other5_by" id="Other5_by" value="{{ $data1->Other5_by }}" disabled>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On5">Other's 5 Review Completed On</label>
                                        <input disabled type="date" name="Other5_on" id="Other5_on" value="{{ $data1->Other5_on }}">
                                    </div>
                                </div>
                           @else
                           <div class="sub-head">
                                Other's 1 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Review Required1"> Other's 1 Review Required? </label>
                                        <select disabled name="Other1_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other1_review" value="{{ $data1->Other1_review }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other1_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Other1_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Other1_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                 @php
                                 $userRoles = DB::table('user_roles')->where(['q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person1"> Other's 1 Person </label>
                                        <select disabled name="Other1_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other1_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other1_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department1"> Other's 1 Department</label>
                                        <select disabled name="Other1_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other1_Department_person" value="{{ $data1->Other1_Department_person }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other1_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other1_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other1_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other1_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other1_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other1_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other1_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other1_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other1_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other1_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other1_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other1_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>  

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment12">Impact Assessment (By  Other's 1)</label>
                                        <textarea disabled class="summernote" name="Other1_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-41">{{$data1->Other1_assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Feedback1"> Other's 1 Feedback</label>
                                        <textarea disabled class="summernote" name="Other1_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-42">{{$data1->Other1_feedback}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 1 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other1_attachment">
                                                @if ($data1->Other1_attachment)
                                                @foreach(json_decode($data1->Other1_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other1_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other1_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By1"> Other's 1 Review Completed By</label>
                                        <input disabled type="text" value="{{ $data1->Other1_by }}" name="Other1_by" id="Other1_by">
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On1">Other's 1 Review Completed On</label>
                                        <input disabled type="date" name="Other1_on" id="Other1_on" value="{{ $data1->Other1_on }}">
                                    
                                    </div>
                                </div>

                                <div class="sub-head">
                                Other's 2 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review2"> Other's 2 Review Required ?</label>
                                        <select disabled name="Other2_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other2_review" value="{{ $data1->Other2_review }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other2_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Other2_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Other2_review == 'na') selected @endif 
                                                   value="na">NA</option>
                                        </select>
                                  
                                    </div>
                                </div>
                               
                                 @php
                                 $userRoles = DB::table('user_roles')->where(['q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person2"> Other's 2 Person</label>
                                        <select disabled name="Other2_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other2_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other2_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department2"> Other's 2 Department</label>
                                        <select disabled name="Other2_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other2_Department_person">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other2_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other2_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other2_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other2_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other2_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other2_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other2_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other2_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other2_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other2_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other2_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other2_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>  
                                        
                                        </select>
                                  
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment13">Impact Assessment (By  Other's 2)</label>
                                        <textarea disabled ="summernote" name="Other2_Assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-43">{{$data1->Other2_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Feedback2"> Other's 2 Feedback</label>
                                        <textarea disabled class="summernote" name="Other2_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-44">{{$data1->Other2_feedback}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 2 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other2_attachment">
                                                @if ($data1->Other2_attachment)
                                                @foreach(json_decode($data1->Other2_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other2_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other2_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By2"> Other's 2 Review Completed By</label>
                                        <input type="text" name="Other2_by" id="Other2_by" value="{{ $data1->Other2_by }}" disabled>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On2">Other's 2 Review Completed On</label>
                                        <input disabled type="date" name="Other2_on" id="Other2_on" value="{{ $data1->Other2_on }}">
                                    </div>
                                </div>

                                <div class="sub-head">
                                Other's 3 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review3"> Other's 3 Review Required ?</label>
                                        <select disabled name="Other3_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other3_review" value="{{ $data1->Other3_review }}">
                                                <option value="0">-- Select --</option>
                                                <option @if ($data1->Other3_review == 'yes') selected @endif
                                                    value="yes">Yes</option>
                                                   <option  @if ($data1->Other3_review == 'no') selected @endif 
                                                   value="no">No</option>
                                                   <option  @if ($data1->Other3_review == 'na') selected @endif 
                                                       value="na">NA</option>
                                            </select>

                                        </select>
                                  
                                    </div>
                                </div>
                               
                                 @php
                                 $userRoles = DB::table('user_roles')->where(['q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person3">Other's 3 Person</label>
                                        <select disabled name="Other3_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other3_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other3_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach

                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department3">Other's 3 Department</label>
                                        <select disabled name="Other3_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other3_Department_person">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other3_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other3_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other3_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other3_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other3_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other3_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other3_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other3_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other3_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other3_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other3_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other3_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>  
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment14">Impact Assessment (By  Other's 3)</label>
                                        <textarea disabled class="summernote" name="Other3_Assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-45">{{$data1->Other3_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="feedback3"> Other's 3 Feedback</label>
                                        <textarea disabled class="summernote" name="Other3_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-46">{{$data1->Other3_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 3 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other3_attachment">
                                                @if ($data1->Other3_attachment)
                                                @foreach(json_decode($data1->Other3_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other3_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other3_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 3 Review Completed By</label>
                                        <input type="text" name="Other3_by" id="Other3_by" value="{{ $data1->Other3_by }}" disabled>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback">Other's 3 Review Completed On</label>
                                        <input disabled type="date" name="Other3_on" id="Other3_on" value="{{$data1->Other3_on}}">
                                    </div>
                                </div>
                                <div class="sub-head">
                                Other's 4 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review4">Other's 4 Review Required ?</label>
                                        <select disabled name="Other4_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other4_review" value="{{ $data1->Other4_review }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other4_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Other4_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Other4_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                
                                 @php
                                 $userRoles = DB::table('user_roles')->where([ 'q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person4"> Other's 4 Person</label>
                                        <select name="Other4_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other4_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other4_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department4"> Other's 4 Department</label>
                                        <select disabled name="Other4_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other4_Department_person">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other4_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other4_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other4_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other4_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other4_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other4_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other4_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other4_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other4_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other4_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other4_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other4_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>  
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment15">Impact Assessment (By  Other's 4)</label>
                                        <textarea disabled class="summernote" name="Other4_Assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-47">{{$data1->Other4_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="feedback4"> Other's 4 Feedback</label>
                                        <textarea disabled class="summernote" name="Other4_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-48">{{$data1->Other4_feedback}}</textarea>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 4 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other4_attachment">
                                                @if ($data1->Other4_attachment)
                                                @foreach(json_decode($data1->Other4_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other4_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other4_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By4"> Other's 4 Review Completed By</label>
                                        <input type="text" name="Other4_by" id="Other4_by" value="{{ $data1->Other4_by }}" disabled>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On4">Other's 4 Review Completed On</label>
                                        <input disabled type="date" name="Other4_on" id="Other4_on" value="{{ $data1->Other4_on }}">
                                    
                                    </div>
                                </div>



                                <div class="sub-head">
                                Other's 5 ( Additional Person Review From Departments If Required)
                           </div>
                           <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="review5">Other's 5 Review Required ?</label>
                                        <select disabled name="Other5_review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other5_review" value="{{ $data1->Other5_review }}">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other5_review == 'yes') selected @endif
                                                value="yes">Yes</option>
                                               <option  @if ($data1->Other5_review == 'no') selected @endif 
                                               value="no">No</option>
                                               <option  @if ($data1->Other5_review == 'na') selected @endif 
                                                   value="na">NA</option>

                                        </select>
                                  
                                    </div>
                                </div>
                                 @php
                                 $userRoles = DB::table('user_roles')->where(['q_m_s_divisions_id' => $data->division_id])->get();
                                 $userRoleIds = $userRoles->pluck('user_id')->toArray();
                                 $users = DB::table('users')->whereIn('id', $userRoleIds)->get(); // Fetch user data based on user IDs
                                @endphp
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Person5">Other's 5 Person</label>
                                        <select disabled name="Other5_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other5_person">
                                            <option value="0">-- Select --</option>
                                            @foreach ($users as $user)
                                            <option {{ $data1->Other5_person == $user->id ? 'selected' : '' }}
                                                value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Department5"> Other's 5 Department</label>
                                        <select disabled name="Other5_Department_person"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="Other5_Department_person">
                                            <option value="0">-- Select --</option>
                                            <option @if ($data1->Other5_Department_person == 'Production') selected @endif
                                                value="Production">Production</option>
                                            <option  @if ($data1->Other5_Department_person == 'Warehouse') selected @endif 
                                               value="Warehouse"> Warehouse</option>
                                            <option  @if ($data1->Other5_Department_person == 'Quality_Control') selected @endif 
                                                value="Quality_Control">Quality Control</option>  
                                                <option @if ($data1->Other5_Department_person == 'Quality_Assurance') selected @endif
                                                    value="Quality_Assurance">Quality Assurance</option>
                                                <option  @if ($data1->Other5_Department_person == 'Engineering') selected @endif 
                                                   value="Engineering">Engineering</option>
                                                <option  @if ($data1->Other5_Department_person == 'Analytical_Development_Laboratory') selected @endif 
                                                    value="Analytical_Development_Laboratory">Analytical Development Laboratory</option> 
                                                    <option @if ($data1->Other5_Department_person == 'Process_Development_Lab') selected @endif
                                                        value="Process_Development_Lab">Process Development Laboratory / Kilo Lab</option>
                                                    <option  @if ($data1->Other5_Department_person == 'Technology transfer/Design') selected @endif 
                                                       value="Technology transfer/Design"> Technology Transfer/Design</option>
                                                    <option  @if ($data1->Other5_Department_person == 'Environment, Health & Safety') selected @endif 
                                                        value="Environment, Health & Safety">Environment, Health & Safety</option>   
                                                        <option @if ($data1->Other5_Department_person == 'Human Resource & Administration') selected @endif
                                                            value="Human Resource & Administration">Human Resource & Administration</option>
                                                        <option  @if ($data1->Other5_Department_person == 'Information Technology') selected @endif 
                                                           value="Information Technology">Information Technology</option>
                                                        <option  @if ($data1->Other5_Department_person == 'Project management') selected @endif 
                                                            value="Project management">Project management</option>  
                                        </select>
                                  
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="Impact Assessment16">Impact Assessment (By  Other's 5)</label>
                                        <textarea disabled class="summernote" name="Other5_Assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-49">{{$data1->Other5_Assessment}}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="group-input">
                                        <label for="productionfeedback"> Other's 5 Feedback</label>
                                        <textarea disabled class="summernote" name="Other5_feedback"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-50">{{$data1->Other5_feedback}}</textarea>
                                    </div>
                                </div>
                               
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">Other's 5 Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Other5_attachment">
                                                @if ($data1->Other5_attachment)
                                                @foreach(json_decode($data1->Other5_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Other5_attachment[]"
                                                    oninput="addMultipleFiles(this, 'Other5_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed By5"> Other's 5 Review Completed By</label>
                                        <input type="text" name="Other5_by" id="Other5_by" value="{{ $data1->Other5_by }}" disabled>
                                    
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="group-input">
                                        <label for="Review Completed On5">Other's 5 Review Completed On</label>
                                        <input disabled type="date" name="Other5_on" id="Other5_on" value="{{ $data1->Other5_on }}">
                                    </div>
                                </div>
                           @endif
                                
                                
                                

                                
                                
                                
 
                            </div>
                            <div class="button-block">
                                <button type="submit"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="ChangesaveButton" class="saveButton saveAuditFormBtn d-flex" style="align-items: center;">
                                    <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                    Save
                                </button>
                                <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="ChangeNextButton" class="nextButton">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                                </div>
                    </div>
                    <!-- investigation and capa -->
                    <div id="CCForm3" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            @if($data->stage==5)
                            <div class="row">
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Investigation Summary">Investigation Summary</label>
                                        <textarea id="Investigation_Summary" name="Investigation_Summary" value="{{ $data->Investigation_Summary }}"  cols="30" ></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Investigation Summary">Investigation Summary <span style="display: {{ $data->stage == 5 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Investigation_Summary"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-8">{{ $data->Investigation_Summary }}</textarea>
                                    </div>
                                    @error('Investigation_Summary')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Impect assessment">Impact Assessment</label>
                                        <textarea id="Impect_assessment" name="Impect_assessment" value="{{ $data->Impect_assessment }}"  cols="30" ></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Impact Assessment">Impact Assessment <span style="display: {{ $data->stage == 5 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Impact_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-9">{{ $data->Impact_assessment }}</textarea>
                                    </div>
                                    @error('Impact_assessment')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Root Cause">Root Cause</label>
                                        <textarea id="Root_cause" name="Root_cause" value="{{ $data->Root_cause }}"  cols="30" ></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Root Cause">Root Cause  <span style="display: {{ $data->stage == 5 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Root_cause"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="summernote-10">{{ $data->Root_cause }}</textarea>
                                    </div>
                                    @error('Root_cause')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="CAPA Rquired">CAPA Required ? <span class="text-danger"   style="display: {{ $data->stage == 5 ? 'inline' : 'none' }}" >*</span></label>
                                      <select name="CAPA_Rquired"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}   id="CAPA_Rquired" value="{{ $data->CAPA_Rquired }}">
                                        <option value="0"> -- Select --</option>
                                        <option @if ($data->CAPA_Rquired == 'yes') selected @endif
                                            value="yes">Yes</option>
                                        <option  @if ($data->CAPA_Rquired == 'no') selected @endif 
                                           value="no">No</option>
                                      </select>
                                      @error('CAPA_Rquired')
                                          <div class="text-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="capa type">CAPA Type? <span id="asteriskIcon32q1" style="display: {{ $data->CAPA_Rquired == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                      <select class="capa_type" name="capa_type"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}   id="capa_type" value="{{ $data->capa_type }}">
                                        <option value="0"> -- Select --</option>
                                        <option @if ($data->capa_type == 'Corrective_Action') selected @endif
                                            value="Corrective_Action">Corrective Action</option>
                                        <option  @if ($data->capa_type == 'Preventive_Action') selected @endif 
                                           value="Preventive_Action"> Preventive Action</option>
                                        <option  @if ($data->capa_type == 'Corrective&Preventive') selected @endif 
                                            value="Corrective&Preventive">Corrective & Preventive Action both</option>   
                                      </select>
                                      @error('capa_type')
                                          <div class="text-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="CAPA Description">CAPA Description  <span id="asteriskIcon32q13" style="display: {{ $data->CAPA_Rquired == 'yes' ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="CAPA_Description summernote" name="CAPA_Description"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="summernote-11">{{ $data->CAPA_Description }}</textarea>
                                    
                                        @error('CAPA_Description')
                                          <div class="text-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                <script>
                                    document.addEventListener('DOMContentLoaded', function () {
                                            var selectField = document.getElementById('CAPA_Rquired');
                                            var inputsToToggle = [];
        
                                            // Add elements with class 'facility-name' to inputsToToggle
                                            var facilityNameInputs = document.getElementsByClassName('capa_type');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                                            var facilityNameInputs = document.getElementsByClassName('CAPA_Description');
                                            for (var i = 0; i < facilityNameInputs.length; i++) {
                                                inputsToToggle.push(facilityNameInputs[i]);
                                            }
                        
                                            selectField.addEventListener('change', function () {
                                                var isRequired = this.value === 'yes';
        
                                                inputsToToggle.forEach(function (input) {
                                                    input.required = isRequired;
                                                });
        
                                                // Show or hide the asterisk icon based on the selected value
                                                var asteriskIcon321 = document.getElementById('asteriskIcon32q1');
                                                var asteriskIcon3211 = document.getElementById('asteriskIcon32q13');
                                                asteriskIcon321.style.display = isRequired ? 'inline' : 'none';
                                                asteriskIcon3211.style.display = isRequired ? 'inline' : 'none';
                                            });
                                        });
                                </script>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="External Auditing Agency">CAPA Description</label>
                                        <textarea  name="CAPA_Description" value="CAPA_Description"></textarea>
                                    </div>
                                </div> --}}
                                
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label class="mt-4" for="External Auditing Agency ">Post Categorization Of Deviation</label>
                                        <textarea class="summernote" name="Post_Categorization"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Post Categorization Of Deviation">Post Categorization Of Deviation <span style="display: {{ $data->stage == 5 ? 'inline' : 'none' }}" class="text-danger">*</span></label>
                                        <div><small class="text-primary">Please Refer Intial deviation category before updating.</small></div>
                                        <select name="Post_Categorization"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="Post_Categorization" value="Post_Categorization">
                                        <option value=""> -- Select --</option>
                                        <option @if ($data->Post_Categorization == 'major') selected @endif
                                            value="major">Major</option>
                                        <option  @if ($data->Post_Categorization == 'minor') selected @endif 
                                           value="minor">Minor</option>
                                           <option  @if ($data->Post_Categorization == 'critical') selected @endif 
                                            value="critical">Critical</option>
                                      </select>
                                      @error('Post_Categorization')
                                          <div class="text-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label class="mt-4"  for="External Auditing Agency">Investigation Of Revised Categorization</label>
                                        <textarea class="summernote" name="Investigation_Of_Review"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Investigation Of Revised Categorization">Justification for Revised Category <span class="text-danger" style="display:{{ $data->stage == 5 ? 'inline' : 'none' }}">*</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea class="summernote" name="Investigation_Of_Review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="summernote-13">{{ $data->Investigation_Of_Review }}</textarea>
                                    </div>
                                    @error('Post_Categorization')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Investigatiom Attachment">Investigation Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Investigation_attachment">
                                                @if ($data->Investigation_attachment)
                                                @foreach(json_decode($data->Investigation_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 5 ? '' : 'disabled' }} type="file" id="myfile" name="Investigation_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} 
                                                    oninput="addMultipleFiles(this, 'Investigation_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="capa_Attachments">CAPA Attachment </label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small>
                                            
                                            
                                            </div>
                                       
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachment[]"
                                                    oninput="addMultipleFiles(this, 'file_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="capa_Attachments">CAPA Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Capa_attachment">
                                                @if ($data->Capa_attachment)
                                                @foreach(json_decode($data->Capa_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 5 ? '' : 'disabled' }} type="file" id="myfile" name="Capa_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} 
                                                    oninput="addMultipleFiles(this, 'Capa_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="row">
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Investigation Summary">Investigation Summary</label>
                                        <textarea id="Investigation_Summary" name="Investigation_Summary" value="{{ $data->Investigation_Summary }}"  cols="30" ></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Investigation Summary">Investigation Summary</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea readonly class="summernote" name="Investigation_Summary"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-8">{{ $data->Investigation_Summary }}</textarea>
                                    </div>
                                    @error('Investigation_Summary')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Impect assessment">Impact Assessment</label>
                                        <textarea id="Impect_assessment" name="Impect_assessment" value="{{ $data->Impect_assessment }}"  cols="30" ></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Impact Assessment">Impact Assessment</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea readonly class="summernote" name="Impact_assessment"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-9">{{ $data->Impact_assessment }}</textarea>
                                    </div>
                                    @error('Impact_assessment')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="Root Cause">Root Cause</label>
                                        <textarea id="Root_cause" name="Root_cause" value="{{ $data->Root_cause }}"  cols="30" ></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Root Cause">Root Cause </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea readonly class="summernote" name="Root_cause"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="summernote-10">{{ $data->Root_cause }}</textarea>
                                    </div>
                                    @error('Root_cause')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="CAPA Rquired">CAPA Required ?</label>
                                      <select disabled name="CAPA_Rquired"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}   id="CAPA_Rquired" value="{{ $data->CAPA_Rquired }}">
                                        <option value="0"> -- Select --</option>
                                        <option @if ($data->CAPA_Rquired == 'yes') selected @endif
                                            value="yes">Yes</option>
                                        <option  @if ($data->CAPA_Rquired == 'no') selected @endif 
                                           value="no">No</option>
                                      </select>
                                      @error('CAPA_Rquired')
                                          <div class="text-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="group-input">
                                        <label for="capa type">CAPA Type?</label>
                                      <select disabled name="capa_type"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}   id="capa_type" value="{{ $data->capa_type }}">
                                        <option value="0"> -- Select --</option>
                                        <option @if ($data->capa_type == 'Corrective_Action') selected @endif
                                            value="Corrective_Action">Corrective Action</option>
                                        <option  @if ($data->capa_type == 'Preventive_Action') selected @endif 
                                           value="Preventive_Action"> Preventive Action</option>
                                        <option  @if ($data->capa_type == 'Corrective&Preventive') selected @endif 
                                            value="Corrective&Preventive">Corrective & Preventive Action both</option>   
                                      </select>
                                      @error('capa_type')
                                          <div class="text-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="External Auditing Agency">CAPA Description</label>
                                        <textarea  name="CAPA_Description" value="CAPA_Description"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="CAPA Description">CAPA Description</label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea readonly class="summernote" name="CAPA_Description"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="summernote-11">{{ $data->CAPA_Description }}</textarea>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label class="mt-4" for="External Auditing Agency ">Post Categorization Of Deviation</label>
                                        <textarea class="summernote" name="Post_Categorization"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Post Categorization Of Deviation">Post Categorization Of Deviation</label>
                                        <div><small class="text-primary">Please Refer Intial deviation category before updating.</small></div>
                                        <select disabled name="Post_Categorization"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="Post_Categorization" value="Post_Categorization">
                                        <option value=""> -- Select --</option>
                                        <option @if ($data->Post_Categorization == 'major') selected @endif
                                            value="major">Major</option>
                                        <option  @if ($data->Post_Categorization == 'minor') selected @endif 
                                           value="minor">Minor</option>
                                           <option  @if ($data->Post_Categorization == 'critical') selected @endif 
                                            value="critical">Critical</option>
                                      </select>
                                      @error('Post_Categorization')
                                          <div class="text-danger">{{ $message }}</div>
                                      @enderror
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label class="mt-4"  for="External Auditing Agency">Investigation Of Revised Categorization</label>
                                        <textarea class="summernote" name="Investigation_Of_Review"></textarea>
                                    </div>
                                </div> --}}
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Investigation Of Revised Categorization">Justification for Revised Category </label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea readonly class="summernote" name="Investigation_Of_Review"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="summernote-13">{{ $data->Investigation_Of_Review }}</textarea>
                                    </div>
                                    @error('Post_Categorization')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="Investigatiom Attachment">Investigatiom Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Investigation_attachment">
                                                @if ($data->Investigation_attachment)
                                                @foreach(json_decode($data->Investigation_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input disabled {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Investigation_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} 
                                                    oninput="addMultipleFiles(this, 'Investigation_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-12">
                                    <div class="group-input">
                                        <label for="capa_Attachments">CAPA Attachment </label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small>
                                            
                                            
                                            </div>
                                       
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="file_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="file_attachment[]"
                                                    oninput="addMultipleFiles(this, 'file_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                            
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="capa_Attachments">CAPA Attachment</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="Capa_attachment">
                                                @if ($data->Capa_attachment)
                                                @foreach(json_decode($data->Capa_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input disabled {{ $data->stage == 0 || $data->stage == 6 ? 'disabled' : '' }} type="file" id="myfile" name="Capa_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} 
                                                    oninput="addMultipleFiles(this, 'Capa_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            <div class="button-block">
                                <button type="submit"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="ChangesaveButton04" class=" saveAuditFormBtn d-flex" style="align-items: center;">
                                    <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                      Save
                                </button>
{{-- <a href="/rcms/qms-dashboard">
                                        <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="backButton">Back</button>
                                    </a> --}}
                                <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- QA Final Review -->
                    <div id="CCForm4" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="col-md-12">
                                    @if($data->stage == 5)
                                        <div class="group-input">
                                            <label for="QA Feedbacks">QA Feedbacks <span class="text-danger">*</span></label>
                                            <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                            <textarea class="summernote" name="QA_Feedbacks"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="summernote-14" required>{{ $data->QA_Feedbacks }}</textarea>
                                        </div>
                                    @else
                                        <div class="group-input">
                                            <label for="QA Feedbacks">QA Feedbacks</label>
                                            <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                            <textarea readonly class="summernote" name="QA_Feedbacks"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="summernote-14">{{ $data->QA_Feedbacks }}</textarea>
                                        </div>
                                    @endif
                                    @error('QA_Feedbacks')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- <div class="col-lg-12">
                                    <div class="group-input">
                                        <label for="Audit Attachments">QA Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting
                                                documents</small></div>
                                        <div class="file-attachment-field">
                                            <div class="file-attachment-list" id="audit_attachment"></div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input type="file" id="myfile" name="Audit_file[]"
                                                    oninput="addMultipleFiles(this, 'audit_attachment')" multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                
                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="QA attachments">QA Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="QA_attachments">
                                                @if ($data->QA_attachments)
                                                @foreach(json_decode($data->QA_attachments) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 5 ? '' : 'disabled' }} type="file" id="myfile" name="QA_attachments[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} 
                                                    oninput="addMultipleFiles(this, 'QA_attachments')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="ChangesaveButton05" class="saveAuditFormBtn d-flex" style="align-items: center;">
                                    <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                      Save
                                </button>
{{-- <a href="/rcms/qms-dashboard">
                                        <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="backButton">Back</button>
                                    </a> --}}
                                <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- QAH-->
                    <div id="CCForm5" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Closure Comments">Closure Comments  <span class="text-danger">@if($data->stage == 6)*@else @endif</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea @if ($data->stage != 6) disabled @endif required class="summernote" name="Closure_Comments"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="summernote-15">{{ $data->Closure_Comments }}</textarea>
                                    </div>
                                    @error('Closure_Comments')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <div class="group-input">
                                        <label for="Disposition of Batch">Disposition of Batch  <span class="text-danger">@if($data->stage == 6)*@else @endif</span></label>
                                        <div><small class="text-primary">Please insert "NA" in the data field if it does not require completion</small></div>
                                        <textarea @if ($data->stage != 6) readonly @endif required class="summernote" name="Disposition_Batch"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}  id="summernote-16">{{ $data->Disposition_Batch }}</textarea>
                                    </div>
                                    @error('Disposition_Batch')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <div class="group-input">
                                        <label for="closure attachment">Closure Attachments</label>
                                        <div><small class="text-primary">Please Attach all relevant or supporting documents</small></div>
                                        <div class="file-attachment-field">
                                            <div disabled class="file-attachment-list" id="closure_attachment">
                                                @if ($data->closure_attachment)
                                                @foreach(json_decode($data->closure_attachment) as $file)
                                                <h6 type="button" class="file-container text-dark" style="background-color: rgb(243, 242, 240);">
                                                    <b>{{ $file }}</b>
                                                    <a href="{{ asset('upload/' . $file) }}" target="_blank"><i class="fa fa-eye text-primary" style="font-size:20px; margin-right:-10px;"></i></a>
                                                    <a  type="button" class="remove-file" data-file-name="{{ $file }}"><i class="fa-solid fa-circle-xmark" style="color:red; font-size:20px;"></i></a>
                                                </h6>
                                           @endforeach
                                                @endif
                                            </div>
                                            <div class="add-btn">
                                                <div>Add</div>
                                                <input {{ $data->stage == 6 ? '' : 'disabled' }} type="file" id="myfile" name="closure_attachment[]"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} 
                                                    oninput="addMultipleFiles(this, 'closure_attachment')"
                                                    multiple>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="button-block">
                                <button type="submit"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} id="ChangesaveButton06" class=" saveAuditFormBtn d-flex" style="align-items: center;">
                                    <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                      Save
                                </button>
                                  {{-- <a href="/rcms/qms-dashboard">
                                        <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="backButton">Back</button>
                                    </a> --}}
                                <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="nextButton" onclick="nextStep()">Next</button>
                                <button type="button"> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                    <!-- Activity Log content -->
                    <div id="CCForm6" class="inner-block cctabcontent">
                        <div class="inner-block-content">
                            <div class="row">
                                <div class="sub-head">Submission</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submit by">Submit By :-</label>
                                        <div class="static">{{ $data->submit_by }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="submit on">Submit On :-</label>
                                        <div class="static">{{ $data->submit_on }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                <div class="group-input" style="width:1620px; height:100px; line-height:3em;  `padding:5px;">
                                    <label for="submit comment">Submit Comments :-</label>
                                    <div class="">{{ $data->submit_comment }}</div> 
                                </div>    
                                </div>
                                    
                                <div class="sub-head">HOD Review Completed</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="HOD Review Complete By">HOD Review Complete By :-</label>
                                        <div class="static">{{ $data->HOD_Review_Complete_By }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="HOD Review Complete On">HOD Review Complete On :-</label>
                                        <div class="static">{{ $data->HOD_Review_Complete_On }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input" style=" ">
                                        <label for="HOD Review Comments">HOD Review Comments :-</label>
                                        <div class="">{{ $data->HOD_Review_Comments }}</div>
                                    </div>
                                </div>
                                

                                <div class="sub-head">QA Initial Review Completed</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="QA Initial Review Complete By">QA Initial Review Complete By :-</label>
                                        <div class="static">{{ $data->QA_Initial_Review_Complete_By }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="QA Initial Review Complete On">QA Initial Review Complete On :-</label>
                                        <div class="static">{{ $data->QA_Initial_Review_Complete_On }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input" style="width:1620px; height:100px; line-height:3em;  `padding:5px;">
                                        <label for="QA Initial Review Comments">QA Initial Review Comments:-</label>
                                        <div class="">{{ $data->QA_Initial_Review_Comments }}</div>
                                    </div>
                                </div>
                                <div class="sub-head">CFT Review Complete</div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="CFT Review Complete By">CFT Review Complete By :-</label>
                                        <div class="static">{{ $data->CFT_Review_Complete_By }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="CFT Review Complete On">CFT Review Complete On :-</label>
                                        <div class="static">{{ $data->CFT_Review_Complete_On }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input" style="width:1620px; height:100px; line-height:3em;  `padding:5px; ">
                                        <label for="CFT Review Comments">CFT Review Comments :-</label>
                                        <div class="">{{ $data->CFT_Review_Comments }}</div>
                                    </div>
                                </div>
                                <div class="sub-head"> QA Final Review Completed</div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="QA Final Review Complete By"> QA Final Review Complete By :-</label>
                                        <div class="static">{{ $data->QA_Final_Review_Complete_By }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="QA Final Review Complete On"> QA Final Review Complete On :-</label>
                                        <div class="static">{{ $data->QA_Final_Review_Complete_On }}</div>
                                    </div>
                                </div> <div class="col-lg-12">
                                    <div class="group-input" style="width:1620px; height:100px; line-height:3em;  `padding:5px; ">
                                        <label for="QA Final Review Comments"> QA Final Review Comments :-</label>
                                        <div class="">{{ $data->QA_Final_Review_Comments }}</div>
                                    </div>
                                </div>
                                <div class="sub-head">Approved</div>

                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Approved By">Approved By :-</label>
                                        <div class="static">{{ $data->Approved_By }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="group-input">
                                        <label for="Approved On">Approved On :-</label>
                                        <div class="static">{{ $data->Approved_On }}</div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="group-input" style="width:1620px; height:100px; line-height:3em;  `padding:5px; ">
                                        <label for="Approved Comments">Approved Comments :-</label>
                                        <div class="">{{ $data->Approved_Comments }}</div>
                                    </div>
                                </div>
                                
                                
                                
                               
                                

                            </div>
                            <div class="button-block">
                                <button type="submit"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="saveButton saveAuditFormBtn d-flex" style="align-items: center;">
                                    <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none" role="status">
                                        <span class="sr-only">Loading...</span>
                                      </div>
                                      Save
                                </button>
<a href="/rcms/qms-dashboard">
                                        <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }} class="backButton">Back</button>
                                    </a>
                                <button type="submit"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}>Submit</button>
                                <button type="button"{{ $data->stage == 0 || $data->stage == 7 ? 'disabled' : '' }}> <a href="{{ url('rcms/qms-dashboard') }}" class="text-white">
                                        Exit </a> </button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
            <div class="sticky-buttons">
                <div
                  
      
                >
            <a type="button" class="" data-toggle="modal" data-target="#myModal3">
                
                  <svg width="18" height="24" viewBox="0 0 384 512" xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill="#ffffff"
                      d="M369.9 97.9L286 14C277 5 264.8-.1 252.1-.1H48C21.5 0 0 21.5 0 48v416c0 26.5 21.5 48 48 48h288c26.5 0 48-21.5 48-48V131.9c0-12.7-5.1-25-14.1-34M332.1 128H256V51.9zM48 464V48h160v104c0 13.3 10.7 24 24 24h104v288zm220.1-208c-5.7 0-10.6 4-11.7 9.5c-20.6 97.7-20.4 95.4-21 103.5c-.2-1.2-.4-2.6-.7-4.3c-.8-5.1.3.2-23.6-99.5c-1.3-5.4-6.1-9.2-11.7-9.2h-13.3c-5.5 0-10.3 3.8-11.7 9.1c-24.4 99-24 96.2-24.8 103.7c-.1-1.1-.2-2.5-.5-4.2c-.7-5.2-14.1-73.3-19.1-99c-1.1-5.6-6-9.7-11.8-9.7h-16.8c-7.8 0-13.5 7.3-11.7 14.8c8 32.6 26.7 109.5 33.2 136c1.3 5.4 6.1 9.1 11.7 9.1h25.2c5.5 0 10.3-3.7 11.6-9.1l17.9-71.4c1.5-6.2 2.5-12 3-17.3l2.9 17.3c.1.4 12.6 50.5 17.9 71.4c1.3 5.3 6.1 9.1 11.6 9.1h24.7c5.5 0 10.3-3.7 11.6-9.1c20.8-81.9 30.2-119 34.5-136c1.9-7.6-3.8-14.9-11.6-14.9h-15.8z"
                    />
                  </svg>
              </a>
                </div>
                {{-- <div
                  
                >
                <a type="button" class="" data-toggle="modal" data-target="#myModal4">
      
                  <svg width="24" height="24" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    <path
                      fill="#ffffff"
                      d="M25.01 49v46H103V49zM153 49v46h78V49zm128 0v46h78V49zm128 0v46h78V49zM55.01 113v64H119v46h18v-46h64v-64h-18v46H73.01v-46zM311 113v64h64v46h18v-46h64v-64h-18v46H329v-46zM89.01 241v46H167v-46zM345 241v46h78v-46zm-226 64v48h128v46h18v-46h128v-48h-18v30H137v-30zm98 112v46h78v-46z"
                    />
                  </svg>
              </a>
      
                </div> --}}
              </div>
        </div>
    </div>
{{-- ==================================================================== --}}


<div class="container">
      
     
    <!-- Modal -->
    <div class="modal right fade" id="myModal3" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
            <h4  class="modal-titles">Deviation Workflow</h4>
          </div>
          <div style="padding:3px;" class="modal-body">
           
             <Div class="button-box">
              <div class="mini_buttons">
                Opened
              </div>
<div class="down-logo">
    <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">

</div>
              <div class="mini_buttons">
                HOD Review
            </div>
            <div class="down-logo">
                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
            
            </div>
            <div class="mini_buttons">
                QA Initial Review
            </div>
            <div class="down-logo">
                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
            
            </div>
            <div class="mini_buttons">
                CFT Review
            </div>
            <div class="down-logo">
                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
            
            </div>
            <div class="mini_buttons">
                QA Final Review
            </div>
            <div class="down-logo">
                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
            
            </div>
            <div class="mini_buttons">
                QA Head Designee Approval
            </div>
            <div class="down-logo">
                <img class="dawn_arrow" src="{{ asset('user/images/down.gif') }}" alt="..." class="w-100 h-100">
            
            </div>
            <div class="mini_buttons">
                Closed - Done
            </div>
             </Div>
            </div>
          {{-- <div class="modal-footer">
            <button type="button" class="btn btn-default close-btn" data-dismiss="modal">Close</button>
          </div> --}}
        </div>
        
      </div>
    </div>
  {{-- --------------------------------------------------------------   --}}
  </div>
  <div class="container">
    
   
  
    <div class="modal right fade" id="myModal4" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
            <h4 class="modal-title">WorkFlow</h4>
          </div>
          <div class="modal-body">
           
             
                  
                  
      
            </div> 
          <div class="modal-footer">
            <button type="button" class="btn btn-default close-btn" data-dismiss="modal">Close</button>
          </div>
        </div>
        
      </div>
    </div>
    
  </div>
  {{-- ==================================================================== --}}

<!-- -----------------------------------------------------------modal body---------------------- -->
{{-- <div class="modal" id="myModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

      <!-- Modal Header -->
      <div style="background: #f7f2f" class="modal-header">
        <h4 class="modal-title">Customers</h4>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <!-- Modal body -->
      <div  class="modal-body">
        <div style="backgorund: #e9e2e2;" class="modal-sub-head">
            <div class="sub-main-head">

            <div  class="left-box">

                <div class="Activity-type">
                    <label style="font-weight: bold;" for="">Customer ID :</label>
                    
                    <input type="text">
                </div>
                <div class="Activity-type ">
                    <label style="font-weight: bold;     margin-left: 30px;" for=""> Email ID :</label>
                    
                    <input type="text">
                </div>
                <div class="Activity-type ">
                    <label style="font-weight: bold;     margin-left: -20px;" for=""> Customer Type :</label>
                
                    <input type="text">
                </div>
                <div class="Activity-type ">
                    <label style="font-weight: bold;     margin-left: 42px;" for=""> Status :</label>
                    
                    <input type="text">
                </div>
            </div>


            <div class="right-box">
                
                <div class="Activity-type">
                    <label style="font-weight: bold; " for="">Customer Name :</label>
                    
                    <input type="text">
                    
                </div>
                
                <div class="Activity-type">
                    <label style="font-weight: bold;  margin-left: 36px;" for="">Contact No :</label>
                    
                    <input type="text">
                    
                </div>
                <div class="Activity-type">
                    <label style="font-weight: bold;     margin-left: 57px;" for="">Industry :</label>
                    
                    <input type="text">
                    
                </div>
                <div class="Activity-type">
                    <label style="font-weight: bold;     margin-left: 66px; " for="">Region :</label>
                    
                    <input type="text">
                    
                </div>
            </div>
            
            </div>
            </div>
            <div class="Activity-type">
                <textarea style="margin-left: 126px; margin-top: 15px; width: 79%;" placeholder="Remarks" name="" id="" cols="30" ></textarea>
                </div>
      </div>
    </div>
  </div>
</div> --}}
<!-- Modal body -->
{{-- <div class="modal-body">
    <!-- Customer creation form -->
    <form id="customerForm">
        <!-- Input fields for customer details -->
        <div class="form-group">
            <label for="customer_id">Customer ID:</label>
            <input type="text" class="form-control" id="customer_id" name="customer_id" required>
        </div>
        <div class="form-group">
            <label for="email">Customer Name:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Customer Type:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Status:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Contact No:</label>
            <input type="number" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Industry:</label>
            <input type="text" class="form-control" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="email">Region:</label>
            <input type="text" class="form-control" id="region" name="region" required>
        </div>
        <div class="form-group">
            <label for="email">Remarks:</label>
            <textarea cols="30" class="form-control" id="remarks" name="remarks" required>
        </div>

        <!-- Add more input fields for other customer details -->

        <!-- Submit button -->
        <button type="submit" class="btn btn-primary">Create Customer</button>
    </form>
</div> --}}



{{-- -----------------new modal------------------- ? --}}

<div class="modal" id="myModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <!-- Modal Header -->
            <div style="background: #f7f2f" class="modal-header">
                <h4 class="modal-title">Customers</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <!-- Form for adding new customer -->
                <form method="POST" id="customerForm"> 
                    @csrf
<style>
.validationClass{
    margin-left: 100px
}
</style>
                    <div class="modal-sub-head">
                        <div class="sub-main-head">
                            <!-- Customer input fields -->
                            <!-- Left box -->
                            <div class="left-box">
                                <!-- Customer ID -->
                                <div class="Activity-type">
                                    <label style="font-weight: bold;" for="customer_id">Customer ID<span class="text-danger">*</span> :</label>
                                    <input type="text" id="customer_id" name="customer_id">
                                </div>
                                <span id="customer_id_error" class="text-danger validationClass"></span>
                                <!-- Email -->
                                <div class="Activity-type">
                                    <label style="font-weight: bold; margin-left: 30px;" for="email">Email ID<span class="text-danger">*</span> :</label>
                                    <input type="text" id="email" name="email">
                                </div>
                                <span id="email_error" class="text-danger validationClass"></span>
                                <!-- Customer Type -->
                                <div class="Activity-type">
                                    <label style="font-weight: bold; margin-left: -20px;" for="customer_type">Customer Type<span class="text-danger">*</span> :</label>
                                    <input type="text" id="customer_type" name="customer_type"> 
                                </div>
                                <span id="customer_type_error" class="text-danger validationClass"></span>
                                <!-- Status -->
                                <div class="Activity-type">
                                    <label style="font-weight: bold; margin-left: 42px;" for="status">Status<span class="text-danger">*</span> :</label>
                                    <input type="text" id="status" name="status">
                                </div>
                                <span id="status_error" class="text-danger validationClass"></span>
                            </div>

                            <!-- Right box -->
                            <div class="right-box">
                                <!-- Customer Name -->
                                <div class="Activity-type">
                                    <label style="font-weight: bold;" for="customer_name">Customer Name<span class="text-danger">*</span> :</label>
                                    <input type="text" id="customer_name" name="customer_name"> 
                                </div>
                                <span id="customer_name_error" class="text-danger validationClass"></span>
                                <!-- Contact No -->
                                <div class="Activity-type">
                                    <label style="font-weight: bold; margin-left: 36px;" for="contact_no">Contact No<span class="text-danger">*</span> :</label>
                                    <input type="text" id="contact_no" name="contact_no">
                                </div>
                                <span id="contact_no_error" class="text-danger validationClass"></span>
                                <!-- Industry -->
                                <div class="Activity-type">
                                    <label style="font-weight: bold; margin-left: 57px;" for="industry">Industry<span class="text-danger">*</span> :</label>
                                    <input type="text" id="industry" name="industry">
                                </div>
                                <span id="industry_error" class="text-danger validationClass"></span>
                                <!-- Region -->
                                <div class="Activity-type">
                                    <label style="font-weight: bold; margin-left: 66px; " for="region">Region<span class="text-danger">*</span> :</label>
                                    <input type="text" id="region" name="region">
                                </div>
                                <span id="region_id_error" class="text-danger validationClass"></span>
                            </div>
                        </div>
                    </div>
                    <!-- Remarks -->
                    <div class="Activity-type">
                        <textarea style="margin-left: 126px; margin-top: 15px; width: 79%;" placeholder="Remarks" name="remarks" id="remarks" cols="30"></textarea>
                    </div>
                    <!-- Save button -->
                    <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 20px;">
                        <button type="button" onclick="submitForm()" class="saveButton saveAuditFormBtn">
                            <div class="spinner-border spinner-border-sm auditFormSpinner" style="display: none" role="status">
                                <span class="sr-only">Loading...</span>
                              </div>
                              Save
                        </button>
                    </div>
                </form>
                
                <script>
                    function submitForm() {
                        document.querySelectorAll('.validationClass').forEach(span => {
                            span.textContent = '';
                        });

                        var formData = new FormData(document.getElementById('customerForm'));

                        // Perform basic validation
                        if (formData.get('customer_id').trim() === '') {
                            document.getElementById('customer_id_error').textContent = 'Customer ID is required.';
                            return;
                        }

                        if (formData.get('email').trim() === '') {
                            document.getElementById('email_error').textContent = 'Email is required.';
                            return;
                        }

                        if (formData.get('customer_type').trim() === '') {
                            document.getElementById('customer_type_error').textContent = 'Customer Type is required.';
                            return;
                        }
                        if (formData.get('status').trim() === '') {
                            document.getElementById('status_error').textContent = 'Status is required.';
                            return;
                        }
                        if (formData.get('customer_name').trim() === '') {
                            document.getElementById('customer_name_error').textContent = 'Customer Name is required.';
                            return;
                        }
                        if (formData.get('industry').trim() === '') {
                            document.getElementById('industry_error').textContent = 'Industry is required.';
                            return;
                        }
                        if (formData.get('contact_no').trim() === '') {
                            document.getElementById('contact_no_error').textContent = 'Contact Number is required.';
                            return;
                        }
                        if (formData.get('region').trim() === '') {
                            document.getElementById('region_error').textContent = 'Region is required.';
                            return;
                        }

//                         var myModal = document.getElementById('myModal');
// // var bootstrapModal = new bootstrap.Modal(myModal); // Initialize the Bootstrap modal

// // bootstrapModal.hide();
// myModal.style.display = 'none';

                        // Send POST request to server
                        fetch("{{ route('customers.store') }}", {
                            method: "POST",
                            body: formData
                        })
                        .then(response => {
                            console.log(response);
                            if (response.ok) {
                                // Close modal
//                                 var myModal = document.getElementById('myModal');
// var bootstrapModal = new bootstrap.Modal(myModal); // Initialize the Bootstrap modal

// bootstrapModal.hide();
location.reload();

                        // Show toaster message
                        // toastr.success('Record is created Successfully');
                                                // Get form data
                        var customerData = {
                            customer_id: formData.get('customer_id'),
                            customer_name: formData.get('customer_name'),
                            email: formData.get('email'),
                            customer_type: formData.get('customer_type'),
                            status: formData.get('status'),
                            contact_no: formData.get('contact_no'),
                            industry: formData.get('industry'),
                            region: formData.get('region'),
                            remarks: formData.get('remarks')
                        };
                        
                        // Append new row with form data to the table
                        var newRow = `
                            <tr>
                                <td>${customerData.customer_id}</td>
                                <td>${customerData.customer_name}</td>
                                <td>${customerData.email}</td>
                                <td>${customerData.customer_type}</td>
                                <td>${customerData.status}</td>
                                <td>${customerData.contact_no}</td>
                                <td>${customerData.industry}</td>
                                <td>${customerData.region}</td>
                                <td>${customerData.remarks}</td>
                            </tr>
                        `;
                        
                        document.querySelector('.table tbody').innerHTML += newRow;
                                            } else {
                                                console.error('Failed to create customer');
                                            }
                                        })
                    .catch(error => {
                        console.error('Error:', error);
                   });
                                    }
                </script>


                @php
                    $customers = DB::table('customer-details')->get();
                @endphp
                <!-- Customer grid view -->
                <div class="table-responsive">
                    <h5>Stored Customers</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Contact No</th>
                                <th>Industry</th>
                                <th>Region</th>
                                <th>Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Check if customers array is empty or null -->
                            @if($customers && count($customers) > 0)
                            <!-- Iterate over stored customers and display them -->
                                @foreach($customers as $customer)
                                <tr>
                                    <td>{{ $customer->customer_id }}</td>
                                    <td>{{ $customer->customer_name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->customer_type }}</td>
                                    <td>{{ $customer->status }}</td>
                                    <td>{{ $customer->contact_no }}</td>
                                    <td>{{ $customer->industry }}</td>
                                    <td>{{ $customer->region }}</td>
                                    <td>{{ $customer->remarks }}</td>
                                </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9">No results available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>












{{-- --------------------------------------------  --}}
<!-- JavaScript to handle form submission -->
{{-- <script>
    $(document).ready(function(){
        $('#customerForm').submit(function(e){
            e.preventDefault(); // Prevent default form submission
            
            // Create data object from form fields
            var formData = {
                customer_id: $('#customer_id').val(),
                email: $('#email').val(),
                // Add more fields here
            };

            // AJAX request to store customer details
            $.ajax({
                url: '{{ url('/customer/store') }}', // URL for storing customer details
                type: 'POST',
                data: formData, // Send form data
                success: function(response){
                    // Handle success
                    console.log(response); // Log success response for debugging
                    $('#myModal').modal('hide'); // Close the modal
                },
                error: function(xhr, status, error){
                    // Handle error
                    console.error(xhr.responseText); // Log error response
                }
            });
        });
    });
</script> --}}

<!-- -----------------------------------------------------end---------------------- -->
   
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
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#reference_record, #related_records, #audit_type'
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
document.addEventListener('DOMContentLoaded', function() {
    const addRowButton = document.getElementById('new-button-icon');
    addRowButton.addEventListener('click', function() {
        const department = this.parentNode.innerText.trim(); // Get the department name
            
        // Create a new row and insert it after the current row
        const newRow = document.createElement('tr');
        newRow.innerHTML = `<td style="background: #e1d8d8">${department}</td>
                            <td><textarea name="Person"></textarea></td>
                            <td><textarea name="Impect_Assessment"></textarea></td>
                            <td><textarea name="Comments"></textarea></td>
                            <td><textarea name="sign&date"></textarea></td>
                            <td><textarea name="Remarks"></textarea></td>`;
                
        // Insert the new row after the current row
        const currentRow = this.parentNode.parentNode;
        currentRow.parentNode.insertBefore(newRow, currentRow.nextSibling);
    });
});
</script>
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     document.getElementById('type_of_audit').addEventListener('change', function() {
        //         var typeOfAuditReqInput = document.getElementById('type_of_audit_req');
        //         if (typeOfAuditReqInput) {
        //             var selectedValue = this.value;
        //             if (selectedValue == 'others') {
        //                 typeOfAuditReqInput.setAttribute('required', 'required');
        //             } else {
        //                 typeOfAuditReqInput.removeAttribute('required');
        //             }
        //         } else {
        //             console.error("Element with id 'type_of_audit_req' not found");
        //         }
        //     });
        // });
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

<script>
        function addWhyField(con_class, name) {
            let mainBlock = document.querySelector('.why-why-chart')
            let container = mainBlock.querySelector(`.${con_class}`)
            let textarea = document.createElement('textarea')
            textarea.setAttribute('name', name);
            container.append(textarea)
        }
    </script>
    <div class="modal fade" id="child-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form action="{{ route('deviation_child_1', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            @if ($data->stage == 3)
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="rca">
                                        RCA
                                </label>
                                <br>
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="extension">
                                        Extension
                                </label>
                            @endif
                            
                            @if ($data->stage == 5)
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="capa">
                                        CAPA
                                </label>
                                <br>
                                <label for="major">
                                    <input type="radio" name="child_type" id="major"
                                        value="extension">
                                        Extension
                                </label>
                            @endif
                        </div>
    
                    </div>
    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit">Continue</button>
                    </div>
                </form>
    
            </div>
        </div>
    </div>
    {{-- <div class="modal fade" id="child-modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Child</h4>
                </div>
                <form  method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="group-input">
                            <label for="major">
                                <input type="radio" name="rsa" id="major"
                                    value="rsa">
                                    RSA
                            </label>
                            <br>
                            <label for="major1">
                                <input type="radio" name="extension" id="major1"
                                    value="extension">
                                    Extension
                            </label>
                        </div>
    
                    </div>
    
                    <!-- Modal footer -->
                    <div class="modal-footer">
                        <button type="button" data-bs-dismiss="modal">Close</button>
                        <button type="submit">Continue</button>
                    </div>
                </form>
    
            </div>
        </div>
    </div> --}}
    
    <div class="modal fade" id="more-info-required-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"> 
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <form action="{{ route('deviation_reject', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>
    
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button>Close</button>
                    </div> -->
                    <div class="modal-footer">
                        <button type="submit">
                            Submit
                        </button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="cancel-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <form action="{{ route('deviationCancel', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>
    
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button>Close</button>
                    </div> -->
                    <div class="modal-footer">
                      <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    
    <div class="modal fade" id="deviationIsCFTRequired">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"> 
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <form action="{{ url('deviationIsCFTRequired', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>
    
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button>Close</button>
                    </div> -->
                    <div class="modal-footer">
                      <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="sendToInitiator">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"> 
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <form action="{{ route('check', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>
    
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button>Close</button>
                    </div> -->
                    <div class="modal-footer">
                      <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="hodsend">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"> 
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <form action="{{ route('check2', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>
    
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button>Close</button>
                    </div> -->
                    <div class="modal-footer">
                      <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="qasend">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content"> 
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
    
                <form action="{{ route('check3', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment <span class="text-danger">*</span></label>
                            <input type="comment" name="comment" required>
                        </div>
                    </div>
    
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button>Close</button>
                    </div> -->
                    <div class="modal-footer">
                      <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="signature-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('deviation_send_stage', $data->id) }}" method="POST" id="signatureModalForm">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input type="comment" name="comment">
                        </div>
                    </div>
    
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button>Close</button>
                    </div> -->
                    <div class="modal-footer">
                        <button type="submit" class="signatureModalButton">
                            <div class="spinner-border spinner-border-sm signatureModalSpinner" style="display: none" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                            Submit
                        </button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="cft-not-reqired">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('cftnotreqired', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input type="comment" name="comment">
                        </div>
                    </div>
    
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button>Close</button>
                    </div> -->
                    <div class="modal-footer">
                      <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
    
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">E-Signature</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('deviation_qa_more_info', $data->id) }}" method="POST">
                    @csrf
                    <!-- Modal body -->
                    <div class="modal-body">
                        <div class="mb-3 text-justify">
                            Please select a meaning and a outcome for this task and enter your username
                            and password for this task. You are performing an electronic signature,
                            which is legally binding equivalent of a hand written signature.
                        </div>
                        <div class="group-input">
                            <label for="username">Username</label>
                            <input type="text" name="username" required>
                        </div>
                        <div class="group-input">
                            <label for="password">Password</label>
                            <input type="password" name="password" required>
                        </div>
                        <div class="group-input">
                            <label for="comment">Comment</label>
                            <input type="comment" name="comment">
                        </div>
                    </div>
    
                    <!-- Modal footer -->
                    <!-- <div class="modal-footer">
                        <button type="submit" data-bs-dismiss="modal">Submit</button>
                        <button>Close</button>
                    </div> -->
                    <div class="modal-footer">
                      <button type="submit">Submit</button>
                        <button type="button" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
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
        VirtualSelect.init({
            ele: '#Facility, #Group, #Audit, #Auditee ,#capa_related_record,'
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
            document.addEventListener('DOMContentLoaded', function () {
                const removeButtons = document.querySelectorAll('.remove-file');
    
                removeButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const fileName = this.getAttribute('data-file-name');
                        const fileContainer = this.closest('.file-container');
    
                        // Hide the file container
                        if (fileContainer) {
                            fileContainer.style.display = 'none';
                        }
                    });
                });
            });
        </script> 
        <script>
            var maxLength = 255;
            $('#docname').keyup(function() {
                var textlen = maxLength - $(this).val().length;
                $('#rchars').text(textlen);});
        </script>
@endsection
