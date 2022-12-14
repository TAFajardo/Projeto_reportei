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
        Schema::create('repo_users', function (Blueprint $table) {
            $table->id();
            $table->string('owner_name');
            $table->string('repo_id');
            $table->string('github_id');
            $table->string('repo_name');
            $table->string('repo_url');
            $table->string('repo_full_name');
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
        Schema::dropIfExists('repouser');
    }
};
