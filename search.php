<?php
include 'db.php';

$search = $_POST['query'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Search Results</h1>
    <form action="search.php" method="POST" class="search-form">
        <input type="text" name="query" placeholder="Enter Roll Number or Name" value="<?= htmlspecialchars($search) ?>" required>
        <button type="submit">Search</button>
    </form>
    
    <div class="cards">
        <?php
        if (!empty($search)) {
            $stmt = $conn->prepare("SELECT * FROM exam_record WHERE roll_number LIKE ? OR student_name LIKE ?");
            $likeSearch = "%$search%";
            $stmt->bind_param("ss", $likeSearch, $likeSearch);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<h2>' . htmlspecialchars($row['student_name']) . '</h2>';
                    echo '<p><strong>Roll No:</strong> ' . htmlspecialchars($row['roll_number']) . '</p>';
                    echo '<p><strong>Subject:</strong> ' . htmlspecialchars($row['subject']) . '</p>';
                    echo '<p><strong>Marks:</strong> ' . htmlspecialchars($row['marks']) . '</p>';
                    echo '<p><strong>Grade:</strong> ' . htmlspecialchars($row['grade']) . '</p>';
                    echo '<p><strong>Date:</strong> ' . htmlspecialchars($row['exam_date']) . '</p>';
                    echo '</div>';
                }
            } else {
                echo '<p class="no-results">No records found</p>';
            }
        }
        ?>
    </div>
</div>
</body>
</html>
