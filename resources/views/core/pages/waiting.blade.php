@extends('layouts.app')

@section('partials')

	@if (Session::has('success'))
		@include('core.partials.success')
	@endif

@endsection

@section('body')
    <div class="padded-full">
		<ul class="list">
			@foreach($waitings as $key=>$waiting)
			<li class="padded-full">
				<a href="{{ url('consult', $waiting->patient->id) }}">{{++$key}}. {{$waiting->patient->name}} (since {{ \Carbon\Carbon::parse($waiting->created_at)->diffForHumans() }})
				</a>
			</li>
			@endforeach
		</ul>
	</div>
	<div class="padded-full">
		<ul class="list">
	        <li class="divider text-center"><p>Past Patients</p> </li>
	    </ul>
		<ul class="list">
			@foreach($past_waitings->reverse() as $waiting)
			<li class="padded-full">
				<a href="{{ url('view', $waiting->patient->id) }}">{{$waiting->patient->name}} (since {{ \Carbon\Carbon::parse($waiting->created_at)->diffForHumans() }})
				</a>
			</li>
			@endforeach
		</ul>
	</div>

@endsection

@section('partials-script')
	@if (Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection