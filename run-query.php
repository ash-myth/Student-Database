<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "root", "", "PBL");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Run Custom Query</title>
  <style>
    :root {
      --primary: #00bcd4;
      --primary-dark: #008fa1;
      --dark-bg: #1e1e1e;
      --darker-bg: #121212;
      --text-light: #e0e0e0;
      --text-lighter: #f5f5f5;
      --table-header: #00bcd4;
      --table-row-odd: #252525;
      --table-row-even: #2a2a2a;
      --table-border: #444;
      --error: #ff5555;
      --success: #4caf50;
      --warning: #ff9800;
    }

    * {
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--darker-bg);
      color: var(--text-light);
      margin: 0;
      padding: 20px;
      line-height: 1.6;
    }

    .query-container {
      max-width: 1000px;
      margin: 0 auto;
      padding: 30px;
      background-color: var(--dark-bg);
      border-radius: 12px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.25);
    }

    h1 {
      color: var(--primary);
      text-align: center;
      margin: 0 0 30px 0;
      font-size: 2.2rem;
    }

    .query-form {
      margin-bottom: 30px;
    }

    .query-form textarea {
      width: 100%;
      min-height: 120px;
      padding: 15px;
      background-color: #2c2c2c;
      color: var(--text-lighter);
      border: 2px solid var(--table-border);
      border-radius: 8px;
      font-family: 'Consolas', 'Courier New', monospace;
      font-size: 15px;
      resize: vertical;
      transition: border-color 0.3s;
      line-height: 1.5;
    }

    .query-form textarea:focus {
      outline: none;
      border-color: var(--primary);
    }

    .query-form input[type="submit"] {
      background-color: var(--primary);
      color: #121212;
      border: none;
      padding: 14px 28px;
      border-radius: 8px;
      font-weight: bold;
      cursor: pointer;
      font-size: 16px;
      transition: all 0.3s;
      margin-top: 20px;
      width: 100%;
      letter-spacing: 0.5px;
    }

    .query-form input[type="submit"]:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .password-field {
      margin-top: 25px;
      background-color: #252525;
      padding: 20px;
      border-radius: 8px;
      border-left: 4px solid var(--warning);
    }

    .password-field label {
      display: block;
      margin-bottom: 10px;
      font-weight: 600;
      color: var(--text-lighter);
    }

    .input-wrapper {
      position: relative;
      display: flex;
      align-items: center;
    }

    .input-wrapper input[type="password"],
    .input-wrapper input[type="text"] {
      width: 100%;
      padding: 12px 45px 12px 15px;
      background-color: #2c2c2c;
      color: var(--text-lighter);
      border: 2px solid var(--table-border);
      border-radius: 6px;
      font-size: 15px;
      transition: border-color 0.3s;
    }

    .input-wrapper input:focus {
      outline: none;
      border-color: var(--primary);
    }

    .toggle-visibility {
      position: absolute;
      right: 15px;
      cursor: pointer;
      font-size: 20px;
      user-select: none;
      color: var(--text-light);
      padding: 5px;
      transition: transform 0.2s;
    }

    .toggle-visibility:hover {
      transform: scale(1.1);
    }

    .table-container {
      overflow-x: auto;
      margin: 30px 0;
      border-radius: 8px;
      background-color: var(--table-row-odd);
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .result-table {
      width: 100%;
      border-collapse: collapse;
      min-width: 800px;
    }

    .result-table th {
      background-color: var(--table-header);
      color: #121212;
      padding: 14px 18px;
      text-align: left;
      position: sticky;
      top: 0;
      font-weight: bold;
      font-size: 15px;
    }

    .result-table td {
      padding: 12px 18px;
      border-bottom: 1px solid var(--table-border);
      font-size: 14px;
    }

    .result-table tr:nth-child(odd) {
      background-color: var(--table-row-odd);
    }

    .result-table tr:nth-child(even) {
      background-color: var(--table-row-even);
    }

    .result-table tr:hover {
      background-color: #333;
    }

    .error-msg {
      color: var(--error);
      padding: 16px;
      background-color: rgba(255, 85, 85, 0.1);
      border-radius: 8px;
      border-left: 4px solid var(--error);
      margin: 25px 0;
      font-weight: 500;
    }

    .success-msg {
      color: var(--success);
      padding: 16px;
      background-color: rgba(76, 175, 80, 0.1);
      border-radius: 8px;
      border-left: 4px solid var(--success);
      margin: 25px 0;
      font-weight: 500;
    }

    .row-count {
      text-align: center;
      color: #aaa;
      font-size: 14px;
      margin-top: -20px;
      margin-bottom: 20px;
    }

    .action-buttons {
      margin-top: 40px;
      text-align: center;
    }

    .action-button {
      display: inline-block;
      padding: 12px 24px;
      background-color: var(--primary);
      color: #121212;
      text-decoration: none;
      border-radius: 6px;
      margin: 0 10px;
      font-weight: bold;
      transition: all 0.3s;
    }

    .action-button:hover {
      background-color: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
      .query-container {
        padding: 20px;
      }
      
      h1 {
        font-size: 1.8rem;
      }
      
      .result-table th,
      .result-table td {
        padding: 10px 12px;
        font-size: 13px;
      }
      
      .query-form textarea {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="query-container">
    <h1>Run Custom SQL Query</h1>

    <form method="post" class="query-form">
      <textarea name="query" required placeholder="Example: SELECT * FROM Student WHERE department = 'Computer Science';"><?php 
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo htmlspecialchars($_POST['query']);
        }
      ?></textarea>

      <div class="password-field">
        <label for="auth">Admin Password (Required for Non-SELECT Queries)</label>
        <div class="input-wrapper">
          <input type="password" id="auth" name="auth" placeholder="Enter admin password">
          <span class="toggle-visibility" id="toggleIcon" onclick="togglePassword()">👁️</span>
        </div>
      </div>

      <input type="submit" value="Execute Query">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $query = trim($_POST['query']);
        $password = $_POST['auth'] ?? "";

        $isSelect = stripos($query, 'SELECT') === 0;
        $requiresAuth = !preg_match('/^\s*SELECT\b/i', $query);

        if ($isSelect || ($requiresAuth && $password === "AshmitSamarthSumit")) {
            $result = $conn->query($query);

            if ($result instanceof mysqli_result) {
                echo '<div class="table-container">';
                echo '<table class="result-table">';
                echo '<tr>';
                while ($field = $result->fetch_field()) {
                    echo "<th>{$field->name}</th>";
                }
                echo '</tr>';

                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    foreach ($row as $col) {
                        echo '<td>' . htmlspecialchars($col) . '</td>';
                    }
                    echo '</tr>';
                }

                echo '</table></div>';
                echo "<p class='row-count'>" . $result->num_rows . " rows returned</p>";
                $result->free();
            } elseif ($result === TRUE) {
                echo "<div class='success-msg'>Query executed successfully. Affected rows: " . $conn->affected_rows . "</div>";
            } else {
                echo "<div class='error-msg'>Error: " . htmlspecialchars($conn->error) . "</div>";
            }
        } else {
            if ($requiresAuth && $password !== "AshmitSamarthSumit") {
                echo "<div class='error-msg'>⚠️ Authentication required: Only SELECT queries can run without the admin password.</div>";
            } else {
                echo "<div class='error-msg'>Invalid query syntax.</div>";
            }
        }
    }
    ?>

    <div class="action-buttons">
      <a href="control_panel.php" class="action-button">← Return to Dashboard</a>
    </div>
  </div>

  <script>
    function togglePassword() {
      const passField = document.getElementById("auth");
      const icon = document.getElementById("toggleIcon");
      if (passField.type === "password") {
        passField.type = "text";
        icon.textContent = "🙈";
      } else {
        passField.type = "password";
        icon.textContent = "👁️";
      }
    }
  </script>
</body>
</html>

<?php $conn->close(); ?>
