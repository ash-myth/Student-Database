<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "PBL");

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Handle new department if specified
    if (!empty($_POST['new_department'])) {
        $new_dept = $conn->real_escape_string($_POST['new_department']);
        $conn->query("INSERT INTO Department (Department_Name) VALUES ('$new_dept')");
        $dept_id = $conn->insert_id;
    } else {
        $dept_id = intval($_POST['dept_id']);
    }

    // Insert student
    $sql = "INSERT INTO Student (Name, Date_of_Birth, Gender, Email, Phone, Address, Department_ID)
            VALUES (
                '" . $conn->real_escape_string($_POST['name']) . "',
                '" . $conn->real_escape_string($_POST['dob']) . "',
                '" . $conn->real_escape_string($_POST['gender']) . "',
                '" . $conn->real_escape_string($_POST['email']) . "',
                '" . $conn->real_escape_string($_POST['phone']) . "',
                '" . $conn->real_escape_string($_POST['address']) . "',
                $dept_id
            )";

    if ($conn->query($sql)) {
        header("Location: view_students.php?success=1");
        exit();
    } else {
        $error = "Error: " . $conn->error;
    }
}

// Fetch existing departments
$dept_result = $conn->query("SELECT Department_ID, Department_Name FROM Department");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Student</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            padding: 10px 20px;
            background: #444;
            color: #e0e0e0;
            text-decoration: none;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .back-button:hover {
            background: #555;
            transform: translateY(-2px);
        }
        
        .view-button {
            padding: 10px 20px;
            background: #00bcd4;
            color: #121212;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s;
        }
        
        .view-button:hover {
            background: #0097a7;
            transform: translateY(-2px);
        }
        
        .form-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 25px;
        }
        
        .submit-btn {
            padding: 12px 25px;
            background: #00bcd4;
            color: #121212;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .submit-btn:hover {
            background: #0097a7;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header-actions">
            <a href="control_panel.php" class="back-button">
                <i class="fas fa-arrow-left"></i> Control Panel
            </a>
            <a href="view_students.php" class="view-button">
                <i class="fas fa-list"></i> View Students
            </a>
        </div>
        
        <h1>Add New Student</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>

        <form method="post">
            <!-- Personal Details -->
            <label>Full Name:</label>
            <input type="text" name="name" required>
            
            <label>Date of Birth:</label>
            <input type="date" name="dob" required>
            
            <label>Gender:</label>
            <select name="gender" required>
                <option value="">-- Select Gender --</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
            
            <label>Email:</label>
            <input type="email" name="email" required>
            
            <label>Phone:</label>
            <input type="tel" name="phone" required pattern="[0-9]{10}">
            
            <label>Address:</label>
            <textarea name="address" rows="3"></textarea>
            
            <!-- Department Selection -->
            <div class="department-options">
                <label>Department:</label>
                <select name="dept_id" id="deptSelect" required>
                    <option value="">-- Select Department --</option>
                    <?php while ($dept = $dept_result->fetch_assoc()): ?>
                        <option value="<?= $dept['Department_ID'] ?>">
                            <?= htmlspecialchars($dept['Department_Name']) ?>
                        </option>
                    <?php endwhile; ?>
                    <option value="new">+ Add New Department</option>
                </select>
                
                <div id="newDeptGroup">
                    <label>New Department Name:</label>
                    <input type="text" name="new_department" id="newDepartment">
                </div>
            </div>
            
            <div class="form-actions">
                <a href="control_panel.php" class="back-button">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="submit-btn">
                    <i class="fas fa-user-plus"></i> Add Student
                </button>
            </div>
        </form>
    </div>

    <script>
        // Show/hide new department field
        document.getElementById('deptSelect').addEventListener('change', function() {
            const newDeptGroup = document.getElementById('newDeptGroup');
            if (this.value === 'new') {
                newDeptGroup.style.display = 'block';
                document.getElementById('newDepartment').required = true;
            } else {
                newDeptGroup.style.display = 'none';
                document.getElementById('newDepartment').required = false;
            }
        });
    </script>
</body>
</html>

<?php $conn->close(); ?>
