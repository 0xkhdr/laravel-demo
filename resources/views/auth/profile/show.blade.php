@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="container">
    <div class="card">
        <div class="p-6">
            <h1 class="text-h2 mb-4">User Profile</h1>

            @if (session('status'))
                <div class="bg-primary text-white p-4 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="profile-info">
                <p>
                    <strong class="text-body-large">Name:</strong> {{ $user->name }}
                </p>
                <p>
                    <strong class="text-body-large">Email:</strong> {{ $user->email }}
                </p>
                <p>
                    <strong class="text-body-large">Email Verified:</strong>
                    @if ($user->email_verified_at)
                        <span class="rounded px-4" style="background-color: var(--color-primary); color: white; padding: var(--space-2) var(--space-4); display: inline-block;">
                            Yes ({{ $user->email_verified_at->format('M d, Y H:i') }})
                        </span>
                    @else
                        <span class="rounded px-4" style="background-color: var(--color-gray-400); color: white; padding: var(--space-2) var(--space-4); display: inline-block;">
                            No
                        </span>
                    @endif
                </p>
                <p>
                    <strong class="text-body-large">Last Login:</strong>
                    @if ($user->last_login)
                        {{ $user->last_login->format('M d, Y H:i') }}
                    @else
                        Never
                    @endif
                </p>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('change-password') }}" class="btn btn-primary">Change Password</a>
        <form method="POST" action="{{ route('logout') }}" style="display: inline-block;">
            @csrf
            <button type="submit" class="btn btn-red">Logout</button>
        </form>
    </div>
</div>
@endsection
