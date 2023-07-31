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
        Schema::create('comments', function (Blueprint $table) {
                $table->id();
                $table->longText('text');
                $table->foreignId('userId') ; 
                $table->foreignId('postId') ; 
                $table->timestamps();
                $table->foreign('userId')->references('id')->on('users')->cascadeOnDelete()->cascadeOnUpdate();
                $table->foreign('postId')->references('id')->on('posts')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            //
        });
    }
};
