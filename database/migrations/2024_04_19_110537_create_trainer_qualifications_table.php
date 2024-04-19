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
        Schema::create('trainer_qualifications', function (Blueprint $table) {
            $table->id();
            $table->string('record_number')->nullable();
            $table->string('division_code')->nullable();
            $table->string('Initiator_id')->nullable();
            $table->date('intiation_date')->nullable();
            $table->string('assign_to')->nullable();
            $table->date('due_date')->nullable();
            $table->string('short_description')->nullable();
            $table->string('trainer_name')->nullable();
            $table->text('qualification')->nullable();
            $table->string('designation')->nullable();
            $table->string('department')->nullable();
            $table->text('Experience')->nullable();
            $table->string('priority_level')->nullable();
            $table->text('initiated_through')->nullable();
            $table->longtext('initiated_if_other')->nullable();
            $table->longtext('external_agencies')->nullable();
            $table->longtext('trainer_skill_set')->nullable();
            $table->text('serial_number')->nullable();
            $table->string('title_of_document')->nullable();
            $table->text('supporting_document')->nullable();
            $table->longtext('remarks')->nullable();
            $table->text('trainingQualificationStatus')->nullable();
            $table->string('Q_comment')->nullable();
            $table->longtext('inv_attachment')->nullable();
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trainer_qualifications');
    }
};
