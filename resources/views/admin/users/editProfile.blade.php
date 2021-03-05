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
	<!-- BEGIN .main-content -->
	<div class="main-content">
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12">
				<div class="card">
					<div class="card-header">Edit User</div>
					<div class="card-body">
						@include('includes.error_messages')
						<form action="{{route('users.update',auth()->user()->id)}}" method="post" enctype="multipart/form-data">
							@csrf
							@method('put')
							<div class="form-row">
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Name</label>
									<input type="text" class="form-control" id="inputEmail4" name="name" placeholder="Name " value="{{ auth()->user()->name }}" required>
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Email</label>
									<input type="text" class="form-control" id="inputEmail4" name="email" placeholder="Email " value="{{ auth()->user()->email }}" required>
								</div>

								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Password</label>
									<input type="password" class="form-control" id="inputEmail4" name="password" placeholder="Password " >
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Confirm Password</label>
									<input type="password" class="form-control" id="inputEmail4" name="password_confirmation" placeholder="Confirm Password " >
								</div>
								<div class="form-group col-md-6">
									<label for="inputEmail4" class="col-form-label">Photo</label>
									<input type="file" class="form-control"  name="image" id="image" >
									
								</div>
								<div class="form-group col-md-6">
									
									<img id="image_preview" src="{{url('upload/users/'.auth()->user()->image)}}" width="100" style="max-height: 95px;" >
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