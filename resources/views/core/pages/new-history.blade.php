@extends('layouts.app')

@section('body')
	<form method="POST" action="{{ url('new-history') }}">
		{{ csrf_field() }}
		<input type="hidden" name="patient_id" value="{{ $patient->id }}">
		<div class="padded-full">
		    <h5 class="pull-right">Complaints</h5>
		</div>
		<div class="padded-full">
		    <textarea name="complaint" value="{{ old('complaint') }}" placeholder="Type here..." autofocus></textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Lab Tests</h5>
		</div>
		<div class="padded-full">
		    <textarea name="lab_test" value="{{ old('lab_test') }}" placeholder="Type here..."></textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Treatments</h5>
		</div>
		<div class="padded-full">
		    <textarea name="treatment" value="{{ old('treatment') }}" placeholder="Type here..."></textarea> 
		</div>
		<div class="padded-full">
		    <button type="submit" class="btn fit-parent primary">Save Clinical History</button>
		</div>
	</form>
@endsection