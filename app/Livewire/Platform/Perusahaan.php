<?php

namespace App\Livewire\Platform;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Livewire\Platform\DashboardPlatformComponent;
use App\Models\Perusahaan as ModelsPerusahaan;
use Illuminate\Database\QueryException;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads; 


class Perusahaan extends DashboardPlatformComponent
{
    use WithPagination, WithFileUploads;

    public $id;
    public $nama;
    public $logo;

    protected $rules = [
        'id' => 'nullable|integer',
        'nama' => 'required|string|max:255',
        'logo' => 'nullable|image', // 1MB max
    ];

    public function closeModal() {
        $this->modalSaveVisible = false;
        $this->modalDeleteVisible = false;
        $this->reset(['nama', 'logo', 'id']);
    }

    // Delete
    public function openModalDelete($id) {
        $this->modalTitle = 'Hapus Perusahaan';
        $this->modalDeleteVisible = true;
        $this->id = $id;
    }

    public function delete() {
        try {
            $record = ModelsPerusahaan::findOrFail($this->id);

            if ($record->logo) {
                Storage::disk('public')->delete('images/perusahaan/' . $record->logo);
            }

            $record->delete();

            $this->modalDeleteVisible = false;
            $this->reset('id');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // SQLSTATE code for integrity constraint
                $this->addError('delete', 'Data perusahaan tidak kosnog.');
            } else {
                $this->addError('delete', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    // Save (CREATE + UPDATE)
    public function openModalCreate() {
        $this->modalSaveVisible = true;
        $this->modalTitle = 'Tambah Perusahaan';
    }

    public function openModalUpdate($id) {
        $this->modalSaveVisible = true;
        $this->modalTitle = 'Edit Perusahaan';

        $record = ModelsPerusahaan::findOrFail($id);
        $this->id = $record->id;
        $this->nama = $record->nama;
        $this->logo = null;
    }

    public function save() {
        $this->validate();

        try {
            $record = $this->id
                ? ModelsPerusahaan::findOrFail($this->id)
                : new ModelsPerusahaan();

            $record->nama = $this->nama;

            if ($this->logo) {
                if ($this->id && $record->logo) {
                    Storage::disk('public')->delete('images/perusahaan/' . $record->logo);
                }
                $record->logo = basename($this->logo->store('images/perusahaan', 'public'));
            }

            $record->save();

            $this->modalSaveVisible = false;

            $this->reset(['nama', 'logo', 'id']);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // SQLSTATE code for integrity constraint
                $this->addError('save', 'Perusahaan dengan nama tersebut sudah ada.');
            } else {
                $this->addError('save', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    public function render()
    {
        $query = ModelsPerusahaan::query();

        if ($this->query) {
            $query->where(function($q) {
                $q->where('id', $this->query)
                ->orWhere('nama', 'like', '%' . $this->query . '%');
            });
        }

        return $this->viewExtends('livewire.platform.perusahaan', [
            'perusahaans' => $query->paginate(10)
        ]);
    }
}