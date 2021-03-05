@extends('app')
@section('content')




<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">Create Page Link</div>
					<div class="card-body">
						@include('includes.error_messages')
						<form action="{{route('pagelinks.store')}}" method="post">
							@csrf
							<div class="form-row">
								<div class="form-group col-md-2">
									<label for="inputEmail4" class="col-form-label">Title</label>
									<input type="text" class="form-control" id="inputEmail4" name="title" placeholder="Title">
								</div>
								<div class="form-group col-md-10">
									<label for="inputEmail4" class="col-form-label">Page Link</label>
									<input type="text" class="form-control" id="inputEmail4" name="url" placeholder="Page Link">
								</div>
							</div>
							<div class="form-row">
								
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