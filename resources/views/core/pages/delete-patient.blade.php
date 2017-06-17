@extends('layouts.app')

@section('body')
    <div class="padded-full">
        <p class="text-center">Are you sure you want to delete this patient <strong>{{ $patient->name}}</strong>? All patient's clinical histories will be deleted too.</p>
    </div>
    <form method="POST" action="{{ url('delete-patient') }}">
		{{ csrf_field() }}
		<input type="hidden" name="patient_id" value="{{$patient->id}}">
	    <div class="padded-full">
	        <button type="submit" class="btn fit-parent negative">Yes, Delete the Patient</button>
	    </div>
	</form>
	<div class="padded-full">
	    <a href="{{ url('consult', $patient->id) }}"><button class="btn fit-parent primary">No, Go Back</button></a>
    </div>
@endsection