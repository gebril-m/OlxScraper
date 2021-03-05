<!-- Common CSS -->
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/css/bootstrap.min.css" />
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/fonts/icomoon/icomoon.css" />
		@if(app()->getLocale()=='en')
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/css/main.css" />
		@else
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/css/main-rtl.css" />
		@endif
		<!-- Data Tables -->
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/vendor/datatables/dataTables.bs4.css" />
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/vendor/datatables/dataTables.bs4-custom.css" />
		<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@600&display=swap" rel="stylesheet">
		
		<style>
			button{
				cursor: pointer;
			}	
			.main-content{
				min-height: 1000px;
			}
			.current-page{
				pointer-events: auto !important;
			}
			.buttonload {
			  font-size: 30px; /* Set a font-size */
			  padding-left: 8px;
			}
			body{
				font-family: 'Cairo', sans-serif;
			}
			.loader {
				  border: 16px solid #f3f3f3;
				  border-radius: 50%;
				  border-top: 16px solid #3498db;
				  width: 120px;
				  height: 120px;
				  -webkit-animation: spin 2s linear infinite; /* Safari */
				  animation: spin 2s linear infinite;
				}

				/* Safari */
				@-webkit-keyframes spin {
				  0% { -webkit-transform: rotate(0deg); }
				  100% { -webkit-transform: rotate(360deg); }
				}

				@keyframes spin {
				  0% { transform: rotate(0deg); }
				  100% { transform: rotate(360deg); }
				}

				#myProgress {
				  width: 100%;
				  background-color: #ddd;
				}

				#myBar {
				  width: 1%;
				  height: 30px;
				  background-color: #4CAF50;
				}
				.progress { position:relative; width:100%; border: 1px solid #7F98B2; padding: 1px; border-radius: 3px; }
		        .bar { background-color: #B4F5B4; width:0%; height:25px; border-radius: 3px; }
		        .percent { position:absolute; display:inline-block; top:3px; left:48%; color: #7F98B2;}
		</style>

		<!-- Notify -->
		<link rel="stylesheet" href="http://bootstrap.gallery/unify-dashboards/design-12/vendor/notify/notify-flat.css" />

		@stack('css')