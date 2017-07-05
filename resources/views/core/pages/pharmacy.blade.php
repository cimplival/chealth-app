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
<form method="POST" action="{{ url('search-drug') }}">
	<div class="padded-full">
			{{ csrf_field() }}
			<input type="text" name="search" placeholder="Search drug here...(out of {{ $no_of_drugs }} @if($no_of_drugs=1) drug @else no_of_drugs @endif)" autocomplete="off" autofocus/>
	</div>
	<div class="padded-full">
		<button type="submit" class="btn fit-parent primary">Search</button>
		<a href="{{ url('add-drug') }}">
			<button class="btn fit-parent primary" style="margin-top: 10px;">Add New Drug</button>
		</a>	
	</div>
</form>
<div class="padded-full">
	<ul class="list" style="padding: 20px 0px 20px 0px;">
		<li class="divider text-center"><p>Stock Management</p> </li>
	</ul>
</div>

@if($drugs)
	<div class="padded-full">
		<ul class="list">
			@foreach($drugs as $drug)
			<li>
				<a class="padded-list" href="{{ url('drug', $drug->id) }}">{{ $drug->name }} ({{ $drug->stock}} {{ $drug->formulation->name }} in stock)</a>
			</li>
			@endforeach
		</ul>
	</div>
@endif

@endsection

@section('partials-script')
@if(Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection