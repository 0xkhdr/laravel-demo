@extends('layouts.app')

@section('title', 'Register')

@section('content')
<div class="container" style="max-width: var(--page-max-width); margin: var(--space-12) auto; padding: var(--page-padding);">
    <div class="card" style="padding: var(--space-8); border: 1px solid var(--color-border); border-radius: 0;">
        <div class="card-header" style="font-size: var(--text-h3); font-weight: 500; margin-bottom: var(--space-6); padding-bottom: var(--space-4); border-bottom: 1px solid var(--color-border);">Register</div>
        <div class="card-body" style="padding: var(--space-6) 0;">
            @if ($errors->any())
                <div style="background-color: var(--color-surface); border-left: 4px solid var(--color-accent); padding: var(--space-4); margin-bottom: var(--space-6);">
                    <ul style="list-style: none; padding: 0; margin: 0; color: var(--color-text-primary); font-size: var(--text-body-small);">
                        @foreach ($errors->all() as $error)
                            <li style="margin-bottom: var(--space-2);">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('auth.register') }}">
                @csrf

                <div style="margin-bottom: var(--space-6);">
                    <label for="name" style="display: block; font-size: var(--text-h5); font-weight: 500; margin-bottom: var(--space-3); color: var(--color-text-primary);">Name</label>
                    <input type="text" id="name" name="name" class="input-base @error('name') is-invalid @enderror" value="{{ old('name') }}" style="width: 100%; font-size: var(--text-body); color: var(--color-text-primary);" required>
                    @error('name')
                        <span style="display: block; font-size: var(--text-caption); color: var(--color-accent); margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: var(--space-6);">
                    <label for="email" style="display: block; font-size: var(--text-h5); font-weight: 500; margin-bottom: var(--space-3); color: var(--color-text-primary);">Email</label>
                    <input type="email" id="email" name="email" class="input-base @error('email') is-invalid @enderror" value="{{ old('email') }}" style="width: 100%; font-size: var(--text-body); color: var(--color-text-primary);" required>
                    @error('email')
                        <span style="display: block; font-size: var(--text-caption); color: var(--color-accent); margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: var(--space-6);">
                    <label for="password" style="display: block; font-size: var(--text-h5); font-weight: 500; margin-bottom: var(--space-3); color: var(--color-text-primary);">Password</label>
                    <input type="password" id="password" name="password" class="input-base @error('password') is-invalid @enderror" style="width: 100%; font-size: var(--text-body); color: var(--color-text-primary);" required>
                    @error('password')
                        <span style="display: block; font-size: var(--text-caption); color: var(--color-accent); margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: var(--space-6);">
                    <label for="password_confirmation" style="display: block; font-size: var(--text-h5); font-weight: 500; margin-bottom: var(--space-3); color: var(--color-text-primary);">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="input-base @error('password_confirmation') is-invalid @enderror" style="width: 100%; font-size: var(--text-body); color: var(--color-text-primary);" required>
                    @error('password_confirmation')
                        <span style="display: block; font-size: var(--text-caption); color: var(--color-accent); margin-top: var(--space-2);">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit" class="btn-primary" style="background-color: var(--color-pure-black); color: var(--color-pure-white); padding: var(--space-4) var(--space-8); border: none; border-radius: 0; font-size: var(--text-body-small); font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase; cursor: pointer; transition: all var(--transition-base);" onmouseover="this.style.backgroundColor='var(--color-gray-800)'" onmouseout="this.style.backgroundColor='var(--color-pure-black)'">Register</button>

                <div style="margin-top: var(--space-6); font-size: var(--text-body-small); color: var(--color-text-secondary);">
                    Already have an account? <a href="{{ route('auth.login') }}" style="color: var(--color-text-primary); text-decoration: none; border-bottom: 1px solid var(--color-text-primary); transition: all var(--transition-base);" onmouseover="this.style.color='var(--color-accent)'; this.style.borderBottomColor='var(--color-accent)'" onmouseout="this.style.color='var(--color-text-primary)'; this.style.borderBottomColor='var(--color-text-primary)'">Login here</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
