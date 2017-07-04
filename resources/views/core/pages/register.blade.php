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
<form id="register_form" method="POST" action="{{ url('register') }}">
{{ csrf_field() }}
	<input id="register_status" type="hidden" name="register_only" value="0">
	<div class="padded-full">
		<input type="text" name="op_no" value="{{ old('op_no') }}" placeholder="Outpatient/Inpatient No." autocomplete="off" autofocus>
	</div>
	<div class="padded-full">
		<input type="text" name="name" value="{{ old('name') }}" autocomplete="off" placeholder="Patient Name">
	</div>
	<div class="padded-full">
		<input type="text" name="age" value="{{ old('age') }}" autocomplete="off" placeholder="Age">
	</div>
	<div class="padded-full">
		<ul class="list">
			<li class="padded-for-list">
				<label class="radio">
					<input type="radio" name="gender" value="Male" @if(old('gender') == "Male") checked @endif>
					Male
					<span></span>
				</label>
			</li>
			<li class="padded-for-list">
				<label class="radio">
					<input type="radio" name="gender" value="Female" @if(old('gender') == "Female") checked @endif>
					Female
					<span></span>
				</label>
			</li>
		</ul>
	</div>
	<div class="padded-full">
		<input type="text" name="phone" value="{{ old('phone') }}" autocomplete="off" placeholder="Phone">
	</div>
	<div class="padded-full">
		<input type="text" name="physical_address" value="{{ old('physical_address') }}" placeholder="Physical Address">
	</div>
	<div class="padded-full">
		<button type="submit" class="btn fit-parent primary">Register and Queue</button>
	</div>

	<div class="padded-full">
		<button type="submit" onclick="register()" class="btn fit-parent">Register Only</button>
	</div>
</form>
@endsection

@section('partials-script')
	@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
		@include('core.partials.notify-script')
	@endif
	<script type="text/javascript">
		function register()
		{	
			document.getElementById("register_status").value = "1";
			document.getElementById('register_form').submit();
		}
	</script>
@endsection