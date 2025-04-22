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
```
git clone https://github.com/ash-myth/student-dbms.git
cd student-database
```
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
## 🖼️ UI Preview

### 1. Main Dashboard
![Control Panel Interface](https://github.com/user-attachments/assets/8f0913cd-9c17-43df-9a56-6b97deb75b44)

### 2. Student Registration
![Add Student Form](https://github.com/user-attachments/assets/becc5d8f-902b-478f-9eb4-f6102fb076dc)

### 3. Student Details View
![View Students Table](https://github.com/user-attachments/assets/7aba07f2-3f22-4901-b0e4-a856faee08e4)

### 4. Faculty Registration
![Add Faculty Form](https://github.com/user-attachments/assets/379f0f67-351a-4a2c-b6e8-1d180a633a88)

### 5. Faculty Details View
![View Faculty Table](https://github.com/user-attachments/assets/91b81397-c91d-42e2-9230-ffcadea5adbb)

### 6. Run Custom SQL Query
![Run Custom SQL Query](https://github.com/user-attachments/assets/53f27896-c13b-4bd5-89e6-258aca287798)

