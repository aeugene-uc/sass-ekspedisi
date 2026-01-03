<?php

namespace App\Livewire\Perusahaan;

use App\Models\DaftarMuat as ModelsDaftarMuat;
use App\Models\Counter;
use App\Models\Kendaraan;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class DaftarMuat extends DashboardPerusahaanComponent
{
    use WithPagination;

    public $modalDetailMuatVisible = false;
    public $dm;
    public $dmKurirs = [];

    public $modalHapusPesananVisible = false;
    public $hapusPesananId;

    public $modalAturKurirVisible = false;

    public $daftarMuatQuery;

    protected $rules = [
        'dm.counter_asal_id' => 'required|integer', // Required for validation
        'dm.kendaraan_id' => 'required|integer', // Required for validation
    ];

    #[Computed]
    public function daftarMuats()
    {
        \Log::info('Fetching DaftarMuats');
        return ModelsDaftarMuat::with('counter')
            ->whereHas('counter', function($q) {
                $q->where('perusahaan_id', function($subquery) {
                    $subquery->select('id')
                        ->from('perusahaan')
                        ->where('subdomain', $this->subdomain);
                });
            })
            ->when($this->daftarMuatQuery, function($q) {
                $q->where('id', 'like', '%' . $this->daftarMuatQuery . '%');
            })
            ->paginate(10);
    }

    #[Computed]
    public function counters() {
        \Log::info('Fetching Counters');
        return Counter::where('perusahaan_id', function($subquery) {
            $subquery->select('id')
                ->from('perusahaan')
                ->where('subdomain', $this->subdomain);
        })->get();
    }

    #[Computed]
    public function kendaraans() {
        \Log::info('Fetching Kendaraans');
        return Kendaraan::where('perusahaan_id', function($subquery) {
            $subquery->select('id')
                ->from('perusahaan')
                ->where('subdomain', $this->subdomain);
        })->get();
    }

    #[Computed]
    public function kurirs() {
        \Log::info('Fetching Kurirs');
        return User::where('perusahaan_id', function($subquery) {
            $subquery->select('id')
                ->from('perusahaan')
                ->where('subdomain', $this->subdomain);
        })
        ->where('peran_id', 3) // 3 = Kurir Driver based on your seeder
        ->get();
    }

    // public function openModalHapusPesanan($pesanan_id = null) {
    //     if ($pesanan_id == null) {
    //         return;
    //     }

    //     $this->hapusPesananId = $pesanan_id;
    //     $this->modalDetailMuatVisible = false;
    //     $this->modalHapusPesananVisible = true;
    // }

    // public function closeModalHapusPesanan() {
    //     $this->modalHapusPesananVisible = false;
    //     $this->modalDetailMuatVisible = true;
    // }

    // public function hapusPesanan() {
    //     if ($this->hapusPesananId == null || $this->dm == null) {
    //         return;
    //     }

    //     $this->dm->pesanan()
    //         ->where('id', $this->hapusPesananId)
    //         ->update(['daftar_muat_id' => null]);

    //     $this->modalHapusPesananVisible = false;
    //     $this->modalDetailMuatVisible = true;

    //     $this->dm->refresh();
    // }

    public function openModalAturKurir() {
        $this->modalDetailMuatVisible = false;
        $this->modalAturKurirVisible = true;
    }

    public function closeModalAturKurir() {
        $this->modalAturKurirVisible = false;
        $this->modalDetailMuatVisible = true;
    }

    public function aturKurir() {
        if ($this->dm == null) {
            return;
        }
        
        $this->dm->kurir()->sync($this->dmKurirs);
        $this->dm->refresh();

        $this->modalAturKurirVisible = false;
        $this->modalDetailMuatVisible = true;
    }

    public function openModalDetailMuat($dm_id = null) {
        if ($dm_id == null) {
            return;
        }

        $this->dm = ModelsDaftarMuat::with('counter', 'kendaraan', 'kurir', 'pesanan')
            ->where('id', $dm_id)
            ->first();

        $this->dmKurirs = $this->dm->kurir->pluck('id')->toArray();

        if (!$this->dm) {
            return;
        }

        $this->modalDetailMuatVisible = true;
        $this->modalTitle = 'Detail Daftar Muat ' . $dm_id;
    }

    public function closeModalDetailMuat() {
        $this->modalDetailMuatVisible = false;
    }    

    public function simpanDetailMuat() {
        if ($this->dm == null) {
            return;
        }

        $this->validate([
            'dm.counter_asal_id' => 'required|integer',
            'dm.kendaraan_id' => 'required|integer',
        ]);

        $this->dm->save();
    }

    public function render()
    {
        return $this->viewExtends('livewire.perusahaan.daftar-muat', [

        ]);
    }
}
