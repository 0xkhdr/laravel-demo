@extends('layouts.app')

@section('content')
<div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: var(--space-6);">
    <div class="card" style="width: 100%; max-width: 400px; padding: var(--space-6);">
                <div style="margin-bottom: var(--space-6);">
                    <h2 style="font-size: var(--type-h2); color: var(--color-primary);">{{ __('Verify Email') }}</h2>
                </div>

                <div>
                    @if ($errors->any())
                        <div style="background-color: var(--color-error-light); border-left: 4px solid var(--color-error); padding: var(--space-4); margin-bottom: var(--space-4); border-radius: 4px;">
                            @foreach ($errors->all() as $error)
                                <div style="color: var(--color-error);">{{ $error }}</div>
                            @endforeach
                        </div>
                    @endif

                    @if (session('error'))
                        <div style="background-color: var(--color-error-light); border-left: 4px solid var(--color-error); padding: var(--space-4); margin-bottom: var(--space-4); border-radius: 4px; color: var(--color-error);">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if (session('success'))
                        <div style="background-color: var(--color-success-light); border-left: 4px solid var(--color-success); padding: var(--space-4); margin-bottom: var(--space-4); border-radius: 4px; color: var(--color-success);">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('verify-resend') }}" method="POST">
                        @csrf
                        <div style="margin-bottom: var(--space-6);">
                            <label for="email" style="display: block; font-size: var(--type-body); color: var(--color-text); margin-bottom: var(--space-2);">Email Address</label>
                            <input type="email" class="input-base" id="email" name="email" required>
                        </div>
                        <button type="submit" class="btn btn-primary">{{ __('Resend Verification Email') }}</button>
                    </form>

                    <p style="margin-top: var(--space-6); font-size: var(--type-body); color: var(--color-secondary);">
                        If you received a verification link in your email, click on it to verify your email address.
                    </p>
                </div>
            </div>
</div>
@endsection
