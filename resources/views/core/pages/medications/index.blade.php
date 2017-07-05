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
<form method="POST" action="{{ url('search-medication') }}">
{{ csrf_field() }}
	<div class="padded-full">
		<input type="text" name="search" placeholder="Search medication here...(out of {{ $no_of_medications }} @if($no_of_medications==1) medication @else medications @endif)" autocomplete="off" autofocus/>
	</div>
	<div class="padded-full">
		<button type="submit" class="btn fit-parent primary">Search</button>
	</div>
</form>
<div class="padded-full">
	<ul class="list" style="padding: 20px 0px 20px 0px;">
		<li class="divider text-center"><p>Medications</p> </li>
	</ul>
</div>

@if($medications)
	<div class="padded-full">
		<ul class="list">
			@foreach($medications->reverse() as $medication)
			<li>
				<a class="padded-list" 
					href="@if($medication->status==1) # @else {{ url('dispense-medication', $medication->id) }}@endif">

					{{ $medication->drug->name }} 
					({{ $medication->quantity }} x {{ $medication->times_a_day }}  x {{ $medication->no_of_days }})

					@if($medication->status==1)
						<span style="color:green;">&#10003;</span> 
					@else
						<span style="color:red;"> &#x2715; </span>
					@endif 
				</a>
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