<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $tableName = 'tokens';

    public function up(): void
    {
        Schema::create($this->tableName, function(Blueprint $table){
            $table->bigInteger('user_id');
            $table->bigInteger('target_chat_id');
            $table->string('secret');
            $table->timestamp('created_at');
            $table->timestamp('revoked_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists($this->tableName);
    }
};
