<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="safe - Steel Arch Furniture Experts - homepage">
		<meta name="keywords" content="furniture,lounge,kitchen,bedroom,bathroom,study,garden,sofas,tables,fridges,appliances,sinks,beds,wardrobes,cabinets,baths,showers,toilets,desks,lamps">
		<meta name="author" content="Nick Giordano">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" type="image/x-icon" href="media/favicon.png">
		<title>Homepage | safe | The UK's most dedicated furniture retailer</title>
	</head>
	<body>
		<!-- main navigation page -->
		<?php require_once('menu.php'); ?>
		<!-- homepage splash hyperlink image -->
		<section class="splash">
		<!-- splash image split into table cells to act as hyperlink -->
			<table>
				<tr><td>
					<a href="products.php?category=livingroom"><img src="splash/01.jpg" class="splash_a" /></a><a href="products.php?category=livingroom"><img src="splash/02.jpg" class="splash_b" /></a><a href="products.php?category=bathroom"><img src="splash/03.jpg" class="splash_c" /></a><a href="products.php?category=bathroom"><img src="splash/04.jpg" class="splash_d" /></a>
				</td></tr><tr><td>
					<a href="products.php?category=livingroom"><img src="splash/05.jpg" class="splash_a" /></a><a href="products.php?category=kitchen"><img src="splash/06.jpg" class="splash_b" /></a><a href="products.php?category=kitchen"><img src="splash/07.jpg" class="splash_c" /></a><a href="products.php?category=bathroom"><img src="splash/08.jpg" class="splash_d" /></a>
				</td></tr><tr><td>
					<a href="products.php?category=livingroom"><img src="splash/09.jpg" class="splash_a" /></a><a href="products.php?category=kitchen"><img src="splash/10.jpg" class="splash_b" /></a><a href="products.php?category=kitchen"><img src="splash/11.jpg" class="splash_c" /></a><a href="products.php?category=bedroom"><img src="splash/12.jpg" class="splash_d" id="splash_bed" /></a>
				</td></tr><tr><td>
					<img src="splash/13.jpg" class="splash_a" /><a href="products.php?category=kitchen"><img src="splash/14.jpg" class="splash_b" /></a><a href="products.php?category=kitchen"><img src="splash/15.jpg" class="splash_c" /></a><a href="products.php?category=bedroom"><img src="splash/16.jpg" class="splash_d" id="splash_bed" /></a>
				</td></tr>
			</table>
		</section>
		<!-- clear database that was initialised from menu page -->
		<?php
			mysqli_free_result($result);
			mysqli_close($db);
		?>
	</body>
</html>