@extends('layouts.app')

@section('content')
    @include('admin.users._nav')

    <div class="d-flex flex-row mb-3">
        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary mr-1">{{ __('Edit') }}</a>
        <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="mr-1">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger">{{ __('Delete') }}</button>
        </form>
    </div>

    <table class="table table-bordered table-striped">
        <tbody>
        <tr>
            <th>{{ __('ID') }}</th>
            <td>{{ $user->id }}</td>
        </tr>
        <tr>
            <th>{{ __('Name') }}</th>
            <td>{{ $user->name }}</td>
        </tr>
        <tr>
            <th>{{ __('Email') }}</th>
            <td>{{ $user->email }}</td>
        </tr>
        <tr>
            <th>{{ __('Status') }}</th>
            <td>
                @if ($user->status === \App\Models\User::STATUS_WAIT)
                    <span class="badge badge-secondary">{{ __('Waiting') }}</span>
                @endif
                @if ($user->status === \App\Models\User::STATUS_ACTIVE)
                    <span class="badge badge-primary">{{ __('Active') }}</span>
                @endif
            </td>
        </tr>
        <tbody>
        </tbody>
    </table>
@endsection