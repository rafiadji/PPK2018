<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>

<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4><img src="<?php echo @$userData['picture_url']; ?>" width="100" height="100"/></h4>
      <div class="input-group">
       <h4 style="font-family: sans-serif;"><?php echo @$userData['first_name'].' '.@$userData['last_name']; ?> </h4>

        <ul class="nav nav-pills nav-stacked">
        <li ><a href="<?php echo base_url().'index.php/PPK_Control/formupload'; ?>">Upload File</a></li>
        <li><a href="<?php echo base_url().'index.php/welcome/logout'; ?>">LogOut</a></li>
      </ul><br>
      </div>
    </div>

    <div class="col-sm-9">
   
  </div>
</div>

  <footer class="container-fluid">
  <p>Footer Text</p>
</footer>


</body>
</html>
