<?php

namespace App\Livewire\Perusahaan;

use App\Models\Barang;
use App\Models\Counter;
use App\Models\Layanan;
use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http as FacadesHttp;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use League\Uri\Http;
use Livewire\Attributes\On;
use Midtrans\Config;
use Midtrans\Snap;
use Ramsey\Uuid\Uuid;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

function imageToBase64($file): ?array {
    try {
        $binary = file_get_contents($file->getRealPath()); // in RAM
        $ext = $file->getClientOriginalExtension();
        return [
            'base64' => base64_encode($binary),
            'extension' => $ext ?: 'bin',
        ];
    } catch (\Exception $e) {
        return null;
    }
}

function base64ToImage(?array $imageData, string $folder = 'images/barang', string $disk = 'public'): ?string {
    try {
        if (!$imageData || !isset($imageData['base64'], $imageData['extension'])) {
            return null;
        }

        $binary = base64_decode($imageData['base64']);
        if (!$binary) return null;

        $fileName = uniqid() . '.' . $imageData['extension'];
        $path = $folder . '/' . $fileName;

        Storage::disk($disk)->put($path, $binary);

        return $fileName;
    } catch (\Exception $e) {
        return null;
    }
}

class BuatPesanan extends DashboardPerusahaanComponent
{
    use WithFileUploads;

    public $step = 1;
    public $barangs = [];
    // private $barangPhotos = [];

    public $modalBarangOpen = false;
    public $berat = null;
    public $panjang = null;
    public $lebar = null;
    public $tinggi = null;
    public $foto = null;
    public $metode_destinasi_pengiriman = 1;
    public $counter_tujuan = null;
    public $tujuan_lat_lng = null;
    public $metode_asal_pengiriman = 1;
    public $counter_asal = null;
    public $asal_lat_lng = null;
    public $layanan_id = null;

    public $query_alamat_tujuan = null;
    public $query_alamat_asal = null;

    public $modalGambarOpen = false;
    public $modalGambarSrc = '';

    public $modalHapusBarangOpen = false;
    public $hapusBarangIndex = null;

    public $totalBiayaVar = null;
    public $snapToken = null;
    public $pesanan = null;

    public $layanans = null;
    public $counters = null;

    // protected $rules = [
    //     'berat' => 'required|numeric|min:1',
    //     'panjang' => 'required|numeric|min:1',
    //     'lebar' => 'required|numeric|min:1',
    //     'tinggi' => 'required|numeric|min:1',
    //     'foto' => 'required|image'
    // ];

    public function openModalGambar($src = null) {
        if (!$src) {
            return;
        }

        $this->closeModal();
        $this->modalGambarOpen = true;
        $this->modalGambarSrc = $src;
    }

    public function closeModalGambar() {
        $this->closeModal();
        $this->modalBarangOpen = true;
    }

    public function openModalTambahBarang() {
        $this->closeModal();
        $this->modalBarangOpen = true;
    }

    public function openModalHapusBarang($index = null) {
        if ($index === null || !isset($this->barangs[$index])) {
            return;
        }

        $this->closeModal();
        $this->modalHapusBarangOpen = true;
        $this->hapusBarangIndex = $index;
    }

    public function closeModal() {
        $this->modalBarangOpen = false;
        $this->modalGambarOpen = false;
        $this->modalHapusBarangOpen = false;
    }

    public function tambahBarang() {
        try {
            $this->validate([
                'berat' => 'required|numeric|min:1',
                'panjang' => 'required|numeric|min:1',
                'lebar' => 'required|numeric|min:1',
                'tinggi' => 'required|numeric|min:1',
                'foto' => 'required|image'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $allErrors = $e->validator->errors()->all();
            $this->addError('validation', implode(' | ', $allErrors));

            return; // stop eksekusi kalau ada error
        }

        $this->barangs[] = [
            'berat' => $this->berat,
            'panjang' => $this->panjang,
            'lebar' => $this->lebar,
            'tinggi' => $this->tinggi,
            'foto' => $this->foto //->temporaryUrl()
        ];
        // $this->barangPhotos[] = imageToBase64($this->foto);

        // Reset form fields
        $this->reset(['berat', 'panjang', 'lebar', 'tinggi', 'foto']);
        $this->closeModal();
    }

    public function hapusBarang() {
        if ($this->hapusBarangIndex !== null && isset($this->barangs[$this->hapusBarangIndex])) {
            if ($this->barangs[$this->hapusBarangIndex]['foto']) {
                Storage::disk('public')->delete('images/barang/' . basename($this->barangs[$this->hapusBarangIndex]['foto']->getClientOriginalName()));
            }

            array_splice($this->barangs, $this->hapusBarangIndex, 1);
        }

        $this->closeModal();
    }

    public function searchAddress($address = null) {
        try {
            $url = "https://nominatim.openstreetmap.org/search?" . http_build_query([
                'q' => $address,
                'format' => 'json',
                'limit' => 1,
                'addressdetails' => 1,
            ]);

            $response = FacadesHttp::withHeaders([
                'User-Agent' => 'YourAppName/1.0'
            ])->get($url)->json();

            if (empty($response)) {
                return null;
            }

            return [
                'lat' => $response[0]['lat'],
                'lng' => $response[0]['lon'],
            ];
        } catch (\Exception $e) {
            return null;
        }   
    }

    public function cariAlamatTujuan() {
        $this->validate([
            'query_alamat_tujuan' => 'required|string|min:1|max:255'
        ]);

        $latLng = $this->searchAddress($this->query_alamat_tujuan);

        $this->tujuan_lat_lng = [
            'lat' => $latLng['lat'] ?? null,
            'lng' => $latLng['lng'] ?? null
        ];
    }

    public function cariAlamatAsal() {
        $this->validate([
            'query_alamat_asal' => 'required|string|min:1|max:255'
        ]);

        $latLng = $this->searchAddress($this->query_alamat_asal);

        $this->asal_lat_lng = [
            'lat' => $latLng['lat'] ?? null,
            'lng' => $latLng['lng'] ?? null
        ];
    }

    public function reverseGeocode($lat = null, $lng = null) {
        if (!$lat || !$lng) {
            return null;
        }

        try {
            $url = "https://nominatim.openstreetmap.org/reverse?" . http_build_query([
                'lat' => $lat,
                'lon' => $lng,
                'format' => 'json',
                'addressdetails' => 1,
            ]);

            $response = FacadesHttp::withHeaders([
                'User-Agent' => 'YourAppName/1.0'
            ])->get($url)->json();

            if (empty($response) || !isset($response['display_name'])) {
                return null;
            }

            return $response['display_name'];
        } catch (\Exception $e) {
            return null;
        }
    }

    public function getDistanceKmOSRM(array $origin, array $destination): float {
        $url = 'https://router.project-osrm.org/table/v1/driving/' .
            $origin['lng'] . ',' . $origin['lat'] . ';' .
            $destination['lng'] . ',' . $destination['lat'] .
            '?annotations=distance';

        $response = FacadesHttp::get($url);

        if (!$response->ok()) {
            throw new \Exception('OSRM request failed');
        }

        $meters = $response->json('distances.0.1');

        if ($meters === null) {
            throw new \Exception('Invalid OSRM response');
        }

        return round($meters / 1000, 3); // convert → km
    }

    // public function getDistanceKmOSRM(array $origin, array $destination): float
    // {
    //     if (!isset($origin['lat'], $origin['lng'], $destination['lat'], $destination['lng'])) {
    //         return 0.0;
    //     }

    //     $url = 'https://router.project-osrm.org/table/v1/driving/' .
    //         $origin['lng'] . ',' . $origin['lat'] . ';' .
    //         $destination['lng'] . ',' . $destination['lat'];

    //     try {
    //         $response = FacadesHttp::get($url, [
    //             'query' => ['annotations' => 'distance']
    //         ]);

    //         if (!$response->ok()) {
    //             throw new \Exception('OSRM request failed: ' . $response->body());
    //         }

    //         $data = $response->json();

    //         if (!isset($data['distances'][0][1])) {
    //             throw new \Exception('Invalid OSRM response: ' . json_encode($data));
    //         }

    //         return round($data['distances'][0][1] / 1000, 3); // meters → km
    //     } catch (\Exception $e) {
    //         Log::error('OSRM error: ' . $e->getMessage());
    //         return 0.0;
    //     }
    // }


    public function totalBiaya() {
        $total = [
            'biaya_barang' => [],
            'total_biaya' => 0,
        ];
        $selectedLayanan = Layanan::where('id', $this->layanan_id)->first();

        if (!$selectedLayanan) {
            return $total;
        }

        $expressionLanguage = new ExpressionLanguage();
        $jarak = $this->getDistanceKmOSRM(
            [
                'lat' => $this->asal_lat_lng['lat'],
                'lng' => $this->asal_lat_lng['lng']
            ],
            [
                'lat' => $this->tujuan_lat_lng['lat'],
                'lng' => $this->tujuan_lat_lng['lng']
            ]
        );

        foreach ($this->barangs as $barang) {
            $biaya = $expressionLanguage->evaluate(
                $selectedLayanan->model_harga, [
                    'berat' => $barang['berat'],
                    'volume' => ($barang['panjang'] * $barang['lebar'] * $barang['tinggi']),
                    'jarak' => $jarak
                ]
            ) ?? 0;

            // Round both of them to non-fractional
            $total['biaya_barang'][] = round($biaya);
            $total['total_biaya'] += round($biaya);
        }

        return $total;
    }

    public function checkout() {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');

        if ($this->pesanan) {
            $pesanan = $this->pesanan;
        } else {
            $this->pesanan = new Pesanan();
            $pesanan = $this->pesanan;
        }

        $pesanan->tarif = $this->totalBiaya()['total_biaya'];
        $pesanan->tanggal_pemesanan = now();
        $pesanan->user_id = Auth::user()->id;
        
        if ($this->metode_asal_pengiriman == 1) {
            $counterAsalModel = Counter::find($this->counter_asal);

            $pesanan->counter_asal_id = $counterAsalModel->id ?? null;
            $pesanan->alamat_asal = $counterAsalModel->alamat ?? null;
            $pesanan->lat_asal = $counterAsalModel->lat ?? null;
            $pesanan->lng_asal = $counterAsalModel->lng ?? null;
        } else {
            $pesanan->alamat_asal = $this->reverseGeocode(
                $this->asal_lat_lng['lat'] ?? null,
                $this->asal_lat_lng['lng'] ?? null
            );
            $pesanan->lat_asal = $this->asal_lat_lng['lat'] ?? null;
            $pesanan->lng_asal = $this->asal_lat_lng['lng'] ?? null;
        }

        $pesanan->metode_asal_pengiriman_id = $this->metode_asal_pengiriman;

        if ($this->metode_destinasi_pengiriman == 1) {
            $counterTujuanModel = Counter::find($this->counter_tujuan);

            $pesanan->counter_destinasi_id = $counterTujuanModel->id ?? null;
            $pesanan->alamat_destinasi = $counterTujuanModel->alamat ?? null;
            $pesanan->lat_destinasi = $counterTujuanModel->lat ?? null;
            $pesanan->lng_destinasi = $counterTujuanModel->lng ?? null;
        } else {
            $pesanan->alamat_destinasi = $this->reverseGeocode(
                $this->tujuan_lat_lng['lat'] ?? null,
                $this->tujuan_lat_lng['lng'] ?? null
            );
            $pesanan->lat_destinasi = $this->tujuan_lat_lng['lat'] ?? null;
            $pesanan->lng_destinasi = $this->tujuan_lat_lng['lng'] ?? null;
        }

        $pesanan->metode_destinasi_pengiriman_id = $this->metode_destinasi_pengiriman;
        $pesanan->layanan_id = $this->layanan_id;
        $pesanan->status_id = 1; // status: menunggu pembayaran

        if ($this->pesanan) {
            foreach ($this->pesanan->barang()->get() as $existingBarang) {
                Storage::disk('public')->delete('images/barang/' . $existingBarang->foto);
                $existingBarang->delete();
            }
        }
  
        $pesanan->save();

        for ($i = 0; $i < count($this->barangs); $i++) {
            // $fotoFileName = base64ToImage($this->barangPhotos[$i]);
            $barang = $this->barangs[$i];
            $fotoFileName = basename($barang['foto']->store('images/barang', 'public'));

            $barangModel = new Barang();
            $barangModel->berat_g = $barang['berat'];
            $barangModel->panjang_cm = $barang['panjang'];
            $barangModel->lebar_cm = $barang['lebar'];
            $barangModel->tinggi_cm = $barang['tinggi'];
            $barangModel->foto = $fotoFileName;
            $barangModel->pesanan_id = $pesanan->id;
            $barangModel->save();
        }

        // if ($pesanan->midtrans_snap) {
        //     $snapToken = $pesanan->midtrans_snap;
        // } else {

        // }
        $midtransOrderId = 'Pesanan_' . $this->pesanan->id . '_' . Uuid::uuid4()->toString();

        $snapToken = Snap::getSnapToken([
            'transaction_details' => [
                'order_id' => $midtransOrderId,
                'gross_amount' => $this->pesanan->tarif,
            ],
            'customer_details' => [
                'first_name' => explode(' ', Auth::user()->name)[0] ?? 'User',
                'last_name' => explode(' ', Auth::user()->name)[1] ?? 'User',
                'email' => Auth::user()->email
            ],
        ]);


        $pesanan->midtrans_snap = $snapToken;
        $pesanan->midtrans_order_id = $midtransOrderId;
        $pesanan->save();

        $this->dispatch('snapToken', $snapToken);
    }

    #[On('historiPesanan')]
    public function redirectHistoriPesanan() {
        return $this->redirectRoute('perusahaan.histori-pesanan', ['subdomain' => $this->subdomain]);
    }

    public function mount() {
        $this->counters = Counter::with('perusahaan')->whereHas('perusahaan', function ($query) {
            $query->where('subdomain', $this->subdomain);
        })->get();

        $this->layanans = Layanan::with('perusahaan')->whereHas('perusahaan', function ($query) {
            $query->where('subdomain', $this->subdomain);
        })->get();

        $this->counter_tujuan = Counter::with('perusahaan')->whereHas('perusahaan', function ($query) {
            $query->where('subdomain', request()->route('subdomain'));
        })->first()->id ?? null;

        $this->counter_asal = Counter::with('perusahaan')->whereHas('perusahaan', function ($query) {
            $query->where('subdomain', request()->route('subdomain'));
        })->where('id', '!=', $this->counter_tujuan)->first()->id ?? null;

        $this->layanan_id = Layanan::with('perusahaan')->whereHas('perusahaan', function ($query) {
            $query->where('subdomain', request()->route('subdomain'));
        })->first()->id ?? null;
    }

    public function render()
    {
        if ($this->step == 2 && $this->metode_destinasi_pengiriman == 1) {
            $latLng = $this->searchAddress(Counter::where('id', $this->counter_tujuan)->first()->alamat ?? '');

            $this->tujuan_lat_lng = [
                'lat' => $latLng['lat'] ?? null,
                'lng' => $latLng['lng'] ?? null
            ];

            \Log::info('Search Address Destinasi');
        }

        if ($this->step == 3 && $this->metode_asal_pengiriman == 1) {
            $latLng = $this->searchAddress(Counter::where('id', $this->counter_asal)->first()->alamat ?? '');

            $this->asal_lat_lng = [
                'lat' => $latLng['lat'] ?? null,
                'lng' => $latLng['lng'] ?? null
            ];

            \Log::info('Search Address Asal');
        }

        if ($this->step == 4) {
            $this->totalBiayaVar = $this->totalBiaya();
            \Log::info('Total Biaya: ');
        }

        return $this->viewExtends('livewire.perusahaan.buat-pesanan', [
            'total_biaya' => $this->step == 4 ? $this->totalBiayaVar : 0,
        ]);
    }
}
