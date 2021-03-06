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
	<form method="POST" action="{{ url('main-settings') }}">
		{{ csrf_field() }}
		<div class="padded-full">
			<input type="text" name="facility_name" value="{{ $setting->facility_name }}" placeholder="Facility Name" autofocus>
		</div>
		<div class="padded-full">
			<input type="text" name="ward" value="{{ $setting->ward }}" placeholder="Ward">
		</div>
		<div class="padded-full">
			<input type="text" name="sub_county" value="{{ $setting->sub_county }}" placeholder="Sub County">
		</div>
		<div class="padded-full">
			<input type="text" name="county" value="{{ $setting->county }}" placeholder="County">
		</div>
		<div class="padded-full">
			<button type="submit" class="btn fit-parent primary">Update Settings</button>
		</div>
	</form>
	<div class="padded-full">
	    <a href="{{ url('settings') }}"><button class="btn fit-parent">Go Back</button></a>
    </div>
@endsection

@section('partials-script')
	@if(Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection