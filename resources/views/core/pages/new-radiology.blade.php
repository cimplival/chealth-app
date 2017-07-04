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
	<p class="text-center">Add lab investigation request for <strong>{{ $patient->name}}</strong> below:</p>
</div>
<form method="POST" action="{{ url('radiology-create', $patient->id) }}">
	{{ csrf_field() }}
	<input type="hidden" name="patient_id" value="{{$patient->id}}">
	<div class="padded-full">
		<ul class="list">
	        <li class="divider text-center"><p>Select Radiology</p> </li>
	    </ul>
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
		<input type="text" name="investigation_request" value="{{ old('investigation_request') }}" autocomplete="off" placeholder="Enter investigation request here" autofocus>
	</div>
	<div class="padded-full">
		<button type="submit" class="btn fit-parent primary">Request Radiology Investigation</button>
	</div>
</form>
<div class="padded-full">
	<a href="{{ url('investigations', $patient->id) }}"><button class="btn fit-parent">Go Back</button></a>
</div>
@endsection

@section('partials-script')
@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
@include('core.partials.notify-script')
@endif
@endsection