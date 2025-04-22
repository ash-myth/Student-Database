# 🎓 University DBMS Project

A simple database management system for student and faculty records using PHP and MySQL.

## 📌 Features

- Add and View Students
- Add and View Faculty
- Execute Custom SQL Queries via the UI
- Clean, responsive control panel interface

## 💻 Tech Stack

- **Frontend:** HTML, CSS, FontAwesome
- **Backend:** PHP (Procedural)
- **Database:** MySQL

## 🗂 Project Structure
```
student-dbms/
│
├── add_faculty.php        # Form to add faculty data
├── add_student.php        # Form to add student data
├── control_panel.php      # Main dashboard / homepage
├── run_query.php          # Execute custom SQL queries
├── style.css              # CSS styles
├── view_faculty.php       # View faculty records
├── view_students.php      # View student records
├── README.md              # Project documentation
└── .gitignore             # Ignored files config
```
## ⚙️ Setup Instructions
- Clone the repository:
git clone https://github.com/ash-myth/student-dbms.git
cd student-dbms

- Database Setup:
Create the database manually in MySQL using the schema in schema.sql.

- Configure Database Connection:
Update the database credentials in the PHP files (typically config.php or connection scripts).

- Run the Application:
Place the project folder in your web server's root directory (e.g., htdocs for XAMPP).
Access the application via:
http://localhost/student-dbms/control_panel.php

## 📋 Prerequisites

- Web Server (XAMPP, Apache, Nginx)
- PHP (≥ 7.0 recommended)
- MySQL (≥ 5.6 recommended)
- Web Browser (Chrome, Firefox, etc.)
