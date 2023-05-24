<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')
                ->nullable()
                ->index('users_organization_id_index');

            $table->foreign('organization_id')->references('id')
                ->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('users_organization_id_index');
            $table->dropForeign('users_organization_id_foreign');
            $table->dropColumn('organization_id');
        });
    }
};
