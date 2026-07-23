<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('literatures', function (Blueprint $table) {
            $table->string('cover_url')->nullable()->after('file_url');
        });
    }
    
    public function down()
    {
        Schema::table('literatures', function (Blueprint $table) {
            $table->dropColumn('cover_url');
        });
    }
};
