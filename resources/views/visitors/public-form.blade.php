<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Buku Tamu Digital - PERUMDA PALJAYA</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo-pal.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <style>
        body {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            font-family: 'Figtree', sans-serif;
        }

        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 2.5rem 2rem;
            text-align: center;
        }

        .form-header img {
            height: 80px;
            margin-bottom: 1rem;
            filter: brightness(0) invert(1);
        }

        .form-header h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            font-size: 1rem;
            margin: 0;
            opacity: 0.95;
        }

        .form-body {
            padding: 2.5rem 2rem;
        }

        .datetime-display {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 0.75rem;
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-around;
            align-items: center;
            border: 2px solid #e9ecef;
        }

        .datetime-item {
            text-align: center;
        }

        .datetime-item i {
            color: #2a5298;
            font-size: 1rem;
            margin-bottom: 0.3rem;
        }

        .datetime-item .label {
            font-size: 0.65rem;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .datetime-item .value {
            font-size: 0.95rem;
            font-weight: 700;
            color: #2c3e50;
        }

        .form-label {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control,
        .form-select {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 0.75rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #2a5298;
            box-shadow: 0 0 0 0.25rem rgba(42, 82, 152, 0.15);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn-submit {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            border: none;
            color: white;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 10px;
            width: 100%;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(42, 82, 152, 0.4);
        }

        .btn-login {
            background: transparent;
            border: 2px solid #2a5298;
            color: #2a5298;
            padding: 0.5rem 1.5rem;
            font-size: 0.875rem;
            font-weight: 600;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-login:hover {
            background: #2a5298;
            color: white;
            transform: translateY(-1px);
        }

        .login-section {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 2px solid #e9ecef;
        }

        .required {
            color: #dc3545;
        }

        @media (max-width: 768px) {
            .form-header h1 {
                font-size: 1.5rem;
            }

            .datetime-display {
                flex-direction: column;
                gap: 1rem;
            }

            .form-body {
                padding: 1.5rem 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="form-container">
        <div class="form-header">
            <img src="{{ asset('images/logo-pal.png') }}" alt="Logo PALJAYA">
            <h1>BUKU TAMU DIGITAL</h1>
            <p>PERUMDA PALJAYA</p>
        </div>

        <div class="form-body">
            <!-- DateTime Display -->
            <div class="datetime-display">
                <div class="datetime-item">
                    <i class="fas fa-calendar-alt"></i>
                    <div class="label">Tanggal</div>
                    <div class="value" id="tanggal-display"></div>
                </div>
                <div class="datetime-item">
                    <i class="fas fa-clock"></i>
                    <div class="label">Waktu</div>
                    <div class="value" id="jam-display"></div>
                </div>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('visitor.store') }}" id="visitorForm">
                @csrf

                <!-- Nama -->
                <div class="mb-3">
                    <label for="nama" class="form-label">
                        Nama Lengkap <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                        value="{{ old('nama') }}" required placeholder="Masukkan nama lengkap Anda">
                    @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label for="kategori" class="form-label">
                        Kategori <span class="required">*</span>
                    </label>
                    <select class="form-select @error('kategori') is-invalid @enderror" id="kategori" name="kategori"
                        required>
                        <option value="">-- Pilih Kategori --</option>
                        <option value="pelanggan" {{ old('kategori')=='pelanggan' ? 'selected' : '' }}>Pelanggan
                        </option>
                        <option value="tamu" {{ old('kategori')=='tamu' ? 'selected' : '' }}>Tamu</option>
                    </select>
                    @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Asal Perusahaan/Instansi -->
                <div class="mb-3">
                    <label for="asal_instansi" class="form-label">
                        Asal Perusahaan/Instansi
                    </label>
                    <input type="text" class="form-control @error('asal_instansi') is-invalid @enderror"
                        id="asal_instansi" name="asal_instansi" value="{{ old('asal_instansi') }}"
                        placeholder="Masukkan asal perusahaan/instansi">
                    @error('asal_instansi')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Kontak -->
                <div class="mb-3">
                    <label for="kontak" class="form-label">
                        Nomor Kontak <span class="required">*</span>
                    </label>
                    <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak"
                        name="kontak" value="{{ old('kontak') }}" required placeholder="Masukkan nomor HP/WhatsApp">
                    @error('kontak')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tujuan Kunjungan -->
                <div class="mb-3">
                    <label for="tujuan_kunjungan" class="form-label">
                        Tujuan Kunjungan <span class="required">*</span>
                    </label>
                    <textarea class="form-control @error('tujuan_kunjungan') is-invalid @enderror" id="tujuan_kunjungan"
                        name="tujuan_kunjungan" required
                        placeholder="Jelaskan tujuan kunjungan Anda">{{ old('tujuan_kunjungan') }}</textarea>
                    @error('tujuan_kunjungan')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane me-2"></i>Kirim Data
                </button>
            </form>

            <!-- Login Section -->
            <div class="login-section">
                <p class="mb-2" style="color: #6c757d; font-size: 0.9rem;">
                    <i class="fas fa-user-shield me-1"></i> Petugas / Admin
                </p>
                <a href="{{ route('login') }}" class="btn-login">
                    <i class="fas fa-sign-in-alt me-1"></i>Login Dashboard
                </a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Update Date and Time
        function updateDateTime() {
            const now = new Date();

            // Format tanggal
            const options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const tanggal = now.toLocaleDateString('id-ID', options);
            document.getElementById('tanggal-display').textContent = tanggal;

            // Format jam
            const jam = now.toLocaleTimeString('id-ID', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('jam-display').textContent = jam;
        }

        // Update setiap detik
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // SweetAlert for success message
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#2a5298',
                confirmButtonText: 'OK'
            }).then(() => {
                // Reset form
                document.getElementById('visitorForm').reset();
            });
        @endif

        // Validation error alert
        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                html: '<ul style="text-align: left;">' +
                    '@foreach ($errors->all() as $error)' +
                    '<li>{{ $error }}</li>' +
                    '@endforeach' +
                    '</ul>',
                confirmButtonColor: '#2a5298',
            });
        @endif
    </script>
</body>

</html>
