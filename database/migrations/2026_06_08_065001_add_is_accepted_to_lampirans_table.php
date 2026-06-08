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
    Schema::table('lampirans', function (Blueprint $table) {
        $table->boolean('is_accepted')->default(0)->after('file_path');
    });
}

public function down(): void
{
    Schema::table('lampirans', function (Blueprint $table) {
        $table->dropColumn('is_accepted');
    });
}
};
