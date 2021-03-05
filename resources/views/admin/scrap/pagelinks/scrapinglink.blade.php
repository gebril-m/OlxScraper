@extends('app')
@section('content')


<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-heading -->
	<header class="main-heading">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
					<div class="page-icon">
						<i class="icon-layers"></i>
					</div>
					<div class="page-title">
						<h5>{{$pagelink->title}}</h5>
						<!-- <h6 class="sub-heading">Welcome to Unify Admin Template</h6> -->
					</div>
				</div>
				<!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="right-actions">
						<a href="{{route('permissions.create')}}" class="btn btn-primary float-right" data-toggle="tooltip" data-placement="left" title="Create Permission">
							create new
						</a>
					</div>
				</div> -->
			</div>
		</div>
	</header>
	<!-- END: .main-heading -->
	<!-- BEGIN .main-content -->
	<div class="main-content">
		
		<!-- Row start -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<!-- <div class="card-header">Advertisings</div> -->
						<div class="card-body">
							<div class="input-group form-group">
								<input type="text" class="form-control" placeholder="Search for..." aria-label="Search for..." value="{{$pagelink->url}}" disabled>
								<span class="input-group-btn">
									<button class="btn btn-secondary" type="button">Start!</button>
								</span>
								<div class="progress">
			                      <div class="progress-bar" role="progressbar" aria-valuenow=""
			                      aria-valuemin="0" aria-valuemax="100" style="width: 0%">
			                        0%
			                      </div>
			                    </div>
			                    <br />
			                    <div id="success">

			                    </div>
			                    <br />
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">Advertisings</div>
					<div class="card-body">

						<table id="basicExample" class="table table-striped table-bordered">
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
								@foreach($pagelink->advertisings as $advertising)
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
		<!-- Row ends -->

	</div>
	<!-- END .main-content -->
</div>


@endsection