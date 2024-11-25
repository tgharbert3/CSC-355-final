<?php
ini_set('error_reporting', 1); // Turns on error reporting - remove once everything works.

try {
    require_once('../pdo_connect.php');


    $sql = 'SELECT 
                B1.title AS Book1, 
                B2.title AS Book2, 
                B1.authFN AS AuthorFirstName, 
                B1.authLN AS AuthorLastName
            FROM 
                book B1
            JOIN 
                book B2 
            ON 
                B1.authFN = B2.authFN 
                AND B1.authLN = B2.authLN 
                AND B1.bookID < B2.bookID
            ORDER BY 
                AuthorLastName, 
                AuthorFirstName, 
                Book1;';

    $result = $dbc->query($sql);
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Books by the Same Author</title>
    <meta charset="utf-8">
</head>
<body>
    <h2>Books by the Same Author (self-join)</h2>

    <table border="1">
        <tr>
            <th>Author First Name</th>
            <th>Author Last Name</th>
            <th>Book 1</th>
            <th>Book 2</th>
        </tr>	
        <?php foreach ($result as $item): ?>
            <tr>
                <td><?= htmlspecialchars($item['AuthorFirstName'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($item['AuthorLastName'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($item['Book1'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?= htmlspecialchars($item['Book2'], ENT_QUOTES, 'UTF-8'); ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>    
</html>
