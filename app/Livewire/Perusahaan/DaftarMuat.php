<?php

namespace App\Livewire\Perusahaan;

use App\Models\DaftarMuat as ModelsDaftarMuat;
use Livewire\Component;

class DaftarMuat extends DashboardPerusahaanComponent
{
    public $modalDetailMuatVisible = false;

    public function openModalDetailMuat($dm_id) {
        $this->modalDetailMuatVisible = true;
        $this->modalTitle = 'Detail Daftar Muat ' . $dm_id;

        $dm = ModelsDaftarMuat::with('counter', 'kendaraan', 'kurirs', 'pesanan')
            ->where('id', $dm_id)
            ->first();
    }

    public function closeModalDetailMuat() {
        $this->modalDetailMuatVisible = false;
    }

    public function render()
    {
        $daftarMuats = ModelsDaftarMuat::with('counter')
            ->whereHas('counter', function($query) {
                $query->where('perusahaan_id', function($subquery) {
                    $subquery->select('id')
                        ->from('perusahaan')
                        ->where('subdomain', $this->subdomain);
                });
            });

        if ($this->query != null) {
            // $pesanans->where(function($q) {
            //     $q->where('full_name', 'like', '%' . $this->query . '%')
            //       ->orWhere('email', 'like', '%' . $this->query . '%');
            // });
        }

        return $this->viewExtends('livewire.perusahaan.daftar-muat', [
            'daftarMuats' => $daftarMuats->paginate(10)
        ]);
    }
}
