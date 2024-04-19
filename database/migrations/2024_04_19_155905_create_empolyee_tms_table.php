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
        Schema::create('employee_tms', function (Blueprint $table) {
            $table->id();
            $table->string('record_number')->nullable();
            $table->unsignedBigInteger('division_id')->nullable();
            $table->string('initiator')->nullable();
            $table->date('intiation_date')->nullable();
            $table->string('assign_to')->nullable();
            $table->date('due_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->string('employee_ID')->nullable();
            $table->string('gender')->nullable();
            $table->string('department_name')->nullable();
            $table->string('job_title')->nullable();
            $table->longText('attached_cv')->nullable();
            $table->longText('certificate_classification')->nullable();
            $table->string('country')->nullable();
            $table->string('zone')->nullable();
            $table->string('city')->nullable();
            $table->string('sitename')->nullable();
            $table->string('building')->nullable();
            $table->string('floor')->nullable();
            $table->string('room')->nullable();
            $table->longText('picture')->nullable();
            $table->text('comment')->nullable();
            $table->string('status')->nullable();
            $table->integer('stage')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('empolyee_tms');
    }
};
