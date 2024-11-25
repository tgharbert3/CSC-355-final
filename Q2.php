<?php
	ini_set ('error_reporting', 1); //Turns on error reporting - remove once everything works.
	
	try{
		require_once('../pdo_connect.php'); //Connect to the database
		$sql = 'SELECT u.username, r.city, r.state, r.country, b.title JOIN users u ON ur.username = u.username JOIN region r ON u.regionID = r.regionID JOIN book b ON ur.bookID = b.bookID ORDER BY r.country';
		$result = $dbc-> query($sql);
	} catch (PDOException $e){
		echo $e->getMessage();
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Library</title>
	<meta charset ="utf-8"> 
</head>
<body>
	<h2>Three Table Join</h2>

	<table>
		<tr>
			<th>Username</th>
			<th>City</th>
			<th>State</th>
			<th>Country</th>
			<th>Title</th>
		</tr>	
		<?php foreach ($result as $item) {
			echo "<tr>";
			echo "<td>".$item['username']."</td>";
			echo "<td>".$item['city']."</td>";
			echo "<td>".$item['state']."</td>";
			echo "<td>".$item['country']."</td>";
			echo "<td>".$item['title']."</td>";
			echo "</tr>";
		}
		?>
	</table>
</body>    
</html>