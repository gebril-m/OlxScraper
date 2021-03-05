<!-- jQuery first, then Tether, then other JS. -->
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/jquery.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/tether.min.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/bootstrap.min.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/unifyMenu/unifyMenu.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/onoffcanvas/onoffcanvas.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/moment.js"></script>

		<!-- Data Tables -->
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/datatables/dataTables.min.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/datatables/dataTables.bootstrap.min.js"></script>
		
		<!-- Custom Data tables -->
		<script src="{{url('/admin/datatables-custom.js')}}"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/datatables/custom/fixedHeader.js"></script>

		<!-- Common JS -->
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/common.js"></script>

		<!-- Notify js -->
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/js/jquery.easing.1.3.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/notify/notify.js"></script>
		<script src="http://bootstrap.gallery/unify-dashboards/design-12/vendor/notify/notify-custom.js"></script>

		<script>
			$(function() {

			    setTimeout(function() {
			        $(".notify-notifications").hide()
			    }, 3000);

			});


			function readURL(input) {
		        if (input.files && input.files[0]) {
		            var reader = new FileReader();

		            reader.onload = function (e) {
		                $('#image_preview').attr('src', e.target.result);
		            }

		            reader.readAsDataURL(input.files[0]);
		        }
		    }

		    $("#image").change(function(){
		        readURL(this);
		    });
		</script>

		@stack('js')