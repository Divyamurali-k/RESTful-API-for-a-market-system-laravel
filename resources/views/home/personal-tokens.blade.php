@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

               <passport-personal-access-tokens></passport-personal-access-tokens>
            </div>
        </div>
    </div>
</div>
@endsection
