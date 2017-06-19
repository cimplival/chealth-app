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
				<a href="{{ url('view', $waiting->patient->id) }}">{{++$key}}. {{$waiting->patient->name}} (since {{ \Carbon\Carbon::parse($waiting->created_at)->diffForHumans() }})
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