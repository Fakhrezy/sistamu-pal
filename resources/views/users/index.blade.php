@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Kelola User</h3>
        <a href="{{ route('users.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Tambah User
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered border-dark">
                <thead class="table-secondary border-dark">
                    <tr class="align-middle text-center border-dark">
                        <th width="5%" class="border-dark">No</th>
                        <th width="25%" class="border-dark">Nama</th>
                        <th width="35%" class="border-dark">Email</th>
                        <th width="20%" class="border-dark">Tanggal Dibuat</th>
                        <th width="15%" class="border-dark">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                    <tr class="align-middle">
                        <td class="text-center">{{ ($users->currentPage() - 1) * $users->perPage() +
                            $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td class="text-center">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm me-1"
                                    title="Edit">
                                    <img src="{{ asset('images/draw.png') }}" alt="Edit" width="16" height="16"
                                        style="filter: brightness(0) invert(1);">
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" title="Hapus"
                                    onclick="confirmDeleteUser({{ $user->id }})">
                                    <img src="{{ asset('images/trash-bin.png') }}" alt="Hapus" width="16" height="16"
                                        style="filter: brightness(0) invert(1);">
                                </button>
                                <form id="delete-user-form-{{ $user->id }}"
                                    action="{{ route('users.destroy', $user->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Tidak ada data user</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-between align-items-center border-top pt-3 mt-3">
            <span class="text-muted">Menampilkan {{ $users->perPage() }} data per halaman</span>
            <nav>
                {{ $users->links() }}
            </nav>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function confirmDeleteUser(id) {
        Swal.fire({
            title: 'Hapus User?',
            text: "User yang dihapus tidak dapat dikembalikan!",
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
                    text: 'Sedang memproses penghapusan user',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submit form
                document.getElementById('delete-user-form-' + id).submit();
            }
        });
    }
</script>
@endpush