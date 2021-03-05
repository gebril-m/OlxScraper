@extends('app')
@section('content')

@if(session()->has('success'))
<div class="notify-notifications">
	<div id="notes" class="notify notify-notes"></div>
	<div id="messages" class="notify notify-messages"><div class="note note-success note-1"><span class="image"><i class="icon-info-outline"></i></span><button type="button" class="remove"></button><div class="content"><strong class="title">Hello</strong>{{session('success')}}</div></div></div>
				
</div>
@endif
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
						<h5>Advertising</h5>
						<h6 class="sub-heading">{{$advertising->title}}</h6>
					</div>
				</div>
				
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
					<div class="card-header"><h4>{{$advertising->title}}</h4> <p>{{$advertising->advertisings_date}}</p>
						<a href="{{$advertising->link}}" target="_blank">{{$advertising->link}}</a>
					</div>
					<div class="card-body">
						<table class="table table-bordered table-responsive">
							<thead>
								<tr>
									@if($advertising->price)
									<th>Price</th>
									@endif
									@if($advertising->area)
									<th>Area</th>
									@endif
									@if($advertising->floor)
									<th>Floor</th>
									@endif
									@if($advertising->rooms)
									<th>Rooms</th>
									@endif
									@if($advertising->supplier_name)
									<th>Name</th>
									@endif
									@if($advertising->address)
									<th>Address</th>
									@endif

									
								</tr>
							</thead>
							<tbody>
								<tr>
									
									@if($advertising->price)
									<td>{{$advertising->price}}</td>
									@endif
									@if($advertising->area)
									<td>{{$advertising->area}}</td>
									@endif
									@if($advertising->floor)
									<td>{{$advertising->floor}}</td>
									@endif
									@if($advertising->rooms)
									<td>{{$advertising->rooms}}</td>
									@endif
									@if($advertising->supplier_name)
									<td>{{$advertising->supplier_name}}</td>
									@endif
									@if($advertising->address)
									<td>{{$advertising->address}}</td>
									@endif
								</tr>
								
							</tbody>
						</table>

						<table class="table table-bordered table-responsive">
							<thead>
								<tr>
									@if($advertising->type)
									<th>Type</th>
									@endif
									@if($advertising->phone)
									<th>Phone</th>
									@endif		

									@if($advertising->website_name)
									<th>Website Name</th>
									@endif
									@if($advertising->aqar_type)
									<th>Aqar Type</th>
									@endif
									@if($advertising->supplier_count_ads)
									<th>Spplier Count Ads</th>
									@endif								
									
								</tr>
							</thead>
							<tbody>
								<tr>
									
									@if($advertising->type)
									<td>{{$advertising->type}}</td>
									@endif

									@if($advertising->phone)
									<td><a href="tel:+02{{$advertising->phone}}">{{$advertising->phone}}</a></td>
									@endif
									@if($advertising->website_name)
									<td>{{$advertising->website_name}}</td>
									@endif
									@if($advertising->aqar_type)
									<td>{{$advertising->aqar_type}}</td>
									@endif
									@if($advertising->supplier_count_ads)
									<td>{{$advertising->supplier_count_ads}}</td>
									@endif
									
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">Details</div>
					<div class="card-body">
						<div class="row gutters">
							@if($advertising->details)
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
								<p>
								{!!$advertising->details!!}
								</p>
							</div>
									
							@endif	
							
							@if($advertising->images != null)
							@foreach($images as $image)
							<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
								<a href="{{$image}}" target="_blank" class="blog-sm">
									<img src="{{$image}}" class="img-fluid blog-thumb" style="width: 320px;">
								</a>
							</div>
							@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>



		</div>
		<!-- Row ends -->

	</div>
	<!-- END .main-content -->
</div>


@endsection