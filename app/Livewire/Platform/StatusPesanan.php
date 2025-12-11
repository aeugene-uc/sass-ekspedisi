<?php

namespace App\Livewire\Platform;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\StatusPesanan as StatusPesananModel;
use Illuminate\Database\QueryException;

class StatusPesanan extends Component
{
    use WithPagination;

    public $query = '';
    public $id, $status;
    public $modalSaveVisible = false;
    public $modalDeleteVisible = false;
    public $modalTitle = '';

    protected $rules = [
        'status' => 'required|string|max:255'
    ];

    public function search()
    {
        $this->resetPage();
    }

    public function openModalCreate()
    {
        $this->modalSaveVisible = true;
        $this->modalTitle = 'Tambah Status Pesanan';
    }

    public function openModalUpdate($id)
    {
        $this->modalSaveVisible = true;
        $this->modalTitle = 'Edit Status Pesanan';

        $record = StatusPesananModel::findOrFail($id);
        $this->id = $record->id;
        $this->status = $record->status;
    }

    public function openModalDelete($id)
    {
        $this->modalTitle = 'Hapus Status Pesanan';
        $this->modalDeleteVisible = true;
        $this->id = $id;
    }

    public function closeModal()
    {
        $this->modalSaveVisible = false;
        $this->modalDeleteVisible = false;
        $this->reset(['status', 'id']);
    }

    public function save()
    {
        $this->validate();

        try {
            $record = $this->id
                ? StatusPesananModel::findOrFail($this->id)
                : new StatusPesananModel();

            $record->status = $this->status;
            $record->save();

            $this->modalSaveVisible = false;
            $this->reset(['status', 'id']);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $this->addError('save', 'Status pesanan dengan nama tersebut sudah ada.');
            } else {
                $this->addError('save', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    public function delete()
    {
        try {
            $record = StatusPesananModel::findOrFail($this->id);
            $record->delete();

            $this->modalDeleteVisible = false;
            $this->reset('id');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) {
                $this->addError('delete', 'Status pesanan tidak dapat dihapus karena masih digunakan.');
            } else {
                $this->addError('delete', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    public function render()
    {
        $statuses = StatusPesananModel::when($this->query, function($query) {
                $query->where('status', 'like', '%' . $this->query . '%');
            })
            ->paginate(10);

        return view('livewire.platform.status-pesanan', compact('statuses'));
    }
}