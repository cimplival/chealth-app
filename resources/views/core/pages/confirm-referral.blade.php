@extends('layouts.app')

@section('body')
    <div class="padded-full">
        <p class="text-center">
        	Are you sure you want to add this Referral: <strong>{{$selected_referral}}</strong>, to <strong>{{$patient->name}}</strong>?
        </p>
    </div>
    <form method="POST" action="{{ url('add-referral/' . $patient->id . '/' . $referral ) }}">
		{{ csrf_field() }}
	    <div class="padded-full">
	        <button type="submit" class="btn fit-parent primary">Yes, Proceed</button>
	    </div>
	</form>
	<div class="padded-full">
	    <a href="{{ url('referrals', $patient->id) }}"><button class="btn fit-parent">No, Go Back</button></a>
    </div>
@endsection