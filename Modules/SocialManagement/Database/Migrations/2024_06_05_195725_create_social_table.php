<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSocialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('social_table', function (Blueprint $table) {
            $table->increments('id'); // This will create an auto-incrementing primary key
            $table->unsignedInteger('business_id');
            $table->string('name', 191)->charset('utf8mb4')->collation('utf8mb4_unicode_ci');
            $table->unsignedInteger('social_category_id')->nullable();
            $table->text('description')->charset('utf8mb4')->collation('utf8mb4_unicode_ci')->nullable();
            $table->unsignedInteger('created_by');
            $table->timestamps();

            // Indexes and foreign keys (if applicable)
            $table->index('business_id');
            $table->index('social_category_id');
            $table->index('created_by');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('social_table');
    }
}
