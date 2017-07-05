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
	<form method="POST" action="{{ url('add-drug') }}">
		{{ csrf_field() }}
		<div class="padded-full">
		    <h5 class="pull-right">New drug</h5>
		</div>
		<div class="padded-full">
			<input type="text" name="drug_name" value="{{ old('drug_name') }}" autocomplete="off" placeholder="Enter name of new drug here" autofocus>
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Formulation</h5>
		</div>
		<div class="padded-full">
			<select name="formulation">
				<option selected value='' disabled>Select a formulation</option>
			    @foreach($formulations as $formulation)
				    <option value='{{$formulation->id}}'>{{$formulation->name}}</option>
				@endforeach
			</select>
		</div>
		<div class="padded-full">
		    <h5 class="pull-right">Stock</h5>
		</div>
		<div class="padded-full">
			<input type="text" name="stock" value="{{ old('stock') }}" autocomplete="off" placeholder="Enter stock of new drug here" autofocus>
		</div>
		<div class="padded-full">
		    <button type="submit" class="btn fit-parent primary">Save New Drug</button>
		    <a href="{{ url('pharmacy') }}"><button class="btn fit-parent primary" style="margin-top: 10px;">Go Back</button></a>
		</div>

	</form>
@endsection

@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection