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
				<a href="{{ route('labs.edit', $lab->id) }}">{{++$key}}. {{$lab->patient->name}} (since {{ \Carbon\Carbon::parse($lab->created_at)->diffForHumans() }}) @if($lab->status==0) <sup style="color:green">*New</sup> @endif
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