@extends('app')
@section('content')

@include('includes.success_messages')
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
						<h5>Projects</h5>
						<!-- <h6 class="sub-heading">Welcome to Unify Admin Template</h6> -->
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					@if(is_super_admin())
					<div class="right-actions">
						<a href="{{route('projects.create')}}" class="btn btn-primary float-right" data-toggle="tooltip" data-placement="left" title="Create Project">
							create new
						</a>
					</div>
					@endif
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
					<div class="card-header">Projects</div>
					<div class="card-body">
						<table id="basicExample" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Name</th>
									<th>image</th>
									
									<th>Created At</th>
									<th>Actions</th>
									
								</tr>
							</thead>
							<tbody>
								@foreach($projects as $project)
								<tr>
									<td>{{$project->title}}</td>
									<td><img src="{{url('upload/projects/'.$project->image)}}" style="height: 70px;width: 70px;"></td>
									<td>{{$project->created_at}}</td>
									<td>
										@if(auth()->user()->hasRole('super-admin'))
										<a href="{{ route('projects.edit', $project->id) }}" class="btn btn-info btn-sm ">
											<span class="icon-pencil3"></span>
										</a>
										<form action="{{ route('projects.destroy', $project->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-danger delete btn-sm "><span class="icon-bin"></span></button>
                                            </form><!-- end of form -->
										@endif
										@if(auth()->user()->hasRole('user'))
											<a href="#" class="btn btn-info btn-sm " title="Buy Project">
												<span class="icon-credit-card"></span>
											</a>
										@endif
									</td>
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

@push('js')

<script>
	

    $('.delete').click(function(e){
        e.preventDefault() // Don't post the form, unless confirmed
        if (confirm('Are you sure?')) {
            // Post the form
            $(e.target).closest('form').submit() // Post the surrounding form
        }
    });


</script>

@endpush