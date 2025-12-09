<?php

namespace App\Livewire\Perusahaan;

use Livewire\Component;
use App\Models\User; 
use App\Models\PeranUser as ModelsPeranUser; 
use Livewire\WithPagination;
use Livewire\Attributes\Rule;

class PeranUser extends DashboardPerusahaanComponent
{
    use WithPagination; 

    public $modalTitle = 'Ubah Peran Pengguna';

    public $id;
    public $full_name;
    public $peran_id;

    protected $rules = [
        'id' => 'nullable|integer',
        'full_name' => 'required|string',
        'peran_id' => 'required|integer'
    ];

    public function closeModal() {
        $this->modalDeleteVisible = false;
        $this->modalSaveVisible = false;
        $this->reset(['id', 'full_name', 'peran_id']);
    }

    public function openModalUpdate($userId) {
        $this->closeModal(); 
        
        $user = User::findOrFail($userId);
        
        $this->id = $user->id;
        $this->full_name = $user->full_name;
        $this->peran_id = $user->peran_id; 

        $this->modalSaveVisible = true;
    }

    public function save() {
        $this->validate();

        try {
            $user = User::findOrFail($this->id);
            $user->peran_id = $this->peran_id;
            $user->save();
            $this->closeModal();
        } catch (\Exception $e) {
            $this->addError('save', 'Gagal menyimpan perubahan peran.');
        }
    }

    public function render()
    {
        $subdomain = $this->subdomain; 

        $query = User::with('perusahaan')->with('peran')
            ->whereHas('perusahaan', function ($q) use ($subdomain) {
                $q->where('subdomain', $subdomain);
            });

        if ($this->query != null) {
            $query->where(function($q) {
                $q->where('full_name', 'like', '%' . $this->query . '%')
                  ->orWhere('email', 'like', '%' . $this->query . '%');
            });
        }

        $users = $query->paginate(10);
        
        return $this->viewExtends('livewire.perusahaan.peran-user', [
            'users' => $users,
            'perans' => ModelsPeranUser::where('id', '!=', 1)->get()
        ]);
    }
}