<div class="wrapper">
	<header class="main-header">
		<nav class="navbar navbar-static-top">
			<div class="container">
				<div class="navbar-header">
					<a href="<?php echo base_url()?>" class="navbar-brand"><b>File</b>Workshop</a>
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
					<i class="fa fa-bars"></i>
					</button>
				</div>
				<div class="collapse navbar-collapse pull-left" id="navbar-collapse">
					<ul class="nav navbar-nav">
						<!-- Menu -->
					</ul>
				</div>
			</div>
		</nav>
	</header>
	<div class="content-wrapper">
		<div class="container">
			<section class="content">
				<div class="row">
				<?php 
					if($page){
						$this->load->view($page);
					}
				?>
				</div>
			</section>
		</div>
	</div>
	<footer class="main-footer">
		<div class="container">
			<div class="pull-right hidden-xs">
				<b>Version</b> 2.4.0
			</div>
			<strong>Copyright &copy; 2014-2016 <a href="https://adminlte.io">Almsaeed Studio</a>.</strong> All rights reserved.
		</div>
	</footer>
</div>