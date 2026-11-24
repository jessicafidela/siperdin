<?php

namespace Tests\Feature\Authorization;

use App\Models\Role;
use App\Models\User;
use App\Support\Rbac\PermissionMatrix;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RolePermissionMatrixTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed([
            RoleSeeder::class,
            PermissionSeeder::class,
            RolePermissionSeeder::class,
        ]);
    }

    public function test_only_the_four_internal_roles_exist_and_guest_is_not_a_role(): void
    {
        $actualRoles = Role::query()
            ->where('guard_name', PermissionMatrix::GUARD)
            ->orderBy('name')
            ->pluck('name')
            ->all();

        $this->assertEqualsCanonicalizing(array_keys(PermissionMatrix::roles()), $actualRoles);
        $this->assertDatabaseMissing('roles', [
            'name' => 'Guest',
            'guard_name' => PermissionMatrix::GUARD,
        ]);
    }

    public function test_role_seeder_removes_a_legacy_guest_role(): void
    {
        Role::create([
            'name' => 'Guest',
            'guard_name' => PermissionMatrix::GUARD,
            'status' => 'aktif',
        ]);

        $this->seed(RoleSeeder::class);

        $this->assertDatabaseMissing('roles', [
            'name' => 'Guest',
            'guard_name' => PermissionMatrix::GUARD,
        ]);
    }

    public function test_role_permission_assignments_match_the_approved_matrix(): void
    {
        foreach (PermissionMatrix::rolePermissions() as $roleName => $expectedPermissions) {
            $role = Role::findByName($roleName, PermissionMatrix::GUARD);
            $actualPermissions = $role->permissions()->pluck('name')->all();

            $this->assertEqualsCanonicalizing(
                $expectedPermissions,
                $actualPermissions,
                "Permission role {$roleName} tidak sesuai matriks."
            );
        }
    }

    public function test_user_management_is_exclusive_to_superadmin(): void
    {
        $superadmin = $this->userWithRole('Superadmin');
        $this->assertTrue($superadmin->can('users.view'));
        $this->assertTrue($superadmin->can('users.create'));
        $this->assertTrue($superadmin->can('users.assign-role'));
        $this->assertTrue($superadmin->can('users.set-status'));
        $this->assertTrue($superadmin->can('users.reset-password'));

        foreach (['Operator Data', 'Operator Satker', 'Admin Keuangan'] as $roleName) {
            $user = $this->userWithRole($roleName);

            foreach ([
                'users.view',
                'users.create',
                'users.update',
                'users.assign-role',
                'users.set-status',
                'users.reset-password',
            ] as $permission) {
                $this->assertFalse(
                    $user->can($permission),
                    "{$roleName} tidak boleh memiliki {$permission}."
                );
            }
        }
    }

    public function test_master_data_is_exclusive_to_superadmin_and_operator_data(): void
    {
        foreach (['Superadmin', 'Operator Data'] as $roleName) {
            $user = $this->userWithRole($roleName);
            $this->assertTrue($user->can('master-data.view'));
            $this->assertTrue($user->can('master-data.create'));
            $this->assertTrue($user->can('master-data.update'));
        }

        foreach (['Operator Satker', 'Admin Keuangan'] as $roleName) {
            $user = $this->userWithRole($roleName);
            $this->assertFalse($user->can('master-data.view'));
            $this->assertFalse($user->can('master-data.create'));
            $this->assertFalse($user->can('master-data.update'));
        }
    }

    public function test_operational_authority_is_separated_between_satker_and_finance(): void
    {
        $operatorSatker = $this->userWithRole('Operator Satker');
        $adminKeuangan = $this->userWithRole('Admin Keuangan');
        $superadmin = $this->userWithRole('Superadmin');

        $this->assertTrue($operatorSatker->can('travel.grouping.create'));
        $this->assertTrue($operatorSatker->can('accountability-drafts.validate'));
        $this->assertTrue($operatorSatker->can('travel.submit'));
        $this->assertTrue($operatorSatker->can('submissions.revise'));
        $this->assertFalse($operatorSatker->can('submissions.verify'));
        $this->assertFalse($operatorSatker->can('travel.finalize'));

        $this->assertTrue($adminKeuangan->can('submissions.verify'));
        $this->assertTrue($adminKeuangan->can('submissions.return'));
        $this->assertTrue($adminKeuangan->can('payouts.manage'));
        $this->assertTrue($adminKeuangan->can('travel.finalize'));
        $this->assertFalse($adminKeuangan->can('travel.grouping.create'));
        $this->assertFalse($adminKeuangan->can('accountability-drafts.validate'));

        // Superadmin monitors globally but does not take over operational approval.
        $this->assertTrue($superadmin->can('travel.monitor.all'));
        $this->assertFalse($superadmin->can('travel.grouping.create'));
        $this->assertFalse($superadmin->can('submissions.verify'));
        $this->assertFalse($superadmin->can('travel.finalize'));
    }

    public function test_monitoring_and_activity_log_permissions_follow_the_role_matrix(): void
    {
        $superadmin = $this->userWithRole('Superadmin');
        $operatorSatker = $this->userWithRole('Operator Satker');
        $adminKeuangan = $this->userWithRole('Admin Keuangan');
        $operatorData = $this->userWithRole('Operator Data');

        $this->assertTrue($superadmin->can('travel.monitor.all'));
        $this->assertTrue($superadmin->can('activity-log.view'));
        $this->assertFalse($superadmin->can('travel.monitor.satker'));

        $this->assertTrue($operatorSatker->can('travel.monitor.satker'));
        $this->assertTrue($adminKeuangan->can('travel.monitor.satker'));
        $this->assertFalse($operatorSatker->can('activity-log.view'));
        $this->assertFalse($adminKeuangan->can('activity-log.view'));
        $this->assertFalse($operatorData->can('travel.monitor.satker'));
    }

    private function userWithRole(string $roleName): User
    {
        $user = User::factory()->create();
        $user->assignRole($roleName);

        return $user;
    }
}
