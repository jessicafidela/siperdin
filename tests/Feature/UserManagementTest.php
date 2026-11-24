<?php

namespace Tests\Feature;

use App\Models\Pegawai;
use App\Models\Permission;
use App\Models\SatuanKerja;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
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

    public function test_superadmin_can_view_the_user_management_page(): void
    {
        $admin = $this->userWithRole('Superadmin');

        $this->actingAs($admin)
            ->get(route('user.index'))
            ->assertOk()
            ->assertSee('Manajemen Pengguna')
            ->assertSee('Daftar akun pengguna');
    }

    public function test_superadmin_can_create_an_account_linked_to_an_employee_and_assign_one_role(): void
    {
        $admin = $this->userWithRole('Superadmin');
        $pegawai = $this->createPegawai();

        $response = $this->actingAs($admin)->post(route('user.store'), [
            'username' => 'operator.satker',
            'id_pegawai' => $pegawai->id_pegawai,
            'role' => 'Operator Satker',
            'password' => 'Very-Strong-Password-2026!',
            'password_confirmation' => 'Very-Strong-Password-2026!',
        ]);

        $user = User::query()->where('username', 'operator.satker')->firstOrFail();

        $response->assertRedirect(route('user.edit', $user));
        $this->assertDatabaseHas('users', [
            'id_user' => $user->id_user,
            'id_pegawai' => $pegawai->id_pegawai,
            'username' => 'operator.satker',
            'status' => 'aktif',
        ]);
        $this->assertTrue(Hash::check('Very-Strong-Password-2026!', $user->password));
        $this->assertSame(['Operator Satker'], $user->getRoleNames()->all());
        $this->assertDatabaseHas('activity_log', [
            'id_user' => $admin->id_user,
            'aktivitas' => 'buat_akun_pengguna',
        ]);
    }

    public function test_satker_scoped_account_must_be_linked_to_an_employee(): void
    {
        $admin = $this->userWithRole('Superadmin');

        $this->actingAs($admin)
            ->from(route('user.create'))
            ->post(route('user.store'), [
                'username' => 'operator.tanpa.pegawai',
                'role' => 'Operator Satker',
                'password' => 'Very-Strong-Password-2026!',
                'password_confirmation' => 'Very-Strong-Password-2026!',
            ])
            ->assertSessionHasErrors('id_pegawai');

        $this->assertDatabaseMissing('users', ['username' => 'operator.tanpa.pegawai']);
    }

    public function test_superadmin_can_change_role_and_deactivate_another_account(): void
    {
        $admin = $this->userWithRole('Superadmin');
        $pegawai = $this->createPegawai();
        $target = User::factory()->create(['id_pegawai' => $pegawai->id_pegawai]);
        $target->assignRole('Operator Data');

        $this->actingAs($admin)
            ->put(route('user.role', $target), ['role' => 'Operator Satker'])
            ->assertRedirect(route('user.edit', $target));

        $this->assertSame(['Operator Satker'], $target->fresh()->getRoleNames()->all());

        $this->actingAs($admin)
            ->put(route('user.status', $target), ['status' => 'nonaktif'])
            ->assertRedirect(route('user.edit', $target));

        $this->assertSame('nonaktif', $target->fresh()->status);
    }

    public function test_system_prevents_deactivating_the_last_active_superadmin(): void
    {
        $targetAdmin = $this->userWithRole('Superadmin');
        $operator = User::factory()->create();
        $operator->givePermissionTo(Permission::findByName('users.set-status', 'web'));

        $this->actingAs($operator)
            ->from(route('user.edit', $targetAdmin))
            ->put(route('user.status', $targetAdmin), ['status' => 'nonaktif'])
            ->assertSessionHasErrors('status');

        $this->assertSame('aktif', $targetAdmin->fresh()->status);
    }

    public function test_user_management_routes_remain_forbidden_to_other_internal_roles(): void
    {
        foreach (['Operator Data', 'Operator Satker', 'Admin Keuangan'] as $role) {
            $user = $this->userWithRole($role);

            $this->actingAs($user)
                ->get(route('user.index'))
                ->assertForbidden();

            $target = User::factory()->create();
            $target->assignRole('Operator Data');

            $this->actingAs($user)
                ->put(route('user.role', $target), ['role' => 'Admin Keuangan'])
                ->assertForbidden();

            $this->actingAs($user)
                ->put(route('user.status', $target), ['status' => 'nonaktif'])
                ->assertForbidden();
        }
    }

    private function userWithRole(string $role): User
    {
        $user = User::factory()->create();
        $user->assignRole($role);

        return $user;
    }

    private function createPegawai(): Pegawai
    {
        $satker = SatuanKerja::create([
            'kode_satker' => 'SATKER-'.fake()->unique()->numerify('####'),
            'nama_satker' => 'Satuan Kerja Pengujian',
            'status' => 'aktif',
        ]);

        return Pegawai::create([
            'id_satker' => $satker->id_satker,
            'nip' => fake()->unique()->numerify('##################'),
            'nama_lengkap' => fake()->name(),
        ]);
    }
}
