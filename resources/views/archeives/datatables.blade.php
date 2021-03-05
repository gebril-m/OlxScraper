<script>
	
$(document).ready(function () {

          $('#example').DataTable({
              dom: 'lBfrtip',
              buttons: [
                  { extend: 'print', text: 'طباعه',messageBottom:' <strong>جميع الحقوق محفوظة  Makdak .</strong>'},
                  { extend: 'excel', text: ' اكسيل' },
              ] ,
              "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
              "language": {
                  "search" : "  search :  ",
                  "paginate": {
                      "previous": "previous",
                      "next": "next"
                  },
                  "info":           "show_START_ to_END_ from_TOTAL_ from records",
                  "lengthMenu":     "show_MENU_ from records",
                  "loadingRecords": "Loading...",
                  "processing":     "Loading...",
                  "zeroRecords":    "لا يوجد نتائج",
                  "infoEmpty":      "show0 to 0 of 0 from records",
                  "infoFiltered":   "(showfrom_MAX_ row)",
              } ,
              "processing": true,
              "serverSide": true,
              "ajax": {
                  "url": "{{route('datatables')}}",
                  "type": "GET"
              },
              "columns": [
                  { data: 'id', name: 'id' },
                  { data: 'name', name: 'name' },
                  { data: 'type', name: 'type' },
                  { data: 'edit', name: 'edit', orderable: false, searchable: false},
                  { data: 'delete', name: 'delete', orderable: false, searchable: false},
                  { data: 'checkbox', name: 'checkbox', orderable: false, searchable: false}

              ]
          });

      });


</script>