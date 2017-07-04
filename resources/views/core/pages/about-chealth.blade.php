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
		<div class="padded-full text-center">
			<h5 style="padding-top: 25px;"><strong>{{\Tremby\LaravelGitVersion\GitVersionHelper::getVersion() }}:</strong></h5>
			<p>Copyright © {{ $year }}. Cimplicity Apps</p>
			<p>Website: <a href="http://www.chealth.io">www.chealth.io</a></p>
			<p>cHealth is released under the cHealth license which can be found <a href="{{ url('chealth-license') }}">here</a>.</p>
		</div>
		
	</div>
@endsection

@section('partials-script')
	@if(Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection