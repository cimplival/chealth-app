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
<form id="register_form" method="POST" action="">
{{ csrf_field() }}
	<div class="padded-full">
		<select>
			<option value=''>--Select Month--</option>
		    <option selected value='January'>January</option>
		    <option value='February'>February</option>
		    <option value='March'>March</option>
		    <option value='April'>April</option>
		    <option value='May'>May</option>
		    <option value='June'>June</option>
		    <option value='July'>July</option>
		    <option value='August'>August</option>
		    <option value='September'>September</option>
		    <option value='October'>October</option>
		    <option value='November'>November</option>
		    <option value='December'>December</option>
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