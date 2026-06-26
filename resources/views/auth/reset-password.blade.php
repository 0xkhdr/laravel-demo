@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: var(--space-4);">
    <div class="card" style="width: 100%; max-width: 600px;">
        <h2 class="text-h2" style="margin-bottom: var(--space-6); color: var(--color-text-primary);">{{ __('Reset Password') }}</h2>
        <div>
            @if ($errors->any())
                <div style="background-color: var(--color-red-100); color: var(--color-red-900); padding: var(--space-4); border-left: 4px solid var(--color-red-500); margin-bottom: var(--space-6);">
                    <ul style="margin: 0; padding-left: var(--space-4);">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('error'))
                <div style="background-color: var(--color-red-100); color: var(--color-red-900); padding: var(--space-4); border-left: 4px solid var(--color-red-500); margin-bottom: var(--space-6);">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST" action="{{ route('auth.reset-password') }}" style="display: flex; flex-direction: column; gap: var(--space-6);">
                @csrf

                <div>
                    <label for="email" style="display: block; margin-bottom: var(--space-2); font-weight: 500; color: var(--color-text-primary);">{{ __('Email Address') }}</label>
                    <input type="email" class="input-base" id="email" name="email" value="{{ $email ?? old('email') }}" required autofocus>
                    @error('email')
                        <span style="color: var(--color-red-500); font-size: var(--font-size-body-small); display: block; margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" style="display: block; margin-bottom: var(--space-2); font-weight: 500; color: var(--color-text-primary);">{{ __('Password') }}</label>
                    <input type="password" class="input-base" id="password" name="password" required>
                    @error('password')
                        <span style="color: var(--color-red-500); font-size: var(--font-size-body-small); display: block; margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" style="display: block; margin-bottom: var(--space-2); font-weight: 500; color: var(--color-text-primary);">{{ __('Confirm Password') }}</label>
                    <input type="password" class="input-base" id="password_confirmation" name="password_confirmation" required>
                    @error('password_confirmation')
                        <span style="color: var(--color-red-500); font-size: var(--font-size-body-small); display: block; margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: var(--space-4);">{{ __('Reset Password') }}</button>
            </form>

            <div style="margin-top: var(--space-6); text-align: center;">
                <a href="{{ route('auth.login') }}" class="btn btn-secondary">{{ __('Back to Login') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
