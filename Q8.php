<?php
ini_set('error_reporting', 1); // Turns on error reporting - remove once everything works.

try {
    require_once('../pdo_connect.php');


    $selectedUsername = isset($_POST['username']) ? $_POST['username'] : '';


    $userQuery = 'SELECT DISTINCT username FROM userReviews';
    $userResult = $dbc->query($userQuery);

    if ($selectedUsername) {
        $stmt = $dbc->prepare('CALL GetBooksReviewedByUser(:username)');
        $stmt->bindParam(':username', $selectedUsername, PDO::PARAM_STR);
        $stmt->execute();


        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Reviews by User</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Books Reviewed by User (Stored Procedure)</h2>

    <form method="POST" action="">
        <label for="username">Select User:</label>
        <select name="username" id="username">
            <option value="">--Select a User--</option>
            <?php
            foreach ($userResult as $user) {
                $selected = ($user['username'] == $selectedUsername) ? 'selected' : '';
                echo "<option value='".$user['username']."' $selected>".$user['username']."</option>";
            }
            ?>
        </select>
        <button type="submit">Submit</button>
    </form>

    <?php if ($selectedUsername): ?>
        <table border="1">
            <tr>
                <th>Title</th>
                <th>Review Date</th>
                <th>Rating</th>
            </tr>
            <?php foreach ($result as $item) {
                echo "<tr>";
                echo "<td>".$item['title']."</td>";
                echo "<td>".$item['reviewDate']."</td>";
                echo "<td>".$item['rating']."</td>";
                echo "</tr>";
            }
            ?>
        </table>
    <?php endif; ?>

</body>
</html>
