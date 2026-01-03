<?php

namespace App\Livewire\Perusahaan;

use App\Models\Barang;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class HistoriPesanan extends DashboardPerusahaanComponent
{
    use WithPagination;

    public $modalGambarVisible = false;
    public $modalGambarSrc = '';

    public $modalPesananId = null;

    public $modalReadBarangVisible = false;
    public $barangPesanan = [];

    public $modalBatalTransaksiVisible = false;

    private $pesanans;

    public function openModalGambar($src) {
        $this->closeModal();
        $this->modalGambarSrc = $src;
        $this->modalGambarVisible = true;
    }

    public function closeModalGambar() {
        $this->closeModal();
        $this->openModalReadBarang($this->modalPesananId);
    }

    public function openModalReadBarang($pesanan_id) {
        $this->modalTitle = 'Daftar Barang Pesanan ' . $pesanan_id;
        $this->modalPesananId = $pesanan_id;
        $this->modalReadBarangVisible = true;
        $this->barangPesanan = Barang::where('pesanan_id', $pesanan_id)->get();
    }

    public function closeModalReadBarang() {
        $this->closeModal();
    }

    public function openModalBatalTransaksi($pesanan_id) {
        $this->modalTitle = 'Batal Transaksi Pesanan ' . $pesanan_id;
        $this->modalPesananId = $pesanan_id;
        $this->modalBatalTransaksiVisible = true;
    }

    public function closeModal() {
        $this->modalGambarVisible = false;
        $this->modalReadBarangVisible = false;
        $this->modalBatalTransaksiVisible = false;
    }

    public function bayar($pesanan_id = null) {
        if (!$pesanan_id) {
            return;
        }

        $pesanan = Pesanan::find($pesanan_id);

        if (!$pesanan) {
            return;
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        if ($pesanan->midtrans_snap) {
            $snapToken = $pesanan->midtrans_snap;
        } else {
            $snapToken = Snap::getSnapToken([
                'transaction_details' => [
                    'order_id' => $pesanan->id,
                    'gross_amount' => $pesanan->tarif,
                ],
                'customer_details' => [
                    'first_name' => explode(' ', Auth::user()->name)[0] ?? 'User',
                    'last_name' => explode(' ', Auth::user()->name)[1] ?? 'User',
                    'email' => Auth::user()->email
                ],
            ]);
            $pesanan->midtrans_snap = $snapToken;
            $pesanan->save();
        }

        $this->dispatch('snapToken', $snapToken);
    }

    public function batal() {
        $pesanan = Pesanan::find($this->modalPesananId);

        if (!$pesanan) {
            return;
        }

        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        // try {
        //     Transaction::cancel($this->modalPesananId);

        // } catch (\Exception $e) {
        //     dd($e);
        //     $this->addError('batal', 'Gagal membatalkan pesanan. Silakan coba lagi.');
        //     return;
        // }

        $pesanan->status_id = 5; // Canceled
        $pesanan->save();
        $this->closeModal();
    }

    public function mount() {
        $this->subdomain = request()->route('subdomain');
        $subdomain = $this->subdomain;
    }


    public function render()
    {
        $subdomain = $this->subdomain;

        $pesanans = Pesanan::with(['user.perusahaan', 'status'])
            ->where('user_id', Auth::user()->id)
            ->whereHas('layanan.perusahaan', function ($q) use ($subdomain) {
                $q->where('subdomain', $subdomain);
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

        if ($this->query) {
            $pesanans->where(function($q) {
                $q->where('id', $this->query)
                ->orWhere('tarif', 'like', '%' . $this->query . '%')
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
                ->orWhereHas('status', function($q2) {
                    $q2->where('nama', 'like', '%' . $this->query . '%');
                })
                ->orWhereHas('layanan', function($q2) {
                    $q2->where('nama', 'like', '%' . $this->query . '%');
                });
            });
        }

        return $this->viewExtends('livewire.perusahaan.histori-pesanan', [
            'pesanans' => $pesanans->paginate(10),
        ]);
    }
}
