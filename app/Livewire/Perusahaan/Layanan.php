<?php

namespace App\Livewire\Perusahaan;

use App\Models\Layanan as ModelsLayanan;
use App\Models\Perusahaan;
use Livewire\WithPagination;
use Illuminate\Database\QueryException;
use Livewire\Component;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

class Layanan extends DashboardPerusahaanComponent
{
    use WithPagination;

    public $id;
    public $nama;
    public $model_harga;

    protected $rules = [
        'id' => 'nullable|integer',
        'nama' => 'required|string|max:100',
        'model_harga' => 'required|string'
    ];

    public function openModalCreate() {
        $this->modalSaveVisible = true;
        $this->id = null;
        $this->modalTitle = 'Tambah Layanan';
    }

    public function openModalUpdate($id) {
        $this->modalSaveVisible = true;
        $this->modalTitle = 'Edit Layanan';

        $record = ModelsLayanan::findOrFail($id);
        $this->id = $record->id;
        $this->nama = $record->nama;
        $this->model_harga = $record->model_harga;
    }

    public function openModalDelete($id) {
        $this->modalTitle = 'Hapus Layanan';
        $this->modalDeleteVisible = true;
        $this->id = $id;
    }

    public function closeModal() {
        $this->modalSaveVisible = false;
        $this->modalDeleteVisible = false;
        $this->reset(['id', 'nama', 'model_harga']);
    }

    public function save() {
        $this->validate();

        try {
            $record = $this->id
                ? ModelsLayanan::findOrFail($this->id)
                : new ModelsLayanan();

            $record->nama = $this->nama;

            try {
                $evaluator = new ExpressionLanguage();
                $evaluator->parse($this->model_harga, ['berat', 'volume', 'jarak']);
            } catch (\Exception $e) {
                $this->addError('save', 'Model harga tidak valid.');
                return;
            }

            $record->model_harga = $this->model_harga;
            $record->perusahaan_id = Perusahaan::where('subdomain', $this->subdomain)->first()->id;
            $record->save();

            $this->modalSaveVisible = false;

            $this->reset(['id', 'nama', 'model_harga']);
        } catch (QueryException $e) {
            dd($e);

            if ($e->getCode() == 23000) { // SQLSTATE code for integrity constraint
                $this->addError('save', 'Layanan dengan nama tersebut sudah ada.');
            } else {
                $this->addError('save', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    public function delete()
    {
        try {
            $record = ModelsLayanan::findOrFail($this->id);
            $record->delete();
            
            $this->modalDeleteVisible = false;
            $this->reset('id');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // SQLSTATE code for integrity constraint
                $this->addError('delete', 'Layanan tidak dapat dihapus karena masih digunakan.');
            } else {
                $this->addError('delete', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    public function render()
    {
        $query = ModelsLayanan::with('perusahaan')
            ->whereHas('perusahaan', function ($q) {
                $q->where('subdomain', $this->subdomain);
            });

        if ($this->query) {
            $query->where(function($q) {
                $q->where('nama', 'like', '%' . $this->query . '%');
            });
        }

        return $this->viewExtends('livewire.perusahaan.layanan', [
            'layanans' => $query->paginate(10)
        ]);
    }
}
