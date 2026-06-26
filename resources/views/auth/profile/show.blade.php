@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header">User Profile</div>
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
            @endif

            <div class="profile-info">
                <p><strong>Name:</strong> {{ $user->name }}</p>
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p>
                    <strong>Email Verified:</strong>
                    @if ($user->email_verified_at)
                        <span class="badge badge-success">Yes ({{ $user->email_verified_at->format('M d, Y H:i') }})</span>
                    @else
                        <span class="badge badge-warning">No</span>
                    @endif
                </p>
                <p>
                    <strong>Last Login:</strong>
                    @if ($user->last_login)
                        {{ $user->last_login->format('M d, Y H:i') }}
                    @else
                        Never
                    @endif
                </p>
            </div>

            <div class="mt-4">
                <a href="{{ route('change-password') }}" class="btn btn-primary">Change Password</a>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
