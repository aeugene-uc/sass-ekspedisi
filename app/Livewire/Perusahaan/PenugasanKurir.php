<?php

namespace App\Livewire\Perusahaan;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use App\Models\Penjemputan as ModelsPenjemputan;
use App\Models\DaftarMuat as ModelsDaftarMuat;
use App\Models\BukuKasus;
use App\Models\Perusahaan;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class PenugasanKurir extends DashboardPerusahaanComponent
{
    use WithPagination;
    use WithFileUploads;

    public $query;

    public $tipe = 'daftar_muat';

    public $modalLihatDetailVisible = false;
    public $detailId;
    public $detail;
    public $fotoTerkirim = [];

    public $modalGambarVisible = false;
    public $modalGambarSrc = '';

    public $modalTambahKasusVisible = false;
    public $kasus_kasus;
    public $kasus_foto;
    public $kasus_pesanan_id;

    #[Computed]
    public function penjemputans()
    {
        return ModelsPenjemputan::with('counter')
            ->whereNull('tanggal_selesai')
            ->whereHas('kurir', function($q) {
                $q->where('id',  Auth::user()->id);
            })
            ->when($this->query, function($q) {
                $q->where('id', 'like', '%' . $this->query . '%');
            })
            ->paginate(10);
    }

    #[Computed]
    public function daftarMuats()
    {
        return ModelsDaftarMuat::with('counter')
            ->whereNull('tanggal_selesai')
            ->whereHas('kurir', function($q) {
                $q->where('id',  Auth::user()->id);
            })
            ->when($this->query, function($q) {
                $q->where('id', 'like', '%' . $this->query . '%');
            })
            ->paginate(10);
    }

    public function updated($propertyName, $value)
    {
        if (str_starts_with($propertyName, 'fotoTerkirim.')) {
            $parts = explode('.', $propertyName);
            $pesananId = $parts[1];
            $this->uploadFotoTerkirim($pesananId);
        }
    }


    public function openModalLihatDetail($id)
    {
        $this->modalLihatDetailVisible = true;
        $this->detailId = $id;
        
        if ($this->tipe == 'penjemputan') {
            $detail = ModelsPenjemputan::with('counter', 'kurir')->find($id);
        } else {
            $detail = ModelsDaftarMuat::with('counter', 'kurir')->find($id);
        }

        if (
            $detail === null ||
            $detail->counter->perusahaan_id != $this->perusahaan_id
        ) {
            return;
        }

        $this->detail = $detail;
    }

    public function closeModalLihatDetail()
    {
        $this->modalLihatDetailVisible = false;
        $this->detailId = null;
    }

    public function uploadFotoTerkirim($pesananId)
    {
        // $this->validate([
        //     'fotoTerkirim' => 'required|array',
        //     'fotoTerkirim.*' => 'required|image', // 2MB Max
        // ]);

        // dd('Here');

        $pesanan = $this->detail->pesanan()->where('id', $pesananId)->first();

        if (
            $pesanan->user->perusahaan_id != $this->perusahaan_id &&
            !$pesanan->user->is_platform_admin
        ) {
            return;
        }

        if ($pesanan->foto_terkirim) {
            \Storage::delete('public/images/pesanan/' . $pesanan->foto_terkirim);
        }

        $pesanan->foto_terkirim = basename($this->fotoTerkirim[$pesananId]->store('images/pesanan', 'public'));
        $pesanan->tanggal_terkirim = now();
        $pesanan->save();
    }

    public function openModalGambar($url)
    {   
        $this->modalGambarSrc = $url;
        $this->modalLihatDetailVisible = false;
        $this->modalGambarVisible = true;
    }

    public function closeModalGambar()
    {
        $this->modalGambarVisible = false;
        $this->modalLihatDetailVisible = true;
    }

    public function openModalTambahKasus($pesanan_id)
    {
        $this->kasus_pesanan_id = $pesanan_id;
        $this->modalLihatDetailVisible = false;
        $this->modalTambahKasusVisible = true;
    }

    public function closeModalTambahKasus() {
        $this->modalTambahKasusVisible = false;
        $this->modalLihatDetailVisible = true;
    }

    public function buatKasus() {
        $this->validate([
            'kasus_kasus' => 'required|string',
            'kasus_pesanan_id' => 'required|integer',
            'kasus_foto' => 'required|image'
        ]);

        $pesanan = $this->detail->pesanan()->where('id', $this->kasus_pesanan_id)->first();

        if ($pesanan === null) {
            return;
        }

        if (
            $pesanan->user->perusahaan_id != $this->perusahaan_id &&
            !$pesanan->user->is_platform_admin
        ) {
            return;
        }

        if ($pesanan->bukuKasus()->whereNull('tanggal_selesai')->exists()) {
            return;
        }

        $kasus = new BukuKasus();
        $kasus->pesanan_id = $this->kasus_pesanan_id;
        $kasus->kasus = $this->kasus_kasus;
        $kasus->foto = basename($this->kasus_foto->store('images/kasus', 'public'));
        $kasus->tanggal_dibuat = now();
        $kasus->save();

        $this->closeModalTambahKasus();
    }

    public function render()
    {
        return $this->viewExtends('livewire.perusahaan.penugasan-kurir', [

        ]);
    }
}
