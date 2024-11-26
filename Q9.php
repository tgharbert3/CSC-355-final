<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../pdo_connect.php'); // Database connection

$averageRating = null;
$users = [];

try {
    // Fetch all users for the dropdown
    $stmt = $dbc->query('SELECT DISTINCT username FROM userReviews ORDER BY username ASC');
    $users = $stmt->fetchAll(PDO::FETCH_COLUMN);
} catch (PDOException $e) {
    echo 'Error fetching users: ' . $e->getMessage();
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    try {
        // Call the stored function
        $stmt = $dbc->prepare('SELECT GetAverageRatingByUserWithMessage(:username) AS AverageRating');
        $stmt->execute([':username' => $username]);
        $averageRating = $stmt->fetchColumn();
    } catch (PDOException $e) {
        echo 'Error executing query: ' . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library</title>
</head>
<body>
    <h1>User Average Rating (Stored Function)</h1>
    <form method="POST">
        <label for="username">Select a User:</label>
        <select id="username" name="username" required>
            <option value="" disabled selected>Select a user</option>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo htmlspecialchars($user); ?>" <?php echo (isset($username) && $username === $user) ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($user); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Get Average Rating</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
        <h2>Results</h2>
        <?php if ($averageRating): ?>
            <p>User "<?php echo htmlspecialchars($username); ?>" has an average rating of <strong><?php echo $averageRating; ?></strong>.</p>
        <?php else: ?>
            <p>No reviews found for user "<?php echo htmlspecialchars($username); ?>".</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>