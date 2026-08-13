<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();

            // ID pengajuan dari database SIADMIN.
            $table->string('id_pengajuan', 255);

            // Jenis karya ilmiah.
            // thesis      = Tesis
            // dissertation = Disertasi
            $table->enum('jenis_karya', [
                'thesis',
                'dissertation',
            ]);

            // Link repository yang dikelola SIPERPUS.
            $table->text('repository_url');

            // Bentuk repository.
            // file   = repository berupa file
            // folder = repository berupa folder
            $table->enum('repository_type', [
                'file',
                'folder',
            ]);

            // Status repository.
            // needs_action = masih perlu diperiksa/ditangani
            // active       = sudah diverifikasi dan aktif
            $table->enum('status', [
                'needs_action',
                'active',
            ])->default('needs_action');

            $table->timestamps();

            // Satu pengajuan hanya memiliki satu repository.
            $table->unique('id_pengajuan');

            // Mempercepat pencarian berdasarkan jenis karya.
            $table->index('jenis_karya');

            // Mempercepat filter berdasarkan status.
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repositories');
    }
};
