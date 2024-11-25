<?php
// Turn on error reporting - remove this once everything works.
ini_set('error_reporting', 1); 


$result = [];
$searchTerm = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require_once('../pdo_connect.php'); 
        
        $searchTerm = $_POST['searchTerm'] ?? '';
        $searchTerm = htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8');
        
        $sql = 'SELECT 
                    title, 
                    authFN AS AuthorFirstName, 
                    authLN AS AuthorLastName, 
                    publicationYear 
                FROM 
                    book 
                WHERE 
                    title LIKE :searchTerm 
                ORDER BY 
                    publicationYear DESC;';
        
        $stmt = $dbc->prepare($sql);
        $stmt->execute(['searchTerm' => '%' . $searchTerm . '%']);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Library</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Search for Books by Title</h2>
    
    <!-- Search form -->
    <form method="POST" action="">
        <label for="searchTerm">Enter a keyword:</label>
        <input type="text" id="searchTerm" name="searchTerm" value="<?= htmlspecialchars($searchTerm, ENT_QUOTES, 'UTF-8'); ?>" required>
        <button type="submit">Search</button>
    </form>
    
    <!-- Results table -->
    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h3>Search Results</h3>
        <?php if (!empty($result)): ?>
            <table border="1">
                <tr>
                    <th>Book Title</th>
                    <th>Author First Name</th>
                    <th>Author Last Name</th>
                    <th>Publication Year</th>
                </tr>
                <?php foreach ($result as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['title'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($item['AuthorFirstName'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($item['AuthorLastName'], ENT_QUOTES, 'UTF-8'); ?></td>
                        <td><?= htmlspecialchars($item['publicationYear'], ENT_QUOTES, 'UTF-8'); ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else: ?>
            <p>No books found matching your search.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
