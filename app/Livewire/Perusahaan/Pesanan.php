<?php

namespace App\Livewire\Perusahaan;

use App\Models\BukuKasus;
use App\Models\Pesanan as ModelsPesanan;
use Livewire\Component;
use Livewire\WithPagination;

class Pesanan extends DashboardPerusahaanComponent
{
    use WithPagination;

    public $modalReadKasusVisible = false;
    public $modalCreateKasusVisible = false;
    public $modalUpdateKasusVisible = false;
    public $modalDeleteKasusVisible = false;
    public $modalPesananId = null;
    public $queryKasus = '';

    public $kasusPesanan = [];
    public $kasus_id;
    public $kasus_kasus;
    public $kasus_selesai = 1;

    protected $rules = [
        'kasus_id' => 'nullable|integer',
        'kasus_kasus' => 'required|string',
        'kasus_selesai' => 'required|in:0,1'
    ];
    
    protected $casts = [
        'kasus_selesai' => 'boolean'
    ];

    public function createKasus() {
        $kasus = new BukuKasus();
        $kasus->pesanan_id = $this->modalPesananId;
        $kasus->kasus = $this->kasus_kasus;
        $kasus->tanggal_dibuat = now();
        $kasus->tanggal_selesai = null;
        $kasus->save();
        $this->closeModalCreateKasus();
    }

    public function updateKasus() {
        $kasus = BukuKasus::where('id', $this->kasus_id)->first();
        $kasus->kasus = $this->kasus_kasus;
        
        if ($this->kasus_selesai) {
            $kasus->tanggal_selesai = now();
        } else {
            $kasus->tanggal_selesai = null;
        }
        $kasus->save();
        $this->closeModalUpdateKasus();
    }

    public function deleteKasus() {
        $kasus = BukuKasus::where('id', $this->kasus_id)->first();
        $kasus->delete();
        $this->closeModalDeleteKasus();
    }

    public function openModalReadKasus($pesanan_id) {
        $this->modalTitle = 'Daftar Kasus Pesanan ' . $pesanan_id;
        $this->modalPesananId = $pesanan_id;
        $this->modalReadKasusVisible = true;
        $query = BukuKasus::where('pesanan_id', $pesanan_id);

        if ($this->queryKasus != null) {
            $query->where('kasus', 'like', '%' . $this->queryKasus . '%');
        }

        $this->kasusPesanan = $query->orderBy('tanggal_dibuat', 'asc')->get();
    }

    public function openModalCreateKasus() {
        $this->reset(['kasus_kasus', 'kasus_selesai']);
        $id = $this->modalPesananId;
        $this->modalTitle = 'Buat Kasus untuk Pesanan ' . $id;
        $this->modalReadKasusVisible = false;
        $this->modalCreateKasusVisible = true;
    }

    public function openModalUpdateKasus($kasus_id) {
        $id = $this->modalPesananId;
        $this->modalTitle = 'Perbarui Kasus untuk Pesanan ' . $id;
        $this->modalReadKasusVisible = false;
        $this->modalUpdateKasusVisible = true;

        $kasus = BukuKasus::where('id', $kasus_id)->first();
        $this->kasus_id = $kasus->id;
        $this->kasus_kasus = $kasus->kasus;
        $this->kasus_selesai = $kasus->tanggal_selesai != null ? 1 : 0;
    }

    public function openModalDeleteKasus($kasus_id) {
        $this->modalTitle = 'Hapus Kasus untuk Pesanan ' . $this->modalPesananId;
        $this->modalReadKasusVisible = false;
        $this->modalDeleteKasusVisible = true;

        $this->kasus_id = $kasus_id;
    }

    public function closeModalUpdateKasus() {
        $this->modalUpdateKasusVisible = false;
        $this->openModalReadKasus($this->modalPesananId);
    }

    public function closeModalCreateKasus() {
        $this->modalCreateKasusVisible = false;
        $this->openModalReadKasus($this->modalPesananId);
    }

    public function closeModalDeleteKasus() {
        $this->modalDeleteKasusVisible = false;
        $this->openModalReadKasus($this->modalPesananId);
    }

    public function closeModal() {
        // $this->modalReadKasusVisible = false;
        $this->reset(['kasusPesanan', 'kasus_id', 'kasus_kasus', 'kasus_selesai', 'modalUpdateKasusVisible', 'modalReadKasusVisible', 'modalCreateKasusVisible']);
    }

    public function render()
    {
        $pesanans = ModelsPesanan::with(['bukuKasus', 'status', 'daftarMuat', 'layanan', 'user', 'asalCounter', 'destinasiCounter'])
            ->whereHas('layanan.perusahaan', function($query) {
                $query->where('subdomain', $this->subdomain);
            });

        if ($this->query != null) {
            $pesanans->where(function($q) {
                $q->where('full_name', 'like', '%' . $this->query . '%')
                  ->orWhere('email', 'like', '%' . $this->query . '%');
            });

            $pesanans->where(function($q) {
                $q->where('id', $this->query)
                ->orWhere('tanggal_pemesanan', 'like', '%' . $this->query . '%')
                ->orWhere('tanggal_terkirim', 'like', '%' . $this->query . '%')
                ->orWhere('alamat_asal', 'like', '%' . $this->query . '%')
                ->orWhere('alamat_destinasi', 'like', '%' . $this->query . '%')
                ->orWhereHas('layanan', function($q2) {
                    $q2->where('nama', 'like', '%' . $this->query . '%'); // sesuaikan nama kolom
                })
                ->orWhereHas('status', function($q3) {
                    $q3->where('status', 'like', '%' . $this->query . '%'); // sesuaikan nama kolom
                });
            });
        }

        return $this->viewExtends('livewire.perusahaan.pesanan', [
            'pesanans' => $pesanans->paginate(10)
        ]);
    }
}
