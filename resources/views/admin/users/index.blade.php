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
						<h5>Users</h5>
						<!-- <h6 class="sub-heading">Welcome to Unify Admin Template</h6> -->
					</div>
				</div>
				<div class="col-xl-4 col-lg-4 col-md-4 col-sm-4">
					<div class="right-actions">
						<a href="{{route('users.create')}}" class="btn btn-primary float-right" data-toggle="tooltip" data-placement="left" title="Create user">
							create new
						</a>
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
					<div class="card-header">users</div>
					<div class="card-body">
						<table id="basicExample" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>Name</th>
									<th>email</th>

									<th>Role</th>
									<th>image</th>
									
									<th>Actions</th>
									
								</tr>
							</thead>
							<tbody>
								@foreach($users as $user)
								<tr>
									<td>{{$user->name}}</td>
									<td>{{$user->email}}</td>
									<td>{{$user->roles->pluck('name')->first()}}</td>
									<td><img src="{{url('upload/users/'.$user->image)}}" style="height: 70px;width: 70px;"></td>
									<td>
										@if(!$user->hasRole('super-admin'))
										<a href="{{ route('users.edit', $user->id) }}" class="btn btn-info btn-sm ">
											<span class="icon-pencil3"></span>
										</a>
										<form action="{{ route('users.destroy', $user->id) }}" method="post" style="display: inline-block">
                                                {{ csrf_field() }}
                                                {{ method_field('delete') }}
                                                <button type="submit" class="btn btn-danger delete btn-sm "><span class="icon-bin"></span></button>
                                            </form><!-- end of form -->
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