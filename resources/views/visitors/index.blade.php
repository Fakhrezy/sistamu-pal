@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Data Tamu</h3>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <div class="mb-3 card">
            <div class="card-body">
                <form action="{{ route('visitors.index') }}" method="GET" class="row g-3">
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
                            <button type="submit" class="btn btn-light flex-fill">Filter</button>
                            <a href="{{ route('visitors.index') }}" class="btn btn-light flex-fill">Reset</a>
                            <button type="submit" class="btn btn-outline-success flex-fill"
                                formaction="{{ route('visitors.export') }}" formmethod="GET">
                                <i class="bi bi-file-excel me-1"></i>Export
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
                        <th width="12%" class="border-dark">Tanggal</th>
                        <th width="8%" class="border-dark">Jam</th>
                        <th width="20%" class="border-dark">Nama</th>
                        <th width="10%" class="border-dark">Kategori</th>
                        <th width="30%" class="border-dark">Tujuan Kunjungan</th>
                        <th width="15%" class="border-dark">Kontak</th>
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
                        <td>{{ $visitor->nama }}</td>
                        <td class="text-center">
                            <span class="badge bg-{{ $visitor->kategori == 'pelanggan' ? 'primary' : 'info' }}">
                                {{ ucfirst($visitor->kategori) }}
                            </span>
                        </td>
                        <td>{{ $visitor->tujuan_kunjungan }}</td>
                        <td class="text-center">{{ $visitor->kontak }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('visitors.edit', $visitor->id) }}" class="btn btn-warning btn-sm me-1"
                                    title="Edit">
                                    <img src="{{ asset('images/draw.png') }}" alt="Edit" width="16" height="16"
                                        style="filter: brightness(0) invert(1);">
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" title="Hapus"
                                    onclick="confirmDelete({{ $visitor->id }})">
                                    <img src="{{ asset('images/trash-bin.png') }}" alt="Hapus" width="16" height="16"
                                        style="filter: brightness(0) invert(1);">
                                </button>
                                <form id="delete-form-{{ $visitor->id }}"
                                    action="{{ route('visitors.destroy', $visitor->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Tidak ada data tamu</td>
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
</script>
@endpush
