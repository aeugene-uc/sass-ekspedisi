<?php

namespace App\Livewire\Perusahaan;

use App\Models\JenisKendaraan;
use Livewire\WithPagination;
use App\Models\Kendaraan as ModelsKendaraan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\QueryException;
use Livewire\Component;

class Kendaraan extends DashboardPerusahaanComponent
{
    use WithPagination;

    public $id;
    public $plat_nomor;
    public $operasional = 1;
    public $jenis_kendaraan_id = 1;

    protected $rules = [
        'id' => 'nullable|integer',
        'plat_nomor' => 'required|string|max:20',
        'operasional' => 'required|in:0,1',
        'jenis_kendaraan_id' => 'nullable|integer'
    ];

    protected $casts = [
        'operasional' => 'boolean'
    ];

    public function closeModal() {
        $this->modalSaveVisible = false;
        $this->modalDeleteVisible = false;
        $this->reset(['id', 'plat_nomor', 'operasional', 'jenis_kendaraan_id']);
    }

    // Delete
    public function openModalDelete($id) {
        $this->modalTitle = 'Hapus Kendaraan';
        $this->modalDeleteVisible = true;
        $this->id = $id;
    }

    public function delete() {
        try {
            $record = ModelsKendaraan::findOrFail($this->id);
            $record->delete();

            $this->modalDeleteVisible = false;
            $this->reset('id');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // SQLSTATE code for integrity constraint
                $this->addError('delete', 'Kendaraan dipakai oleh data lain.');
            } else {
                $this->addError('delete', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    // Save (CREATE + UPDATE)
    public function openModalCreate() {
        $this->modalSaveVisible = true;
        $this->id = null;
        $this->modalTitle = 'Tambah Kendaraan';
    }

    public function openModalUpdate($id) {
        $this->modalSaveVisible = true;
        $this->modalTitle = 'Edit Kendaraan';

        $record = ModelsKendaraan::findOrFail($id);
        $this->id = $record->id;
        $this->plat_nomor = $record->plat_nomor;
        $this->operasional = $record->operasional;
        $this->jenis_kendaraan_id = $record->jenis_kendaraan_id;
    }

    public function save() {
        $this->validate();

        try {
            $record = $this->id
                ? ModelsKendaraan::findOrFail($this->id)
                : new ModelsKendaraan();

            $record->plat_nomor = $this->plat_nomor;
            $record->operasional = $this->operasional;
            $record->jenis_kendaraan_id = $this->jenis_kendaraan_id;
            $record->save();

            $this->modalSaveVisible = false;

            $this->reset(['id', 'plat_nomor', 'operasional', 'jenis_kendaraan_id']);
        } catch (QueryException $e) {
            dd($e);

            if ($e->getCode() == 23000) { // SQLSTATE code for integrity constraint
                $this->addError('save', 'Kendaraan dengan plat nomor tersebut sudah ada.');
            } else {
                $this->addError('save', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    public function render()
    {
        $subdomain = $this->subdomain;

        $query = ModelsKendaraan::with('jenis')
            ->whereHas('perusahaan', function ($q) use ($subdomain) {
                $q->where('subdomain', $subdomain);
            });

        if ($this->query) {
            $query->where(function($q) {
                $q->where('id', $this->query)
                ->orWhere('plat_nomor', 'like', '%' . $this->query . '%')
                ->orWhereHas('jenis', function($q2) {
                    $q2->where('jenis', 'like', '%' . $this->query . '%'); // sesuaikan nama kolom
                });
            });
        }

        return $this->viewExtends('livewire.perusahaan.kendaraan', [
            'kendaraans' => $query->paginate(10),
            'jenis_kendaraans' => JenisKendaraan::all()
        ]);
    }
}
