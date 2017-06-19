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
<form method="POST" action="{{ url('update-patient') }}">
	{{ csrf_field() }}
	<input type="hidden" name="patient_id" value="{{ $patient->id }}">
	<div class="padded-full">
		<input type="text" name="op_no" value="{{ $patient->op_no }}" autofocus>
	</div>
	<div class="padded-full">
		<input type="text" name="name" value="{{ $patient->name }}">
	</div>
	<div class="padded-full">
		<input type="text" name="age" value="{{ $patient->age }}">
	</div>
	<div class="padded-full">
		<ul class="list">
			<li class="padded-for-list">
				<label class="radio">
					<input type="radio" name="gender" value="Male" @if($patient->gender=="Male") checked @endif/>
					Male
					<span></span>
				</label>
			</li>
			<li class="padded-for-list">
				<label class="radio">
					<input type="radio" name="gender" value="Female" @if($patient->gender=="Female") checked @endif/>
					Female
					<span></span>
				</label>
			</li>
		</ul>
	</div>
	<div class="padded-full">
		<input type="text" name="phone" value="{{ $patient->phone }}">
	</div>
	<div class="padded-full">
		<button type="submit" class="btn fit-parent">Update Patient</button>
	</div>
</form>
@endsection

@section('partials-script')
	@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection