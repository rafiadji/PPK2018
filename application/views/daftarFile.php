<div class="box">
	<div class="box-header">
		<h3 class="box-title">Upload File</h3>
	</div>
	<div class="box-body">
		<form class="form-horizontal" action="<?php echo base_url()?>welcome/submitUpload" method="post" enctype="multipart/form-data">
			<div class="form-group">
				<label class="control-label col-md-1">Nama File</label>
				<div class="col-md-5">
					<input type="text" name="nama" class="form-control"/>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-1">File</label>
				<div class="col-md-5">
					<input type="file" name="file" class="form-control"/>
				</div>
				<div class="col-md-2">
					<input type="submit" name="proses" value="Upload" class="btn btn-primary" />
				</div>
			</div>
		</form>
	</div>
</div>
<div class="box">
	<div class="box-header">
		<h3 class="box-title">Download File</h3>
	</div>
	<div class="box-body">
		<table class="table table-bordered table-striped dtable">
			<thead>
				<tr>
					<th>Nama File</th>
					<th>Opsi</th>
				</tr>
			</thead>
			<tbody>
			<?php foreach($file as $row):?>
				<tr>
					<td><?php echo $row->name?></td>
					<td><a href="<?php echo base_url()?>PPK_Control/download/<?php echo $row->id?>" class="btn btn-success">Download</a>
						<a href="<?php echo base_url()?>PPK_Control/delete/<?php echo $row->id?>" class="btn btn-danger">Hapus</a></td>
				</tr>
			<?php endforeach;?>	
			</tbody>
		</table>
	</div>
</div>