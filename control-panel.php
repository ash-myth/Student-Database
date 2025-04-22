<?php
$conn = new mysqli("localhost", "root", "", "PBL");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Control Panel</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #00bcd4;
            --primary-dark: #008fa1;
            --dark: #121212;
            --darker: #0d0d0d;
            --light: #e0e0e0;
        }

        body {
            background: radial-gradient(circle at center, #1a1a1a 0%, #0d0d0d 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', system-ui, sans-serif;
        }

        .glow {
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle at center, rgba(0,188,212,0.1) 0%, transparent 70%);
            z-index: -1;
            animation: pulse 15s infinite alternate;
        }

        @keyframes pulse {
            0% { transform: scale(1); opacity: 0.5; }
            100% { transform: scale(1.2); opacity: 0.8; }
        }

        .control-panel {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
            position: relative;
        }

        .panel-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .panel-title {
            font-size: 2.8rem;
            background: linear-gradient(to right, #00bcd4, #00ffaa);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            margin-bottom: 15px;
            text-shadow: 0 0 20px rgba(0,188,212,0.3);
        }

        .dashboard {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .card {
            background: rgba(30,30,30,0.6);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 30px;
            border: 1px solid rgba(255,255,255,0.05);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            transition: all 0.4s;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.4);
            border-color: rgba(0,188,212,0.3);
        }

        .card-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .card-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--primary), #00e5ff);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            color: var(--dark);
            font-size: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,188,212,0.3);
        }

        .card-title {
            font-size: 1.4rem;
            color: var(--light);
            margin: 0;
        }

        .card-actions {
            display: grid;
            gap: 15px;
        }

        .action-btn {
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }

        .action-btn i {
            margin-right: 10px;
        }

        .action-primary {
            background: var(--primary);
            color: var(--dark);
            box-shadow: 0 4px 15px rgba(0,188,212,0.3);
        }

        .action-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0,188,212,0.4);
        }

        .credits {
            text-align: center;
            margin-top: 50px;
            color: rgba(224,224,224,0.7);
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 30px;
        }

        .team-members {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
            flex-wrap: wrap;
        }

        .member {
            background: rgba(0,188,212,0.1);
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid rgba(0,188,212,0.3);
            display: flex;
            align-items: center;
        }

        .member i {
            margin-right: 8px;
            color: var(--primary);
        }

        .member a {
            color: var(--light);
            text-decoration: none;
            font-weight: 500;
        }

        .member a:hover {
            text-decoration: underline;
            color: #00e5ff;
        }
    </style>
</head>
<body>
    <div class="glow"></div>
    <div class="control-panel">
        <div class="panel-header">
            <h1 class="panel-title">University DBMS</h1>
        </div>

        <div class="dashboard">
            <!-- Students Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <h2 class="card-title">Students</h2>
                </div>
                <div class="card-actions">
                    <a href="add_student.php" class="action-btn action-primary">
                        <i class="fas fa-plus"></i> Add Student
                    </a>
                    <a href="view_students.php" class="action-btn action-primary" style="background: #444; color: #e0e0e0;">
                        <i class="fas fa-list"></i> View All
                    </a>
                </div>
            </div>

            <!-- Faculty Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-chalkboard-teacher"></i>
                    </div>
                    <h2 class="card-title">Faculty</h2>
                </div>
                <div class="card-actions">
                    <a href="add_faculty.php" class="action-btn action-primary">
                        <i class="fas fa-plus"></i> Add Faculty
                    </a>
                    <a href="view_faculty.php" class="action-btn action-primary" style="background: #444; color: #e0e0e0;">
                        <i class="fas fa-list"></i> View All
                    </a>
                </div>
            </div>

            <!-- Database Card -->
            <div class="card">
                <div class="card-header">
                    <div class="card-icon">
                        <i class="fas fa-database"></i>
                    </div>
                    <h2 class="card-title">Database</h2>
                </div>
                <div class="card-actions">
                    <a href="run_query.php" class="action-btn action-primary" style="grid-column: 1 / -1;">
                        <i class="fas fa-terminal"></i> Run Custom Query
                    </a>
                </div>
            </div>
        </div>

        <div class="credits">
            <h3>Project-Based Learning Submission</h3>
            <p>Database Management System Project</p>
            <div class="team-members">
                <div class="member">
                    <i class="fas fa-user"></i>
                    <a href="https://www.linkedin.com/in/ashmit-chatterjee-013511288/" target="_blank">Ashmit Chatterjee</a>
                </div>
                <div class="member">
                    <i class="fas fa-user"></i>
                    <a href="https://www.linkedin.com/in/samarthsharma2004/" target="_blank">Samarth Sharma</a>
                </div>
                <div class="member">
                    <i class="fas fa-user"></i>
                    <a href="https://www.linkedin.com/in/sumit-03a941318/" target="_blank">Sumit</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
