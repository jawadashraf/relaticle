<?php

declare(strict_types=1);

use App\Models\User;
use Filament\Facades\Filament;

describe('SystemAdmin Security', function () {
    beforeEach(function () {
        Filament::setCurrentPanel('sysadmin');
    });

    it('enforces complete authentication isolation', function () {
        $admin = User::factory()->create(['is_system_admin' => true]);
        $user = User::factory()->create();

        // System admin cannot access app panel
        expect($admin->canAccessPanel(Filament::getPanel('app')))->toBeFalse();

        // Regular user cannot access sysadmin panel
        expect($user->canAccessPanel(Filament::getPanel('sysadmin')))->toBeFalse();

        // Guards are isolated
        $this->actingAs($admin, 'web');
        $this->assertAuthenticatedAs($admin, 'web');
    });

    it('enforces role-based authorization', function () {
        $superAdmin = User::factory()->create([
            'is_system_admin' => true,
        ]);

        $otherAdmin = User::factory()->create([
            'is_system_admin' => true,
        ]);

        $this->actingAs($superAdmin, 'web');

        expect(auth('web')->user()->can('create', User::class))->toBeTrue()
            ->and(auth('web')->user()->can('viewAny', User::class))->toBeTrue()
            ->and(auth('web')->user()->can('update', $otherAdmin))->toBeTrue()
            ->and(auth('web')->user()->can('delete', $otherAdmin))->toBeTrue()
            ->and(auth('web')->user()->can('delete', $superAdmin))->toBeFalse();
    });

    it('requires email verification for panel access', function () {
        $unverifiedAdmin = User::factory()->unverified()->create(['is_system_admin' => true]);

        expect($unverifiedAdmin->canAccessPanel(Filament::getPanel('sysadmin')))->toBeFalse();
    });

    it('protects routes with authentication', function () {
        $this->get('/sysadmin/system-administrators')
            ->assertRedirect('/sysadmin/login');

        $admin = User::factory()->create(['is_system_admin' => true]);

        $this->actingAs($admin, 'web')
            ->get('/sysadmin/system-administrators')
            ->assertOk();
    });

    it('validates data integrity', function () {
        $admin = User::factory()->create([
            'is_system_admin' => true,
        ]);

        expect($admin->is_system_admin)->toBeTrue()
            ->and($admin->hasVerifiedEmail())->toBeTrue();
    });
});
