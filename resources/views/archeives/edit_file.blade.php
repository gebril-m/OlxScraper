@extends('app')
@push('styles')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap.min.css">
  <style>
        .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
    </style>
@endpush
@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-4">
        

        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#CopyModal" style="display: none;" id="copy" onclick="copy()">
                 <i class="fa fa-folder"></i>Copy</button>

        
        
      </div><!-- /.col -->
      <div class="col-sm-4">
        <h1 class="m-0">{{$file->name}}</h1>
      </div><!-- /.col -->

      
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card" style="padding: 18px">
          
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <form  action="{{route('update_file')}}"  method="POST">
              @csrf
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">name</label>
                  <textarea class="form-control" name="content" >{{$file_content}}</textarea>
                </div>
                
              </div>
              <input type="hidden" name="id" value="{{$file->id}}">

              <div class="card-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
              </div>
            </form>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</div>

 

@endsection


@push('js')
<script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
@include('archeives.datatables')
<script>
  CKEDITOR.replace( 'content' );
</script>





@endpush