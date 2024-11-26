<?php
	ini_set ('error_reporting', 1); //Turns on error reporting - remove once everything works.
	
	try{
		require_once('../pdo_connect.php'); //Connect to the database
		$sql = 'SELECT b.title, COUNT(ur.rating) AS reviewCount FROM userReviews ur JOIN book b ON ur.bookID = b.bookID GROUP BY b.bookID HAVING COUNT(ur.rating) > 1';
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
	<h2>Total Reviews(Aggregate Function Using Group By And Having)</h2>

	<table>
		<tr>
			<th>Title</th>
			<th>Review Count</th>
		</tr>	
		<?php foreach ($result as $item) {
			echo "<tr>";
			echo "<td>".$item['title']."</td>";
			echo "<td>".$item['reviewCount']."</td>";
			echo "</tr>";
		}
		?>
	</table>
</body>    
</html>