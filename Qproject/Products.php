<!DOCTYPE html>
<html>
<head>
	<title>Product Page</title>
	<style>
		
		.container {
			margin: 0 auto;
			padding: 20px;
			max-width: 800px;
			text-align: center;
			background-color: #333;
			border-radius: 10px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
		}
		h1 {
			font-size: 36px;
			line-height: 48px;
			color: #fff;
			margin-bottom: 30px;
		}
		ul {
			list-style: none;
			margin: 0;
			padding: 0;
		}
		li {
			display: inline-block;
			margin: 10px;
			background-color: #222;
			border-radius: 10px;
			padding: 20px;
			box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
			transition: all 0.3s ease;
		}
		li:hover {
			transform: translateY(-5px);
			box-shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
		}
		.btn {
			padding: 10px 20px;
			border: none;
			background-color: black;
			color: #fff;
			border-radius: 5px;
			margin: 5px;
			font-size: 18px;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<div class="container">
		<h1>Our Products</h1>
		<ul>

			 <?php
			 	// Connect to the database.
				include('connection.php');
				include('secureLFI.php');

				// Query the database for the products.
				$sql = "SELECT * FROM products";
				$result = $con->query($sql);

				// Loop through the results and create an li element for each product.
				foreach ($result as $row) {
					echo '<a href="'.$row['product_img'].'"><li>' . $row['product_name'] . '</li></a>';
				}
				if (isset($_GET['page'])){
					$user_input = $_GET['page']; // Assuming 'page' is the parameter containing the file to include
					secure_include($user_input, $allowed_directories);
				}
				
				?>
		</ul>
		<button class="btn" onclick="window.location.href = 'Home.html';">Home Page</button>
	</div>
</body>
</html>