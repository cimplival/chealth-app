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
        <ul class="list">
            <li><strong>Drug Name:</strong> {{ $drug->name }}</li>
            <li><strong>Formulation:</strong> {{ $drug->formulation->name }}</li>
            <li><strong>In Stock:</strong> {{ $drug->stock }}</li>
        </ul>
    </div>
    <div class="padded-full">
    	<ul class="list">
	        <li class="divider text-center"><p>Management</p> </li>
	    </ul>
    </div>
    <div class="padded-full">
    	<ul class="list">
	        <li>
	            <i class="pull-right icon icon-expand-more"></i>
	            <a href="#" class="padded-list">Add Quantity to Stock</a>
	            <div class="accordion-content bd-clinical">
	                <div class="padded-top">
	                <form method="POST" action="{{ url('add-stock', $drug->id) }}">
	                {{ csrf_field() }}
	                	<div class="padded-full">
							<input type="text" name="quantity" autocomplete="off" placeholder="Quantity to be added" style="padding-left: 20px;">
					    </div>
					    <div class="padded-full">
					   		<button type="submit" class="btn fit-parent primary">Add Quantity</button>
					    </div>
					</form>
	                </div>
	            </div>
	        </li>
	        <li>
	            <i class="pull-right icon icon-expand-more"></i>
	            <a href="#" class="padded-list">Remove Quantity from Stock</a>
	            <div class="accordion-content bd-clinical">
	                <div class="padded-top">
	                <form method="POST" action="{{ url('remove-stock', $drug->id) }}">
	                {{ csrf_field() }}
	                	<div class="padded-full">
							<input type="text" name="quantity" autocomplete="off" placeholder="Quantity to be removed" style="padding-left: 20px;">
					    </div>
					    <div class="padded-full">
					   		<button type="submit" class="btn fit-parent primary">Remove Quantity</button>
					    </div>
					</form>
	                </div>
	            </div>
	        </li>
	    </ul>
    </div>
    <div class="padded-full">
	    <a href="{{ url('delete-drug', $drug->id) }}"><button class="btn fit-parent negative">Delete Drug</button></a>
	    <a href="{{ url('pharmacy') }}"><button class="btn fit-parent primary" style="margin-top: 10px;">Go Back</button></a>
    </div>
@endsection

@section('partials-script')
	@if(Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
	@include('core.partials.notify-script')
	@endif
@endsection