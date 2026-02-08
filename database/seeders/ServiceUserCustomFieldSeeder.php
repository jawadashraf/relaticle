<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\CustomFields\PeopleField;
use App\Models\People;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Relaticle\CustomFields\Enums\CustomFieldSectionType;
use Relaticle\CustomFields\Models\CustomField;
use Relaticle\CustomFields\Models\CustomFieldSection;

final class ServiceUserCustomFieldSeeder extends Seeder
{
    public function run(): void
    {
        // We sync fields for all teams or at least the first one for development
        Team::all()->each(function (Team $team) {
            $this->syncFieldsForTeam($team);
        });
    }

    private function syncFieldsForTeam(Team $team): void
    {
        // 1. Create a "Service User Case File" section
        $section = CustomFieldSection::updateOrCreate([
            'tenant_id' => $team->id,
            'entity_type' => People::class,
            'code' => 'service_user_case_file',
        ], [
            'name' => 'Service User Case File',
            'type' => CustomFieldSectionType::SECTION,
            'active' => true,
        ]);

        $fields = [
            PeopleField::CONSENT_DATA_STORAGE,
            PeopleField::CONSENT_REFERRALS,
            PeopleField::CONSENT_COMMUNICATIONS,
            PeopleField::PRESENTING_ISSUES,
            PeopleField::RISK_SUMMARY,
            PeopleField::FAITH_CULTURAL_SENSITIVITY,
            PeopleField::SERVICE_TEAM,
            PeopleField::ENGAGEMENT_STATUS,
        ];

        foreach ($fields as $index => $fieldEnum) {
            $config = $fieldEnum->getConfiguration();

            $field = CustomField::updateOrCreate([
                'tenant_id' => $team->id,
                'entity_type' => People::class,
                'code' => $fieldEnum->value,
            ], [
                'custom_field_section_id' => $section->id,
                'name' => $config['name'],
                'type' => $config['type'],
                'system_defined' => true,
                'active' => true,
                'sort_order' => $index,
            ]);

            // Sync options if applicable
            if ($config['options']) {
                $field->options()->delete();
                $sortOrder = 0;
                foreach ($config['options'] as $value => $label) {
                    $field->options()->create([
                        'tenant_id' => $team->id,
                        'name' => $label,
                        // We might need to store the value somewhere,
                        // but usually name is used as the underlying value in select options
                        'settings' => ['value' => $value],
                        'sort_order' => $sortOrder++,
                    ]);
                }
            }
        }
    }
}
