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
        	Would you like to administer a medication from the pharmacy?
        </p>
    </div>
    <div class="padded-full">
	    <a href="{{ url('new-medication', $clinical->id) }}"><button class="btn fit-parent primary">Yes, Administer Medication</button></a>
    </div>
	<div class="padded-full">
	    <a href="{{ url('consult', $clinical->patient->id) }}"><button class="btn fit-parent">No, Go to Consultation</button></a>
    </div>
@endsection


@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection