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
	<form method="POST" action="{{ url('update-lab', $lab->id) }}">
		{{ csrf_field() }}
		<div class="padded-full">
		    <ul class="list">
		        <li><strong>Outpatient No:</strong> {{ $lab->patient->op_no }}</li>
		        <li><strong>Patient Name:</strong> {{ $lab->patient->name }}</li>
		    </ul>
		</div>
		<input type="hidden" name="lab_id" value="{{$lab->id}}">
		<div class="padded-full">
		    <h5 class="pull-right">Specimen</h5>
		</div>
		<div class="padded-full">
		    <textarea name="specimen" placeholder="Specimen" autofocus>{{$lab->specimen}}</textarea> 
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Investigation Request</h5>
		</div>
		<div class="padded-full">
		    <textarea name="investigation_request" placeholder="Investigation Request">{{$lab->investigation_request}}</textarea> 
		</div>
		<div class="padded-full">
		    <button type="submit" class="btn fit-parent primary">Update Lab Record</button>
		</div>
	</form>
		<div class="padded-full">
		    <a href="{{ url('consult', $lab->patient->id) }}">
                <button class="btn fit-parent">Consult Patient</button>
            </a>
		</div>
@endsection

@section('partials-script')
	@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection