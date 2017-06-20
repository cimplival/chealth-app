@extends('layouts.app')

@section('body')
    <div class="padded-full">
        <p class="text-center">Are you sure you want to delete this lab record for <strong>{{ $lab->patient->name}}</strong>?</p>
    </div>
    <form method="POST" action="{{ url('delete-lab', $lab->id) }}">
		{{ csrf_field() }}
	    <div class="padded-full">
	        <button type="submit" class="btn fit-parent negative">Yes, Delete Lab Record</button>
	    </div>
	</form>
	<div class="padded-full">
	    <a href="{{ url('consult', $lab->patient->id) }}"><button class="btn fit-parent primary">No, Go Back</button></a>
    </div>
@endsection