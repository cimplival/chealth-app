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
	<div class="padded-full">
		<a href="{{ url('main-settings') }}">
	        <button class="btn fit-parent primary" style="margin-top: 10px;">Main settings</button>
	    </a>
	    <a href="{{ url('about-chealth') }}">
	        <button class="btn fit-parent primary" style="margin-top: 10px;">About cHealth</button>
	    </a>
	    <a href="{{ url('upgrade-chealth')}}">
	        <button class="btn fit-parent primary" style="margin-top: 10px;">Upgrade cHealth</button>
	    </a>
	</div>
@endsection

@section('partials-script')
	@if(Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection