@extends('layouts.app')

@section('body')
	<form method="POST" action="{{ url('new-history') }}">
		{{ csrf_field() }}
		<input type="hidden" name="patient_id" value="{{ $patient->id }}">
		<div class="padded-full">
		    <h5 class="pull-right">Chief Complaint</h5>
		</div>
		<div class="padded-full">
		    <textarea name="chief_complaint" value="{{ old('chief_complaint') }}" placeholder="Type here..." autofocus></textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Review of System</h5>
		</div>
		<div class="padded-full">
		    <textarea name="review_of_system" value="{{ old('review_of_system') }}" placeholder="Type here..."></textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">PMSHx:</h5>
		</div>
		<div class="padded-full">
		    <textarea name="pmshx" value="{{ old('pmshx') }}" placeholder="Type here..."></textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Investigations (Lab/X-ray)</h5>
		</div>
		<div class="padded-full">
		    <textarea name="investigations" value="{{ old('investigations') }}" placeholder="Type here..."></textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Diagnosis</h5>
		</div>
		<div class="padded-full">
		    <textarea name="diagnosis" value="{{ old('diagnosis') }}" placeholder="Type here..."></textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Management</h5>
		</div>
		<div class="padded-full">
		    <textarea name="management" value="{{ old('management') }}" placeholder="Type here..."></textarea>
		</div>
		<div class="padded-full">
		    <ul class="list">
		        <li class="">
		            <label class="checkbox">
		                <input type="checkbox" name="reattendance" value="1">
		                Patient Reattendance? (Check if True)
		                <span></span>
		            </label>
		        </li>
		    </ul>
		</div>
		<div class="padded-full">
		    <button type="submit" class="btn fit-parent primary">Save Clinical History</button>
		</div>
	</form>
@endsection