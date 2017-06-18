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
		    <h5 class="pull-right">Complaints</h5>
		</div>
		<div class="padded-full">
		    <textarea name="complaint" autofocus>{{$clinical->complaint}}</textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">PMS History</h5>
		</div>
		<div class="padded-full">
		    <textarea name="pmshx">{{$clinical->pmshx}}</textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Lab Tests</h5>
		</div>
		<div class="padded-full">
		    <textarea name="lab_test">{{$clinical->lab_test}}</textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Treatments</h5>
		</div>
		<div class="padded-full">
		    <textarea name="treatment">{{$clinical->treatment}}</textarea> 
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