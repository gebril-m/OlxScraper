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
        .dataTables_filter{  margin-left: 25pc;  }
    </style>
@endpush
@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-4">
        @if(session()->has('error'))
            <div class="alert alert-danger">
                <ul>
                    
                        <li>{{ session()->get('error') }}</li>
                    
                </ul>
            </div>
        @endif
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if(session()->get('folder_id')>0)
          <a href="{{get_back_folder_path() }}"> <i class="fa fa-angle-double-left" style="font-size: 35px;margin-right: 23px;"></i>  </a>
        @else
           <i class="fa fa-angle-double-left" style="font-size: 35px;margin-right: 23px;opacity:.3;pointer-events: none;cursor: default;"></i>  
        @endif

        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#CopyModal" style="display: none;" id="copy" onclick="copy()">
                 Copy</button>

        <button style="opacity:.3;pointer-events: none;cursor: default;" type="button" class="btn btn-info " data-toggle="modal" id="nocopy">
                 Copy</button>

        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#CopyModal" style="display: none;" id="cut" onclick="copy(true)">
                 Cut</button>

        <button style="opacity:.3;pointer-events: none;cursor: default;" type="button" class="btn btn-info " data-toggle="modal" id="nocut">
                 Cut</button>
        
      </div><!-- /.col -->
      <div class="col-sm-4">
        <ol class="breadcrumb float-sm-right">
          <?php  
                $x='app/Ainshams/';
          ?>
          <li class="breadcrumb-item"><a href="{{url('index')}}">Index</a></li>
          @foreach(path_array() as $folderName)
          <li class="breadcrumb-item"><a href="{{url('view-folder?path='.$x.$folderName)}}">{{$folderName}}</a></li>
          <?php $x .= $folderName.'/'; ?>
          @endforeach
          <!-- <li class="breadcrumb-item active">Dashboard v3</li> -->
        </ol>
      </div>

      <div class="col-sm-2">
       
       <button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal">
                 <i class="fa fa-folder"></i>إضافة مجلد </button>
      </div><!-- /.col -->
      <div class="col-sm-2">
        <button type="button" class="btn btn-info " data-toggle="modal" data-target="#fileModal"> <i class="fa fa-file"></i> إضافة ملف </button>
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
            <table id="example" class="table table-striped table-bordered" style="width:100%;">
              <thead>
                  <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <th>check</th>
                  </tr>
              </thead>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
  </div>
</div>

 
@include('archeives.modals')
@endsection


@push('js')

<!-- Bootstrap 4 -->
<script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap.min.js"></script>
<script src="http://malsup.github.com/jquery.form.js"></script>
@include('archeives.datatables')
<script>
//   $(document).ready(function() {
//     $('#example').DataTable();
// } );

function check_folder(element){

  if (element.prop("checked") == true) {
        $('#cut').show();
        $('#copy').show();
        $('#nocopy').hide();
        $('#nocut').hide();
    }
    if ($("#example input:checkbox:checked").length) {
      $('#cut').show();
        $('#copy').show();
        $('#nocopy').hide();
        $('#nocut').hide();
      }else{
        $('#copy').hide();
        $('#cut').hide();
        $('#nocopy').show();
        $('#nocut').show();
      }
    
       var searchIDs = $("#example input:checkbox:checked").map(function(){
          return $(this).val();
        }).get();

       console.log(searchIDs);
 
}
 
function copy($cut=false)
{
  let message = 'Copy Files : ';
  if ($cut) {
    message = 'Cut Files : ';
    $('#cutOrNot').val(1);
  }
  let x = 1;
  var folders = $("#example input:checkbox:checked").map(function(){
          var str = $(this).val();
          str = str.split(",").pop();

          message += str;
          if ($("#example input:checkbox:checked").length>x) {
            message +=','
          }
          x++;
          return str;
        }).get();

  var folders_ids = $("#example input:checkbox:checked").map(function(){
           var str = $(this).val();
            str = str.split(",");
          return str;
        }).get();

var folders_ids = folders_ids.filter(function(el) {
    return el.length && el==+el;
//  more comprehensive: return !isNaN(parseFloat(el)) && isFinite(el);
});


  message='<h1>' + message + '</h1>';

  $('#card_primary2').html(message);
  let a = '{{get_current_folder_path(session()->get("folder_id"))}}';


  $('#pathFolderHidden').val(folders_ids);
  $('#pathFolder').val(a.replace("app/Ainshams/", ""));
}

//File indicator
$(document).ready(function(){

    $('#Upload_file').ajaxForm({
      beforeSend:function(){
        $('#success').empty();
      },
      uploadProgress:function(event, position, total, percentComplete)
      {
        $('.progress-bar').text(percentComplete + '%');
        $('.progress-bar').css('width', percentComplete + '%');
      },
      success:function(data)
      {
        if(data.errors)
        {
          $('.progress-bar').text('0%');
          $('.progress-bar').css('width', '0%');
          $('#success').html('<span class="text-danger"><b>'+data.errors+'</b></span>');
        }
        if(data.success)
        {
          $('.progress-bar').text('Uploaded');
          $('.progress-bar').css('width', '100%');
          $('#success').html('<span class="text-success"><b>'+data.success+'</b></span><br /><br />');
          location.reload(true);
          //$('#success').append(data.image);
        }
      }
    });


});





</script>

@endpush