<?php 
	foreach ($file as $row) {
		echo $row->name . "<br>";
	}
	echo $pagetoken;
?>
<a href="<?php base_url(); echo $pagetoken;?>">Next</a>
<a href="<?php base_url()?>logout">Logout</a>