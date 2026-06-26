@extends('layouts.app')

@section('title', 'Change Password')

@section('content')
<div class="container" style="max-width: 500px; margin: 0 auto; padding: var(--space-lg)">
    <div class="card" style="padding: var(--space-lg); border-radius: var(--radius-md); background-color: var(--color-surface)">
        <h1 style="font-size: var(--type-h3); margin-bottom: var(--space-md); color: var(--color-text-primary)">Change Password</h1>

        @if ($errors->any())
            <div style="padding: var(--space-md); margin-bottom: var(--space-md); background-color: var(--color-error-light); border-left: 4px solid var(--color-error); border-radius: var(--radius-sm)">
                <ul style="margin: 0; padding-left: var(--space-md); color: var(--color-error)">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('status'))
            <div style="padding: var(--space-md); margin-bottom: var(--space-md); background-color: var(--color-success-light); border-left: 4px solid var(--color-success); border-radius: var(--radius-sm); color: var(--color-success)">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('change-password.update') }}">
            @csrf

            <div style="margin-bottom: var(--space-md)">
                <label for="current_password" style="display: block; font-weight: 500; margin-bottom: var(--space-xs); color: var(--color-text-primary); font-size: var(--type-sm)">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="input-base @error('current_password') input-error @enderror" required style="width: 100%">
                @error('current_password')
                    <span style="display: block; margin-top: var(--space-xs); font-size: var(--type-xs); color: var(--color-error)">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: var(--space-md)">
                <label for="password" style="display: block; font-weight: 500; margin-bottom: var(--space-xs); color: var(--color-text-primary); font-size: var(--type-sm)">New Password</label>
                <input type="password" id="password" name="password" class="input-base @error('password') input-error @enderror" required style="width: 100%">
                @error('password')
                    <span style="display: block; margin-top: var(--space-xs); font-size: var(--type-xs); color: var(--color-error)">{{ $message }}</span>
                @enderror
            </div>

            <div style="margin-bottom: var(--space-lg)">
                <label for="password_confirmation" style="display: block; font-weight: 500; margin-bottom: var(--space-xs); color: var(--color-text-primary); font-size: var(--type-sm)">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="input-base" required style="width: 100%">
            </div>

            <div style="display: flex; gap: var(--space-sm)">
                <button type="submit" class="btn-primary" style="padding: var(--space-sm) var(--space-md); border-radius: var(--radius-sm); border: none; cursor: pointer; font-weight: 500">Update Password</button>
                <a href="{{ route('profile.show') }}" class="btn-secondary" style="display: inline-block; padding: var(--space-sm) var(--space-md); border-radius: var(--radius-sm); border: 1px solid var(--color-border); text-decoration: none; cursor: pointer; font-weight: 500">Back to Profile</a>
            </div>
        </form>
    </div>
</div>
@endsection
