@extends('layouts.app')

@section('breadcrumbs', '')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Hello') }}</div>

                <div class="card-body">
                    {{ __('Your site') }}
                </div>
                </div>
            </div>
        </div>
@endsection
