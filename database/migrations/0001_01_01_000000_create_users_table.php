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
        // Tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('usertype')->default('user'); // admin, ptk, siswa
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel password_reset_tokens
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email');
            $table->string('token');
            $table->timestamp('created_at')->nullable();
            $table->primary(['email', 'token']); // Gabungkan email dan token sebagai primary key
            $table->unique('token'); // Pastikan token unik
        });

        // Tabel sessions
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary(); // session id (UUID atau string)
            $table->foreignId('user_id')->nullable()->constrained('users')->index();
            $table->string('ip_address', 45)->nullable(); // Untuk IPv6, gunakan panjang 45 karakter
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
            $table->timestamps(); // Menambahkan created_at dan updated_at untuk sessions
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
