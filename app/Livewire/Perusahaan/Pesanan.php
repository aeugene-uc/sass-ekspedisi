<?php

namespace App\Livewire\Perusahaan;

use App\Models\Barang;
use App\Models\BukuKasus;
use App\Models\Pesanan as ModelsPesanan;
use App\Models\StatusPesanan;
use Livewire\Component;
use Livewire\WithPagination;
use Midtrans\Config;
use Midtrans\Transaction;

class Pesanan extends DashboardPerusahaanComponent
{
    use WithPagination;

    public $modalReadKasusVisible = false;
    public $modalCreateKasusVisible = false;
    public $modalUpdateKasusVisible = false;
    public $modalDeleteKasusVisible = false;
    public $modalPesananId = null;
    public $queryKasus = '';

    public $modalReadBarangVisible = false;
    public $barangPesanan = [];

    public $kasusPesanan = [];
    public $kasus_id;
    public $kasus_kasus;
    public $kasus_selesai = 1;

    public $statusPesanans = [];
    public $statusPesanan;

    public $modalGambarVisible = false;
    public $modalGambarSrc = '';

    private $pesanans;

    protected $rules = [
        'kasus_id' => 'nullable|integer',
        'kasus_kasus' => 'required|string',
        'kasus_selesai' => 'required|in:0,1'
    ];
    
    protected $casts = [
        'kasus_selesai' => 'boolean'
    ];

    public function openModalReadBarang($pesanan_id) {
        $this->modalTitle = 'Daftar Barang Pesanan ' . $pesanan_id;
        $this->modalPesananId = $pesanan_id;
        $this->modalReadBarangVisible = true;
        $this->barangPesanan = Barang::where('pesanan_id', $pesanan_id)->get();
    }

    public function closeModalReadBarang() {
        $this->modalReadBarangVisible = false;
        $this->barangPesanan = [];
    }

    public function openModalGambar($src) {
        $this->closeModal();
        $this->modalGambarSrc = $src;
        $this->modalGambarVisible = true;
    }

    public function closeModalGambarToBarang() {
        $this->modalGambarVisible = false;
        $this->modalGambarSrc = '';
        $this->openModalReadBarang($this->modalPesananId);
    }

    public function createKasus() {
        $this->validate([
            'kasus_kasus' => 'required|string',
            'modalPesananId' => 'required|integer|exists:pesanan,id'
        ]);

        $kasus = new BukuKasus();
        $kasus->pesanan_id = $this->modalPesananId;
        $kasus->kasus = $this->kasus_kasus;
        $kasus->tanggal_dibuat = now();
        $kasus->tanggal_selesai = null;
        $kasus->save();

        // $pesanan = ModelsPesanan::where('id', $this->modalPesananId)->first();
        // $pesanan->tanggal_terkirim = null;
        // $pesanan->status_id = 3;
        // $pesanan->save();

        $this->closeModalCreateKasus();
    }

    public function updateKasus() {
        $this->validate([
            'kasus_id' => 'required|integer|exists:buku_kasus,id'
        ]);

        $kasus = BukuKasus::where('id', $this->kasus_id)->first();
        $kasus->kasus = $this->kasus_kasus;
        
        if ($this->kasus_selesai) {
            $kasus->tanggal_selesai = now();
        } else {
            $kasus->tanggal_selesai = null;
            // $pesanan = ModelsPesanan::where('id', $this->modalPesananId)->first();
            // $pesanan->tanggal_terkirim = null;
            // $pesanan->status_id = 3;
            // $pesanan->save();
        }
        $kasus->save();
        $this->closeModalUpdateKasus();
    }

    public function deleteKasus() {
        $this->validate([
            'kasus_id' => 'required|integer|exists:buku_kasus,id'
        ]);

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
            $query->where('kasus', 'like', '%' . $this->queryKasus . '%')
                    ->orWhere('tanggal_dibuat', 'like', '%' . $this->queryKasus . '%')
                    ->orWhere('tanggal_selesai', 'like', '%' . $this->queryKasus . '%');
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
        $this->reset(['modalGambarVisible', 'modalReadBarangVisible', 'modalGambarSrc', 'kasusPesanan', 'kasus_id', 'kasus_kasus', 'kasus_selesai', 'modalUpdateKasusVisible', 'modalReadKasusVisible', 'modalCreateKasusVisible']);
    }

    public function updateStatusPesanan($pesanan_id, $status_id) {
        try {
            $pesanan = ModelsPesanan::where('id', $pesanan_id)->firstOrFail();
            $pesanan->status_id = $status_id;

            if ($status_id == 4) { // Delivered
                $pesanan->tanggal_terkirim = now();
            } else {
                $pesanan->tanggal_terkirim = null;
            }

            $pesanan->save();
        } catch (\Exception $e) {
            $this->addError('statusPesanan', 'Gagal memperbarui status pesanan. Silakan coba lagi.');
        }
    }

    public function mount() {
        $this->subdomain = request()->route('subdomain');
        $this->statusPesanans = StatusPesanan::all();
    }

    public function render()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        $pesanans = ModelsPesanan::with(['bukuKasus', 'status', 'daftarMuat', 'layanan', 'user', 'asalCounter', 'destinasiCounter'])
            ->whereHas('layanan.perusahaan', function($query) {
                $query->where('subdomain', $this->subdomain);
            });

        // foreach ($pesanans->get() as $pesanan) {
        //     if ($pesanan->status_id == 1 && !$pesanan->bukuKasus->count() > 0) {
        //         try {
        //             $status = Transaction::status($pesanan->midtrans_order_id);

        //             if ($status->transaction_status == 'settlement') {
        //                 $pesanan->status_id = 2; // Update status to 'Paid'
        //                 $pesanan->save();
        //             }
        //         } catch (\Exception $e) {}
        //     }
        // }

        if ($this->query != null) {
            $pesanans->where(function($q) {
                $q->where('id', $this->query)
                ->orWhere('tarif', 'like', '%' . $this->query . '%')
                ->orWhere('daftar_muat_id', 'like', '%' . $this->query . '%')
                ->orWhere('tanggal_pemesanan', 'like', '%' . $this->query . '%')
                ->orWhere('tanggal_terkirim', 'like', '%' . $this->query . '%')
                ->orWhere('alamat_asal', 'like', '%' . $this->query . '%')
                ->orWhere('alamat_destinasi', 'like', '%' . $this->query . '%')
                ->orWhereHas('asalCounter', function($q2) {
                    $q2->where('nama', 'like', '%' . $this->query . '%');
                })
                ->orWhereHas('destinasiCounter', function($q2) {
                    $q2->where('nama', 'like', '%' . $this->query . '%');
                })
                ->orWhereHas('user', function($q1) {
                    $q1->where('full_name', 'like', '%' . $this->query . '%') // sesuaikan nama kolom
                      ->orWhere('email', 'like', '%' . $this->query . '%'); // sesuaikan nama kolom
                })
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
