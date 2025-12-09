<?php

namespace App\Livewire\Platform;

use Livewire\Component;
use App\Models\User; 
use App\Models\PeranUser as ModelsPeranUser; 
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class PeranUser extends Component 
{
    use WithPagination; 

    public $modalVisible = false;
    public $modalTitle = 'Ubah Peran Pengguna';
    public $query;

    public $user_id;
    public $user_nama;
    
    public $new_peran_id;

    public $perans; 

    public function mount()
    {
        $this->perans = PeranUser::select('id', 'nama')->get();
    }

    public function search() { $this->resetPage(); }

    public function closeModal() {
        $this->modalVisible = false;
        $this->reset(['user_id', 'user_nama', 'new_peran_id']);
    }

    public function openModalUpdateRole($userId) {
        $this->closeModal(); 
        
        $user = User::findOrFail($userId);
        
        $this->user_id = $user->id;
        $this->user_nama = $user->name;
        $this->new_peran_id = $user->peran_user_id; 

        $this->modalVisible = true;
    }

    public function saveRoleUpdate() {
        $this->validate();

        try {
            $user = User::findOrFail($this->user_id);
            $user->peran_user_id = $this->new_peran_id;
            $user->save();

            session()->flash('message', 'Peran pengguna ' . $user->name . ' berhasil diubah.');
            $this->closeModal();

        } catch (\Exception $e) {
            $this->addError('save', 'Gagal menyimpan perubahan peran.');
        }
    }

    public function render()
    {
        $query = User::with('peran');

        if ($this->query = null) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->query . '%')
                  ->orWhere('email', 'like', '%' . $this->query . '%');
            });
        }

        $users = $query->paginate(10);
        
        return view('livewire.perusahaan.peran-user', [
            'users' => $users
        ]);
    }
}