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
        min-width: 100vw;
        min-height: 100vh;
    }

    .w-10 {
        width: 10%;
    }

    .w-20 {
        width: 20%;
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

    table,
    th,
    td {
        border: 1px solid black;
        border-collapse: collapse;
        font-size: 0.9rem;
    }

    table {
        width: 100%;
    }

    th,
    td {
        padding: 10px;
        text-align: left;
    }

    header .head {
        font-weight: bold;
        text-align: center;
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
        position: fixed;
        bottom: -40px;
        left: 0;
        width: 100%;
    }

    .inner-block {
        padding: 10px;
    }

    .inner-block .head {
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 5px;
    }

    .inner-block .division {
        margin-bottom: 10px;
    }

    .first-table {
        border-top: 1px solid black;
        margin-bottom: 20px;
    }

    .first-table table td,
    .first-table table th,
    .first-table table {
        border: 0;
    }

    .second-table td:nth-child(1)>div {
        margin-bottom: 10px;
    }

    .second-table td:nth-child(1)>div:nth-last-child(1) {
        margin-bottom: 0px;
    }

    .table_bg {
        background: #4274da57;
    }
    .pagenum:before {
        content: counter(page);
    }
</style>

<body>

    <header>
        <table>
            <tr>
                <td class="w-70 head">
                   Deviation Audit Trail Report
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
                    <strong>Deviation No.</strong>
                </td>
                <td class="w-40">
                    {{ Helpers::divisionNameForQMS($doc->division_id) }}/{{ Helpers::year($doc->created_at) }}/{{ str_pad($doc->record, 4, '0', STR_PAD_LEFT) }}
                </td>
                <td class="w-30">
                    <strong>Record No.</strong> {{ str_pad($doc->record, 4, '0', STR_PAD_LEFT) }}
                </td>
            </tr>
        </table>
    </header>

    <div class="inner-block">

        <div class="head">Deviation Audit Trail Report</div>

        <div class="division">
            {{ Helpers::divisionNameForQMS($doc->division_id) }}/{{ Helpers::year($doc->created_at) }}/{{ str_pad($doc->record, 4, '0', STR_PAD_LEFT) }}
        </div>

        {{-- <div class="first-table">
            <table>
                <tr>
                    <td class="w-50">
                        <strong>Config Area :</strong> All - No Filter
                    </td>
                    <td class="w-50">
                        <strong>Start Date (GMT) :</strong> {{ $doc->created_at }}
                    </td>
                </tr>
                <tr>
                    <td class="w-50">
                        <strong>Config Sub Area :</strong> All - No Filter
                    </td>
                    <td class="w-50">
                        <strong>End Date (GMT) :</strong>
                        @if ($doc->stage >= 9)
                            {{ $doc->updated_at }}
                        @endif
                    </td>
                </tr>
                <tr>
                    <td class="w-50">&nbsp;</td>
                    <td class="w-50">
                        <strong>Person Responsible : {{ $doc->originator }}</strong>
                    </td>
                </tr>
            </table>
        </div> --}}

        <div class="second-table">
            <table>
                <thead>
                    <tr class="table_bg">
                        <th>Flow Changed From</th>
                        <th>Flow Changed To</th>
                        <th>Data Field</th>
                        <th>Action Type</th>
                        <th>Performer</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $previousItem = null;
                    @endphp
                    @foreach ($data as $datas => $dataDemo)
                        <tr>
                            <td>
                                @if($previousItem == null)
                                <div><strong>Changed From :</strong>{{" Intiation"}}</div>
                                @else
                             <div><strong>Changed From :</strong>{{$previousItem->origin_state ? $previousItem->origin_state  : "Not Applicable"}}</div>
                                @endif
                                  @php
                                 $previousItem  = $dataDemo;
                                @endphp                 
    
                           
                             </td>
                            <td>
                                <div><strong>Changed To :</strong>{{$dataDemo->origin_state ? $dataDemo->origin_state  : "Not Applicable"}}</div>
       
                               </td>
                            <td>
                                    <div>
                                <strong> Data Field Name :</strong>{{ $dataDemo->activity_type ? $dataDemo->activity_type  : "Not Applicable" }}</a> </div>
                                <div style="margin-top: 5px;">
                                <strong>Change From :</strong>{{$dataDemo->previous ? $dataDemo->previous  : "Not Applicable"}}</div>
                                        <br>
                                        <!--  -->
                                <div ><strong>Changed To :</strong>{{$dataDemo->current ? $dataDemo->current  : "Not Applicable"}}</div> 
                                        <div style="margin-top: 5px;"><strong>Change Type :</strong>{{$dataDemo->action_name ? $dataDemo->action_name  : "Not Applicable"}}
                                        </div>
                            </td>
                            {{-- <td>
                                {{$dataDemo->previous == "NULL" ? 'Modify' : 'New'}}
                            </td> --}}
                            {{-- <td>
                                {{$dataDemo->action_name ? $dataDemo->action_name  : "Not Applicable"}}
                            </td> --}}
                            <td>
                                <div>
                               <strong> Action Name :</strong>{{$dataDemo->action ? $dataDemo->action  : "Not Applicable"}}
        
                                </div>
                                </td>
                            <td>
                                <div ><strong> Peformed By :</strong>{{$dataDemo->user_name ? $dataDemo->user_name  : "Not Applicable"}}</div>
                                <div style="margin-top: 5px;">  <strong>Performed On :</strong>{{$dataDemo->created_at ? $dataDemo->created_at  : "Not Applicable"}}</div>
                                 <div style="margin-top: 5px;"><strong> Comments :</strong>{{$dataDemo->comment ? $dataDemo->comment  : "Not Applicable"}}</div>       
                            </td>
                            
                        </tr>
                        @php
                        $previousItem = $dataDemo;
                        @endphp
                    @endforeach
                </tbody>
            </table>
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
                <td class="w-30">
                    <strong>Page :</strong>  <span class="pagenum"></span> of 1
                </td>
            </tr>
        </table>
    </footer>

</body>

</html>
