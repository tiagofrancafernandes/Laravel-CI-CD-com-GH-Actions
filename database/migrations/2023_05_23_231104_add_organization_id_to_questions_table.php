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
        Schema::table('questions', function (Blueprint $table) {
            $table->unsignedBigInteger('organization_id')
                ->nullable()
                ->index('questions_organization_id_index');

            $table->foreign('organization_id')->references('id')
                ->on('organizations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropIndex('questions_organization_id_index');
            $table->dropForeign('questions_organization_id_foreign');
            $table->dropColumn('organization_id');
        });
    }
};
