<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBusinessBackupSharesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sheet_businessbackup_shares', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('sheet_businessbackup_id');
            $table->foreign('sheet_businessbackup_id')
                ->references('id')->on('sheet_businessbackups')
                ->onDelete('cascade');

            $table->string('shared_with')
                ->index()
                ->comment('Shared with like user/role/todo');
            
            $table->integer('shared_id')
                ->index()
                ->comment('Id of shared with like user_id/role_id/todo_id');

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
        Schema::dropIfExists('sheet_businessbackup_shares');
    }
}
