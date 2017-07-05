@extends('layouts.app')

@section('partials')

@if (Session::has('info'))
@include('core.partials.info')
@endif

@if (Session::has('success'))
@include('core.partials.success')
@endif

@if (Session::has('error'))
@include('core.partials.error')
@endif

@if (Session::has('errors'))
@include('core.partials.errors')
@endif

@endsection


@section('body')
    <div class="padded-full">
        <p class="text-center">
        	Would you like to dispense this medication <strong>({{ $medication->quantity }} x {{ $medication->times_a_day }} x {{ $medication->no_of_days }})</strong> for <strong>{{ $medication->clinical->patient->name}}</strong>?
        </p>
    </div>
    <div class="padded-full">
        <form method="POST" action="{{ url('dispense-medication', $medication->id) }}">
        {{ csrf_field() }}
            <button class="btn fit-parent primary">Yes, Dispense Medication</button>
        </form>
    </div>
	<div class="padded-full">
	    <a href="{{ url('medications') }}"><button class="btn fit-parent">No, Go Back</button></a>
    </div>
@endsection


@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection