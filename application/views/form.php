<?php echo $error;?>
<form action="<?php echo base_url().'PPK_Control/upload/'; ?>" method="post" enctype="multipart/form-data">
<!-- <input type="name" name="path" size="50" />
<br /> -->
<input type="file" name="file" size="50" />
<br />
<input type="submit" value="Upload" />
</form>