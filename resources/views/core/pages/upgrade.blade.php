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
		<div class="padded-full">
				<h5 style="padding-top: 25px;"><strong>cHealth Upgrade:</strong></h5>
					<p>To successfully make the upgrade, kindly make sure that the slimbox (i.e. microserver) is connected to the internet via LAN or USB Tethering.</p>
					<p>Upon upgrading cHealth, all your current information will be retained. Additional features and a better User experience will be added to the entire application.</p>
				<h5 style="padding-top: 25px;"><strong>cHealth License:</strong></h5>
					<p>
					Your use of both cHealth software or hardware products will be based on the software license and other terms and conditions in effect for the product at the time of purchase.
					</p>
					<p>
						Please be aware that the software license that accompanies the product at the time of purchase may differ from the version of the license of the upgraded version of cHealth. The current version of the the license can be found <a href="{{ url('chealth-license') }}">here</a>.
					</p>
		</div>
		<a href="{{ url('update-chealth') }}">
			<button class="btn fit-parent primary">
				Upgrade cHealth
				<i class="icon icon-sync-problem with-circle"></i>
			</button>
		</a>
	</div>
	<div class="padded-full">
		<a href="{{ url('settings') }}" style="margin-top: 20px;"><button class="btn fit-parent">Go Back</button></a>
	</div>
@endsection

@section('partials-script')
	@if(Session::has('errors') || Session::has('error') || Session::has('info') || Session::has('success'))
		@include('core.partials.notify-script')
	@endif
@endsection