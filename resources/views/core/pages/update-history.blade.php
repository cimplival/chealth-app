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
	<form method="POST" action="{{ url('update-history') }}">
		{{ csrf_field() }}
		<input type="hidden" name="clinical_id" value="{{ $clinical->id }}">
		<div class="padded-full">
		    <h5 class="pull-right">Chief Complaint</h5>
		</div>
		<div class="padded-full">
		    <textarea name="chief_complaint" placeholder="Chief Complaint" autofocus>{{$clinical->chief_complaint}}</textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Review of System</h5>
		</div>
		<div class="padded-full">
		    <textarea name="review_of_system" placeholder="Review of System">{{$clinical->review_of_system}}</textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">PMSHx:</h5>
		</div>
		<div class="padded-full">
		    <textarea name="pmshx" placeholder="PMSHx">{{$clinical->pmshx}}</textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Investigations (Lab/ X-ray)</h5>
		</div>
		<div class="padded-full">
		    <textarea name="investigations" placeholder="Investigations">{{$clinical->investigations}}</textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Diagnosis</h5>
		</div>
		<div class="padded-full">
		    <textarea name="diagnosis" placeholder="Diagnosis">{{$clinical->diagnosis}}</textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Management</h5>
		</div>
		<div class="padded-full">
		    <textarea name="management" placeholder="Management">{{$clinical->management}}</textarea> 
		</div>
		<div class="padded-full">
		    <button type="submit" class="btn fit-parent primary">Update Clinical History</button>
		</div>
	</form>
@endsection

@section('partials-script')
	@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection