<?php

declare(strict_types=1);

namespace App\Listeners;

use App\Enums\CustomFields\CompanyField as CompanyCustomField;
use App\Enums\CustomFields\NoteField as NoteCustomField;
use App\Enums\CustomFields\OpportunityField as OpportunityCustomField;
use App\Enums\CustomFields\PeopleField as PeopleCustomField;
use App\Enums\CustomFields\TaskField as TaskCustomField;
use App\Models\Company;
use App\Models\CustomField;
use App\Models\CustomFieldOption;
use App\Models\CustomFieldSection;
use App\Models\Note;
use App\Models\Opportunity;
use App\Models\People;
use App\Models\Task;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Features;
use Relaticle\OnboardSeed\OnboardSeeder;

/**
 * Creates custom fields for a team when it's created
 */
final readonly class CreateTeamCustomFields
{
    /**
     * Maps model classes to their corresponding custom field enum classes
     *
     * @var array<class-string, class-string>
     */
    private const array MODEL_ENUM_MAP = [
        Company::class => CompanyCustomField::class,
        Opportunity::class => OpportunityCustomField::class,
        Note::class => NoteCustomField::class,
        People::class => PeopleCustomField::class,
        Task::class => TaskCustomField::class,
    ];

    /**
     * Create a new event listener instance
     */
    public function __construct(
        private OnboardSeeder $onboardSeeder,
    ) {}

    /**
     * Handle the team created event
     */
    public function handle(TeamCreated $event): void
    {
        if (! Features::hasTeamFeatures()) {
            return;
        }

        $team = $event->team;

        // Create custom fields for all models defined in the map
        foreach (self::MODEL_ENUM_MAP as $modelClass => $enumClass) {
            foreach ($enumClass::cases() as $enum) {
                $this->createCustomField($team->id, $modelClass, $enum);
            }
        }

        if ($team->isPersonalTeam()) {
            /** @var Authenticatable $owner */
            $owner = $team->owner;
            $this->onboardSeeder->run($owner);
        }
    }

    /**
     * Create a custom field using the provided enum configuration
     */
    private function createCustomField(int $teamId, string $model, mixed $enum): void
    {
        // Ensure we have a default section
        $section = CustomFieldSection::query()->firstOrCreate(
            ['team_id' => $teamId, 'entity_type' => $model, 'code' => 'general'],
            ['name' => 'General', 'type' => 'headless', 'sort_order' => 0]
        );

        /** @var CustomField $field */
        $field = CustomField::query()->create([
            'team_id' => $teamId,
            'custom_field_section_id' => $section->id,
            'entity_type' => $model,
            'type' => $enum->getFieldType(),
            'name' => $enum->getDisplayName(),
            'code' => $enum->value,
            'active' => true,
            'system_defined' => $enum->isSystemDefined(),
            'width' => $enum->getWidth(),
            'sort_order' => 0, // Enums are processed in order
            'settings' => [
                'list_toggleable_hidden' => $enum->isListToggleableHidden(),
                'enable_option_colors' => $enum->hasColorOptions(),
            ],
        ]);

        // Add options for select-type fields
        $options = $enum->getOptions();
        $colorMapping = $enum->getOptionColors();

        if ($options !== null) {
            foreach ($options as $optionName) {
                $color = $colorMapping[$optionName] ?? null;

                CustomFieldOption::query()->create([
                    'team_id' => $teamId,
                    'custom_field_id' => $field->id,
                    'name' => $optionName,
                    'sort_order' => 0,
                    'settings' => $color ? ['color' => $color] : null,
                ]);
            }
        }
    }
}
