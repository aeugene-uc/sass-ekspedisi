<?php

namespace App\Livewire\Perusahaan;

use App\Models\Counter as ModelsCounter;
use App\Models\Perusahaan;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\WithPagination;

class Counter extends DashboardPerusahaanComponent
{
    use WithPagination;

    public $id;
    public $alamat;
    public $nama;
    public $lat;
    public $lng;

    public $alamat_query;

    protected $rules = [
        'id' => 'nullable|integer',
        'nama' => 'required|string',
        'alamat' => 'required|string',
        'lat' => 'required|numeric',
        'lng' => 'required|numeric'
    ];

    public function closeModal() {
        $this->modalSaveVisible = false;
        $this->modalDeleteVisible = false;
        $this->reset(['id', 'alamat', 'nama', 'lat', 'lng', 'alamat_query']);
    }

    public function openModalDelete($id) {
        $this->modalTitle = 'Hapus Counter';
        $this->modalDeleteVisible = true;
        $this->id = $id;
    }

    public function delete() {
        try {
            $record = ModelsCounter::findOrFail($this->id);
            $record->delete();

            $this->modalDeleteVisible = false;
            $this->reset('id');
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // SQLSTATE code for integrity constraint
                $this->addError('delete', 'Data Counter dipakai oleh data lain.');
            } else {
                $this->addError('delete', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    // Save (CREATE + UPDATE)
    public function geocodeAddress()
    {
        if (!$this->alamat_query || trim($this->alamat_query) === '') {
            $this->addError('alamat_query', 'Alamat tidak boleh kosong.');
            return;
        }

        try {
            $url = "https://nominatim.openstreetmap.org/search?" . http_build_query([
                'q' => $this->alamat_query,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1,
            ]);

            $response = Http::withHeaders([
                'User-Agent' => 'YourAppName/1.0'
            ])->get($url)->json();

            if (empty($response)) {
                $this->addError('alamat_query', 'Alamat tidak ditemukan.');
                return;
            }

            // ✔ DIRECTLY SET LAT / LNG
            $this->lat = $response[0]['lat'];
            $this->lng = $response[0]['lon'];

            // (Optional) Set the display address
            $this->alamat = $response[0]['display_name'];

            // Notify JS map to move
            $this->dispatch('location-updated', $this->lat, $this->lng);
            $this->modalSaveVisible = true;

        } catch (\Exception $e) {
            $this->addError('alamat_query', 'Gagal mengambil koordinat.');
        }
    }

    public function reverseGeocode()
    {
        if (!$this->lat || !$this->lng) {
            $this->addError('reverse', 'Koordinat tidak valid.');
            return;
        }

        try {
            $url = "https://nominatim.openstreetmap.org/reverse?" . http_build_query([
                'lat' => $this->lat,
                'lon' => $this->lng,
                'format' => 'json',
                'addressdetails' => 1,
            ]);

            $response = Http::withHeaders([
                'User-Agent' => 'YourAppName/1.0'
            ])->get($url)->json();

            if (empty($response) || !isset($response['display_name'])) {
                $this->addError('reverse', 'Alamat tidak ditemukan.');
                return;
            }

            $this->alamat = $response['display_name'];
            $this->alamat_query = $response['display_name'];

        } catch (\Exception $e) {
            $this->addError('reverse', 'Gagal mengambil alamat.');
        }
    }

    public function openModalCreate() {
        $this->modalSaveVisible = true;
        $this->id = null;
        $this->modalTitle = 'Tambah Counter';
    }

    public function openModalUpdate($id) {
        $this->modalSaveVisible = true;
        $this->modalTitle = 'Edit Counter';

        $record = ModelsCounter::findOrFail($id);
        $this->id = $record->id;
        $this->alamat = $record->alamat;
        $this->nama = $record->nama;
        $this->lat = $record->lat;
        $this->lng = $record->lng;
        $this->alamat_query = $record->alamat;
    }

    public function save() {
        $this->validate();

        try {
            $record = $this->id
                ? ModelsCounter::findOrFail($this->id)
                : new ModelsCounter();

            $this->reverseGeocode();

            $record->alamat = $this->alamat;
            $record->nama = $this->nama;
            $record->lat = $this->lat;
            $record->lng = $this->lng;
            $record->perusahaan_id = Perusahaan::where('subdomain', $this->subdomain)->first()->id;
            $record->save();

            $this->modalSaveVisible = false;
            $this->reset(['id', 'alamat', 'nama', 'lat', 'lng', 'alamat_query']);
        } catch (QueryException $e) {
            if ($e->getCode() == 23000) { // SQLSTATE code for integrity constraint
                $this->addError('save', 'Counter dengan nama tersebut sudah ada.');
            } else {
                $this->addError('save', 'Internal Server Error. Silakan coba lagi nanti.');
            }
        }
    }

    public function render()
    {
        $subdomain = $this->subdomain; //request()->route('subdomain');
        
        $query = ModelsCounter::with('perusahaan')
            ->whereHas('perusahaan', function ($q) use ($subdomain) {
                $q->where('subdomain', $subdomain);
            });

        if ($this->query) {
            $query = $query->where(function($q) {
                $q->where('id', $this->query)
                    ->orWhere('alamat', 'like', '%' . $this->query . '%')
                    ->orWhere('nama', 'like', '%' . $this->query . '%');
            });
        }

        return $this->viewExtends('livewire.perusahaan.counter', [
            'counters' => $query->paginate(10)
        ]);
    }
}
