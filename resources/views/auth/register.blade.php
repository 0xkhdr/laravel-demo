@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div style="display: flex; align-items: center; justify-content: center; min-height: calc(100vh - 64px);">
    <div class="card" style="width: 100%; max-width: 400px; padding: var(--space-8);">
        <div class="card-header" style="font-size: var(--text-h3); font-weight: 500; margin-bottom: var(--space-6);">Register</div>
        <div class="card-body">
            @if ($errors->any())
                <div style="background-color: var(--color-surface); border-left: 4px solid var(--color-accent); padding: var(--space-4); margin-bottom: var(--space-6);">
                    <ul style="list-style: none; padding: 0; margin: 0; color: var(--color-text-primary); font-size: var(--text-body-small);">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom: var(--space-2);">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.register') }}" style="display: flex; flex-direction: column; gap: var(--space-6);">
                @csrf

                <div>
                    <label for="name" style="display: block; margin-bottom: var(--space-2); font-weight: 500; color: var(--color-text-primary);">Name</label>
                    <input type="text" id="name" name="name" class="input-base @error('name') is-invalid @enderror" value="{{ old('name') }}" style="width: 100%; font-size: var(--text-body); color: var(--color-text-primary);" required>
                    @error('name')
                        <span style="display: block; font-size: var(--text-caption); color: var(--color-accent); margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="email" style="display: block; margin-bottom: var(--space-2); font-weight: 500; color: var(--color-text-primary);">Email</label>
                    <input type="email" id="email" name="email" class="input-base @error('email') is-invalid @enderror" value="{{ old('email') }}" style="width: 100%; font-size: var(--text-body); color: var(--color-text-primary);" required>
                    @error('email')
                        <span style="display: block; font-size: var(--text-caption); color: var(--color-accent); margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password" style="display: block; margin-bottom: var(--space-2); font-weight: 500; color: var(--color-text-primary);">Password</label>
                    <input type="password" id="password" name="password" class="input-base @error('password') is-invalid @enderror" style="width: 100%; font-size: var(--text-body); color: var(--color-text-primary);" required>
                    @error('password')
                        <span style="display: block; font-size: var(--text-caption); color: var(--color-accent); margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" style="display: block; margin-bottom: var(--space-2); font-weight: 500; color: var(--color-text-primary);">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="input-base @error('password_confirmation') is-invalid @enderror" style="width: 100%; font-size: var(--text-body); color: var(--color-text-primary);" required>
                    @error('password_confirmation')
                        <span style="display: block; font-size: var(--text-caption); color: var(--color-accent); margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-primary" style="margin-top: var(--space-4); width: 100%; cursor: pointer;">Register</button>

                <div style="margin-top: var(--space-6); font-size: var(--text-body-small); color: var(--color-text-secondary);">
                    Already have an account? <a href="{{ route('auth.login') }}" style="color: var(--color-text-primary); text-decoration: none; border-bottom: 1px solid var(--color-text-primary); transition: all var(--transition-base);" onmouseover="this.style.color='var(--color-accent)'; this.style.borderBottomColor='var(--color-accent)'" onmouseout="this.style.color='var(--color-text-primary)'; this.style.borderBottomColor='var(--color-text-primary)'">Login here</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
