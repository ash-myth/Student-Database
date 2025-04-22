<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "PBL");

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $dept_id = intval($_POST['dept_id']);

    $sql = "INSERT INTO Faculty (Name, Email, Phone, Department_ID) 
            VALUES ('$name', '$email', '$phone', $dept_id)";
    
    if ($conn->query($sql)) {
        header("Location: view_faculty.php?success=1");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}

$dept_result = $conn->query("SELECT Department_ID, Department_Name FROM Department");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Faculty</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .container {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
        }
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .back-button {
            padding: 8px 15px;
            background: #444;
            color: #e0e0e0;
            text-decoration: none;
            border-radius: 5px;
        }
        .view-button {
            padding: 8px 15px;
            background: #00bcd4;
            color: #121212;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }
        .error {
            color: #ff5555;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-actions">
            <a href="control_panel.php" class="back-button">← Control Panel</a>
            <a href="view_faculty.php" class="view-button">View All Faculty</a>
        </div>
        
        <h1>Add New Faculty Member</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <label>Full Name:</label>
            <input type="text" name="name" required>
            
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Phone:</label>
            <input type="text" name="phone" required pattern="[0-9]{10,15}">
            
            <label>Department:</label>
            <select name="dept_id" required>
                <option value="">-- Select Department --</option>
                <?php while ($dept = $dept_result->fetch_assoc()): ?>
                    <option value="<?= $dept['Department_ID'] ?>">
                        <?= htmlspecialchars($dept['Department_Name']) ?>
                    </option>
                <?php endwhile; ?>
            </select>
            
            <input type="submit" value="Add Faculty" class="submit-btn">
        </form>
    </div>
</body>
</html>

<?php $conn->close(); ?>
