@extends('layouts.main')

@section('content')
<div class="card">
    <div class="card-header">
        <h3>Edit Data Tamu</h3>
    </div>
    <div class="card-body">
        <form action="{{ route('visitors.update', $visitor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3 row">
                <div class="col-md-6">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                        name="tanggal" value="{{ old('tanggal', $visitor->tanggal) }}" required>
                    @error('tanggal')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="jam" class="form-label">Jam Check In</label>
                    <input type="text" class="form-control timepicker @error('jam') is-invalid @enderror" id="jam"
                        name="jam" value="{{ old('jam', $visitor->jam) }}" required>
                    @error('jam')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="jam_checkout" class="form-label">Jam Check Out</label>
                <input type="text" class="form-control timepicker @error('jam_checkout') is-invalid @enderror"
                    id="jam_checkout" name="jam_checkout" value="{{ old('jam_checkout', $visitor->jam_checkout) }}">
                @error('jam_checkout')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nama" class="form-label">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                    value="{{ old('nama', $visitor->nama) }}" required>
                @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kategori" class="form-label">Kategori</label>
                <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori"
                    required>
                    <option value="">Pilih Kategori</option>
                    <option value="pelanggan" {{ (old('kategori', $visitor->kategori) == 'pelanggan') ? 'selected' : ''
                        }}>
                        Pelanggan
                    </option>
                    <option value="tamu" {{ (old('kategori', $visitor->kategori) == 'tamu') ? 'selected' : '' }}>
                        Tamu
                    </option>
                </select>
                @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="asal_instansi" class="form-label">Asal Perusahaan/Instansi</label>
                <input type="text" class="form-control @error('asal_instansi') is-invalid @enderror" id="asal_instansi"
                    name="asal_instansi" value="{{ old('asal_instansi', $visitor->asal_instansi) }}">
                @error('asal_instansi')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kontak" class="form-label">Kontak</label>
                <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak"
                    value="{{ old('kontak', $visitor->kontak) }}" required>
                @error('kontak')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tujuan_kunjungan" class="form-label">Tujuan Kunjungan</label>
                <textarea class="form-control @error('tujuan_kunjungan') is-invalid @enderror" id="tujuan_kunjungan"
                    name="tujuan_kunjungan" rows="3"
                    required>{{ old('tujuan_kunjungan', $visitor->tujuan_kunjungan) }}</textarea>
                @error('tujuan_kunjungan')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                    <option value="">Pilih Status</option>
                    <option value="check in" {{ (old('status', $visitor->status) == 'check in') ? 'selected' : '' }}>
                        Check In
                    </option>
                    <option value="check out" {{ (old('status', $visitor->status) == 'check out') ? 'selected' : '' }}>
                        Check Out
                    </option>
                </select>
                @error('status')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="text-end">
                <a href="{{ route('visitors.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    flatpickr(".timepicker", {
        enableTime: true,
        noCalendar: true,
        dateFormat: "H:i",
        time_24hr: true
    });
</script>
@endpush
