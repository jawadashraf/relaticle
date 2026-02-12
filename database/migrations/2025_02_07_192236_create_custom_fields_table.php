<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /**
         * Custom Field Sections
         */
        Schema::create('custom_field_sections', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('team_id')->nullable()->index();
            $table->string('width')->nullable();

            $table->string('code');
            $table->string('name');
            $table->string('type');
            $table->string('entity_type');
            $table->unsignedBigInteger('sort_order')->nullable();

            $table->string('description')->nullable();

            $table->boolean('active')->default(true);
            $table->boolean('system_defined')->default(false);

            $table->json('settings')->nullable();

            $table->unique(['entity_type', 'code', 'team_id']);

            $table->index(['team_id', 'entity_type', 'active'], 'cf_sections_team_entity_active_idx');

            $table->timestamps();
        });

        /**
         * Custom Fields
         */
        Schema::create('custom_fields', function (Blueprint $table): void {
            $table->id();

            $table->unsignedBigInteger('custom_field_section_id')->nullable();
            $table->string('width')->nullable();

            $table->foreignId('team_id')->nullable()->index();

            $table->string('code');
            $table->string('name');
            $table->string('type');
            $table->string('lookup_type')->nullable();
            $table->string('entity_type');
            $table->unsignedBigInteger('sort_order')->nullable();
            $table->json('validation_rules')->nullable();

            $table->boolean('active')->default(true);
            $table->boolean('system_defined')->default(false);

            $table->json('settings')->nullable();

            $table->unique(['code', 'entity_type', 'team_id'], 'custom_fields_code_entity_type_team_id_unique');

            $table->index(['team_id', 'entity_type', 'active'], 'custom_fields_team_entity_active_idx');

            $table->timestamps();
        });

        /**
         * Custom Field Options
         */
        Schema::create('custom_field_options', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('team_id')->nullable()->index();

            $table->foreignId('custom_field_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('name')->nullable();
            $table->unsignedBigInteger('sort_order')->nullable();
            $table->json('settings')->nullable();

            $table->timestamps();

            $table->unique(['custom_field_id', 'name', 'team_id']);
        });

        /**
         * Custom Field Values
         */
        Schema::create('custom_field_values', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('team_id')->nullable()->index();

            $table->morphs('entity');
            $table->foreignId('custom_field_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->text('string_value')->nullable();
            $table->longText('text_value')->nullable();
            $table->boolean('boolean_value')->nullable();
            $table->bigInteger('integer_value')->nullable();
            $table->double('float_value')->nullable();
            $table->date('date_value')->nullable();
            $table->dateTime('datetime_value')->nullable();
            $table->json('json_value')->nullable();

            $table->unique(['entity_type', 'entity_id', 'custom_field_id', 'team_id'], 'custom_field_values_entity_type_unique');

            $table->index(['team_id', 'entity_type', 'entity_id'], 'custom_field_values_team_entity_idx');

            $table->index(['entity_id', 'custom_field_id'], 'custom_field_values_entity_id_custom_field_id_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('custom_field_values');
        Schema::dropIfExists('custom_field_options');
        Schema::dropIfExists('custom_fields');
        Schema::dropIfExists('custom_field_sections');
    }
};
