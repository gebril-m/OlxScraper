@extends('app')
@section('content')


<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row gutters">
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<div class="card">
					<div class="card-header">Contact</div>
					<div class="card-body">
						@include('includes.error_messages')
						<form action="" method="post" enctype="multipart/form-data">
							
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Name</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Name " value="{{old('name')}}" required>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Phone</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Phone " value="{{old('name')}}" required>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Company</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Company " value="{{old('name')}}" required>
								</div>	
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Description</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Description " value="{{old('name')}}" required>
								</div>								
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Category</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Category " value="{{old('name')}}" required>
								</div>								

								

							</div>
							
							<button type="submit" class="btn btn-primary">add</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
				<div class="card">
					<div class="card-header">Extract</div>
					<div class="card-body">
						@include('includes.error_messages')
						<form action="" method="post" enctype="multipart/form-data">
							
							<div class="form-row" style="margin-top: -16px;">
								<div class="form-group col-md-10">
									<label for="inputEmail4" class="col-form-label">search link</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Name " value="{{old('name')}}" required>

								</div>
								<div class="form-group col-md-2" style="    color: white;padding-left: 15px;padding-top: 36px;font-size: 31px;">
									<span class="icon-plus2" style="cursor: pointer;background-color: #659087;" onclick="plus_link($(this))"></span>
								</div>	
								

							</div>
							<div class="form-row" style="margin-top: -11px;">
								<div class="form-group col-md-4">
									<div class="form-check"  style="margin-top: -5px;">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" checked="" required="">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Check if exists in contact base</span>
										</label>
									</div>
									<div class="form-check"  style="margin-top: -18px;">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" required="">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Check if exists in Tab</span>
										</label>
									</div>
									<div class="form-check" style="margin-top: -18px;">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" required="">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Check if has phone</span>
										</label>
									</div>
								</div>
								<div class="form-group col-md-8">
									<button type="button" class="btn btn-primary">Start</button>
									<button type="button" class="btn btn-dark">Pause</button>
									<button type="button" class="btn btn-secondary">Update</button>
									<button type="button" class="btn btn-success">Export</button>
								</div>
								<div class="form-group col-md-12" style="    margin-top: -25px;">
									<table class="table table-bordered table-responsive">
										<thead>
											<tr>
												<th>Current Page</th>
												<th>Opened Ads</th>
												<th>Returned Ads</th>
												<th>Total Ads</th>
												<th>Total Pages</th>
												<th>Status</th>
												
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row">1</th>
												<td>10</td>
												<td>5</td>
												<td>7</td>
												<td>120</td>
												<td>Extracting.......</td>
												
											</tr>
											
										</tbody>
									</table>
								</div>
							</div>
								

							</div>
							
							
						</form>
					</div>
				</div>
			</div>
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header" style="margin-bottom: -12px;margin-top: -1px;">Advertisings</div>
					<div class="card-body">

						<table id="basicExample" class="table table-striped table-bordered" style="margin-top: -12px;">
							<thead>
								<tr>
									<th>Title</th>
									<th>phone</th>
									<th>price</th>
									<th>area</th>
									<th>rooms</th>
									<th>floor</th>
									<th>business type</th>
									
									<th>Created At</th>
									
								</tr>
							</thead>
							<tbody>
								@foreach($advertisings as $advertising)
								<tr>
									<td><a href="{{url('/scraping/show/'.$advertising->id)}}" style="color: blue;">{{$advertising->title}}</a></td>
									<td>{{$advertising->phone}}</td>
									<td>{{$advertising->price}}</td>
									<td>{{$advertising->area}}</td>
									<td>{{$advertising->rooms}}</td>
									<td>{{$advertising->floor}}</td>
									<td>{{$advertising->type}}</td>
									<td>{{$advertising->advertisings_date}}</td>
									
								</tr>
								@endforeach
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- END .main-content -->
</div>


@endsection
@push('js')

<script type="text/javascript">
	function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_preview').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#photo_user").change(function(){
        readURL(this);
    });
</script>

@endpush