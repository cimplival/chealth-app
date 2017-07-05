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
	<form method="POST" action="{{ url('add-medication', $clinical->id)}}">
	{{ csrf_field() }}
		@if(count($medications)>0)
			<div class="padded-full">
			    <ul class="list">
			        <li class="divider text-center">Drugs Administered</li>
			    </ul>
			    <ul class="list">
			    	@foreach($medications as $key => $medication)
			        <li>
			        	{{++$key}}. {{ $medication->drug->name }} 
			        	({{ $medication->quantity }} x {{ $medication->times_a_day }} x {{ $medication->no_of_days }})
			        </li>
			        @endforeach
			    </ul>
			    <ul class="list">
			        <li class="divider text-center"></li>
			    </ul>
			</div>
		@endif
		<div class="padded-full">
			<h5 class="pull-right">Select drug from pharmacy</h5>
		</div>
		<div class="padded-full">
			<select name="drug_id" selected>
				<option disabled>Select a drug</option>
				@foreach($drugs as $drug)
				<option value='{{$drug->id}}'>{{ $drug->name}} ({{ $drug->formulation->name }})</option>
				@endforeach
			</select>
		</div>
		<div class="padded-full">
			<h5 class="pull-right">Quantity</h5>
		</div>
		<div class="padded-full">
			<input type="text" name="quantity" autocomplete="off" value="{{ old('quantity') }}" placeholder="Quantity to be Administered" style="padding-left: 20px;">
		</div>
		<div class="padded-full">
			<h5 class="pull-right">Times a day</h5>
		</div>
		<div class="padded-full">
			<select name="times_a_day">
				<option disabled selected>How many times a day</option>
				<option value='1'>1</option>
				<option value='2'>2</option>
				<option value='3'>3</option>
				<option value='4'>4</option>
				<option value='5'>5</option>
			</select>
		</div>
		<div class="padded-full">
			<h5 class="pull-right">For how many days</h5>
		</div>
		<div class="padded-full">
			<input type="text" name="no_of_days" autocomplete="off" value="{{ old('no_of_days') }}" placeholder="Days of Administration" style="padding-left: 20px;">
		</div>
		<div class="padded-full">
			<button type="submit" class="btn fit-parent primary">Administer medication</button>
		</div>
	</form>
	<div class="padded-full">
		<a href="{{ url('consult', $clinical->patient->id) }}"><button class="btn fit-parent" style="margin-top: 10px;">Go Back to Consultation</button></a>
	</div>
@endsection

@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection
