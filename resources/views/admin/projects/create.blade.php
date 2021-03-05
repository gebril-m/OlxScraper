@extends('app')
@section('content')


<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">Create Project</div>
					<div class="card-body">
						@include('includes.error_messages')
						<form action="{{route('projects.store')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Title</label>
									<input type="text" class="form-control" id="inputEmail4" name="title" placeholder="Title " value="{{old('title')}}" required>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Slug</label>
									<input type="text" class="form-control" id="inputEmail4" name="slug" placeholder="Slug " value="{{old('slug')}}" required>
								</div>
								<div class="form-group col-md-12">
									<label for="inputEmail4" class="col-form-label">Description</label>
									<textarea class="form-control" name="description">{{old('description')}}</textarea>
									
								</div>
								
								
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Image</label>
									<input type="file" class="form-control"  name="image" id="image" required>
									
								</div>
								<div class="form-group col-md-6">
									
									<img id="image_preview" src="" width="100" style="max-height: 95px;" >
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
