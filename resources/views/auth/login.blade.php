@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div style="display: flex; align-items: center; justify-content: center; min-height: 100vh;">
    <div class="card" style="width: 100%; max-width: 400px;">
        <h1 style="font-size: var(--text-h2); margin-bottom: var(--space-6); color: var(--color-text-primary);">Login</h1>
        <div style="">
            @if ($errors->any())
                <div style="background-color: #fee2e2; color: #991b1b; padding: var(--space-4); border-left: 4px solid var(--color-accent); margin-bottom: var(--space-6);">
                    <ul style="margin: 0; padding-left: var(--space-4);">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div style="background-color: #dcfce7; color: #166534; padding: var(--space-4); border-left: 4px solid #22c55e; margin-bottom: var(--space-6);">{{ session('status') }}</div>
            @endif

            @if (session('error'))
                <div style="background-color: #fee2e2; color: #991b1b; padding: var(--space-4); border-left: 4px solid var(--color-accent); margin-bottom: var(--space-6);">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('auth.login') }}" style="display: flex; flex-direction: column; gap: var(--space-6);">
                @csrf

                <div>
                    <label for="email" style="display: block; margin-bottom: var(--space-2); font-weight: 500; color: var(--color-text-primary);">Email</label>
                    <input type="email" id="email" name="email" class="input-base @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                    @error('email')
                        <span style="color: var(--color-accent); font-size: var(--font-size-body-small); display: block; margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" style="display: block; margin-bottom: var(--space-2); font-weight: 500; color: var(--color-text-primary);">Password</label>
                    <input type="password" id="password" name="password" class="input-base @error('password') is-invalid @enderror" required>
                    @error('password')
                        <span style="color: var(--color-accent); font-size: var(--font-size-body-small); display: block; margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; align-items: center; gap: var(--space-2);">
                    <input type="checkbox" id="remember" name="remember" style="width: 18px; height: 18px; cursor: pointer;" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" style="cursor: pointer; color: var(--color-text-primary);">Remember me</label>
                </div>

                <button type="submit" class="btn-primary" style="margin-top: var(--space-4); width: 100%; cursor: pointer;">Login</button>
            </form>

            <div style="margin-top: var(--space-6); padding-top: var(--space-4); border-top: 1px solid var(--color-border);">
                <p style="margin: 0 0 var(--space-2) 0; font-size: var(--font-size-body-small);">
                    <a href="{{ route('auth.forgot-password') }}" style="color: var(--color-accent); text-decoration: none;">Forgot your password?</a>
                </p>
                <p style="margin: 0; font-size: var(--font-size-body-small);">
                    Don't have an account? <a href="{{ route('auth.register') }}" style="color: var(--color-accent); text-decoration: none;">Register here</a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
