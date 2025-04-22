<?php
$conn = new mysqli("localhost", "root", "", "PBL");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch faculty with department names
$result = $conn->query("
    SELECT f.*, d.Department_Name 
    FROM Faculty f
    LEFT JOIN Department d ON f.Department_ID = d.Department_ID
    ORDER BY f.Name ASC
");

$success = isset($_GET['success']) ? "Faculty added successfully!" : "";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Faculty Records</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            background-color: #121212;
            color: #e0e0e0;
        }

        .records-container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 25px;
            background: #1e1e1e;
            border-radius: 12px;
            box-shadow: 0 0 25px rgba(0, 0, 0, 0.5);
        }

        h1 {
            margin: 0;
            font-size: 28px;
        }

        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background: #00bcd4;
            color: #121212;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .action-button:hover {
            background: #0097a7;
            transform: translateY(-2px);
        }

        .action-button.secondary {
            background: #444;
            color: #e0e0e0;
        }

        .action-button.secondary:hover {
            background: #555;
        }

        .success-msg {
            color: #4CAF50;
            background: #1e2e1e;
            padding: 14px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 5px solid #4CAF50;
            font-weight: bold;
        }

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-bar input[type="text"] {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            border: none;
            background-color: #2c2c2c;
            color: #fff;
        }

        .search-bar button {
            padding: 10px 16px;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .search-btn {
            background-color: #00bcd4;
            color: #121212;
        }

        .search-btn:hover {
            background-color: #0097a7;
        }

        .reset-btn {
            background-color: #444;
            color: #e0e0e0;
        }

        .reset-btn:hover {
            background-color: #666;
        }

        .faculty-table {
            width: 100%;
            border-collapse: collapse;
        }

        .faculty-table th {
            background-color: #00bcd4;
            color: #121212;
            padding: 12px;
            text-align: left;
        }

        .faculty-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #333;
        }

        .faculty-table tr:nth-child(even) {
            background-color: #252525;
        }

        .faculty-table tr:hover {
            background-color: #2c2c2c;
        }

        @media screen and (max-width: 768px) {
            .header-actions {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-bar {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="records-container">
        <div class="header-actions">
            <h1>Faculty Records</h1>
            <div>
                <a href="add_faculty.php" class="action-button">
                    <i class="fas fa-user-plus"></i> Add Faculty
                </a>
                <a href="control_panel.php" class="action-button secondary" style="margin-left: 10px;">
                    <i class="fas fa-home"></i> Control Panel
                </a>
            </div>
        </div>

        <?php if (!empty($success)): ?>
            <div class="success-msg"><i class="fas fa-check-circle"></i> <?= $success ?></div>
        <?php endif; ?>

        <div class="search-bar">
            <input type="text" id="searchInput" placeholder="Search by Name, Email or Department">
            <button class="search-btn" onclick="searchTable()"><i class="fas fa-search"></i> Search</button>
            <button class="reset-btn" onclick="resetSearch()"><i class="fas fa-undo"></i> Reset</button>
        </div>

        <table class="faculty-table" id="facultyTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Department</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['Faculty_ID'] ?></td>
                    <td><?= htmlspecialchars($row['Name']) ?></td>
                    <td><?= htmlspecialchars($row['Email']) ?></td>
                    <td><?= $row['Phone'] ?></td>
                    <td><?= htmlspecialchars($row['Department_Name'] ?? 'N/A') ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        function searchTable() {
            const input = document.getElementById("searchInput").value.toLowerCase();
            const table = document.getElementById("facultyTable");
            const rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                const cells = rows[i].getElementsByTagName("td");
                let match = false;

                for (let j = 0; j < cells.length; j++) {
                    const text = cells[j].innerText.toLowerCase();
                    if (text.includes(input)) {
                        match = true;
                        break;
                    }
                }

                rows[i].style.display = match ? "" : "none";
            }
        }

        function resetSearch() {
            document.getElementById("searchInput").value = "";
            searchTable();
        }
    </script>
</body>
</html>

<?php $conn->close(); ?>
