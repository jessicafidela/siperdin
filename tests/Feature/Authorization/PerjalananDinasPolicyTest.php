<?php

namespace Tests\Feature\Authorization;

use App\Models\Pegawai;
use App\Models\PerjalananDinas;
use App\Models\SatuanKerja;
use App\Models\User;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\RolePermissionSeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Tests\TestCase;

class PerjalananDinasPolicyTest extends TestCase
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

    public function test_travel_lists_are_scoped_to_the_users_satker_except_superadmin(): void
    {
        $satkerA = $this->createSatker('A');
        $satkerB = $this->createSatker('B');

        $operatorA = $this->userForSatker('Operator Satker', $satkerA);
        $financeB = $this->userForSatker('Admin Keuangan', $satkerB);
        $operatorData = $this->userForSatker('Operator Data', $satkerA);
        $superadmin = $this->userWithRole('Superadmin');

        $travelA = $this->createTravel($satkerA, $operatorA);
        $travelB = $this->createTravel($satkerB, $financeB);

        $this->assertSame(
            [$travelA->id_perjalanan],
            PerjalananDinas::query()->visibleTo($operatorA)->pluck('id_perjalanan')->all()
        );
        $this->assertSame(
            [$travelB->id_perjalanan],
            PerjalananDinas::query()->visibleTo($financeB)->pluck('id_perjalanan')->all()
        );
        $this->assertEqualsCanonicalizing(
            [$travelA->id_perjalanan, $travelB->id_perjalanan],
            PerjalananDinas::query()->visibleTo($superadmin)->pluck('id_perjalanan')->all()
        );
        $this->assertCount(0, PerjalananDinas::query()->visibleTo($operatorData)->get());
    }

    public function test_operator_satker_can_manage_own_travel_but_cannot_verify_or_access_other_satker(): void
    {
        $satkerA = $this->createSatker('A');
        $satkerB = $this->createSatker('B');
        $operatorA = $this->userForSatker('Operator Satker', $satkerA);
        $financeB = $this->userForSatker('Admin Keuangan', $satkerB);
        $travelA = $this->createTravel($satkerA, $operatorA);
        $travelB = $this->createTravel($satkerB, $financeB);

        $this->assertTrue(Gate::forUser($operatorA)->allows('view', $travelA));
        $this->assertTrue(Gate::forUser($operatorA)->allows('update', $travelA));
        $this->assertTrue(Gate::forUser($operatorA)->allows('submit', $travelA));
        $this->assertFalse(Gate::forUser($operatorA)->allows('verify', $travelA));
        $this->assertFalse(Gate::forUser($operatorA)->allows('view', $travelB));
        $this->assertFalse(Gate::forUser($operatorA)->allows('update', $travelB));
    }

    public function test_admin_keuangan_can_verify_own_satker_but_cannot_create_or_edit_travel(): void
    {
        $satkerA = $this->createSatker('A');
        $satkerB = $this->createSatker('B');
        $financeA = $this->userForSatker('Admin Keuangan', $satkerA);
        $operatorB = $this->userForSatker('Operator Satker', $satkerB);
        $travelA = $this->createTravel($satkerA, $financeA);
        $travelB = $this->createTravel($satkerB, $operatorB);

        $this->assertTrue(Gate::forUser($financeA)->allows('verify', $travelA));
        $this->assertTrue(Gate::forUser($financeA)->allows('returnForRevision', $travelA));
        $this->assertTrue(Gate::forUser($financeA)->allows('managePayout', $travelA));
        $this->assertTrue(Gate::forUser($financeA)->allows('finalize', $travelA));
        $this->assertFalse(Gate::forUser($financeA)->allows('create', PerjalananDinas::class));
        $this->assertFalse(Gate::forUser($financeA)->allows('update', $travelA));
        $this->assertFalse(Gate::forUser($financeA)->allows('verify', $travelB));
    }

    public function test_superadmin_has_global_monitoring_but_not_operational_approval_authority(): void
    {
        $satker = $this->createSatker('A');
        $operator = $this->userForSatker('Operator Satker', $satker);
        $travel = $this->createTravel($satker, $operator);
        $superadmin = $this->userWithRole('Superadmin');

        $this->assertTrue(Gate::forUser($superadmin)->allows('viewAny', PerjalananDinas::class));
        $this->assertTrue(Gate::forUser($superadmin)->allows('view', $travel));
        $this->assertFalse(Gate::forUser($superadmin)->allows('verify', $travel));
        $this->assertFalse(Gate::forUser($superadmin)->allows('finalize', $travel));
    }

    public function test_satker_scoped_roles_without_a_linked_employee_cannot_access_travel_records(): void
    {
        $satker = $this->createSatker('A');
        $operator = $this->userWithRole('Operator Satker');
        $travel = $this->createTravel($satker, $operator);

        $this->assertNull($operator->satkerId());
        $this->assertFalse($operator->canAccessSatker($satker->id_satker));
        $this->assertFalse(Gate::forUser($operator)->allows('create', PerjalananDinas::class));
        $this->assertFalse(Gate::forUser($operator)->allows('view', $travel));
    }

    private function createSatker(string $suffix): SatuanKerja
    {
        return SatuanKerja::create([
            'kode_satker' => 'SATKER-'.$suffix.'-'.Str::upper(Str::random(5)),
            'nama_satker' => 'Satuan Kerja '.$suffix,
            'status' => 'aktif',
        ]);
    }

    private function userForSatker(string $roleName, SatuanKerja $satker): User
    {
        $pegawai = Pegawai::create([
            'id_satker' => $satker->id_satker,
            'nama_lengkap' => 'Pegawai '.Str::random(8),
        ]);

        $user = User::factory()->create([
            'id_pegawai' => $pegawai->id_pegawai,
        ]);
        $user->assignRole($roleName);

        return $user;
    }

    private function userWithRole(string $roleName): User
    {
        $user = User::factory()->create();
        $user->assignRole($roleName);

        return $user;
    }

    private function createTravel(SatuanKerja $satker, User $creator): PerjalananDinas
    {
        return PerjalananDinas::create([
            'id_satker' => $satker->id_satker,
            'created_by' => $creator->id_user,
            'nomor_pengajuan' => 'PD-'.Str::upper(Str::random(12)),
            'tanggal_pengajuan' => now()->toDateString(),
            'kegiatan' => 'Pengujian RBAC',
            'misi_perjalanan' => 'Pengujian pembatasan akses satuan kerja.',
            'status_pengajuan' => 'draft',
        ]);
    }
}
