<!DOCTYPE html>
<html>
	<head></head>
	<body>
		<!-- header bar at top of each page -->
		<header>
			<div class="top">
				<div class="left">
					<div class="logo"><a href="index.php"><img src="media/logo.png"></a></div>
				</div><div class="right">
					<form action="login.php" method="post" id="login" name="login">
						<?php
							session_start();
							if( isset( $_SESSION['user'] ) ) {
								echo '<div class="user">'.'logged in as <b>'.$_SESSION['user'].'</b></div>' .
								'<input type="submit" name="login_btn" value="logout" class="login_btn" />';
							}
							else {
								$url_position = strpos($_SERVER['REQUEST_URI'], '?');
								if( empty($url_position) ) {$url_suffix = '';}
								else {$url_suffix = substr($_SERVER['REQUEST_URI'], $url_position);};
								if( strpos($url_suffix, 'register') ) {$register = '';}
								else if( empty($url_position) ) {$register = '?register';}
								else {$register = $url_suffix.'&register';}
								echo '<span style="font-size:0.8em;"><a href="'.$register.'">' .
								'Not registered? Click here to create an account...</a></span><br>'.
								'<input type="text" name="user" class="login" placeholder="username" required />' .
								'<input type="password" name="pass" class="login" placeholder="password" required />' .
								'<input type="submit" name="login_btn" value="login" class="login_btn" />';
							}
						?>
					</form>
				</div>
			</div>
		</header>
		<!-- navigation bar at top of each page -->
		<nav>
			<div class="links">
				<div></div>
				<?php
					// connect to database
					require_once('connect.php');
					// query database to get categories, ordered by most popular category
					$result = mysqli_query($db, 'SELECT Category FROM Product GROUP BY Category ORDER BY COUNT(ID) DESC;');
					// place categories into array and create navigation links
					$categories = array();
					while( $row = mysqli_fetch_row($result) ) {array_push($categories, $row[0]);}
					for($i = 0 ; $i < count($categories) ; $i++) {
						echo '<a href="products.php?category='.strtolower( str_replace(' ', '', $categories[$i]) ).'">' .
						'<div class="link';
						if( isset($_GET['category']) && $_GET['category'] == strtolower( str_replace(' ', '', $categories[$i]) ) )
						{echo '_selected';}
						echo '">'.$categories[$i].'</div></a>';
					}
				?>
				<div></div>
			</div>
		</nav>
		<!-- registration popup section -->
		<section class="registration<?php if( !isset($_SESSION['user']) && isset($_GET['register']) ) {echo '_visible';}?>">
			<!-- registration form header -->
			<h3>Create an account</h3>
			<p>Fill in the form below to register your <span style="font-weight:bold; color:#800000;">safe</span> account...</p>
			<?php
				// display error message if registration was unsuccessful
				if( isset($_GET['account_taken']) ) {
					echo '<p style="font-size:0.9em; font-weight:bold; color:red;">' .
					'Sorry, the chosen username or email address is already in use!<br>Please try again...' .
					'</p>';
				}
			?>
			<!-- registration form main body -->
			<form action="register.php" method="post" id="register" name="register">
				<input type="text" name="username" id="username" placeholder="Username" required autofocus title="must contain no special characters" />
				<input type="text" name="phone" id="phone" placeholder="Phone number" maxlength="11" required title="must contain only numbers and not exceed 11 characters" />
				<input type="text" name="email" id="email" placeholder="Email address" required title="must be a valid email address" />
				<input type="password" name="password" id="password" placeholder="Password" required title="must be at least 8 characters and contain no special characters" />
				<input type="password" name="retype" id="retype" placeholder="Re-type password" required title="must match the password typed above" />
				<input type="submit" value="Create account" onclick="return validation()" />
			</form>
			<?php
				// button used to close registration popup section
				$register = substr($_SERVER['REQUEST_URI'], $url_position);
				$register = str_replace('&database_error', '', $register);
				$register = str_replace('&account_taken', '', $register);
				$register = str_replace('&register', '', $register);
				$register = str_replace('register', '', $register);
				echo '<a href="'.$register.'"><img src="media/close.png" style="width:30px;" /></a>';
			?>
		</section>
		<!-- disclaimer bar at bottom of each page -->
		<footer>
			Copyright © 2020 -- Steel Arch Furniture Experts Ltd. -- All rights reserved
		</footer>
	</body>
</html>