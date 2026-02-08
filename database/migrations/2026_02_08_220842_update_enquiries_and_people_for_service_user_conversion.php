<?php

declare(strict_types=1);

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
        Schema::table('enquiries', function (Blueprint $table): void {
            $table->string('status')->default('open')->after('creator_id');
            $table->timestamp('converted_at')->nullable()->after('status');
        });

        Schema::table('people', function (Blueprint $table): void {
            $table->boolean('is_service_user')->default(false)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enquiries', function (Blueprint $table): void {
            $table->dropColumn(['status', 'converted_at']);
        });

        Schema::table('people', function (Blueprint $table): void {
            $table->dropColumn('is_service_user');
        });
    }
};
