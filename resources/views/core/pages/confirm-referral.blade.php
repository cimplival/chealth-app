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
        	Add the Institution of this referral -  <strong>{{$selected_referral}}</strong> below for <strong>{{$patient->name}}</strong>:
        </p>
    </div>
    <form method="POST" action="{{ url('add-referral/' . $patient->id . '/' . $referral ) }}">
		{{ csrf_field() }}
	    <div class="padded-full">
		    <textarea name="institution" value="{{ old('institution') }}" placeholder="Type name of institution here..." autofocus></textarea> 
		</div>
		<div class="padded-full">
	        <button type="submit" class="btn fit-parent primary">Confirm Referral</button>
	    </div>
	</form>
	<div class="padded-full">
	    <a href="{{ url('referrals', $patient->id) }}"><button class="btn fit-parent">Go Back</button></a>
    </div>
@endsection


@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection