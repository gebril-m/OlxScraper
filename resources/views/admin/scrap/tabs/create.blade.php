@extends('app')
@section('content')


<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">Create Tab</div>
					<div class="card-body">
						@include('includes.error_messages')
						<form action="{{route('tabs.store')}}" method="post">
							@csrf
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Tab Name</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Tab name">
								</div>
							</div>
							
							<button type="submit" class="btn btn-primary">add</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END .main-content -->
</div>


@endsection

@push('js')



@endpush