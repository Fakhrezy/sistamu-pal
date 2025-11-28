<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Username -->
        <div class="mb-3">
            <label for="username" class="form-label fw-semibold">Username</label>
            <input id="username" class="form-control form-control-lg" type="text" name="username"
                value="{{ old('username') }}" required autofocus autocomplete="username"
                placeholder="Masukkan username" />
            @if($errors->get('username'))
            <div class="mt-1 text-danger small">
                @foreach($errors->get('username') as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label fw-semibold">Password</label>
            <input id="password" class="form-control form-control-lg" type="password" name="password" required
                autocomplete="current-password" placeholder="Masukkan password" />
            @if($errors->get('password'))
            <div class="mt-1 text-danger small">
                @foreach($errors->get('password') as $error)
                <div>{{ $error }}</div>
                @endforeach
            </div>
            @endif
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label text-muted" for="remember_me">
                    Ingat saya
                </label>
            </div>
        </div>

        <div class="gap-2 d-grid">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-sign-in-alt me-2"></i>Login
            </button>
        </div>

        <div class="gap-2 mt-2 d-grid">
            <a href="https://drive.google.com/file/d/1MCKWIAFHq3lskwh_MJ8IovnsAbbap35l/view?usp=sharing" target="_blank"
                class="btn btn-outline-secondary btn-panduan">
                <i class="fas fa-question-circle me-2"></i>Panduan
            </a>
        </div>

        @if (Route::has('password.request'))
        <div class="mt-3 text-center">
            <a href="{{ route('password.request') }}" class="text-decoration-none text-muted small">
                Lupa password?
            </a>
        </div>
        @endif
    </form>

    <style>
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #6689ea 0%, #4b7ea2 100%);
            border: none;
            transition: all 0.3s ease;
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .form-control-lg {
            padding: 0.75rem 1rem;
            font-size: 1rem;
        }

        .btn-panduan {
            font-size: 0.875rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
            border-color: #6c757d;
        }

        .btn-panduan:hover {
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(108, 117, 125, 0.3);
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
        }
    </style>
</x-guest-layout>