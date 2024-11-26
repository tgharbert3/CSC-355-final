<?php
	ini_set ('error_reporting', 1); //Turns on error reporting - remove once everything works.
	
	try{
		require_once('../pdo_connect.php');
		$sql = 'SELECT
    B.title AS BookTitle,
    B.authFN AS AuthorFirstName,
    B.authLN AS AuthorLastName,
    B.publicationYear,
    (
    SELECT
        COUNT(*)
    FROM
        userReviews R
    WHERE
        R.bookID = B.bookID
) AS ReviewCount
FROM
    book B
WHERE
    (
    SELECT
        COUNT(*)
    FROM
        userReviews R
    WHERE
        R.bookID = B.bookID
) =(
    SELECT
        MAX(review_count)
    FROM
        (
        SELECT
            COUNT(*) AS review_count
        FROM
            userReviews
        GROUP BY
            bookID
    ) AS SubQuery
);';
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
	<h2>Books With The Highest Number Of Reviews (Subquery)</h2>

	<table border="1">
		<tr>
			<th>Book Title</th>
			<th>Author First Name</th>
			<th>Author Last Name</th>
			<th>Publication Year</th>
			<th>Review Count</th>
		</tr>	
		<?php foreach ($result as $item) {
			echo "<tr>";
			echo "<td>".$item['BookTitle']."</td>";
			echo "<td>".$item['AuthorFirstName']."</td>";
			echo "<td>".$item['AuthorLastName']."</td>";
			echo "<td>".$item['publicationYear']."</td>";
			echo "<td>".$item['ReviewCount']."</td>";
			echo "</tr>";
		}
		?>
	</table>
</body>    
</html>