# Bicol University–Polangui Student Management System

A web-based student records management system for Bicol University–Polangui Campus, developed as a BSIT final project using PHP, MariaDB/MySQL, and XAMPP.

---

## Table of Contents

1. [Project Overview](#1-project-overview)
2. [Project Objectives](#2-project-objectives)
3. [Features and Functionalities](#3-features-and-functionalities)
4. [User Roles and Permissions](#4-user-roles-and-permissions)
5. [Technologies Used](#5-technologies-used)
6. [System Requirements](#6-system-requirements)
7. [Project Folder Structure](#7-project-folder-structure)
8. [Database Overview](#8-database-overview)
9. [Installation and Setup Using XAMPP](#9-installation-and-setup-using-xampp)
10. [How to Access and Use the Application](#10-how-to-access-and-use-the-application)
11. [Security Measures](#11-security-measures)
12. [Project Information](#12-project-information)
13. [License and Use](#13-license-and-use)

---

## 1. Project Overview

The **Bicol University–Polangui Student Management System** is a web application that centralizes student records for the campus. It replaces scattered spreadsheets and paper-based lists with a single, organized database that authorized users can access through a web browser.

The system stores each student's personal details and academic information, including the student number, name, birthdate, gender, contact details, address, course, year level, and block. The department is not stored on the student record directly; it is derived from the student's course. Departments and courses are connected in the database, so the courses shown in the forms always come from the department selected by the user.

The application has two account roles:

- **Administrator** – manages student records and views system totals.
- **User** – browses, searches, and views student profiles in read-only mode.

The interface is responsive and supports both light and dark themes. It is intended to run locally through XAMPP during development and demonstration.

---

## 2. Project Objectives

This project was developed with the following objectives:

1. To centralize student records in a single, organized database.
2. To reduce the errors and duplication caused by manual record keeping.
3. To provide a complete student records workflow: create, view, search, update, and delete.
4. To enforce role-based access so that only administrators can change records.
5. To connect departments, courses, and year levels through proper database relationships.
6. To apply secure web development practices, including password hashing, prepared statements, CSRF protection, and input validation.
7. To provide a responsive and accessible interface that works on desktop and mobile screens.
8. To demonstrate the integration of PHP, MariaDB/MySQL, and front-end web technologies in a working information system.

---

## 3. Features and Functionalities

### 3.1 Authentication and Account Management

- **Login** using a username and password.
- **Logout** that clears the session and expires the session cookie.
- **Self-registration** with the following validation rules:
  - Username must be 3–50 characters and may contain only letters, numbers, and underscores.
  - Password must be at least 8 characters.
  - Password confirmation must match.
  - Duplicate usernames are rejected.
- Passwords are stored as hashes, never as plain text.
- Newly registered accounts are always assigned the **user** role.
- A password visibility toggle lets users show or hide the password while typing.
- A generic error message is shown for invalid login attempts.

### 3.2 Role-Based Access

- Guests may only access the login and registration pages.
- Regular users may view and search student records but cannot add, edit, or delete them.
- Administrators have full access to the dashboard and student records management.
- Direct access to administrator-only pages by a regular user returns an **HTTP 403 Access Denied** response.

### 3.3 Student Records Management

Administrators can:

- **Add** a student record with personal and academic information.
- **Edit** an existing student record.
- **Delete** a student record after a confirmation prompt.
- **View** the complete profile of any student.

Each student record contains:

- Student number (unique)
- First name and last name
- Birthdate
- Gender
- Contact number
- Email address
- Address
- Department (displayed from the selected course; not stored on the student row)
- Course
- Year level
- Block

### 3.4 Search and Profile Viewing

- The student list can be searched by **student number**, **first name**, or **last name**.
- All logged-in users can open a student's profile page.
- The profile page displays personal information, academic information, and the date the record was added.
- Department badges are color-coded in the interface.

### 3.5 Department and Course Integration

- Departments and courses are stored in separate database tables and linked by a foreign key.
- When a department is selected in the add or edit form, the course list is filtered to show only the courses that belong to that department.
- The filtering is a convenience for the user. The server independently verifies that the selected course exists and belongs to the selected department before saving.
- Course-to-department relationships are never hardcoded in JavaScript or HTML; they always come from the database.

### 3.6 Administrator Dashboard

The dashboard displays current system totals:

- Total students
- Total courses
- Total year levels
- Total users

It also provides shortcuts to the student list and the add-student form.

### 3.7 User Interface

- Responsive layout with a shared sidebar on desktop and a slide-out drawer on mobile.
- Light and dark themes. The chosen theme is saved in the browser and applied before the page paints to avoid a flash.
- Clear success and error messages after form submissions.
- Form validation messages displayed above the form.
- Confirmation dialog before deleting a record.
- Accessible labels, focus states, and reduced-motion support.

### 3.8 Scope and Limitations

The following are **not** implemented in the current version:

- Pagination of the student list (all matching records are displayed).
- A user management screen (accounts are created through registration only).
- Management screens for departments, courses, or year levels (reference data is maintained in the database).
- Export to PDF, Excel, or CSV.
- Attendance, grades, or class scheduling.
- Student profile photo uploads.
- Password reset by email.
- Email notifications.
- Two-factor authentication or login rate limiting.
- Audit logging of record changes.

---

## 4. User Roles and Permissions

| Capability | Guest | User | Administrator |
|---|---|---|---|
| View login page | Yes | Redirected | Redirected |
| Register a new account | Yes | Redirected | Redirected |
| Log in | Yes | Yes | Yes |
| Log out | No | Yes | Yes |
| View student list | No | Yes | Yes |
| Search student records | No | Yes | Yes |
| View a student profile | No | Yes | Yes |
| Access administrator dashboard | No | No (403) | Yes |
| Add a student | No | No (403) | Yes |
| Edit a student | No | No (403) | Yes |
| Delete a student | No | No (403) | Yes |

New accounts created through the registration page always receive the **user** role. Administrator access must be assigned through the database during initial setup (see [Section 9.5](#95-create-the-first-administrator-account)).

**Redirected** means signed-in accounts cannot open the login or registration page; they are sent to their role's home page (dashboard for administrators, student list for regular users).

---

## 5. Technologies Used

| Category | Technology |
|---|---|
| Server | Apache 2.4.65 (XAMPP) |
| Server-side language | PHP 8.3.36 |
| Database | MariaDB 10.11.16 (MySQL compatible, InnoDB, utf8mb4) |
| Database access | PHP Data Objects (PDO) with prepared statements |
| Front-end markup | HTML5 |
| Front-end styling | CSS3 with custom properties, Flexbox, CSS Grid, and media queries |
| Front-end behavior | Vanilla JavaScript (no framework) |
| Fonts | Google Fonts: DM Sans and Manrope |
| Development environment | XAMPP on Windows |
| Version control | Git |

The project does not use Composer, Node.js, npm, or any PHP or JavaScript framework. All application code is contained in the project folder.

---

## 6. System Requirements

### Minimum requirements

- **Operating system:** Windows, Linux, or macOS capable of running XAMPP.
- **XAMPP** with:
  - Apache 2.4 or later
  - PHP 8.1 or later (tested with PHP 8.3.36)
  - MySQL 5.7+ or MariaDB 10.4+ (tested with MariaDB 10.11.16)
- **Web browser:** a modern browser such as Google Chrome, Mozilla Firefox, or Microsoft Edge.
- **Disk space:** enough for the project files, images, and database.
- **Internet connection (optional):** required only to load the Google Fonts used by the interface. If fonts are unavailable, the system falls back to standard system fonts.

### Default XAMPP paths used in this documentation

- Project folder: `C:\xampp\htdocs\student_management_system`
- phpMyAdmin: `http://localhost/phpmyadmin`
- Application: `http://localhost/student_management_system/`

If XAMPP is installed in a different location, adjust the paths accordingly.

---

## 7. Project Folder Structure

```text
student_management_system/
│
├── index.php                     Login page; redirects signed-in users by role
├── register.php                  Self-service registration (creates "user" accounts)
├── logout.php                    Ends the session and deletes the session cookie
├── README.md                     This documentation file
│
├── admin/
│   └── dashboard.php             Administrator dashboard with system totals
│
├── students/
│   ├── index.php                 Student list and search
│   ├── view.php                  Student profile page (all logged-in users)
│   ├── create.php                Add student form (administrators only)
│   ├── edit.php                  Edit student form (administrators only)
│   └── delete.php                Delete handler (POST + CSRF, administrators only)
│
├── includes/
│   ├── auth.php                  Security headers, session setup, CSRF, role guards
│   ├── helpers.php               Department code to CSS class mapping
│   ├── sidebar.php               Shared desktop sidebar and mobile navigation
│   └── theme-toggle.php          Reusable light/dark theme button
│
├── config/
│   ├── database.example.php      Template database configuration (safe to commit)
│   └── database.php              Created from the example during setup; excluded by .gitignore
│
├── database/
│   └── student_management_system.sql   Schema and reference data for a fresh install
│
├── docs/
│   └── DATABASE.md               Technical database reference
│
├── assets/
│   ├── css/
│   │   └── style.css             All interface styles, themes, and responsive rules
│   ├── js/
│   │   ├── theme.js              Applies the saved or preferred theme before paint
│   │   └── script.js             Confirmations, password toggle, drawer, course filter
│   └── img/
│       ├── bicol-university-logo.png
│       ├── bu-polangui-logo.png
│       ├── bupc.jpg              Campus photo used in the login page and sidebar
│       └── BU-Torch.jpg          Additional campus photo (not currently referenced)
│
└── .gitignore                    Excludes local configuration and temporary files
```

---

## 8. Database Overview

The system uses a MariaDB/MySQL database named **`student_management_system`**. It contains five tables.

### 8.1 Tables

#### `departments`

Stores the academic departments of the campus.

| Field | Type | Key / Notes |
|---|---|---|
| `department_id` | INT, AUTO_INCREMENT | Primary key |
| `department_name` | VARCHAR(100) | Required; unique |
| `department_code` | VARCHAR(20) | Required; unique; used for display badges |

#### `courses`

Stores the courses offered under each department.

| Field | Type | Key / Notes |
|---|---|---|
| `course_id` | INT, AUTO_INCREMENT | Primary key |
| `course_code` | VARCHAR(20) | Required; unique |
| `course_name` | VARCHAR(150) | Required |
| `department_id` | INT | Required; foreign key to `departments.department_id` |

#### `year_levels`

Stores the year levels used by student records.

| Field | Type | Key / Notes |
|---|---|---|
| `year_level_id` | INT, AUTO_INCREMENT | Primary key |
| `year_name` | VARCHAR(50) | Required; unique |

#### `students`

Stores the student records managed by the application.

| Field | Type | Key / Notes |
|---|---|---|
| `student_id` | INT, AUTO_INCREMENT | Primary key |
| `student_number` | VARCHAR(30) | Required; unique |
| `first_name` | VARCHAR(100) | Required |
| `last_name` | VARCHAR(100) | Required |
| `birthdate` | DATE | Optional |
| `gender` | VARCHAR(20) | Optional |
| `address` | VARCHAR(255) | Optional |
| `contact_number` | VARCHAR(20) | Optional |
| `email` | VARCHAR(150) | Optional |
| `course_id` | INT | Required; foreign key to `courses.course_id` |
| `year_level_id` | INT | Required; foreign key to `year_levels.year_level_id` |
| `block` | VARCHAR(20) | Optional |
| `created_at` | TIMESTAMP | Defaults to the current date and time |

#### `users`

Stores login accounts for the system.

| Field | Type | Key / Notes |
|---|---|---|
| `user_id` | INT, AUTO_INCREMENT | Primary key |
| `username` | VARCHAR(50) | Required; unique |
| `password` | VARCHAR(255) | Required; stores a password hash |
| `role` | ENUM('admin', 'user') | Required; defaults to `user` |
| `created_at` | TIMESTAMP | Defaults to the current date and time |

### 8.2 Relationships

```text
departments (1) ───< courses (1) ───< students
                                       ▲
year_levels (1) ───────────────────────┘

users (standalone)
```

- One department can have many courses.
- One course can have many students.
- One year level can have many students.
- A student belongs to exactly one course and one year level.
- Foreign keys preserve referential integrity:
  - `courses.department_id` → `departments.department_id` (ON UPDATE CASCADE, ON DELETE RESTRICT)
  - `students.course_id` → `courses.course_id` (ON DELETE RESTRICT)
  - `students.year_level_id` → `year_levels.year_level_id` (ON DELETE RESTRICT)

### 8.3 Reference Data

The SQL file included in `database/student_management_system.sql` creates the tables and inserts the following reference data.

**Departments**

| Code | Name |
|---|---|
| EDUC | Education Department |
| CSD | Computer Studies Department |
| ENG | Engineering Department |
| TECH | Technology Department |
| NURS | Nursing Department |
| ENTREP | Entrepreneurship Department |

**Courses**

| Code | Course Name | Department |
|---|---|---|
| BSIT | Bachelor of Science in Information Technology | CSD |
| BSCS | Bachelor of Science in Computer Science | CSD |
| BSIS | Bachelor of Science in Information Systems | CSD |
| ITANIM | Information Technology - Animation | CSD |
| BSCpE | Bachelor of Science in Computer Engineering | ENG |
| ECE | Bachelor of Science in Electronics Engineering | ENG |
| BEEd | Bachelor of Elementary Education | EDUC |
| BSEd-ENG | Bachelor of Secondary Education Major in English | EDUC |
| BSEd-MATH | Bachelor of Secondary Education Major in Mathematics | EDUC |
| BTLEd | Bachelor of Technology and Livelihood Education | EDUC |
| BSAT | Bachelor of Science in Automotive Technology | TECH |
| BSET-ELEC | Bachelor of Science in Electrical Technology | TECH |
| BSET-ELT | Bachelor of Science in Electronics Technology | TECH |
| BSMeT | Bachelor of Science in Mechanical Technology | TECH |
| BSN | Bachelor of Science in Nursing | NURS |
| BSEntrep | Bachelor of Science in Entrepreneurship | ENTREP |

**Year levels**

- First Year
- Second Year
- Third Year
- Fourth Year

> The SQL file contains **schema and reference data only**. It does **not** include student records, user accounts, usernames, password hashes, or any credentials. Student records and accounts are created through the application after installation.

---

## 9. Installation and Setup Using XAMPP

### 9.1 Install and start XAMPP

1. Install XAMPP from the official Apache Friends website.
2. Open the **XAMPP Control Panel**.
3. Start **Apache**.
4. Start **MySQL**.
5. Confirm that both modules show a running status. If a port conflict appears, resolve it before continuing.

### 9.2 Place the project in the web root

1. Copy the entire `student_management_system` folder into `C:\xampp\htdocs\`.
2. The resulting path should be:

   ```text
   C:\xampp\htdocs\student_management_system
   ```

3. Confirm that `index.php` is directly inside that folder.

### 9.3 Create and import the database

The project includes a ready-to-import SQL file:

```text
database/student_management_system.sql
```

**Option A: Import through phpMyAdmin**

1. Open `http://localhost/phpmyadmin` in your browser.
2. *Optional:* create the database ahead of time. In the left panel, click **New**, enter the name `student_management_system`, choose the collation `utf8mb4_general_ci`, and click **Create**.

   > This step is not required. The SQL file already creates the database if it does not exist and sets `utf8mb4` / `utf8mb4_general_ci`, so creating it first only lets you select it in advance.

3. Select the database in the left panel **only if you created it in step 2**. If you skipped step 2, stay on the phpMyAdmin home page; the import will create the database.
4. Open the **Import** tab.
5. Click **Choose File** and select:

   ```text
   C:\xampp\htdocs\student_management_system\database\student_management_system.sql
   ```

6. Leave the default import settings and click **Import** (or **Go**).
7. Wait for the success message. The five tables and the reference data should now be visible.

**Option B: Import from the phpMyAdmin home page**

1. Open `http://localhost/phpmyadmin`.
2. Open the **Import** tab without selecting a database.
3. Choose `database/student_management_system.sql`.
4. Click **Import**.

The SQL file itself creates the database if it does not exist, so Option B also works.

> **Caution:** The SQL file contains `DROP TABLE IF EXISTS` statements for the five application tables. Do not import it into a database that contains records you need to keep.

### 9.4 Configure the database connection

The repository includes a template configuration file, but not the local credentials file.

1. Open the `config` folder.
2. Copy `database.example.php` and rename the copy to `database.php`.
3. Open `config/database.php` in a text editor.
4. Set the values for your own MySQL/MariaDB installation:

   ```php
   $host = "localhost";
   $dbname = "student_management_system";
   $username = "your_username";
   $password = "your_password";
   ```

   These are the same placeholders used in `config/database.example.php`; replace them with the credentials of your own MySQL/MariaDB account.

5. Save the file.

Notes:

- In a default XAMPP installation, the MySQL administrator account is usually `root`. Use whatever account and password you configured in your own XAMPP setup.
- Do **not** commit `config/database.php` to a public repository. It is already listed in `.gitignore`.
- If your copy of the project already contains `config/database.php`, edit that file instead of creating a new one.
- The database name must match the name created in Section 9.3.

### 9.5 Create the first administrator account

The SQL import does not include user accounts. Create the first account through the application, then promote it to administrator.

**Step 1: Register an account**

1. Open `http://localhost/student_management_system/`.
2. Click **Sign up now**.
3. Register a username and a password of at least 8 characters.
4. Log in with the new account.

At this point the account has the **user** role.

**Step 2: Promote the account to administrator**

Using phpMyAdmin:

1. Open `http://localhost/phpmyadmin`.
2. Select the `student_management_system` database.
3. Open the `users` table.
4. Locate the row for the account you just registered.
5. Click **Edit**.
6. Change the `role` field from `user` to `admin`.
7. Click **Go**.

Alternatively, run this SQL statement in phpMyAdmin's **SQL** tab:

```sql
UPDATE users
SET role = 'admin'
WHERE username = 'your_username';
```

Replace `your_username` with the username you registered.

**Step 3: Refresh the session**

1. Log out of the application.
2. Log in again.

The new role is read from the database during login. After signing in, the administrator dashboard and student management actions become available.

> No default administrator username or password is provided in this project. Each installation creates its own account through the registration page.

### 9.6 Run the application

Open the following URL in your browser:

```text
http://localhost/student_management_system/
```

The login page should appear. If the page cannot be reached:

1. Confirm that Apache and MySQL are running in the XAMPP Control Panel.
2. Confirm that the project folder is inside `C:\xampp\htdocs\`.
3. Confirm that the database name in `config/database.php` matches the imported database.
4. Check the Apache error log if a PHP or database error is displayed.

---

## 10. How to Access and Use the Application

### 10.1 Login and registration

1. Open `http://localhost/student_management_system/`.
2. Enter an existing username and password and click **Login**, or click **Sign up now** to create an account.
3. After login, the system redirects you according to your role:
   - Administrators go to the dashboard.
   - Regular users go to the student list.

### 10.2 Regular user workflow

A regular user can:

1. View the student list.
2. Search by student number, first name, or last name.
3. Click **View** on a record to open the student profile.
4. Use the **Clear Search** link to return to the full list.
5. Switch between light and dark mode using the theme button.
6. Log out using the logout link in the sidebar.

Regular users do not see the add, edit, or delete controls.

### 10.3 Administrator workflow

After logging in as an administrator:

**Dashboard**

- Review total students, courses, year levels, and users.
- Use the management shortcuts to open the student list or the add-student form.

**Viewing and searching students**

1. Open **Students** in the sidebar.
2. Use the search field to filter records.
3. Click **View** to open a student's complete profile.

**Adding a student**

1. Click **Add New Student** (labelled **Add Student** in the sidebar).
2. Complete the personal information fields.
3. Select a **Department**.
4. Select a **Course**. Only courses belonging to the selected department are shown.
5. Select the **Year Level** and enter the **Block** if applicable.
6. Click **Add Student**.

Required fields are marked with an asterisk. The server validates the input even if browser validation is bypassed.

**Editing a student**

1. Open the student list or a student profile.
2. Click **Edit** on the target row in the student list (`students/index.php`), or click **Edit Student** on the student profile page (`students/view.php`).
3. Update the fields.
4. Click **Save Changes**.

Changing the department clears the selected course so that a valid course from the new department can be chosen.

**Deleting a student**

1. In the student list, click **Delete** on the target row.
2. Confirm the deletion in the browser dialog.
3. The record is removed and a success message is displayed.

Deletion is accepted only through a POST request with a valid CSRF token.

### 10.4 Interface controls

- **Theme button:** switches between light and dark mode and remembers the choice in the browser.
- **Sidebar:** provides navigation between the dashboard (administrators), student list, and **Add Student** form (administrators).
- **Mobile menu button:** opens and closes the navigation drawer on small screens. Pressing `Escape` or clicking outside the drawer also closes it.
- **Password eye icon:** shows or hides the password field while typing.

---

## 11. Security Measures

The application implements the following security measures:

### 11.1 Authentication

- Passwords are stored using PHP's `password_hash()` with `PASSWORD_DEFAULT`.
- Login verifies passwords using `password_verify()`.
- The session ID is regenerated after a successful login to prevent session fixation.
- Invalid login attempts receive a generic message that does not reveal whether the username or password was incorrect.
- Logout clears session data, expires the session cookie, and destroys the session.

### 11.2 Authorization

- `requireLogin()` protects pages that require authentication.
- `requireAdmin()` protects administrator-only pages and returns HTTP 403 for non-administrators.
- Administrator-only controls are also hidden from regular users in the interface.
- Access checks are performed on the server, not only in the browser.

### 11.3 Database Security

- All database queries that accept user input use PDO prepared statements with bound parameters.
- SQL errors are written to the server error log and are not displayed to users.
- Foreign keys protect the relationships between departments, courses, students, and year levels.
- Selected departments, courses, and year levels are verified to exist before a record is saved.
- The server verifies that the selected course belongs to the selected department.

### 11.4 Cross-Site Request Forgery (CSRF)

- A random CSRF token is generated and stored in the session.
- The token is included in login, registration, add, edit, and delete forms.
- Submitted tokens are compared using `hash_equals()`, which provides a timing-safe comparison.
- The delete handler rejects non-POST requests.

### 11.5 Session Security

- `session.use_strict_mode` is enabled.
- `session.use_only_cookies` is enabled.
- `session.use_trans_sid` is disabled.
- Session cookies are `HttpOnly`.
- Session cookies use `SameSite=Lax`.
- Session cookies use the `Secure` flag automatically when the site is served over HTTPS.

### 11.6 Output and Input Handling

- Dynamic output is escaped with `htmlspecialchars()` before being rendered.
- Input is trimmed and validated on the server.
- Email addresses are validated with `filter_var()`.
- Dates are validated with `DateTime::createFromFormat()`.
- Identifiers are validated as positive integers.
- Student numbers are checked for uniqueness by the database, and duplicate-key errors are handled gracefully.
- Write and authentication handlers (`register.php`, `students/create.php`, `students/edit.php`, `students/delete.php`) catch and log SQL errors instead of showing database details to users.
- The read views (`students/index.php`, `students/view.php`) execute their queries without a try/catch block; a database failure on those pages is not converted into a friendly message.

### 11.7 HTTP Security Headers

The application sends the following headers:

- `X-Content-Type-Options: nosniff`
- `X-Frame-Options: DENY`
- `Referrer-Policy: strict-origin-when-cross-origin`
- `Permissions-Policy: camera=(), microphone=(), geolocation=()`

### 11.8 Configuration Protection

- `config/database.php` is excluded from version control through `.gitignore`.
- Only the placeholder file `config/database.example.php` is intended to be committed.
- The repository does not include real database credentials, administrator accounts, or student records.

### 11.9 Known Limitations

For transparency, the current version does not yet provide:

- Login rate limiting or account lockout.
- Password reset functionality.
- Two-factor authentication.
- Audit logs for record changes.
- HTTPS by default in the local XAMPP environment.
- Protection against all possible denial-of-service or automated abuse scenarios.

These limitations are acceptable for a local academic project but should be addressed before a production deployment.

---

## 12. Project Information

Complete the following details before submitting the project.

| Item | Details |
|---|---|
| Project title | Bicol University–Polangui Student Management System |
| Project type | BSIT Final Project |
| Student name | [Your Name] |
| Course and section | [Your Course and Section] |
| Instructor | [Instructor's Name] |
| Institution | Bicol University–Polangui Campus |
| School year | [School Year] |
| Date completed | [Date] |

---

## 13. License and Use

This project was created for academic purposes at Bicol University–Polangui Campus. It is intended for educational demonstration and local use. Student information must be handled responsibly and in accordance with the institution's data privacy policies.
