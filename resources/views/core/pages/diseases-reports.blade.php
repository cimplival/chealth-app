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
<form  method="POST" action="{{ url('diseases-reports') }}">
	{{ csrf_field() }}
	<div class="padded-full">
		<select name="month">
			<option value=''>--Select Month---</option>
		    <option selected value='0'>January</option>
		    <option value='1'>February</option>
		    <option value='2'>March</option>
		    <option value='3'>April</option>
		    <option value='4'>May</option>
		    <option value='5'>June</option>
		    <option value='6'>July</option>
		    <option value='7'>August</option>
		    <option value='8'>September</option>
		    <option value='9'>October</option>
		    <option value='10'>November</option>
		    <option value='11'>December</option>
		</select>
	</div>
	<div class="padded-full">
		<select name="year">
			<option value=''>--Select Year---</option>
		    <option selected value='2017'>2017</option>
		    <option value='2018'>2018</option>
		    <option value='2019'>2019</option>
		    <option value='2020'>2020</option>
		    <option value='2021'>2021</option>
		    <option value='2022'>2022</option>
		    <option value='2023'>2023</option>
		    <option value='2024'>2024</option>
		    <option value='2025'>2025</option>
		    <option value='2026'>2026</option>
		    <option value='2027'>2027</option>
		    <option value='2028'>2028</option>
		    <option value='2029'>2029</option>
		    <option value='2030'>2030</option>
		</select>
	</div>
	<div class="padded-full">
		<ul class="list">
			<li class="padded-for-list">
				<label class="radio">
					<input type="radio" name="period" value="under5" @if(old('period') == "under5") checked @endif>
					Report for Under 5 Years
					<span></span>
				</label>
			</li>
			<li class="padded-for-list">
				<label class="radio">
					<input type="radio" name="period" value="over5" @if(old('period') == "over5") checked @endif>
					Report for Over 5 Years
					<span></span>
				</label>
			</li>
		</ul>
	</div>
	<div class="padded-full">
		<button type="submit" class="btn fit-parent primary">Generate Report</button>
	</div>
</form>
@endsection

@section('partials-script')
	@if (Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection