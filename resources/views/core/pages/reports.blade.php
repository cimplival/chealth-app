@extends('layouts.app')

@section('partials')

	@if (Session::has('success'))
		@include('core.partials.success')
	@endif

@endsection

@section('body')
    <div class="padded-full">
		<ul class="list">
			<li class="padded-full"><a href="{{ url('diseases-reports') }}">Diseases Report</a></li>
			<li class="padded-full"><a href="{{ url('outpatient-reports') }}">Outpatient Report</a></li>
		</ul>
	</div>
@endsection

@section('partials-script')
	@if (Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection