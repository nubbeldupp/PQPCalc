<!DOCTYPE html>
<!--
	Created by: nubbeldupp 
	Date: Oct 20th 2019
	Contact FT: https://www.flyertalk.com/forum/members/nubbeldupp.html
	Contact VFT: https://www.vielfliegertreff.de/members/nubbeldupp-45497.html

	Versioning:
	V0.1 	Oct 20th 2019	First draft
	V0.2 	Oct 22nd 2019	Added all airlines to database
	V0.3	Oct 24th 2019	Added UA specialty fares to database
	V0.4	Nov 18th 2019	Changed MySQL Queries to prevent SQL-Injection and added htmlspecialchars() to prevent XXS
	V0.5	Nov 18th 2019	Added ICAO Airport codes
-->
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
	<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
	<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/locale/bootstrap-table-en-EN.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.15.4/extensions/filter-control/bootstrap-table-filter-control.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.15.4/extensions/filter-control/bootstrap-table-filter-control.js"></script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-151909228-1"></script>
	<!--
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-151909228-1');
	</script>
	-->
	
	<title>
		UA PQP CALC
	</title>
</head>
<div class="jumbotron" style="margin-bottom: 0px">
	<h1>UA PQP CALC</h1>
	<p>Calculate PQP for non016-Stock and UA specialty fares</p>
</div>
<nav class="navbar navbar-expand-md navbar-dark bg-dark sticky-top">
	<a class="navbar-brand"><img src="/images/ualogo.jpg" alt=""></a>
	<button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#collapse_target">
		<span class="navbar-toggler-icon"></span>
	</button>
	<div class="collapse navbar-collapse" id="collapse_target">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="http://pqp-calc.com">Start</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="index.php?page=calculator">Calculator</a>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDataDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Data</a>
				<div class="dropdown-menu" aria-labelledby="navbarDataDropdown">
					<a class="dropdown-item" href="index.php?page=fareclasses">Fareclasses</a>
					<div class="dropdown-divider"></div>
					<a class="dropdown-item" href="index.php?page=dividend">Divisor</a>
				</div>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="index.php?page=about">About</a>
			</li>
		</ul>
	</div>
</nav>
<div id="main" style="text-align: center; margin-top: 10px">
	<?php
		header("X-XSS-Protection: 1; mode=block");
		if(isset($_GET['page'])){
			$page = $_GET['page'];
			$display = $page . '.php';
			include($display);
		}else{
			echo '<div class="col-lg-6" style="display: inline-block">';
				echo '<div class="embed-responsive embed-responsive-16by9">';
					echo '<iframe width="1120" class="embed-responsive-item" src="https://www.youtube.com/embed/fvlN-mY9iFc?rel=0" allowfullscreen></iframe>';
				echo '</div>';
			echo '</div>';
		}
	?>
</div>
</html>
