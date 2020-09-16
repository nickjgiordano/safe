<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="description" content="safe - Steel Arch Furniture Experts - view and buy furniture">
		<meta name="keywords" content="furniture,lounge,kitchen,bedroom,bathroom,study,garden,sofas,tables,fridges,appliances,sinks,beds,wardrobes,cabinets,baths,showers,toilets,desks,lamps">
		<meta name="author" content="Nick Giordano">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script type="text/javascript" src="script.js"></script>
		<link rel="stylesheet" type="text/css" href="style.css">
		<link rel="shortcut icon" type="image/x-icon" href="media/favicon.png">
		<title>Products page | safe | The UK's most dedicated furniture retailer</title>
	</head>
	<body>
		<!-- main navigation page -->
		<?php require_once('menu.php'); ?>
		<?php
			// only proceed if product category has been set
			if( isset($_GET['category']) ) {
				// side panel used for sorting and filtering products
				echo '<section class="side" id="side">' .
				// panel header that can be toggled to collapse
				'<div class="sort_title" onclick="menu_toggle(\'side\', \'side_icon\')">' .
				'<img src="media/side_icon.png" />sort</div>';
				//  create sort links, preserving selected filters
				echo '<a href="?category='.$_GET['category'];
				if( isset($_GET['filter']) ) {echo '&filter='.$_GET['filter'];}
				echo '"><div class="side_';
				if( isset($_GET['sort']) ) {echo 'un';}
				echo 'selected">Default</div></a>' .
				'<a href="?category='.$_GET['category'];
				if( isset($_GET['filter']) ) {echo '&filter='.$_GET['filter'];}
				echo '&sort=Name"><div class="side_';
				if( !isset($_GET['sort']) || $_GET['sort'] !== 'Name' ) {echo 'un';}
				echo 'selected">Name</div></a>' .
				'<a href="?category='.$_GET['category'];
				if( isset($_GET['filter']) ) {echo '&filter='.$_GET['filter'];}
				echo '&sort=Price"><div class="side_';
				if( !isset($_GET['sort']) || $_GET['sort'] !== 'Price' ) {echo 'un';}
				echo 'selected">Price</div></a>';
				// filter header and default unfiltered menu option
				echo '<div class="filter_title">filter</div>' .
				'<a href="?category='.$_GET['category'].'"><div class="side_';
				if( isset($_GET['filter']) ) {echo 'un';}
				echo 'selected">(none)</div></a>';
				// get category and subcategories
				for($i = 0 ; $i < count($categories) ; $i++) {
					if( $_GET['category'] == strtolower( str_replace(' ', '', $categories[$i]) ) ) {
						$category = $categories[$i];
					}
				}
				$result = mysqli_query($db, 'SELECT Subcategory FROM Product WHERE Category = \''.$category .'\' ' .
				'GROUP BY Subcategory ORDER BY COUNT(Subcategory) DESC;');
				// create filter link for each subcategory
				while( $row = mysqli_fetch_row($result) ) {
					$filter = strtolower( str_replace(' ', '', $row[0]) );
					if(isset($_GET['filter']) && $filter == $_GET['filter']) {$filter_string = $row[0];}
					echo '<a href="?category='.$_GET['category'].'&filter='.$filter.'"><div class="side_';
					if(!isset($_GET['filter']) || $_GET['filter'] !== $filter) {echo 'un';}
					echo 'selected">'.$row[0].'</div></a>';
				}
				echo '</section>' .
				// collapsed version of sort/filter side panel
				'<section class="side_icon" id="side_icon" onclick="menu_toggle(\'side_icon\', \'side\')">' .
				'<img src="media/side_icon.png" /></section>';
				
				// central product display section
				echo '<section class="products">';
				// create database query string to get products for selected product category
				$query = 'SELECT ID, Name, Price FROM Product WHERE Category = \''.$category.'\'';
				// append query string with user's filter and sort selections
				if( isset($_GET['filter']) ) {$query = $query.' AND Subcategory = \''.$filter_string.'\'';}
				if( isset($_GET['sort']) ) {$query = $query.' ORDER BY '.$_GET['sort'];}
				// query database with appended query string
				$result = mysqli_query($db, $query.';');
				// loop through products, adding each to webpage grid
				while( $row = mysqli_fetch_assoc($result) ) {
					// product image, using database entry that matches image filename
					echo '<div><img src="furniture/'.$row['Name'].'.jpg" class="furniture" />' .
					// product name
					'<p><span style="font-size:1.2em;">'.$row['Name'].'</span>' .
					// product price, formatted as a currency
					'<br><span style="font-size:0.9em; font-weight:bold; color:#800000">£' .
					number_format($row['Price'], 2, '.', ',').'</span><br>';
					// if user is logged in, display basket information
					if( isset($_SESSION['user']) ) {
						// if product is already in basket, display quantity alongside minus and plus buttons
						if(isset($_SESSION['basket']) && array_search($row['ID'], $_SESSION['basket']) !== false) {
							echo '<a href="basket.php?delete&id='.$row['ID'].'">' .
							'<img src="media/minus.png" class="basket_images" /></a>' .
							'<span style="display:inline-block; width:30px;">' .
							'<sup>'.array_count_values($_SESSION['basket'])[$row['ID']].'</sup></span>' .
							'<a href="basket.php?id='.$row['ID'].'">' .
							'<img src="media/plus.png" class="basket_images" /></a>';
						}
						// if product isn't in basket, simply display basket image to allow basket addition
						else {
							echo '<a href="basket.php?id='.$row['ID'].'"><img src="media/basket.png" ' .
							'onmouseover="this.src=\'media/basket_hover.png\'" ' .
							'onmouseout="this.src=\'media/basket.png\'" ' .
							'class="basket_images" alt="steel arch furniture experts basket"></a>';
						}
					}
					// if user isn't logged in, display transparent spacer image
					else {echo '<img src="media/spacer.png" class="basket_spacer" />';}
					echo '</p></div>';
				} echo '</section>';
				
				// side panel used to display basket of user's selected products
				if( isset($_SESSION['basket']) ) {
					// set total and tally variables to 0 before beginning counts
					$total = 0;
					$tally = 0;
					// panel header that can be toggled to collapse
					echo '<section class="basket';
					if($_SESSION['expand'] == 0) {echo '_hidden';}
					echo '" id="basket">' .
					'<div class="basket_title" onclick="menu_toggle(\'basket\', \'basket_icon\')">' .
					'<img src="media/basket_icon.png" /></div><table>';
					// for each item in basket, add row to basket table
					foreach(array_count_values($_SESSION['basket']) as $key=>$quantity) {
						// query database to get name and price of selected product
						$result = mysqli_query($db, "SELECT Name, Price FROM Product WHERE ID = $key;");
						$row = mysqli_fetch_assoc($result);
						$product = $row['Name'];
						$price = $row['Price'];
						// accumulate total and tally variables with current product counts
						$total += + $price * $quantity;
						$tally += $quantity;
						// display product name, price, and quantity, alongside minus and plus buttons
						echo '<tr><td class="product">'.$product.'</td>' .
						'<td class="price">£'.number_format($price, 2, '.', ',').'</td>' .
						'<td class="minus"><a href="basket.php?delete&id='.$key.'">' .
						'<img src="media/minus2.png" /></a></td>' .
						'<td class="quantity">'.$quantity.'</td>' .
						'<td class="plus"><a href="basket.php?id='.$key.'">' .
						'<img src="media/plus2.png" /></a></td></tr>';
					}
					// display row for total basket price and quantity
					echo '<tr class="basket_total">' .
					'<td>TOTAL</<td><td class="total_price">£'.number_format($total, 2, '.', ',').'</td>' .
					'<td colspan="3" class="total_quantity">'.$tally.'</td></tr></table>' .
					// display button to allow user to complete order
					'<a href="order.php"><div class="basket_order">complete order</div></a>' .
					'</section>' .
					// collapsed version of basket side panel
					'<section class="basket_icon" id="basket_icon" onclick="menu_toggle(\'basket_icon\', \'basket\')">' .
					'<img src="media/basket_icon.png" /></section>';
				}
				// set session variable to keep basket collapsed on page
				$_SESSION['expand'] = 0;
					
				// clear database variables
				mysqli_free_result($result);
				mysqli_close($db);
			}
			// if page was arrived at erroneously, redirect user back to homepage
			else {header('Location: index.php');}
		?>
	</body>
</html>