<?php

namespace App\Livewire\Perusahaan;

use App\Models\DaftarMuat as ModelsDaftarMuat;
use App\Models\Counter;
use App\Models\Pesanan;
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
    public $dmPesanans = [];

    public $modalHapusPesananVisible = false;
    public $hapusPesananId;

    public $modalHapusDMVisible = false;
    public $hapusDMId;

    public $modalAturKurirVisible = false;

    public $modalTambahPesananVisible = false;

    public $modalBuatDMVisible = false;
    public $modalBuatDMKurirVisible = false;
    public $newDMCounterAsalId;
    public $newDMKendaraanId;
    public $newDMKurirs = [];
    public $namaKurirBaru = [];

    public $daftarMuatQuery;
    public $pesananQuery;

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

    #[Computed]
    public function allPesanans() {
        \Log::info('Fetching All Pesanans');
        return Pesanan::whereNull('daftar_muat_id') // Use whereNull for safety
            ->where('status_id', 3)
            ->whereHas('user', function ($query) {
                $query
                    ->where('perusahaan_id', function ($subquery) {
                        $subquery->select('id')
                            ->from('perusahaan')
                            ->where('subdomain', $this->subdomain);
                    })
                    ->orWhere('is_platform_admin', true);
            })
            ->when($this->pesananQuery, function($q) {
                $q->where(function($sub) {
                    $sub->where('id', $this->pesananQuery)
                        ->orWhere('tanggal_terkirim', 'like', '%' . $this->pesananQuery . '%')
                        ->orWhere('alamat_destinasi', 'like', '%' . $this->pesananQuery . '%')
                        ->orWhereHas('destinasiCounter', function($q2) { // Note: Relation name is usually camelCase
                            $q2->where('nama', 'like', '%' . $this->pesananQuery . '%');
                        })
                        ->orWhereHas('user', function($q1) {
                            $q1->where('full_name', 'like', '%' . $this->pesananQuery . '%')
                            ->orWhere('email', 'like', '%' . $this->pesananQuery . '%');
                        });
                });
            })
            ->paginate(10, ['*'], 'pagePesanans');
    }

    public function openModalHapusPesanan($pesanan_id = null) {
        if ($pesanan_id == null) {
            return;
        }

        $this->hapusPesananId = $pesanan_id;
        $this->modalDetailMuatVisible = false;
        $this->modalHapusPesananVisible = true;
    }

    public function closeModalHapusPesanan() {
        $this->modalHapusPesananVisible = false;
        $this->modalDetailMuatVisible = true;
    }

    public function hapusPesanan() {
        if ($this->hapusPesananId == null || $this->dm == null) {
            return;
        }

        $this->dm->pesanan()
            ->where('id', $this->hapusPesananId)
            ->update(['daftar_muat_id' => null]);

        $this->modalHapusPesananVisible = false;
        $this->modalDetailMuatVisible = true;

        $this->dm->refresh();
    }

    public function openModalAturKurir() {
        $this->modalDetailMuatVisible = false;
        $this->modalAturKurirVisible = true;
    }

    public function closeModalAturKurir() {
        $this->modalAturKurirVisible = false;
        $this->modalDetailMuatVisible = true;
    }

    public function openModalBuatKurir() {
        $this->modalBuatDMVisible = false;
        $this->modalBuatDMKurirVisible = true;
    }

    public function closeModalBuatKurir() {
        $this->modalBuatDMKurirVisible = false;
        $this->openModalBuatDM();
    }

    public function openModalTambahPesanan() {
        $this->reset(['pesananQuery', 'dmPesanans']);
        $this->modalDetailMuatVisible = false;
        $this->modalTambahPesananVisible = true;
    }

    public function closeModalTambahPesanan() {
        $this->modalTambahPesananVisible = false;
        $this->modalDetailMuatVisible = true;
    }

    public function tambahPesanan() {
        if ($this->dm == null) {
            return;
        }

        foreach ($this->dmPesanans as $pesanan_id) {
            $pesanan = Pesanan::whereHas('user', function ($query) {
                $query->where('perusahaan_id', function ($subquery) {
                    $subquery->select('id')
                        ->from('perusahaan')
                        ->where('subdomain', $this->subdomain);
                })
                    ->orWhere('is_platform_admin', true);
            })
            ->find($pesanan_id);

            if ($pesanan) {
                $pesanan->daftar_muat_id = $this->dm->id;
                $pesanan->save();
            }
        }

        $this->dm->refresh();

        $this->modalTambahPesananVisible = false;
        $this->modalDetailMuatVisible = true;
    }

    public function buatKurir() {
        $this->modalBuatDMKurirVisible = false;
        $this->modalBuatDMVisible = true;
    }

    public function aturKurir() {
        if ($this->dm == null) {
            return;
        }

        foreach ($this->dmKurirs as $kurir_id) {
            $kurir = User::where('perusahaan_id', function ($subquery) {
                $subquery->select('id')
                    ->from('perusahaan')
                    ->where('subdomain', $this->subdomain);
            })
            ->where('peran_id', 3) // 3 = Kurir Driver based on your seeder
            ->find($kurir_id);

            if (!$kurir) {
                return;
            }
        }

        $this->dm->kurir()->sync($this->dmKurirs);
        $this->dm->refresh();

        $this->modalAturKurirVisible = false;
        $this->modalDetailMuatVisible = true;
    }
    
    public function openModalBuatDM() {
        $this->modalBuatDMVisible = true;

        $this->namaKurirBaru = [];

        foreach ($this->newDMKurirs as $i => $newKurirID) {
            $this->namaKurirBaru[$newKurirID] = User::find($newKurirID);
        }

        $this->newDMCounterAsalId = Counter::where('perusahaan_id', function($subquery) {
            $subquery->select('id')
                ->from('perusahaan')
                ->where('subdomain', $this->subdomain);
        })->first()->id;

        $this->newDMKendaraanId = Kendaraan::where('perusahaan_id', function ($subquery) {
                $subquery->select('id')
                    ->from('perusahaan')
                    ->where('subdomain', $this->subdomain);
            })->first()->id;
    }

    public function closeModalBuatDM() {
        $this->modalBuatDMVisible = false;
    }    

    public function openModalHapusDM($dm_id = null) {
        if ($dm_id == null) {
            return;
        }

        $this->hapusDMId = $dm_id;
        $this->modalHapusDMVisible = true;
    }

    public function closeModalHapusDM() {
        $this->modalHapusDMVisible = false;
    }

    public function hapusDM() {
        if ($this->hapusDMId == null) {
            return;
        }

        $dm = ModelsDaftarMuat::whereHas('counter', function($q) {
                $q->where('perusahaan_id', function($subquery) {
                    $subquery->select('id')
                        ->from('perusahaan')
                        ->where('subdomain', $this->subdomain);
                });
            })->find($this->hapusDMId);

        if (!$dm) {
            return;
        }

        Pesanan::where('daftar_muat_id', $dm->id)
            ->update(['daftar_muat_id' => null]);

        $dm->delete();

        $this->closeModalHapusDM();
    }

    public function buatDetailMuat() {
        $this->validate([
            'newDMCounterAsalId' => 'required|integer',
            'newDMKendaraanId' => 'required|integer'
        ]);

        foreach ($this->newDMKurirs as $kurir_id) {
            $kurir = User::where('perusahaan_id', function ($subquery) {
                $subquery->select('id')
                    ->from('perusahaan')
                    ->where('subdomain', $this->subdomain);
            })
            ->where('peran_id', 3)
            ->find($kurir_id);

            if (!$kurir) {
                return;
            }
        }


        $newDM = new ModelsDaftarMuat();
        $newDM->counter_asal_id = $this->newDMCounterAsalId;
        $newDM->kendaraan_id = $this->newDMKendaraanId;
        $newDM->tanggal_dibuat = now();
        $newDM->save();

        $newDM->kurir()->sync($this->newDMKurirs);
        $newDM->save();

        $this->closeModalBuatDM();
    }

    public function openModalDetailMuat($dm_id = null) {
        if ($dm_id == null) {
            return;
        }

        $this->dm = ModelsDaftarMuat::with('counter', 'kendaraan', 'kurir', 'pesanan')
            ->where('id', $dm_id)
            ->whereHas('counter', function($q) {
                $q->where('perusahaan_id', function($subquery) {
                    $subquery->select('id')
                        ->from('perusahaan')
                        ->where('subdomain', $this->subdomain);
                });
            })
            ->first();

        if (!$this->dm) {
            return;
        }

        $this->dmKurirs = $this->dm->kurir->pluck('id')->toArray();
        $this->dmPesanans = $this->dm->pesanan->pluck('id')->toArray();

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

        if (!Counter::where('id', $this->dm->counter_asal_id)
            ->where('perusahaan_id', function ($subquery) {
                $subquery->select('id')
                    ->from('perusahaan')
                    ->where('subdomain', $this->subdomain);
            })->exists()) {
            return;
        }

        if (!Kendaraan::where('id', $this->dm->kendaraan_id)
            ->where('perusahaan_id', function ($subquery) {
                $subquery->select('id')
                    ->from('perusahaan')
                    ->where('subdomain', $this->subdomain);
            })->exists()) {
            return;
        }

        $this->dm->save();
    }

    public function render()
    {
        return $this->viewExtends('livewire.perusahaan.daftar-muat', [

        ]);
    }
}
