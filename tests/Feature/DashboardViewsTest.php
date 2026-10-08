<?php

namespace Tests\Feature;

use App\Models\Lomba;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardViewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_dashboard_renders_management_sections(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Panel Admin')
            ->assertSee('Tambah Mata Lomba Baru')
            ->assertSee('Manajemen Status Peserta')
            ->assertSee('Manajemen Akun Siswa');
    }

    public function test_student_dashboard_renders_lombas_and_registration_history(): void
    {
        $student = User::factory()->create(['role' => 'siswa']);
        $lomba = Lomba::create([
            'nama_lomba' => 'Web Design',
            'deskripsi' => 'Kompetisi desain web',
        ]);

        $student->pendaftarans()->create([
            'lomba_id' => $lomba->id,
            'status' => 'Dokumen dalam Tinjauan',
        ]);

        $this->actingAs($student)
            ->get(route('siswa.dashboard'))
            ->assertOk()
            ->assertSee('Formulir Pendaftaran Lomba')
            ->assertSee('Riwayat & Tracking Status')
            ->assertSee('Sedang Ditinjau Juri')
            ->assertSee('Web Design');
    }
}
