@extends('layouts.app')

@section('body')
    <div class="padded-full text-center">
        <p>Are you sure you want to delete this medication record for <strong>{{ $medication->clinical->patient->name}}</strong>?</p>
        <p>
        	<strong>Note:</strong> Deleting the medication won't affect the number of drugs in the inventory.
        </p>
    </div>
    <form method="POST" action="{{ url('delete-medication', $medication->id) }}">
		{{ csrf_field() }}
	    <div class="padded-full">
	        <button type="submit" class="btn fit-parent negative">Yes, Delete Medication</button>
	    </div>
	</form>
	<div class="padded-full">
	    <a href="{{ url('consult', $medication->clinical->patient->id) }}"><button class="btn fit-parent">No, Go Back</button></a>
    </div>
@endsection