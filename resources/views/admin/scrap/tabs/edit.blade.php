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
											<input type="checkbox" class="custom-control-input contact-base-check" onchange="check_if_exist_in_contact_base()" >
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Check if exists in contact base</span>
										</label>
									</div>
									<div class="form-check"  style="margin-top: -18px;">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input tab-exists" onchange="check_if_exist_in_contact_base()">
											<span class="custom-control-indicator"></span>
											<span class="custom-control-description">Check if exists in Tab</span>
										</label>
									</div>
									<div class="form-check" style="margin-top: -18px;">
										<label class="custom-control custom-checkbox">
											<input type="checkbox" class="custom-control-input phone-exsits" onchange="check_if_exist_in_contact_base()">
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
												<th>Status</th>
												
											</tr>
										</thead>
										<tbody>
											<tr id="details-table">
												<th scope="row" class="current-page-pagination">1</th>
												<td class="opened-ads">0</td>
												<td>0</td>
												<td>0</td>
												<td class="total-pages">0</td>
												<td class="process">no current process</td>
												
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
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12" id="table-ads">
				<div class="card">
					<div class="card-header" style="margin-bottom: -12px;margin-top: -1px;">Advertisings</div>
					<div class="card-body" id="basicExampleTable">

						<table id="basicExample" class="table table-striped table-bordered table-ads" style="margin-top: -12px;">
							<thead>
								<tr>
									<th>Title</th>
									<th>phone</th>
									<th>whatsapp</th>
									<th>price</th>
									<th>Following</th>
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
									<td><a href="call:+02{{$advertising->phone}}"><span class="icon-phone4"></span></a></td>
									<td><a href="https://wa.me/+02{{$advertising->phone}}"><span class="icon-bubble"></span></a></td>
									<td>{{$advertising->price}}</td>
									<td id="following{{$advertising->id}}">
										<select class="form-control" id="checker" style="width: 64%;" onchange="change_following($(this),'{{$advertising->id}}')">
											<option disabled="disabled" selected>following</option>
											<option value="phone_later" @if($advertising->following=='phone_later') 'selected' @endif >phone_later</option>
											<option value="phone_done" @if($advertising->following=='phone_done') 'selected' @endif>phone_done</option>
											<option value="closed" @if($advertising->following=='closed') 'selected' @endif >closed</option>
											<option value="office" @if($advertising->following=='office') 'selected' @endif>office</option>
											
										</select>
										
									</td>
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

	function loading_bar() {
		let i=0
		if (i == 0) {
		    i = 1;
		    var elem = document.getElementById("myBar");
		    var width = 1;
		    var id = setInterval(frame, 10);
		    function frame() {
		      if (width >= 100) {
		        clearInterval(id);
		        i = 0;
		      } else {
		        width++;
		        elem.style.width = width + "%";
		      }
		    }
		  }
	}


	function make_table_loading()
	{
		$('#table-ads').css('padding-left',' 460px')
		$('#table-ads').css('padding-top',' 70px')
		$('#table-ads').css('padding-bottom',' 90px')
		$('#table-ads').css('background-color',' #e9ecef')
		$("#table-ads").html(`<div class="loader"></div>`);
		

		
	}

	function start_scraping(argument) {
		
		//make_table_loading()

		$("input[name^='links']").each(function(){
			$('.dataTables_empty').show();
			get_number_of_pagination($(this).val());
			$('.dataTables_empty').show();
		});
		
		
	}

	function get_number_of_pagination(url)
	{

		//let link="get_number_of_pagination?url="+url;
		$.ajax({
	        type: 'GET',
	        url: 'get_number_of_pagination',
	        data:{'url':url},
	        beforeSend: function() {
	                       
	        },
	        success: function(data) {
	        	
	        	$('.total-pages').html(data.current_count+1);
	        	//make_loop_on_pages(data.url,data.count,data.current_count,data.is_search)
	        	let i =0
	        	data.pagination_pages.forEach(function(page){
	        		i++
	        		get_Ads_Count(page,i)
	        	})
	        	//window.location.reload()
	        	//$(".table-ads").load(location.href + " .table-ads");
	         
	        },
	    })
	}

	function make_loop_on_pages(url,count,current_count,is_search)
	{
		if (count>0) {
			var y=count-current_count
			var x=0
			for(  y; y <= count ; y++) {
				x++
				if(is_search==1){
					get_Ads_Count(url+'&page='+y,x)
				}else{
					// console.log(current_count)
					get_Ads_Count(url+'?page='+y,x)
				}
				
			}
		}
	}
var store_links=[];

	function get_Ads_Count(url,page_number) {
		var url =url;
		
		
		var page_number=page_number;
		$('.current-page-pagination').html(page_number)
		$.ajax({
	        type: 'GET',
	        url: 'get_number_of_ads',
	        data:{'url':url},
	        async: false,
	        beforeSend: function() {
	            
	        },
	        success: function(data) {
	        	//$('.current-page-pagination').html(page_number)
	        	store_links=data.ads_links
	        	let i=0
	        	store_links.forEach(function(link){
	        		i++
	        		var request_store=store_ads(link,i,page_number)
	        		console.log(page_number)
	        		$('#details-table').html(`
							<th scope="row" class="current-page-pagination">${page_number}</th>
								<td class="opened-ads">${i}</td>
								<td>0</td>
								<td>0</td>
								<td class="total-pages">0</td>
							<td class="process">no current process</td>`)
	        		//$("#basicExampleTable").load(" #basicExampleTable");
	        	})
	        	//store_ads(store_links[0],1)
	        	
	        	// if (data.count>0) {
	        	// 	let i=1
	        		
	        	// 	data.ads_links.forEach(function(link){
	        	// 		//store_ads(link,i);
	        			
	        	// 		//i++
	        	// 		//$('.opened-ads').html(i);
	        	// 	})
	        	// }
	        },
	    })
	}

	function store_ads(url,i,page_number)
	{
		// console.log(store_links);
		// var i=i
		// var nextItem=null;
		// var index = store_links.indexOf(url);
		// if(index >= 0 && index < store_links.length - 1)
		//     nextItem = store_links[index + 1]

		

		var request_store=$.ajax({
	        type: 'GET',
	        url: 'store_ads',
	        data:{'url':url},
	        async :false,
	        beforeSend: function() {
	            $('.process').html('Extracting...!')
	        },
	        success: function(data) {
	        	$('.process').html('Success...!')
	        	console.log(data)
	        	$('#details-table').html(`
					<th scope="row" class="current-page-pagination">${page_number}</th>
						<td class="opened-ads">${store_links.indexOf(data.link)}</td>
						<td>0</td>
						<td>0</td>
						<td class="total-pages">0</td>
					<td class="process">no current process</td>`)
	        	// $("#basicExampleTable").load(" #basicExampleTable");
	        	// $('.ads-tbody').prepend(data);
	        	// $('.opened-ads').html(i)
	        	// $('.process').html('success!')
	        	//var table = $('#basicExample').DataTable();
	        	// if (nextItem !== null) {
	        	// 	console.log(nextItem)
	        		
	        	// 	// table.row.add([ data.title, data.phone, data.price , data.rooms , data.floor , data.type , data.created_at]);
	        		
	        	// 	//loading_bar()
	        	// 	store_ads(nextItem , i+1,page_number)
	        	// 	if (index == store_links.length - 1) {
	        	// 		window.location.reload()
	        	// 	}
	        	// }
	        	
	        	
	        	// $(".table-ads").load(location.href + " .table-ads");
	        	//$('.ads-tbody').append(data);
	        	//$(".ads-tbody").load(" .ads-tbody");
	        },
	    })
	    return request_store


	}




	//Check if exists in contact base
	function check_if_exist_in_contact_base()
	{
		let contact_base=0
		let phone=0
		let tab_exists=0
		if ($('.contact-base-check').is(':checked')) {
			contact_base=1
		}
		if ($('.phone-exsits').is(':checked')) {
			phone=1
		}
		if ($('.tab-exists').is(':checked')) {
			tab_exists=1
		}

		$.ajax({
	        type: 'GET',
	        url: 'toggole_check_if_exist_in_contact_base?contact_base='+contact_base+'&phone='+phone+'&tab_exists='+tab_exists,
	        beforeSend: function() {
	            
	        },
	        success: function(data) {
	        	
	        },
	    })
	}

	function reloadTable()
	{


	}

</script>

@endpush

@push('js')

<script>
	function change_following(ele,ads_id)
	{
		url='change_following/'+ads_id+'/'+ele.val();
		$.ajax({
	        type: 'GET',
	        url: url,
	        beforeSend: function() {
	            $('#following'+ads_id).html(
	            	`<div class="buttonload">
					  <i class="fa fa-spinner fa-spin"></i>
					</div>`
							);	            
	        },
	        success: function(data) {
	            $('#following'+ads_id).html(data)
	        },
	    })
	}
</script>


@endpush

@include('admin.scrap.tabs.tab_js')