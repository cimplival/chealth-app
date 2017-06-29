@extends('layouts.app')

@section('partials')

	@if (Session::has('success'))
		@include('core.partials.success')
	@endif

@endsection

@section('body')
    <div class="padded-full">
		<ul class="list">
			@foreach($labs as $key=>$lab)
			<li class="padded-full">
				<a href="{{ route('labs.edit', $lab->id) }}">{{++$key}}. {{$lab->patient->name}} (since {{ \Carbon\Carbon::parse($lab->created_at)->diffForHumans() }})
				</a>
			</li>
			@endforeach
		</ul>
	</div>
	<div class="padded-full">
		<ul class="list">
	        <li class="divider text-center"><p>Past Lab Investigations</p> </li>
	    </ul>
		<ul class="list">
			@foreach($past_labs->reverse() as $lab)
				<li class="padded-full">
					<a href="{{ route('labs.edit', $lab->id) }}">{{$lab->patient->name}} (since {{ \Carbon\Carbon::parse($lab->created_at)->diffForHumans() }})
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