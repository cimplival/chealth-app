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
	<p class="text-center">Choose Radiology Investigation below:</p>
</div>
<form method="POST" action="{{ url('radiology-add', $lab_id) }}">
	{{ csrf_field() }}
	<div class="padded-full">
		<ul class="list">
			@foreach($radios as $radio)
				<li class="">
					<label class="checkbox">
					<input name="radiology[]" type="checkbox" value="{{$radio->id}}">
						{{$radio->name}}
						<span></span>
					</label>
				</li>
			@endforeach
		</ul>
	</div>
	<div class="padded-full">
		<button type="submit" class="btn fit-parent primary">Add Radiology</button>
	</div>
</form>
<div class="padded-full">
	<a href="{{ route('labs.edit', $lab_id) }}"><button class="btn fit-parent">Go Back</button></a>
</div>
@endsection

@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection