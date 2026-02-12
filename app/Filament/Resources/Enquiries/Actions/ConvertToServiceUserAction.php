<?php

declare(strict_types=1);

namespace App\Filament\Resources\Enquiries\Actions;

use App\Enums\EngagementStatus;
use App\Enums\EnquiryStatus;
use App\Enums\ServiceTeam;
use App\Models\Enquiry;
use App\Models\People;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Support\Colors\Color;
use Filament\Support\Icons\Heroicon;
use Illuminate\Support\Facades\DB;

final class ConvertToServiceUserAction extends Action
{
    public static function getDefaultName(): string
    {
        return 'convertToServiceUser';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label('Promote to Service User')
            ->icon(Heroicon::UserPlus)
            ->color(Color::Blue)
            ->authorize('convertToServiceUser')
            ->hidden(fn (Enquiry $record): bool => ! $record->canBeConverted())
            ->modalHeading('Convert Enquiry to Service User')
            ->modalDescription('This will promote the caller to a formal Service User record and capture essential case file details.')
            ->modalWidth('4xl')
            ->form([
                Section::make('Consent & GDPR')
                    ->schema([
                        Toggle::make('consent_data_storage')
                            ->label('Consent for Data Storage')
                            ->required(),
                        Toggle::make('consent_referrals')
                            ->label('Consent for Referrals'),
                        Toggle::make('consent_communications')
                            ->label('Consent for Communications'),
                    ])->columns(3),

                Section::make('Initial Assessment')
                    ->schema([
                        Textarea::make('presenting_issues')
                            ->label('Presenting Issues')
                            ->rows(3)
                            ->default(fn (Enquiry $record) => $record->reason_for_contact),
                        Textarea::make('risk_summary')
                            ->label('Risk Summary')
                            ->rows(3)
                            ->default(fn (Enquiry $record) => $record->risk_flags),
                        Textarea::make('faith_cultural_sensitivity')
                            ->label('Faith & Cultural Sensitivity')
                            ->rows(2),
                    ]),

                Section::make('Service Assignment')
                    ->schema([
                        Select::make('target_service_team')
                            ->label('Service Team')
                            ->options(ServiceTeam::class)
                            ->native(false)
                            ->required(),
                        Select::make('engagement_status')
                            ->options(EngagementStatus::class)
                            ->native(false)
                            ->default(EngagementStatus::ACTIVE->value)
                            ->required(),
                    ])->columns(2),
            ])
            ->action(function (array $data, Enquiry $record): void {
                DB::transaction(function () use ($data, $record) {
                    /** @var People $person */
                    $person = $record->people;

                    $customFields = $data;
                    $customFields['service_team'] = $data['target_service_team'];
                    unset($customFields['target_service_team']);

                    // Promote to Service User and Pass Custom Fields to Observer
                    $person->custom_fields = $customFields;
                    $person->update([
                        'is_service_user' => true,
                    ]);

                    // Update Enquiry Status
                    $record->update([
                        'status' => EnquiryStatus::CONVERTED,
                        'converted_at' => now(),
                    ]);
                });

                Notification::make()
                    ->title('Success')
                    ->body('Enquiry has been converted to a Service User record.')
                    ->success()
                    ->send();
            });
    }
}
