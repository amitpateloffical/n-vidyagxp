<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nirvanas', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->integer('record_number')->nullable();
            $table->string('division_id')->nullable();
           // $table->string('division_code')->nullable();
          
            $table->date('intiation_date')->nullable();
           $table->string('assign_to')->nullable();
           $table->date('due_date')->nullable();
            $table->longText('short_description')->nullable();
            $table->longText('Class_Session_information')->nullable();
           
           
            $table->string('Trainer_Name')->nullable();
            $table->string('audit_type')->nullable();
            $table->string('registrationend_date')->nullable();
            $table->string('Training_Topic')->nullable();
            $table->string('Scheduled_Start_date')->nullable();
            $table->string('Scheduled_End_date')->nullable();
            $table->string('initial_comments')->nullable();

            $table->string('audit-agenda-grid')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('Title_Document')->nullable();
        //  $table->string('Supporting_Documents')->nullable();
            $table->string('Remarks')->nullable();
            $table->date('date')->nullable();
            $table->string('start_time')->nullable();
            $table->string('end_time')->nullable();
            $table->string('topic')->nullable();
            $table->string('responsible_person')->nullable();
           $table->string('Supporting_Documents')->nullable();
           $table->string('inv_attachment')->nullable();
           $table->string('audit_file_attachment')->nullable();

//===================================================== Attendace 

           $table->string('TrainingTopic')->nullable();
           $table->string('TrainersMultipersonField')->nullable();
           $table->string('AttendeeName')->nullable();
           $table->string('Department')->nullable();
           $table->string('TrainingAttended')->nullable();
           $table->string('Training_ModeOnline_Classroom')->nullable();
           $table->string('Training_Completion_Date')->nullable();
           $table->string('pass_fail')->nullable();
           $table->string('No_Attempts')->nullable();
           $table->string('Rating')->nullable();
           $table->string('Supporting Document_2')->nullable();
           $table->string('remarks_2')->nullable();
           $table->string('Title_Document_2')->nullable();
           $table->string('Supporting_Document-3')->nullable();
           $table->string('Remarks_3')->nullable(); 
           $table->string('Feedback')->nullable();
           $table->string('if_comments')->nullable();













$table->string('status')->nullable();
// $table->string('Remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nirvanas');
    }
};
