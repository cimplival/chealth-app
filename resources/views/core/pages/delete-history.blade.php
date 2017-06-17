@extends('layouts.app')

@section('body')
    <div class="padded-full">
        <p class="text-center">Are you sure you want to delete this clinical history for <strong>{{ $clinical->patient->name}}</strong>?</p>
    </div>
    <form method="POST" action="{{ url('delete-history') }}">
		{{ csrf_field() }}
		<input type="hidden" name="clinical_id" value="{{$clinical->id}}">
	    <div class="padded-full">
	        <button type="submit" class="btn fit-parent negative">Yes, Delete Clinical History</button>
	    </div>
	</form>
	<div class="padded-full">
	    <a href="{{ url('consult', $clinical->patient->id) }}"><button class="btn fit-parent primary">No, Go Back</button></a>
    </div>
@endsection