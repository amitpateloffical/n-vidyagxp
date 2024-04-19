<?php

namespace Database\Seeders;

use App\Models\Process;
use App\Models\QMSProcess;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProcessSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $process  = new Process();
        $process->division_id = 1;
        $process->process_name = "New Document";
        $process->save();


        $process  = new Process();
        $process->division_id = 2;
        $process->process_name = "New Document";
        $process->save();


        $process  = new Process();
        $process->division_id = 3;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 4;
        $process->process_name = "New Document";
        $process->save();


        $process  = new Process();
        $process->division_id = 5;
        $process->process_name = "New Document";
        $process->save();


        $process  = new Process();
        $process->division_id = 6;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 7;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 8;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 9;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id =    10;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 11;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 12;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 13;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 14;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 15;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 16;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 17;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 18;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 19;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 20;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 20;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 21;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 22;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 23;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 24;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 25;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 26;
        $process->process_name = "New Document";
        $process->save();

        $process  = new Process();
        $process->division_id = 27;
        $process->process_name = "New Document";
        $process->save();




        $processNames = [
            "Extension",
            "Action Item",
            "Observation",
            "Root Cause Analysis",
            "Risk Assessment",
            "Management Review",
            "External Audit",
            "Internal Audit",
            "Audit Program",
            "CAPA",
            "Change Control",
            "New Document",
            "Lab Incident",
            "Effective Check",
            "Deviation"
        ];

        // Loop through each process name
        foreach ($processNames as $index => $processName) {
            // Loop through 8 divisions
            // Loop through 8 divisions
            for ($divisionId = 1; $divisionId <= 10; $divisionId++) {
                $process = new QMSProcess();
                $process->division_id = $divisionId;
                $process->process_name = $processName;
                $process->save();
            }

            if($processName == "New Document"){
                for ($divisionId = 14; $divisionId <= 27; $divisionId++) {
                    $process = new QMSProcess();
                    $process->division_id = $divisionId;
                    $process->process_name = $processName;
                    $process->save();
                }
            }
        }
    }
}

