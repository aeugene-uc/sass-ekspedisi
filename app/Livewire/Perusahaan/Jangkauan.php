<?php

namespace App\Livewire\Perusahaan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Jangkauan as JangkauanModel;
use App\Models\Perusahaan;

class Jangkauan extends Component
{
    use WithPagination;

    public $query = '';
    public $id, $nama, $perusahaan_id;
    public $modalSaveVisible = false;
    public $modalDeleteVisible = false;
    public $modalTitle = '';

    protected $rules = [
        'nama' => 'required|string|max:255',
        'perusahaan_id' => 'required|exists:perusahaan,id'
    ];

    public function search()
    {
        $this->resetPage();
    }

    public function openModalCreate()
    {
        $this->modalSaveVisible = true;
        $this->modalTitle = 'Tambah Jangkauan';
    }

    public function openModalUpdate($id)
    {
        $this->modalSaveVisible = true;
        $this->modalTitle = 'Edit Jangkauan';

        $record = JangkauanModel::findOrFail($id);
        $this->id = $record->id;
        $this->nama = $record->nama;
        $this->perusahaan_id = $record->perusahaan_id;
    }

    public function openModalDelete($id)
    {
        $this->modalTitle = 'Hapus Jangkauan';
        $this->modalDeleteVisible = true;
        $this->id = $id;
    }

    public function closeModal()
    {
        $this->modalSaveVisible = false;
        $this->modalDeleteVisible = false;
        $this->reset(['nama', 'perusahaan_id', 'id']);
    }

    public function save()
    {
        $this->validate();

        try {
            $record = $this->id
                ? JangkauanModel::findOrFail($this->id)
                : new JangkauanModel();

            $record->nama = $this->nama;
            $record->perusahaan_id = $this->perusahaan_id;
            $record->save();

            $this->modalSaveVisible = false;
            $this->reset(['nama', 'perusahaan_id', 'id']);
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                $this->addError('save', 'Jangkauan dengan nama tersebut sudah ada.');
            } else {
                $this->addError('save', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    public function delete()
    {
        try {
            $record = JangkauanModel::findOrFail($this->id);
            $record->delete();

            $this->modalDeleteVisible = false;
            $this->reset('id');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                $this->addError('delete', 'Jangkauan tidak dapat dihapus karena masih digunakan.');
            } else {
                $this->addError('delete', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    public function render()
    {
        $jangkauans = JangkauanModel::with('perusahaan')
            ->when($this->query, function($query) {
                $query->where('nama', 'like', '%' . $this->query . '%')
                      ->orWhereHas('perusahaan', function($q) {
                          $q->where('nama', 'like', '%' . $this->query . '%');
                      });
            })
            ->paginate(10);

        $perusahaans = Perusahaan::all();

        return view('livewire.perusahaan.jangkauan', compact('jangkauans', 'perusahaans'));
    }
}
