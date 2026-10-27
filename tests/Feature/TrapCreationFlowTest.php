<?php

namespace Tests\Feature;

use App\Models\Entry;
use App\Models\Trap;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase as BaseTestCase;

class TrapCreationFlowTest extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Schema::create('traps', function (Blueprint $table) {
            $table->id();
            $table->string('no_trap');
            $table->string('type_detector');
            $table->string('spesies_hama');
            $table->string('lokasi');
            $table->timestamps();
        });

        Schema::create('entries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trap_id');
            $table->date('tanggal');
            $table->string('tindakan')->nullable();
            $table->string('aktivitas')->nullable();
            $table->string('hasil')->nullable();
            $table->timestamps();
        });

        Schema::create('rekomendasi_perbaikans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entry_id');
            $table->text('rekomendasi_catatan')->nullable();
            $table->string('rekomendasi_gambar')->nullable();
            $table->text('perbaikan_catatan')->nullable();
            $table->string('perbaikan_gambar')->nullable();
            $table->string('status_persetujuan')->default('pending');
            $table->foreignId('approved_by')->nullable();
            $table->text('catatan_admin')->nullable();
            $table->timestamp('diputuskan_pada')->nullable();
            $table->timestamps();
        });

        Schema::create('rekomendasi_approval_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rekomendasi_perbaikan_id');
            $table->foreignId('user_id')->nullable();
            $table->string('aksi');
            $table->string('status_sebelumnya')->nullable();
            $table->string('status_sesudahnya');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });
    }

    protected function tearDown(): void
    {
        Schema::dropIfExists('rekomendasi_approval_histories');
        Schema::dropIfExists('rekomendasi_perbaikans');
        Schema::dropIfExists('entries');
        Schema::dropIfExists('traps');

        parent::tearDown();
    }

    public function test_admin_can_add_trap_but_cannot_open_daily_inspection(): void
    {
        $admin = new User();
        $admin->setAttribute('role', 'admin');
        $this->actingAs($admin);

        $this->post(route('traps.store'), [
            'no_trap' => 'TEST-001',
            'type_detector' => 'Insect Light',
            'spesies_hama' => 'Lalat',
            'lokasi' => 'Area Uji',
        ])->assertRedirect(route('traps.index'))
            ->assertSessionHas('success');

        $trap = Trap::where('no_trap', 'TEST-001')->firstOrFail();
        $this->assertDatabaseHas('traps', ['no_trap' => 'TEST-001']);

        $this->get(route('traps.index'))
            ->assertOk()
            ->assertSee('TEST-001');

        $this->get(route('entries.create'))
            ->assertForbidden();

        $this->post(route('entries.store'), [
            'tanggal' => '2026-10-22',
            'entries' => [
                $trap->id => [
                    'aktivitas' => 'HIGH',
                    'tindakan' => 'Inspeksi admin tidak diizinkan',
                    'hasil' => 'Tes',
                ],
            ],
        ])->assertForbidden();

        $this->assertSame(0, Entry::where('trap_id', $trap->id)->count());
    }

    public function test_petugas_roles_can_open_daily_inspection(): void
    {
        $trap = Trap::create([
            'no_trap' => 'TEST-PETUGAS',
            'type_detector' => 'Insect Light',
            'spesies_hama' => 'Lalat',
            'lokasi' => 'Area Uji',
        ]);
        $entry = Entry::create([
            'trap_id' => $trap->id,
            'tanggal' => '2026-10-22',
        ]);
        $recommendation = $entry->rekomendasi()->create([
            'rekomendasi_catatan' => 'Catatan uji',
        ]);

        foreach (['pengelola', 'operatorpc'] as $role) {
            $petugas = new User();
            $petugas->setAttribute('role', $role);
            $this->actingAs($petugas);

            $this->get(route('entries.create'))->assertOk();
            $this->get(route('traps.index'))->assertForbidden();
            $this->post(route('rekomendasi.approve', $recommendation), [
                'catatan_admin' => 'Tidak diizinkan',
            ])->assertForbidden();
        }
    }

    public function test_petugas_can_save_activity_without_creating_a_recommendation(): void
    {
        $petugas = new User();
        $petugas->setAttribute('role', 'pengelola');
        $this->actingAs($petugas);

        $trap = Trap::create([
            'no_trap' => 'TEST-ACTIVITY',
            'type_detector' => 'Insect Light',
            'spesies_hama' => 'Lalat',
            'lokasi' => 'Area Uji',
        ]);

        $this->post(route('entries.store'), [
            'tanggal' => '2026-10-22',
            'entries' => [
                $trap->id => [
                    'aktivitas' => 'HIGH',
                ],
            ],
        ])->assertRedirect(route('entries.create', ['tanggal' => '2026-10-22']));

        $this->assertDatabaseHas('entries', [
            'trap_id' => $trap->id,
            'tanggal' => '2026-10-22',
            'aktivitas' => 'HIGH',
        ]);
        $this->assertDatabaseCount('rekomendasi_perbaikans', 0);
    }

    public function test_navigation_displays_role_specific_menus(): void
    {
        $admin = new User();
        $admin->setAttribute('role', 'admin');
        $this->actingAs($admin);

        $adminNavigation = view('partials.nav')->render();

        $this->assertStringContainsString('Data Master Perangkap', $adminNavigation);
        $this->assertStringNotContainsString('Input Harian', $adminNavigation);
        $this->assertStringNotContainsString('Rekomendasi Perbaikan', $adminNavigation);

        $petugas = new User();
        $petugas->setAttribute('role', 'operatorpc');
        $this->actingAs($petugas);

        $petugasNavigation = view('partials.nav')->render();

        $this->assertStringContainsString('Input Harian', $petugasNavigation);
        $this->assertStringNotContainsString('Data Master Perangkap', $petugasNavigation);
        $this->assertStringNotContainsString('Rekomendasi Perbaikan', $petugasNavigation);
    }

    public function test_admin_can_record_repair_follow_up_from_inspection_detail(): void
    {
        $admin = new User();
        $admin->setAttribute('role', 'admin');
        $this->actingAs($admin);

        $trap = Trap::create([
            'no_trap' => 'TEST-002',
            'type_detector' => 'Insect Light',
            'spesies_hama' => 'Lalat',
            'lokasi' => 'Area Uji',
        ]);

        $entry = Entry::create([
            'trap_id' => $trap->id,
            'tanggal' => '2026-10-22',
            'aktivitas' => 'HIGH',
            'tindakan' => 'Inspeksi petugas',
            'hasil' => 'Ada temuan',
        ]);

        $recommendation = $entry->rekomendasi()->create([
            'rekomendasi_catatan' => 'Perlu perbaikan perangkap',
        ]);

        $this->post(route('entries.store'), [
            'tanggal' => '2026-10-22',
            'entries' => [
                $trap->id => [
                    'perbaikan_catatan' => 'Perangkap sudah diperbaiki',
                ],
            ],
        ])->assertRedirect(route('entries.riwayat', [
            'bulan' => '2026-10',
            'tanggal' => '2026-10-22',
        ]));

        $this->assertDatabaseHas('rekomendasi_perbaikans', [
            'id' => $recommendation->id,
            'perbaikan_catatan' => 'Perangkap sudah diperbaiki',
        ]);
    }

    public function test_admin_can_approve_reject_and_request_revisions(): void
    {
        $admin = new User();
        $admin->setAttribute('role', 'admin');
        $this->actingAs($admin);

        $trap = Trap::create([
            'no_trap' => 'TEST-004',
            'type_detector' => 'Insect Light',
            'spesies_hama' => 'Lalat',
            'lokasi' => 'Area Uji',
        ]);
        $entry = Entry::create([
            'trap_id' => $trap->id,
            'tanggal' => '2026-10-22',
        ]);
        $recommendation = $entry->rekomendasi()->create([
            'rekomendasi_catatan' => 'Usulan perbaikan',
        ]);

        $detailUrl = route('entries.riwayat', [
            'bulan' => '2026-10',
            'tanggal' => '2026-10-22',
        ]);

        $this->get($detailUrl)
            ->assertOk()
            ->assertSee('Usulan perbaikan')
            ->assertSee('Menunggu keputusan')
            ->assertSee('Setujui')
            ->assertSee('Minta revisi');

        $this->from($detailUrl)->post(route('rekomendasi.approve', $recommendation), [
            'catatan_admin' => 'Disetujui untuk ditindaklanjuti',
        ])->assertRedirect($detailUrl);

        $this->assertDatabaseHas('rekomendasi_perbaikans', [
            'id' => $recommendation->id,
            'status_persetujuan' => 'disetujui',
            'catatan_admin' => 'Disetujui untuk ditindaklanjuti',
        ]);

        $this->from($detailUrl)->post(route('rekomendasi.reject', $recommendation), [
            'catatan_admin' => 'Alasan penolakan',
        ])->assertRedirect($detailUrl);

        $this->assertDatabaseHas('rekomendasi_perbaikans', [
            'id' => $recommendation->id,
            'status_persetujuan' => 'ditolak',
            'catatan_admin' => 'Alasan penolakan',
        ]);

        $this->from($detailUrl)->post(route('rekomendasi.revision', $recommendation), [
            'catatan_admin' => 'Mohon lengkapi rekomendasi',
        ])->assertRedirect($detailUrl);

        $this->assertDatabaseHas('rekomendasi_perbaikans', [
            'id' => $recommendation->id,
            'status_persetujuan' => 'perlu_revisi',
            'catatan_admin' => 'Mohon lengkapi rekomendasi',
        ]);
        $this->assertDatabaseCount('rekomendasi_approval_histories', 3);
    }

    public function test_reject_and_revision_require_admin_notes(): void
    {
        $admin = new User();
        $admin->setAttribute('role', 'admin');
        $this->actingAs($admin);

        $trap = Trap::create([
            'no_trap' => 'TEST-005',
            'type_detector' => 'Insect Light',
            'spesies_hama' => 'Lalat',
            'lokasi' => 'Area Uji',
        ]);
        $entry = Entry::create([
            'trap_id' => $trap->id,
            'tanggal' => '2026-10-22',
        ]);
        $recommendation = $entry->rekomendasi()->create([
            'rekomendasi_catatan' => 'Usulan perbaikan',
        ]);

        $this->post(route('rekomendasi.reject', $recommendation), [])
            ->assertSessionHasErrors('catatan_admin');
        $this->post(route('rekomendasi.revision', $recommendation), [])
            ->assertSessionHasErrors('catatan_admin');
    }

    public function test_repair_upload_preserves_recommendation_photo(): void
    {
        Storage::fake('public');

        $admin = new User();
        $admin->setAttribute('role', 'admin');
        $this->actingAs($admin);

        $trap = Trap::create([
            'no_trap' => 'TEST-006',
            'type_detector' => 'Insect Light',
            'spesies_hama' => 'Lalat',
            'lokasi' => 'Area Uji',
        ]);
        $entry = Entry::create([
            'trap_id' => $trap->id,
            'tanggal' => '2026-10-22',
        ]);
        $recommendation = $entry->rekomendasi()->create([
            'rekomendasi_catatan' => 'Usulan',
            'rekomendasi_gambar' => 'rekomendasi/foto-lama.jpg',
        ]);

        $this->post(route('entries.store'), [
            'tanggal' => '2026-10-22',
            'entries' => [
                $trap->id => [
                    'perbaikan_catatan' => 'Sudah diperbaiki',
                    'perbaikan_gambar' => UploadedFile::fake()->image('perbaikan.jpg'),
                ],
            ],
        ])->assertRedirect(route('entries.riwayat', [
            'bulan' => '2026-10',
            'tanggal' => '2026-10-22',
        ]));

        $recommendation->refresh();
        $this->assertSame('rekomendasi/foto-lama.jpg', $recommendation->rekomendasi_gambar);
        $this->assertNotEmpty($recommendation->perbaikan_gambar);
        Storage::disk('public')->assertExists($recommendation->perbaikan_gambar);
    }

    public function test_admin_can_read_inspection_history_without_opening_daily_input(): void
    {
        $admin = new User();
        $admin->setAttribute('role', 'admin');
        $this->actingAs($admin);

        $trap = Trap::create([
            'no_trap' => 'TEST-003',
            'type_detector' => 'Insect Light',
            'spesies_hama' => 'Lalat',
            'lokasi' => 'Area Uji',
        ]);

        $entry = Entry::create([
            'trap_id' => $trap->id,
            'tanggal' => '2026-10-22',
            'aktivitas' => 'HIGH',
            'tindakan' => 'Inspeksi Petugas',
            'hasil' => 'Ada temuan',
        ]);

        $entry->rekomendasi()->create([
            'rekomendasi_catatan' => 'Perlu perbaikan',
        ]);
        Trap::create([
            'no_trap' => 'TEST-UNINSPECTED',
            'type_detector' => 'Insect Light',
            'spesies_hama' => 'Lalat',
            'lokasi' => 'Area Belum Diperiksa',
        ]);

        $this->get(route('entries.riwayat', [
            'bulan' => '2026-10',
            'tanggal' => '2026-10-22',
        ]))
            ->assertOk()
            ->assertSee('Detail Inspeksi')
            ->assertSee('TEST-003')
            ->assertSee('Inspeksi Petugas')
            ->assertSee('Perlu perbaikan')
            ->assertSee('TEST-UNINSPECTED')
            ->assertSee('Belum diperiksa');

        $this->get(route('entries.create'))->assertForbidden();
    }
}
