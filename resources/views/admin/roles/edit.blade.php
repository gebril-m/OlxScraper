@extends('app')
@section('content')


<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">Edit Role : {{$role->name}}</div>
					<div class="card-body">
						@include('includes.error_messages')
						<form action="{{route('roles.update',$role->id)}}" method="post">
							@csrf
							@method('put')
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Role</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Role name " value="{{$role->name}}">
								</div>
							</div>
							<hr>
							<h5>Choose Permissions</h5>
							<div class="form-check" style="padding-top: 20px;">
								@foreach($permissions as $permission)
								<label class="custom-control custom-checkbox">
									<input type="checkbox" class="custom-control-input" name="permissions[]" value="{{$permission->id}}" @if($role->hasPermissionTo($permission->name)) checked @endif >
									<span class="custom-control-indicator"></span>
									<span class="custom-control-description">{{$permission->name}}</span>
								</label>
								@endforeach
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