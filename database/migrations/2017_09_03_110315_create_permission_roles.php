<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create("admin_roles", function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 30)->default('');
            $table->string('description', 100)->default('');
            $table->timestamps();
        });

        Schema::create("admin_permissions", function(Blueprint $table){
            $table->increments('id');
            $table->string('name', 30)->default('');
            $table->string('description', 100)->default('');
            $table->timestamps();
        });

        Schema::create("admin_permission_roles", function(Blueprint $table){
            $table->increments('id');
            $table->integer("role_id");
            $table->integer("permission_id");
        });

        Schema::create("admin_role_users", function(Blueprint $table){
            $table->increments('id');
            $table->integer("role_id");
            $table->integer("user_id");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('admin_roles');
        Schema::drop('admin_permissions');
        Schema::drop('admin_permission_roles');
        Schema::drop('admin_role_users');
    }
}
