<!DOCTYPE >
<html>
	<head>
		<title>MANAJEMEN FILE STIKI</title>
		<link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/font-awesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/Ionicons/css/ionicons.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/AdminLTE.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
		<link rel="stylesheet" href="<?php echo base_url()?>assets/dist/css/skins/_all-skins.min.css">
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
		<!-- jQuery 3 -->
		<script src="<?php echo base_url()?>assets/bower_components/jquery/dist/jquery.min.js"></script>
	</head>
	<body class="hold-transition skin-blue layout-top-nav">
		<?php include("template/content.php");?>
		<script src="<?php echo base_url()?>assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url()?>assets/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
		<script src="<?php echo base_url()?>assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
		<script src="<?php echo base_url()?>assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?php echo base_url()?>assets/bower_components/fastclick/lib/fastclick.js"></script>
		<script src="<?php echo base_url()?>assets/dist/js/adminlte.min.js"></script>
		<script src="<?php echo base_url()?>assets/dist/js/demo.js"></script>
		<script>
			$(document).ready(function () {
				$('.dtable').DataTable({
					'ordering'    : false
				})
			})
		</script>
	</body>
</html>
