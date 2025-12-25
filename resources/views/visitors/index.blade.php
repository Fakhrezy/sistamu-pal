@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Data Tamu</h3>
    </div>
    <div class="card-body">
        <!-- Search Form -->
        <div class="mb-3">
            <form action="{{ route('visitors.index') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" class="form-control" name="search"
                            placeholder="Cari nama tamu atau asal instansi..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-search me-1"></i>Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Filter Form -->
        <div class="mb-3 card">
            <div class="card-body">
                <form action="{{ route('visitors.index') }}" method="GET" class="row g-3">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <div class="col-md-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai"
                            value="{{ request('tanggal_mulai') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="tanggal_akhir" name="tanggal_akhir"
                            value="{{ request('tanggal_akhir') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="kategori" class="form-label">Kategori</label>
                        <select class="form-select" id="kategori" name="kategori">
                            <option value="semua" {{ request('kategori')=='semua' ? 'selected' : '' }}>Semua</option>
                            <option value="pelanggan" {{ request('kategori')=='pelanggan' ? 'selected' : '' }}>Pelanggan
                            </option>
                            <option value="tamu" {{ request('kategori')=='tamu' ? 'selected' : '' }}>Tamu</option>
                        </select>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <div class="gap-2 d-grid d-md-flex w-100">
                            <button type="submit" class="btn btn-light flex-fill">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                            @if(request('tanggal_mulai') || request('tanggal_akhir') || request('kategori') != 'semua'
                            && request('kategori') || request('search'))
                            <a href="{{ route('visitors.index') }}" class="btn btn-light flex-fill">
                                <i class="bi bi-x-circle me-1"></i>Reset
                            </a>
                            @endif
                            <button type="submit" class="btn btn-outline-success flex-fill"
                                formaction="{{ route('visitors.export') }}" formmethod="GET">
                                <i class="bi bi-download me-1"></i>Export
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-bordered border-dark">
                <thead class="table-secondary border-dark">
                    <tr class="text-center align-middle border-dark">
                        <th width="5%" class="border-dark">No</th>
                        <th width="10%" class="border-dark">Tanggal</th>
                        <th width="7%" class="border-dark">Jam In</th>
                        <th width="7%" class="border-dark">Jam Out</th>
                        <th width="15%" class="border-dark">Nama</th>
                        <th width="9%" class="border-dark">Kategori</th>
                        <th width="13%" class="border-dark">Asal Instansi</th>
                        <th width="18%" class="border-dark">Tujuan Kunjungan</th>
                        <th width="10%" class="border-dark">Kontak</th>
                        <th width="8%" class="border-dark">Status</th>
                        <th width="10%" class="border-dark">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visitors as $index => $visitor)
                    <tr class="align-middle">
                        <td class="text-center">{{ ($visitors->currentPage() - 1) * $visitors->perPage() +
                            $loop->iteration }}</td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($visitor->tanggal)) }}</td>
                        <td class="text-center">{{ date('H:i', strtotime($visitor->jam)) }}</td>
                        <td class="text-center">{{ $visitor->jam_checkout ? date('H:i',
                            strtotime($visitor->jam_checkout)) : '-' }}</td>
                        <td>{{ $visitor->nama }}</td>
                        <td class="text-center">
                            <span class="badge"
                                style="background-color: {{ $visitor->kategori == 'pelanggan' ? '#a78bfa' : '#7dd3fc' }}; color: {{ $visitor->kategori == 'pelanggan' ? '#3730a3' : '#0c4a6e' }};">
                                {{ ucfirst($visitor->kategori) }}
                            </span>
                        </td>
                        <td>{{ $visitor->asal_instansi ?? '-' }}</td>
                        <td>{{ $visitor->tujuan_kunjungan }}</td>
                        <td class="text-center">{{ $visitor->kontak }}</td>
                        <td class="text-center">
                            <span class="badge"
                                style="background-color: {{ $visitor->status == 'check in' ? '#86efac' : '#d1d5db' }}; color: {{ $visitor->status == 'check in' ? '#065f46' : '#374151' }};">
                                {{ ucfirst($visitor->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm me-1"
                                    style="background-color: {{ $visitor->status == 'check in' ? '#86efac' : '#9ca3af' }}; border-color: {{ $visitor->status == 'check in' ? '#4ade80' : '#6b7280' }}; color: {{ $visitor->status == 'check in' ? '#065f46' : '#fff' }};"
                                    title="Ubah Status ke {{ $visitor->status == 'check in' ? 'Check Out' : 'Check In' }}"
                                    onclick="confirmStatusChange({{ $visitor->id }}, '{{ $visitor->status }}')">
                                    <i
                                        class="bi bi-{{ $visitor->status == 'check in' ? 'box-arrow-right' : 'box-arrow-in-right' }}"></i>
                                </button>
                                <a href="{{ route('visitors.edit', $visitor->id) }}" class="btn btn-sm me-1"
                                    style="background-color: #93c5fd; border-color: #60a5fa; color: #1e3a8a;"
                                    title="Edit">
                                    <img src="{{ asset('images/draw.png') }}" alt="Edit" width="16" height="16"
                                        style="filter: brightness(0) saturate(100%) invert(17%) sepia(50%) saturate(3000%) hue-rotate(215deg) brightness(90%) contrast(90%);">
                                </a>
                                <button type="button" class="btn btn-sm"
                                    style="background-color: #fca5a5; border-color: #f87171; color: #7f1d1d;"
                                    title="Hapus" onclick="confirmDelete({{ $visitor->id }})">
                                    <img src="{{ asset('images/trash-bin.png') }}" alt="Hapus" width="16" height="16"
                                        style="filter: brightness(0) saturate(100%) invert(12%) sepia(50%) saturate(3000%) hue-rotate(0deg) brightness(80%) contrast(90%);">
                                </button>
                                <form id="delete-form-{{ $visitor->id }}"
                                    action="{{ route('visitors.destroy', $visitor->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                                <form id="status-form-{{ $visitor->id }}"
                                    action="{{ route('visitors.toggle-status', $visitor->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="11" class="text-center">Tidak ada data tamu</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="pt-3 mt-3 d-flex justify-content-between align-items-center border-top">
            <span class="text-muted">Menampilkan {{ $visitors->perPage() }} data per halaman</span>
            <nav>
                {{ $visitors->withQueryString()->links() }}
            </nav>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Data Tamu?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading
                Swal.fire({
                    title: 'Menghapus...',
                    text: 'Sedang memproses penghapusan data',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    function confirmStatusChange(id, currentStatus) {
        const newStatus = currentStatus === 'check in' ? 'Check Out' : 'Check In';
        const icon = currentStatus === 'check in' ? 'box-arrow-right' : 'box-arrow-in-right';

        Swal.fire({
            title: 'Ubah Status?',
            html: `Apakah Anda yakin ingin mengubah status menjadi <strong>${newStatus}</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: currentStatus === 'check in' ? '#17a2b8' : '#28a745',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Ubah!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            focusCancel: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Tampilkan loading
                Swal.fire({
                    title: 'Mengubah Status...',
                    text: 'Sedang memproses perubahan status',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                document.getElementById('status-form-' + id).submit();
            }
        });
    }
</script>
@endpush
