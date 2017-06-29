@extends('layouts.app')

@section('body')
<div class="padded-full">
	<p class="text-center">Add lab investigation request for <strong>{{ $patient->name}}</strong> below:</p>
</div>
<form method="POST" action="{{ url('lab-create', $patient->id) }}">
	{{ csrf_field() }}
	<input type="hidden" name="patient_id" value="{{$patient->id}}">
	<div class="padded-full">
		<input type="text" name="investigation_request" value="{{ old('investigation_request') }}" autocomplete="off" placeholder="Enter investigation request here" autofocus>
	</div>
	<div class="padded-full">
		<button type="submit" class="btn fit-parent primary">Request Lab Investigation</button>
	</div>
</form>
<div class="padded-full">
	<a href="{{ url('consult', $patient->id) }}"><button class="btn fit-parent">Go Back</button></a>
</div>
@endsection