<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Vérifie si la colonne 'profile_photo_path' existe déjà dans la table 'users'
        if (!Schema::hasColumn('users', 'profile_photo_path')) {
            Schema::table('users', function (Blueprint $table) {
                $table->string('profile_photo_path', 2048)->nullable(); // Ajoute la colonne si elle n'existe pas
            });
        }
    }
    
    
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('profile_photo_path');
        });
    }    
};
