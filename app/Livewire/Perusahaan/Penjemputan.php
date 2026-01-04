<?php

namespace App\Livewire\Perusahaan;

use Livewire\Component;
use App\Models\Counter;
use App\Models\Pesanan;
use App\Models\Kendaraan;
use App\Models\User;
use App\Models\Penjemputan as ModelsPenjemputan;
use Livewire\WithPagination;
use Livewire\Attributes\Computed;

class Penjemputan extends DashboardPerusahaanComponent
{
    use WithPagination;

    public $modalBuatPenjemputanVisible = false;
    public $newCounterDestinasiId;
    public $newKendaraanId;
    public $newKurirs = [];
    public $namaKurirBaru = [];

    public $modalBuatKurirVisible = false;

    public $modalAturKurirVisible = false;

    public $modalDetailPenjemputanVisible = false;
    public $p;
    public $pKurirs = [];
    public $pPesanans = [];

    public $modalTambahPesananVisible = false;

    public $modalHapusPesananVisible = false;
    public $hapusPesananId;

    public $modalHapusPVisible = false;
    public $hapusPId;

    public $penjemputanQuery;
    public $pesananQuery;

    protected $rules = [
        'p.counter_destinasi_id' => 'required|integer', // Required for validation
        'p.kendaraan_id' => 'required|integer', // Required for validation
    ];


    #[Computed]
    public function penjemputans()
    {
        return ModelsPenjemputan::with('counter')
            ->whereHas('counter', function($q) {
                $q->where('perusahaan_id', function($subquery) {
                    $subquery->select('id')
                        ->from('perusahaan')
                        ->where('subdomain', $this->subdomain);
                });
            })
            ->when($this->penjemputanQuery, function($q) {
                $q->where('id', 'like', '%' . $this->penjemputanQuery . '%');
            })
            ->paginate(10);
    }

    #[Computed]
    public function counters() {
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
        return Pesanan::whereNull('penjemputan_id') // Use whereNull for safety
            ->where('status_id', 2)
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

    public function openModalBuatPenjemputan() {
        $this->modalBuatPenjemputanVisible = true;

        $this->namaKurirBaru = [];

        foreach ($this->newKurirs as $i => $newKurirID) {
            $this->namaKurirBaru[$newKurirID] = User::find($newKurirID);
        }
    }

    public function closeModalBuatPenjemputan() {
        $this->modalBuatPenjemputanVisible = false;
    }

    public function buatPenjemputan() {
        $this->validate([
            'newCounterDestinasiId' => 'required|integer',
            'newKendaraanId' => 'required|integer'
        ]);

        foreach ($this->newKurirs as $kurir_id) {
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

        $penjemputan = new ModelsPenjemputan();
        $penjemputan->counter_destinasi_id = $this->newCounterDestinasiId;
        $penjemputan->kendaraan_id = $this->newKendaraanId;
        $penjemputan->tanggal_dibuat = now();
        $penjemputan->save();

        $penjemputan->kurir()->attach($this->newKurirs);
        $penjemputan->save();

        $this->closeModalBuatPenjemputan();
    }

    public function openModalBuatKurir() {
        $this->modalBuatKurirVisible = true;
        $this->closeModalBuatPenjemputan();
    }

    public function closeModalBuatKurir() {
        $this->modalBuatKurirVisible = false;
        $this->openModalBuatPenjemputan();
    }

    public function openModalPenjemputan($p_id = null) {
        if ($p_id == null) {
            return;
        }

        $this->modalTitle = "Detail Penjemputan " . $p_id;

        $this->p = ModelsPenjemputan::with('counter', 'kendaraan', 'kurir', 'pesanan')
            ->where('id', $p_id)
            ->whereHas('counter', function($q) {
                $q->where('perusahaan_id', function($subquery) {
                    $subquery->select('id')
                        ->from('perusahaan')
                        ->where('subdomain', $this->subdomain);
                });
            })
            ->first();

        if ($this->p == null) {
            return;
        }

        $this->pKurirs = $this->p->kurir->pluck('id')->toArray();
        $this->pPesanans = $this->p->pesanan->pluck('id')->toArray();

        $this->modalDetailPenjemputanVisible = true;
    }

    public function closeModalPenjemputan() {
        $this->modalDetailPenjemputanVisible = false;
    }

    public function simpanPenjemputan() {
        if ($this->p == null) {
            return;
        }

        $this->validate([
            'p.counter_destinasi_id' => 'required|integer',
            'p.kendaraan_id' => 'required|integer',
        ]);

        if (!Counter::where('id', $this->p->counter_destinasi_id)
            ->where('perusahaan_id', function ($subquery) {
                $subquery->select('id')
                    ->from('perusahaan')
                    ->where('subdomain', $this->subdomain);
            })->exists()) {
            return;
        }

        if (!Kendaraan::where('id', $this->p->kendaraan_id)
            ->where('perusahaan_id', function ($subquery) {
                $subquery->select('id')
                    ->from('perusahaan')
                    ->where('subdomain', $this->subdomain);
            })->exists()) {
            return;
        }

        $this->p->save();
    }

    public function openModalAturKurir() {
        $this->modalDetailPenjemputanVisible = false;
        $this->modalAturKurirVisible = true;
    }

    public function closeModalAturKurir() {
        $this->modalAturKurirVisible = false;
        $this->modalDetailPenjemputanVisible = true;
    }

    public function aturKurir() {
        if ($this->p == null) {
            return;
        }

        foreach ($this->pKurirs as $kurir_id) {
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

        $this->p->kurir()->sync($this->pKurirs);
        $this->p->refresh();

        $this->closeModalAturKurir();
    }

    public function openModalTambahPesanan() {
        $this->reset(['pesananQuery', 'pPesanans']);
        $this->modalDetailPenjemputanVisible = false;
        $this->modalTambahPesananVisible = true;
    }

    public function closeModalTambahPesanan() {
        $this->modalTambahPesananVisible = false;
        $this->modalDetailPenjemputanVisible = true;
    }

    public function tambahPesanan() {
        if ($this->p == null) {
            return;
        }

        foreach ($this->pPesanans as $pesanan_id) {
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
                $pesanan->penjemputan_id = $this->p->id;
                $pesanan->save();
            }
        }

        $this->p->refresh();

        $this->modalTambahPesananVisible = false;
        $this->modalDetailPenjemputanVisible = true;
    }

    public function openModalHapusPesanan($pesanan_id = null) {
        if ($pesanan_id == null) {
            return;
        }

        $this->hapusPesananId = $pesanan_id;
        $this->modalDetailPenjemputanVisible = false;
        $this->modalHapusPesananVisible = true;
    }

    public function closeModalHapusPesanan() {
        $this->modalHapusPesananVisible = false;
        $this->modalDetailPenjemputanVisible = true;
    }

    public function hapusPesanan() {
        if ($this->hapusPesananId == null || $this->p == null) {
            return;
        }

        $this->p->pesanan()
            ->where('id', $this->hapusPesananId)
            ->update(['penjemputan_id' => null]);

        $this->modalHapusPesananVisible = false;
        $this->modalDetailPenjemputanVisible = true;

        $this->p->refresh();
    }

    public function openModalHapusPenjemputan($p_id = null) {
        if ($p_id == null) {
            return;
        }

        $this->hapusPId = $p_id;
        $this->modalHapusPVisible = true;
    }

    public function closeModalHapusP() {
        $this->modalHapusPVisible = false;
    }

    public function hapusP() {
        if ($this->hapusPId == null) {
            return;
        }

        $p = ModelsPenjemputan::whereHas('counter', function($q) {
                $q->where('perusahaan_id', function($subquery) {
                    $subquery->select('id')
                        ->from('perusahaan')
                        ->where('subdomain', $this->subdomain);
                });
            })->find($this->hapusPId);

        if (!$p) {
            return;
        }

        Pesanan::where('penjemputan_id', $p->id)
            ->update(['penjemputan_id' => null]);

        $p->delete();

        $this->closeModalHapusP();
    }

    public function mount() {
        $this->newCounterDestinasiId = Counter::where('perusahaan_id', function($subquery) {
            $subquery->select('id')
                ->from('perusahaan')
                ->where('subdomain', $this->subdomain);
        })->first()->id;

        $this->newKendaraanId = Kendaraan::where('perusahaan_id', function ($subquery) {
                $subquery->select('id')
                    ->from('perusahaan')
                    ->where('subdomain', $this->subdomain);
            })->first()->id;
    }

    public function render()
    {
        return $this->viewExtends('livewire.perusahaan.penjemputan', [
            
        ]);
    }
}
