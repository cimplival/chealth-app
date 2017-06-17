@if (count($errors) > 0)
<div class="notification" id="notify-chealth" data-timeout="5000">
	<div class="progress">
		<div class="determinate"></div>
	</div>
	<ol>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ol>
</div>
@endif