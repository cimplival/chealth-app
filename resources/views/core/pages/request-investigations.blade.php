@extends('layouts.app')

@section('partials')

	@if (Session::has('success'))
		@include('core.partials.success')
	@endif

@endsection

@section('body')
    <div class="padded-full">
		<a href="{{ url('lab-create', $patient->id) }}">
	        <button class="btn fit-parent primary" style="margin-top: 10px;">Lab Investigation</button>
	    </a>
	    <a href="{{ url('radiology-create', $patient->id) }}">
	        <button class="btn fit-parent primary" style="margin-top: 10px;">Radiology Investigation</button>
	    </a>
	</div>
@endsection

@section('partials-script')
	@if (Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection