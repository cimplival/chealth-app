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
<form method="POST" action="{{ url('outpatient-reports') }}">
{{ csrf_field() }}
	<div class="padded-full">
		<select name="month">
			<option selected value=''>---Select a Month---</option>
		    <option value='0'>January</option>
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
			<option selected value=''>---Select Year---</option>
		    <option value='2017'>2017</option>
		    <option value='2018'>2018</option>
		</select>
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
	<script type="text/javascript">
		function register()
		{	
			document.getElementById("register_status").value = "1";
			document.getElementById('register_form').submit();
		}
	</script>
@endsection