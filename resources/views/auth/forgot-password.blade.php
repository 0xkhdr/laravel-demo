@extends('layouts.app')

@section('title', 'Forgot Password')

@section('content')
<div class="container">
    <div class="card" style="padding: var(--space-6);">
        <h1 style="font-size: var(--text-h2); margin-bottom: var(--space-4);">Forgot Password</h1>

        @if (session('status'))
            <div style="background-color: var(--color-success-50); color: var(--color-success-900); padding: var(--space-3); border-radius: 4px; margin-bottom: var(--space-4);">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('auth.forgot-password') }}">
            @csrf

            <div style="margin-bottom: var(--space-4);">
                <label for="email" style="display: block; margin-bottom: var(--space-2); font-size: var(--text-body); font-weight: 500;">Email Address</label>
                <input type="email" id="email" name="email" class="input-base @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <span style="color: var(--color-error-600); font-size: var(--text-small); margin-top: var(--space-1); display: block;">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary" style="margin-bottom: var(--space-4);">Send Password Reset Link</button>
        </form>

        <div style="border-top: 1px solid var(--color-neutral-200); padding-top: var(--space-4);">
            <a href="{{ route('auth.login') }}" style="color: var(--color-primary-600); text-decoration: none;">Back to Login</a>
        </div>
    </div>
</div>
@endsection
