<?php
$conn = new mysqli("localhost", "root", "", "PBL");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$deptResult = $conn->query("SELECT Department_ID, Department_Name FROM Department");

$search = $_GET['search'] ?? '';
$filterDept = $_GET['department'] ?? '';
$page = max(1, (int)($_GET['page'] ?? 1));
$limit = 10;
$offset = ($page - 1) * $limit;

$sql = "
    SELECT s.*, d.Department_Name
    FROM Student s
    LEFT JOIN Department d ON s.Department_ID = d.Department_ID
    WHERE 1=1
";

if ($search !== '') {
    $safeSearch = $conn->real_escape_string($search);
    $sql .= " AND (s.Name LIKE '%$safeSearch%' OR s.Email LIKE '%$safeSearch%' OR s.Phone LIKE '%$safeSearch%')";
}
if ($filterDept !== '') {
    $safeDept = (int)$filterDept;
    $sql .= " AND s.Department_ID = $safeDept";
}

$countResult = $conn->query(str_replace("SELECT s.*, d.Department_Name", "SELECT COUNT(*) as total", $sql));
$totalRows = $countResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

$sql .= " LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Records</title>
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

        .search-bar {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .search-bar input[type="text"],
        .search-bar select {
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

        .student-table {
            width: 100%;
            border-collapse: collapse;
        }

        .student-table th {
            background-color: #00bcd4;
            color: #121212;
            padding: 12px;
            text-align: left;
        }

        .student-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #333;
        }

        .student-table tr:nth-child(even) {
            background-color: #252525;
        }

        .student-table tr:hover {
            background-color: #2c2c2c;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .pagination a {
            padding: 8px 14px;
            background: #444;
            color: #e0e0e0;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }

        .pagination a:hover {
            background: #00bcd4;
            color: #121212;
        }

        .pagination .active {
            background: #00bcd4;
            color: #121212;
            font-weight: bold;
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
        <h1>Student Records</h1>
        <div>
            <a href="add_student.php" class="action-button">
                <i class="fas fa-user-plus"></i> Add Student
            </a>
            <a href="control_panel.php" class="action-button secondary" style="margin-left: 10px;">
                <i class="fas fa-home"></i> Control Panel
            </a>
        </div>
    </div>

    <form method="GET" class="search-bar">
        <input type="text" name="search" placeholder="Search by Name, Email or Phone" value="<?= htmlspecialchars($search) ?>">
        <select name="department">
            <option value="">All Departments</option>
            <?php while ($dept = $deptResult->fetch_assoc()): ?>
                <option value="<?= $dept['Department_ID'] ?>" <?= ($filterDept == $dept['Department_ID']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($dept['Department_Name']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit" class="search-btn"><i class="fas fa-search"></i> Search</button>
        <button type="button" class="reset-btn" onclick="window.location.href='view_students.php'">
    <i class="fas fa-undo"></i> Reset
</button>

    </form>

    <table class="student-table">
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
                <td><?= $row['Student_ID'] ?></td>
                <td><?= htmlspecialchars($row['Name']) ?></td>
                <td><?= htmlspecialchars($row['Email']) ?></td>
                <td><?= $row['Phone'] ?></td>
                <td><?= htmlspecialchars($row['Department_Name'] ?? 'N/A') ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <?php if ($totalPages > 1): ?>
        <div class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <a href="?search=<?= urlencode($search) ?>&department=<?= urlencode($filterDept) ?>&page=<?= $i ?>" class="<?= $i === $page ? 'active' : '' ?>">
                    <?= $i ?>
                </a>
            <?php endfor; ?>
        </div>
    <?php endif; ?>
</div>
</body>
</html>

<?php $conn->close(); ?>
