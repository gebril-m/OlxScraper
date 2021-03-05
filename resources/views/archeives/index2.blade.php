@extends('app')
@push('styles')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
 <!--  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap.min.css"> -->



  <style>
        .progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
        .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
        .dataTables_filter{  margin: 0;  }
        th{width:auto !important; text-align:center !important;}
        table{text-align:center;}
        .dataTables_info{text-align: center;}
        .dataTables_paginate{text-align: center;}
        .previous{padding-right:8px;}
        .next{padding-left:8px;}
        .paginate_button {padding-left:6px;cursor: pointer;}
        .current{color:red;font-weight: bolder;}


         
         
        
  </style>
    <link rel="stylesheet" href="{{url('AdminLTE-master/')}}/plugins/jquery-ui/jquery-ui.css">
  
<style>
  #draggable {  padding: 0.5em; float: right;}
  #droppable {  padding: 0.5em; float: right; }
</style>
@endpush
@section('content')


<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-12 col-xs-12">
          <div class=" col-sm-1 col-xs-2">
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

          </div>
      
         <div class="col-sm-9 col-xs-9" style="padding-top:8px;">
              <ol class="breadcrumb">
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
              
          
       
      
      </div><!-- /.col -->
      <div class="col-sm-12 col-xs-12" style="text-align:center">
          
          <div class="col-sm-3 col-xs-3" style="padding:0">
              <button type="button" class="btn btn-info " data-toggle="modal" data-target="#CopyModal" style="display: none;" id="copy" onclick="copy()">
                 Copy</button>

        <button style="opacity:.3;pointer-events: none;cursor: default;" type="button" class="btn btn-info " data-toggle="modal" id="nocopy">
                 Copy</button>
          </div>
          <div class="col-sm-3 col-xs-3"  style="padding:0">
              <button type="button" class="btn btn-info " data-toggle="modal" data-target="#CopyModal" style="display: none;" id="cut" onclick="copy(true)">
                 Cut</button>

        <button style="opacity:.3;pointer-events: none;cursor: default;" type="button" class="btn btn-info " data-toggle="modal" id="nocut">
                 Cut</button>
          </div>
          <div class="col-sm-3 col-xs-3" style="padding:0">
               <button type="button" class="btn btn-info " data-toggle="modal" data-target="#myModal">
                             new folder</button>
          </div>
          <div class="col-sm-3 col-xs-3">
              <button type="button" class="btn btn-info" data-toggle="modal" data-target="#fileModal"> new file</button>
          </div>
               

        
         
         
            
        
        
      </div>
   
      
      
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-12">
        <div class="card" >
          
          <!-- /.card-header -->
          <div class="card-body table-responsive p-0">
            <table id="example2" class="table table-striped table-bordered" style="width:100%;">
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
              <tbody>
                @foreach($archeives as $file)
                  <tr class="my_column {{($file->type=='folder')?'my_column2':''}}" id="record{{$file->id}}" ondragstart="pass_id('{{$file->id}}')" ondrop="pass_folder_id('{{$file->id}}')" >
                    <td>{{ $file->id }}</td>
                    <td>
                      
                        @if($file->type=='folder')
                          <i class="fa fa-folder"></i>
                         <a href="{{url('/view-folder/?path='.$file->path)}}">{{$file->name}}</a>
                        @else
                          <a href="{{'/storage/app/'.$file->path}}">{{$file->name}}</a>
                        @endif
                    
                    
                    </td>
                    <td>{{ $file->type }}</td>
                    <td>
                    @if($file->type=='file' && in_array($file->extension , ['txt','html','php','js','css']))
                      <a href="{{url('/file-edit?id='.$file->id)}}" type="button" class="btn btn-info"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></a>
                    @else
                      <a href="" style="opacity:.3;pointer-events: none;cursor: default;" type="button" class="btn btn-info"><i class="glyphicon glyphicon-pencil" aria-hidden="true"></i></a>
                    @endif

                    </td>
                    <td>
                      <form action="{{route('delete_file', $file->id)}}" method="POST" onclick="return confirm('Are you sure?')">
                        @csrf
                        <input type="submit" name="Delete" class="btn btn-danger sa-warning" value="delete" >
                      </form>
                      <?php
                     //  \Form::open(['url'=>route('delete_file', $file->id), 'class' => 'd-inline', 'onclick' => 'return confirm("Are you sure?")']);
                     // \Form::submit('Delete', ['class' => 'btn btn-danger sa-warning']);
                     // \Form::close();
                     ?>

                    </td>
                    <td>
                      <input type="checkbox" name="archeives[]" onclick="check_folder($(this))" value="{{ $file->id .','. $file->name}}" >
                    </td>
                  </tr>
                @endforeach
              </tbody>
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
<!-- <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script> -->
<!-- DataTables  & Plugins -->
<!-- <script src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap.min.js"></script> -->


  <!-- <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script> -->
@include('archeives.datatables')
<script>
  $(document).ready(function() {
    $('#example2').DataTable();
} );

function check_folder(element){

  if (element.prop("checked") == true) {
        $('#cut').show();
        $('#copy').show();
        $('#nocopy').hide();
        $('#nocut').hide();
    }
    if ($("#example2 input:checkbox:checked").length) {
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
    
       var searchIDs = $("#example2 input:checkbox:checked").map(function(){
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
  var folders = $("#example2 input:checkbox:checked").map(function(){
          var str = $(this).val();
          str = str.split(",").pop();

          message += str;
          if ($("#example2 input:checkbox:checked").length>x) {
            message +=','
          }
          x++;
          return str;
        }).get();

  var folders_ids = $("#example2 input:checkbox:checked").map(function(){
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


var child_id;
var parent_id;
function pass_id(myid) {
  child_id=myid;
}
function pass_folder_id(myid) {
  parent_id=myid;
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
        $('#upload_my_file').css('pointer-events',none)
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




$('.my_column').draggable({ helper: 'clone' });

$('.my_column2').droppable({
    accept : '.my_column',
    drop : function(ev,ui){

      let item=$(ui.draggable.clone);

      console.log(child_id+'   '+parent_id);

      copyToFolder(child_id,parent_id);

    }
})



});


function copyToFolder(new_id,old_id) {
    var url='cut-ajax?copy_in_id='+old_id+'&copy_from_id='+new_id+'&cut=1';
    
    // $.get(url,function(res){
    //     if(res=='success'){
    //       $('#record'+new_id).hide();
    //     }
    // })
    
    $.ajax({
        type: 'GET',
        url: url,
        beforeSend: function() {
            $('.mybody2').hide();
            $('#myLoading').show();
            
        },
        success: function(data) {
            $('#myLoading').hide();
            $('.mybody2').show();
            $('#record'+new_id).hide();
        },
    })
}



// var t_id;
// function allow_drop(ev)
// {
//   ev.preventDefault();
// }

// function drag_start(ev) {
//   t_id=ev.target.id;
// }

// function drop(ev)
// {
//   ev.target.append($('#'+t_id));
// }
// var m_Id;
// function drop(ele,id){
//   ele.draggable();
//   m_Id=id;
// }

// function dragIn(ele) {
//   console.log(m_Id);
//   ele.droppable({
//       drop: function( event, ui ) {
//         $('#'+m_Id).hide();
//       }
//     });
// }

// $( function() {
//     $( "#draggable" ).draggable();
//     $( "#droppable" ).droppable({
//       drop: function( event, ui ) {
//         $( this )
//           .addClass( "ui-state-highlight" )
//           .find( ("#droppable") )
//             .html( $( "#draggable" ) );
//       }
//     });
// });

</script>

@endpush