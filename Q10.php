<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../pdo_connect.php'); // Database connection

$mostReviewedGenre = null;

try {
    // Query to find the most reviewed genre
    $stmt = $dbc->query("
        SELECT 
            g.genre AS Genre,
            COUNT(ur.username) AS TotalReviews
        FROM 
            genre g
        JOIN 
            userReviews ur ON g.bookID = ur.bookID
        GROUP BY 
            g.genre
        ORDER BY 
            TotalReviews DESC
        LIMIT 1;
    ");
    $mostReviewedGenre = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library</title>
</head>
<body>
    <h1>Most Reviewed Genre</h1>

    <?php if ($mostReviewedGenre): ?>
        <h2>Results</h2>
        <p>The genre "<strong><?php echo htmlspecialchars($mostReviewedGenre['Genre']); ?></strong>" has the highest number of reviews with <strong><?php echo htmlspecialchars($mostReviewedGenre['TotalReviews']); ?></strong> reviews.</p>
    <?php else: ?>
        <p>No reviews found in the database.</p>
    <?php endif; ?>
</body>
</html>
