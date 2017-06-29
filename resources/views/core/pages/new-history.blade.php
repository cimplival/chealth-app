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
			<select name="classify_disease">
				<option selected value='' disabled>Select a disease classification</option>
			    @foreach($diseases as $disease)
				    <option value='{{$disease->id}}'>{{$disease->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="padded-full">
		    <ul class="list">
		        <li class="">
		            <label class="checkbox">
		                <input type="checkbox" name="reattendance" value="1">
		                	Select if Patient Reattendance
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

@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection