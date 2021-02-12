<?php
?>

<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="UTF-8" />
    <title>E-Permit System  </title>
     <meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="This is a web-based application for the application, processing and registration of building permits within the district assembly" name="description" />
	<meta content="Paul Eshun" name="author" />
     <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <!--browser icon-->
    <link rel="icon" href="../assets/images/logo.jpg" type="image/jpg">    
    <!-- GLOBAL STYLES -->
    <link rel="stylesheet" href="../admin/assets/plugins/bootstrap/css/bootstrap.css" />
    <link rel="stylesheet" href="../admin/assets/css/main.css" />
    <link rel="stylesheet" href="../admin/assets/css/theme.css" />
    <link rel="stylesheet" href="../admin/assets/css/MoneAdmin.css" />
    <link rel="stylesheet" href="../assets/font-awesome/css/fontawesome-all.css" />
    <!--END GLOBAL STYLES -->

    <!-- PAGE LEVEL STYLES -->
    <link href="../admin/assets/css/layout2.css" rel="stylesheet" />
    <link href="../admin/assets/plugins/flot/examples/examples.css" rel="stylesheet" />
    <link rel="stylesheet" href="../admin/assets/plugins/timeline/timeline.css" />
    <!-- END PAGE LEVEL  STYLES -->
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    
	<style>
		/*preloader styling*/
        .loading{
            position: fixed;
            width: 100%;
            height: 100%;
            opacity: 1.0;
			top: 0px;
			left: 0px;
            background: #fefefe url('../assets/images/LoaderIcon.gif')
                no-repeat center;
            z-index: 99999;
            
        }

		
    </style>
<!--    enable tooltips-->
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>

</head>

    <!-- END HEAD -->

    <!-- BEGIN BODY -->
<body class="padTop53 " onload="" >
       
	<div class="spinning" id="spinner"></div>    <!--loader/spinner for module show-->
	<div class="loading" id="loader"></div>    <!--    preloader-->
