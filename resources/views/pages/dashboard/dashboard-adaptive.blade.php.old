<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $modelName }} - Dashboard Abeka Transportation</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="icon" href="{{ asset('images/logo-trans-white.png') }}" type="image/png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top shadow">
        <div class="container-fluid">
            <a class="navbar-brand me-auto" href="{{  route('beranda') }}">
                <img src="{{ asset('images/logo-trans-white.png') }}" alt="Logo navbar Abeka" class="d-inline-block align-text-top">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse w-100 justify-content-center" id="navbarNav">
                <x-dashboard-link model="User" :forNavbar="true" />
                <x-dashboard-link model="Informasi Umum" :forNavbar="true" />
                <x-dashboard-link model="Kategori Informasi Umum" :forNavbar="true" />
                <x-dashboard-link model="Jangkauan" :forNavbar="true" />
                <x-dashboard-link model="Layanan" :forNavbar="true" />

                <form action="{{ route('logout-handler') }}" method="POST" class="mt-auto d-flex justify-content-center align-items-center w-100 p-1">
                    @csrf
                    <button type="submit" class="btn theme-button w-100">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
    <div class="row"  style="height: calc(100vh - 66px)">
            <div class="bg-dark sidebar d-none d-md-flex flex-column">
                <x-dashboard-link model="User" />
                <x-dashboard-link model="Informasi Umum" />
                <x-dashboard-link model="Kategori Informasi Umum" />
                <x-dashboard-link model="Jangkauan" />
                <x-dashboard-link model="Layanan" />

                <form action="{{ route('logout-handler') }}" method="POST" class="mt-auto d-flex justify-content-center align-items-center w-100 p-1">
                    @csrf
                    <button type="submit" class="btn theme-button w-100">Logout</button>
                </form>
            </div>

            <div class="content overflow-y-scroll p-3 p-md-5 bg-light h-100">
                <h2 class="display-6 fw-bold mb-4">{{ $modelName }}</h2>

                <form class="d-flex mb-2">
                    <input type="text" class="form-control me-1" name="search" placeholder="Search"
                        value="{{ request('search') }}"
                    >
                    <button class="btn theme-button me-1">Search</button>
                    <button type="button" class="btn theme-button" data-bs-toggle="modal" data-bs-target="#createModal">Create</button>
                </form>
                
                <div class="overflow-x-auto">
                    <div class="table-responsive">
                        <table class="table table-light table-striped table-hover align-middle">
                            <thead>
                                <tr>
                                    @foreach($columnNames as $columnName)
                                        @if($columnName === 'password')
                                            @continue
                                        @endif

                                        @php
                                            $displayName = $columnName === 'id' ? 'No.' : ucwords(str_replace('_', ' ', $columnName));
                                        @endphp
                                        <th scope="col">{{ $displayName }}</th>
                                    @endforeach

                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $row)
                                    <tr>
                                        @foreach($columnNames as $columnName)
                                            @if($columnName === 'password')
                                                @continue
                                            @endif

                                            <td class="text-muted">
                                                @if($columnName === 'image')
                                                    <img src="{{ asset('images/' . strtolower($modelName) . '/' . $row->image) }}">
                                                @else
                                                    {{ $row->getAttribute($columnName) }}
                                                @endif
                                            </td>
                                        @endforeach
                                        <td>
                                            <button 
                                                class="btn theme-button update-btn" 
                                                data-id="{{ $row->id }}"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#updateModal"
                                            >
                                                Update
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-3 mt-3 pagination-wrapper">
                    <form class="per-page-form">
                        <select name="per_page" class="form-select per-page-select" onchange="this.form.submit()">
                            @foreach([10, 25, 50, 100] as $size)
                                <option value="{{ $size }}" {{ request('per_halaman') == $size ? 'selected' : '' }}>
                                    {{ $size }} / halaman
                                </option>
                            @endforeach
                        </select>
                    </form>

                    <div class="pagination-links">
                        {{ $data->onEachSide(0)->links('pagination.limit-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Update Modal --}}
    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <form class="modal-dialog">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Update {{ $modelName }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    @foreach($columns as $columnName => $col)
                        {{-- <th scope="col">{{ ucwords(str_replace('_', ' ', $columnName)) }}</th> --}}
                        <div class="col-12 col-md-6">
                            <label for="update-{{ $columnName }}" class="form-label">{{ $col['alias'] }}</label>
                            
                            @if(in_array($columnName, $foreignColumns))
                                <select 
                                    class="form-select"
                                    name="{{ $columnName }}"
                                    id="update-{{ $columnName }}" 
                                >
                                    @foreach($foreignTableData[$col['foreignTableName']] as $row)
                                        <option 
                                            value="{{ $row->id }}"
                                        >
                                            {{ $row->getAttribute($columnName) }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input 
                                    type="{{ $col['inputType'] }}"
                                    class="form-control" 
                                    name="{{ $columnName }}" 
                                    id="update-{{ $columnName }}" 
                                    placeholder="{{ $col['alias'] }}"
                                    value="{{ old($columnName) }}"
                                    {{ $col['inputType'] === 'file' ? '' : 'required' }}
                                    {{ $col['inputType'] === 'file' ? '' : 'accept="image/*"' }}
                                >
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn theme-button">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <form class="modal-dialog">
            @csrf

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create {{ $modelName }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">
                    @foreach($columns as $columnName => $col)
                        @if ($columnName === 'id')    
                            @continue
                        @endif

                        <div class="col-12 col-md-6">
                            <label for="update-{{ $columnName }}" class="form-label">{{ $col['alias'] }}</label>
                            
                            @if(in_array($columnName, $foreignColumns))
                                <select 
                                    class="form-select"
                                    name="{{ $columnName }}"
                                    id="update-{{ $columnName }}" 
                                >
                                    @foreach($foreignTableData[$col['foreignTableName']] as $row)
                                        <option 
                                            value="{{ $row->id }}"
                                        >
                                            {{ $row->getAttribute($columnName) }}
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input 
                                    type="{{ $col['inputType'] }}"
                                    class="form-control" 
                                    name="{{ $columnName }}" 
                                    id="update-{{ $columnName }}" 
                                    placeholder="{{ $col['alias'] }}"
                                    {{ $col['inputType'] === 'file' ? '' : 'required' }}
                                >
                            @endif
                        </div>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn theme-button">Simpan</button>
                </div>
            </div>
        </form>
    </div>

    {{-- Delete Modal --}}
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <form class="modal-dialog">
            @csrf

            <input type="hidden" name="id" />

            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete {{ $modelName }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">
                        Apa Anda yakin ingin menghapus baris ini?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn theme-button">Hapus</button>
                </div>
            </div>
        </form>
    </div>
</body>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script>
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            const nav = document.getElementById('navbarNav');
            const inst = bootstrap.Collapse.getInstance(nav);

            if (inst) {
                nav.classList.remove('collapsing');
                nav.classList.remove('show');
                nav.style.height = '';
            }
        }
    });

    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('.update-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                tr = btn.parentElement.parentElement;
            })
        })
    }); 
</script>
</html>