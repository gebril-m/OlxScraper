@extends('app')
@section('content')


<!-- BEGIN .app-main -->
<div class="app-main">
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">Create User</div>
					<div class="card-body">
						@include('includes.error_messages')
						<form action="{{route('users.store')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Name</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Name " value="{{old('name')}}" required>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Email</label>
									<input type="text" class="form-control" id="inputEmail4" name="email" placeholder="Email " value="{{old('email')}}" required>
								</div>

								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Password</label>
									<input type="password" class="form-control" id="inputEmail4" name="password" placeholder="Password " required>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Confirm Password</label>
									<input type="password" class="form-control" id="inputEmail4" name="password_confirmation" placeholder="Confirm Password " required>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Photo</label>
									<input type="file" class="form-control"  name="image" id="image" >
									
								</div>
								<div class="form-group col-md-6">
									
									<img id="image_preview" src="https://www.nicepng.com/png/detail/413-4138963_unknown-person-unknown-person-png.png" width="100" style="max-height: 95px;" >
								</div>

								<div class="form-group col-md-6">

									<label for="inputEmail4" class="col-form-label">Role</label>
									<select name="role" class="form-control" required>
										@foreach($roles as $role)
										<option value="{{$role->id}}" >{{$role->name}}</option>
										@endforeach
									</select>
									
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