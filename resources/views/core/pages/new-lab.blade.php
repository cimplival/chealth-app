@extends('layouts.app')

@section('body')
<div class="padded-full">
	<p class="text-center">Are you sure you want to request a lab record for <strong>{{ $patient->name}}</strong>?</p>
</div>
<form method="POST" action="{{ url('lab-create', $patient->id) }}">
	{{ csrf_field() }}
	<input type="hidden" name="patient_id" value="{{$patient->id}}">
	<div class="padded-full">
		<button type="submit" class="btn fit-parent primary">Yes, Request Lab Record</button>
	</div>
</form>
<div class="padded-full">
	<a href="{{ url('consult', $patient->id) }}"><button class="btn fit-parent">No, Go Back</button></a>
</div>
@endsection