@extends('app')
@section('content')

@include('includes.success_messages')
<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row gutters">
			<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
				<div class="card">
					<div class="card-header">Tab</div>
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
									<label for="inputEmail4" class="col-form-label">Category</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Category " value="{{old('name')}}" required>
								</div>								
								<div class="form-group col-md-12">
									<label for="inputEmail4" class="col-form-label">Description</label>
									<textarea class="form-control" id="inputEmail4" name="description" placeholder="Description "></textarea>
									
								</div>								

								

							</div>
							
							<button type="submit" class="btn btn-primary" style="width: 100%;">add</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-xl-8 col-lg-8 col-md-8 col-sm-8">
				<div class="card">
					<div class="card-header">Extract</div>
					<div class="card-body">
						@include('includes.error_messages')
						<form action="" method="get" enctype="multipart/form-data">
							<!-- <form action="{{url('olx-scraping')}}" method="get" enctype="multipart/form-data"> -->
							
							<div class="form-row" style="margin-top: -16px;">
								<div class="form-group col-md-10">
									<label for="inputEmail4" class="col-form-label">Tab Name</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Name " value="{{old('name')}}" >

								</div>								

							</div>

							<div class="form-row" id="link-container" style="margin-top: -16px;">
								<div class="form-group col-md-10">
									<label for="inputEmail4" class="col-form-label">search link</label>
									<input type="text" class="form-control" id="inputEmail4" name="links[]" placeholder="Url "  required>

								</div>
								<div class="form-group col-md-2" style="    color: white;padding-left: 15px;padding-top: 36px;font-size: 31px;">
									<span class="icon-plus2" style="cursor: pointer;background-color: #659087;" onclick="plus_link($(this))"></span>
								</div>	
								

							</div>
							<div class="form-row" style="margin-top: -11px;">
								<div class="form-group col-md-4">
									<div class="form-check"  style="margin-top: -5px;">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" checked="" >
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Check if exists in contact base</span>
										</label>
									</div>
									<div class="form-check"  style="margin-top: -18px;">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" >
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Check if exists in Tab</span>
										</label>
									</div>
									<div class="form-check" style="margin-top: -18px;">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input" >
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Check if has phone</span>
										</label>
									</div>
								</div>
								<div class="form-group col-md-8">
									<button type="button" class="btn btn-primary" onclick="start_scraping()">Start</button>
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
												<!-- <th>Status</th> -->
												
											</tr>
										</thead>
										<tbody>
											<tr>
												<th scope="row" class="current-page-pagination">1</th>
												<td class="opened-ads">0</td>
												<td>5</td>
												<td>0</td>
												<td class="total-pages">0</td>
												<!-- <td class="process">no current process</td> -->
												
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
							<tbody class="ads-tbody">
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

<script>
	
	function plus_link(ele)
	{
		$('#link-container').append(`
				<div class="form-group col-md-10">
					<label for="inputEmail4" class="col-form-label">search link</label>
					<input type="text" class="form-control" id="inputEmail4" name="links[]" placeholder="Url "  required>

				</div>
				<div class="form-group col-md-2" style="    color: white;padding-left: 15px;padding-top: 36px;font-size: 31px;">
					<span class="icon-plus2" style="cursor: pointer;background-color: #659087;" onclick="plus_link($(this))"></span>
				</div>`);
		ele.parent().html(`<span class="icon-times" style="cursor: pointer;background-color: #a63434;" onclick="remove_link($(this))"></span>`);
	}

	function remove_link(ele)
	{
		ele.parent().prev().hide();
		ele.parent().hide();
	}

	function start_scraping(argument) {
		$("input[name^='links']").each(function(){

			var ads_count=0
			var get_number_of_pagination_var=get_number_of_pagination($(this).val());

			if (get_number_of_pagination_var>0) {

				for (var i = 0; i <= get_number_of_pagination_var; i++) {

					ads_count=ads_count+53
					if (i==0) {
						save_data($(this).val(),ads_count)
					}else{
						
						save_data($(this).val()+'?page='+i,ads_count)

					}

					//$('.opened-ads').html(ads_count)

				}
			}

		});
		
	}

	function get_number_of_pagination(url)
	{
		var count
		let link="get_number_of_pagination?url="+url;
		$.ajax({
	        type: 'GET',
	        url: link,
	        async: false,
	        beforeSend: function() {
	                       
	        },
	        success: function(data) {
	        	count=data.count
	        	$('.total-pages').html(data.count);
	        	//make_loop_on_pages(data.url,data.count)
	         
	        },
	    })
	    return count
	}

	

	function save_data(url,current)
	{
		$.ajax({
	        type: 'GET',
	        url: '{{url("tabs/save_data_for_one_link")}}',
	        dataType:'json',
	        data: { 'url': url,'_token':"{{csrf_token()}}" },
	        async: false,
	        beforeSend: function() {
	                       
	        },
	        success: function(data) {
	        	console.log(data)
	            $('.opened-ads').html(20)
	         
	        },
	    })

		
	}








////////////////////////////////////////
	function make_loop_on_pages(url,count)
	{
		if (count>0) {
			for (var i = 0; i <= count; i++) {

				get_Ads_Count(url+'?page='+i,i)
			}
		}
	}

	function get_Ads_Count(url,page_number) {
		var url =url;
		let link="get_number_of_ads?url="+url;

		var page_number=page_number;

		$.ajax({
	        type: 'GET',
	        url: link,
	        beforeSend: function() {
	            
	        },
	        success: function(data) {
	        	$('.current-page-pagination').html(page_number)
	        	$('.opened-ads').html(page_number*53)
	        	if (data.ads_links.length>0) {
	        		let i=1
	        		data.ads_links.forEach(function(link){
	        			
	        			store_ads(link,i)
	        			i++
	        		})
	        	}
	        },
	    })
	}

	function store_ads(url,i)
	{	
		
		let link="store_ads?url="+url;
		var i=i
		
		$.ajax({
	        type: 'GET',
	        url: link,
	        beforeSend: function() {
	            
	        },
	        success: function(data) {
	        	
	        	$('.ads-tbody').append(data);
	        },
	    })
	}


</script>

@endpush

@include('admin.scrap.tabs.tab_js')