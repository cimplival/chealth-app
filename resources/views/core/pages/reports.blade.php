@extends('layouts.app')

@section('partials')

	@if (Session::has('success'))
		@include('core.partials.success')
	@endif

@endsection

@section('body')
    <div class="padded-full">
		<ul class="list">
			<li><a href="{{ url('moh-reports') }}">MOH 705 Reports</a></li>
			<li><a href="{{ url('outpatient-reports') }}">Outpatient Report</a></li>
		</ul>
	</div>
@endsection

@section('partials-script')
	@if (Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection