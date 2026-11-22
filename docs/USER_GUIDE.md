# User Guide

**Bicol University–Polangui Student Management System**
A beginner-friendly guide for administrators and regular users

---

## Table of Contents

1. [About This Guide](#1-about-this-guide)
2. [System Overview and User Roles](#2-system-overview-and-user-roles)
3. [Getting Started](#3-getting-started)
4. [Understanding the Screen](#4-understanding-the-screen)
5. [Administrator Guide](#5-administrator-guide)
6. [Regular User Guide](#6-regular-user-guide)
7. [Student Form Reference](#7-student-form-reference)
8. [Messages and Troubleshooting](#8-messages-and-troubleshooting)
9. [Access Restrictions and Security](#9-access-restrictions-and-security)
10. [Quick Reference and FAQ](#10-quick-reference-and-faq)
- [Appendix: Screenshot Index](#appendix-screenshot-index)

---

## 1. About This Guide

This guide explains how to use the Bicol University–Polangui Student Management System: how to sign in, find student records, and—if you are an administrator—how to add, edit, and delete records.

It is written for first-time users and assumes no prior experience with the system. Installation and database setup are covered separately in the main [README](../README.md#9-installation-and-setup-using-xampp).

### 1.1 Conventions used in this guide

| Convention | Meaning |
|---|---|
| **Bold text** | A button, link, menu item, or field label that you can see on the screen. |
| `Code-style text` | A message, page path, or value shown exactly as the system displays it. |
| An asterisk (`*`) | A required field on a form. |
| **Note** | Useful information about how the system behaves. |
| **Warning** | An action that cannot be undone or that affects data. |

### 1.2 What this guide does not contain

- Real account credentials or example passwords.
- Real student information.
- Steps for changing the database directly.
- Features that the application does not provide.

Screenshots are represented by plain-text placeholders. They are marked with the suggested filename and the state that should be captured. No screenshot images are included yet.

---

## 2. System Overview and User Roles

The Student Management System stores student records for Bicol University–Polangui Campus. Each record contains personal information and academic information such as the student's course, department, year level, and block.

The application has two account roles.

| Capability | Regular User | Administrator |
|---|---|---|
| Log in and log out | Yes | Yes |
| View the student list | Yes | Yes |
| Search for students | Yes | Yes |
| View a student profile | Yes | Yes |
| Open the administrator dashboard | No | Yes |
| Add a student | No | Yes |
| Edit a student | No | Yes |
| Delete a student | No | Yes |
| Manage user accounts | No | No |
| Manage departments, courses, or year levels | No | No |

### 2.1 Important information about accounts

- **Public registration always creates a regular user account.** The registration page does not create an administrator.
- Administrator access is assigned during initial system setup, outside the application. The procedure is described in the main [README](../README.md#95-create-the-first-administrator-account).
- There is no screen for creating, editing, disabling, or deleting user accounts.
- There is no “Forgot Password” or in-application password reset.
- An account is used only to sign in. It is not linked to a student record.

### 2.2 What the application does not do

The application does not manage attendance, grades, class schedules, or payments. It does not export records to PDF, Excel, or CSV, and it does not send email notifications. These features should not be expected anywhere in this guide.

---

## 3. Getting Started

### 3.1 Opening the system

1. Make sure Apache and MySQL are running in the XAMPP Control Panel. If they are not, start them and wait until both show a running status.
2. Open a web browser.
3. Go to:

   ```text
   http://localhost/student_management_system/
   ```

4. The login page should appear.

> **Note:** If the page does not load, confirm that the project folder is inside `C:\xampp\htdocs\` and that Apache and MySQL are running. The main [README](../README.md#9-installation-and-setup-using-xampp) contains the full setup instructions.

```text
[ SCREENSHOT — LOGIN PAGE ]
File: docs/screenshots/ug-01-login.png
Capture: The login page in light mode, signed out, showing the Username and Password fields, the eye button, the Login button, and the Sign up now link.
```

### 3.2 Logging in

1. Enter your **Username**.
2. Enter your **Password**.
3. Optional: click the eye button beside the Password field to show or hide what you typed.
4. Click **Login**.

The system redirects you according to your role:

| Account type | Where you are taken |
|---|---|
| Administrator | Administrator dashboard |
| Regular user | Student list |

If you are already signed in and open the login page again, the system automatically redirects you to your role's home page.

### 3.3 Creating an account

1. On the login page, click **Sign up now**.
2. Enter a **Username**.
   - It must be 3 to 50 characters long.
   - It may contain only letters, numbers, and underscores.
3. Enter a **Password** of at least 8 characters.
4. Enter the same password in **Confirm Password**.
5. Click **Register**.

```text
[ SCREENSHOT — REGISTRATION PAGE ]
File: docs/screenshots/ug-02-register.png
Capture: The registration page with the Username, Password, and Confirm Password fields, the eye buttons, the Register button, and the Login here link.
```

If the account is created successfully, the login page opens with this green message:

```text
Registration successful! You can now log in to your account.
```

```text
[ SCREENSHOT — REGISTRATION SUCCESS ]
File: docs/screenshots/ug-03-registration-success.png
Capture: The login page after registration, showing the green Registration successful message above the login form.
```

> **Important:** Registration does not sign you in automatically. You must enter your new username and password on the login page.

### 3.4 What happens after registration

- The new account is always a **regular user** account.
- A regular user can browse, search, and view student records but cannot add, edit, or delete them.
- If you need administrator access, the account must be promoted during system setup. This is not done through the registration page and is not described with credentials in this guide.

### 3.5 If you cannot log in

- Check the spelling of your username and password. The login error does not say which one is wrong.
- Confirm that the account has already been registered.
- There is no password-reset link. If you forget your password, contact the person who maintains the system; account maintenance must be done outside the application.
- If you see “Invalid security token”, refresh the page and try again.

---

## 4. Understanding the Screen

### 4.1 Sidebar and navigation

After signing in, the application uses a sidebar for navigation. The links depend on your role.

**Administrator sidebar:**

- **Dashboard**
- **Students**
- **Add Student**

**Regular-user sidebar:**

- **Students**

The sidebar footer contains:

- The **Appearance** label and the light/dark theme button.
- Your initial, username, and role label (“Administrator” or “User”).
- **Logout**

The brand area at the top of the sidebar links to your role's home page. The current page is highlighted in the navigation.

```text
[ SCREENSHOT — ADMINISTRATOR NAVIGATION ]
File: docs/screenshots/ug-05-admin-navigation.png
Capture: The administrator sidebar on a desktop screen, showing Dashboard, Students, Add Student, the Appearance theme button, the Administrator role label, and Logout.
```

```text
[ SCREENSHOT — REGULAR USER NAVIGATION ]
File: docs/screenshots/ug-06-user-navigation.png
Capture: The regular-user sidebar showing only Students, with the User role label, the theme button, and Logout. No add, edit, or delete controls should be visible.
```

### 4.2 Mobile navigation

On a narrow screen, the sidebar is replaced by a top bar with a menu button.

1. Tap the menu button to open the navigation drawer.
2. Tap a link to open that page. The drawer closes automatically.
3. To close the drawer without choosing a link, tap the dark backdrop, press `Escape`, or rotate/resize the screen to a wider layout.

```text
[ SCREENSHOT — MOBILE NAVIGATION DRAWER ]
File: docs/screenshots/ug-18-mobile-drawer.png
Capture: The application on a narrow mobile-width screen with the navigation drawer open, showing the menu links and the top bar.
```

### 4.3 Light and dark mode

The theme button appears:

- At the top-right of the login and registration pages.
- In the sidebar under **Appearance** on desktop.
- In the mobile top bar.

1. Click or tap the sun/moon button to switch between light and dark mode.
2. The icon changes and the whole interface updates.
3. The choice is remembered in the browser.

On your first visit, the system follows your operating system's light or dark preference. The theme is applied before the page appears, so the page should not flash in the wrong colours.

```text
[ SCREENSHOT — DARK MODE ]
File: docs/screenshots/ug-17-dark-mode.png
Capture: Any main application page with dark mode enabled, showing the sun icon and the dark colour scheme.
```

### 4.4 Logging out

1. Open the sidebar.
2. Click **Logout**.

The system ends your session and returns you to the login page. There is no confirmation prompt and no “logged out” message.

> **Note:** The session lasts for the browser session. You may be signed out automatically after closing the browser. Always click **Logout** when using a shared computer.

---

## 5. Administrator Guide

This section applies only to accounts with the administrator role. Regular users should use [Section 6](#6-regular-user-guide).

### 5.1 Reading the dashboard

1. Sign in with an administrator account.
2. The **Administrator Dashboard** opens automatically. You can also click **Dashboard** in the sidebar.
3. Review the four statistic cards.

| Card | What it counts |
|---|---|
| Total Students | All student records |
| Total Courses | All courses in the reference data |
| Total Year Levels | All year levels in the reference data |
| Total Users | All registered accounts, including administrators |

The **Management** panel contains two links:

- **Manage Students** opens the student list.
- **Add New Student** opens the add form.

The dashboard shows counts only. It does not contain charts, recent activity, or a user-management table.

```text
[ SCREENSHOT — ADMINISTRATOR DASHBOARD ]
File: docs/screenshots/ug-04-admin-dashboard.png
Capture: The administrator dashboard with the welcome heading, the four statistic cards, and the Management links.
```

### 5.2 Browsing the student list

1. Click **Students** in the sidebar, or click **Manage Students** on the dashboard.
2. The page heading is **Students**.
3. Review the table.

| Column | Contents |
|---|---|
| Student Number | The school-issued number |
| First Name | Student's first name |
| Last Name | Student's last name |
| Course | Course code and course name |
| Department | Colour-coded department badge and department name |
| Year Level | First Year, Second Year, Third Year, or Fourth Year |
| Block | Block or section label, if provided |
| Actions | **View**, **Edit**, and **Delete** for administrators |

Above the table, the page shows **+ Add New Student** and a search form.

> **Note:** The list has no page controls. Every matching record is displayed in one table, in ascending record order. Use search to narrow a long list.

```text
[ SCREENSHOT — STUDENT LIST FOR ADMINISTRATORS ]
File: docs/screenshots/ug-07-student-list.png
Capture: The student list while signed in as an administrator, showing the search form, the Add New Student button, the table columns, and the View, Edit, and Delete actions.
```

### 5.3 Searching for a student

1. In the search field, type part or all of a **student number**, **first name**, or **last name**. The placeholder reads “Search student number or name...”.
2. Click **Search** or press `Enter`.
3. The table shows only matching records. The count above the table changes to “Search results: N”.
4. To return to the full list, click **Clear Search**.

Search is a partial match, so a short fragment is enough. It does not search by course, department, year level, block, or email address.

If nothing matches, the table displays:

```text
No student records found.
```

```text
[ SCREENSHOT — SEARCH RESULTS ]
File: docs/screenshots/ug-08-search-results.png
Capture: The student list after a search, showing the search term in the field, the Search results count, and the filtered rows.
```

```text
[ SCREENSHOT — NO SEARCH RESULTS ]
File: docs/screenshots/ug-09-no-results.png
Capture: The student list after a search that matched nothing, showing the Search results count and the No student records found message.
```

### 5.4 Viewing a student profile

1. In the student list, click **View** on the target row.
2. Review the profile.
3. To return to the list, click **Back to Student Records** at the top or bottom.

The profile contains:

- The student's full name, student number, and department badge.
- **Personal Information**: Student Number, First Name, Last Name, Birthdate, Gender, Contact Number, Email Address, and Address.
- **Academic Information**: Course Code, Course Name, Department, Year Level, and Block.
- **Record Information**: Date Added.

Blank optional values are shown as “Not provided”. The Date Added value is displayed as a date and time.

Administrators see an **Edit Student** button on this page. Regular users do not.

```text
[ SCREENSHOT — STUDENT PROFILE FOR ADMINISTRATORS ]
File: docs/screenshots/ug-10-student-profile-admin.png
Capture: A student profile viewed as an administrator, showing the personal, academic, and record sections and the Edit Student button.
```

### 5.5 Adding a student

1. Open the add form using any of these methods:
   - Click **Add Student** in the sidebar.
   - Click **+ Add New Student** on the student list.
   - Click **Add New Student** on the dashboard.
2. Complete the **Personal Information** section.
   - **Student Number** is required and must be unique.
   - **First Name** and **Last Name** are required.
   - **Birthdate** is optional; use the date field.
   - **Gender** is optional; choose **Select Gender**, **Male**, or **Female**.
   - **Contact Number**, **Email Address**, and **Address** are optional.
3. Complete the **Academic Information** section.
   - Select a **Department**. This is required.
   - Select a **Course**. Only courses belonging to the selected department appear.
   - Select a **Year Level**. This is required.
   - Enter a **Block** if applicable. This is optional.
4. Click **Add Student**.

Fields marked with `*` are required. The page also displays the note “* Required fields”.

If the record is saved, the same add page reloads with this green message:

```text
Student added successfully!
```

The form is then empty, ready for another record. To see the new student, open **Students**.

```text
[ SCREENSHOT — ADD STUDENT: PERSONAL INFORMATION ]
File: docs/screenshots/ug-12-add-personal.png
Capture: The top of the Add New Student form, showing the required Student Number, First Name, and Last Name fields, the birthdate and gender fields, and the optional contact fields.
```

```text
[ SCREENSHOT — ADD STUDENT: DEPARTMENT AND FILTERED COURSES ]
File: docs/screenshots/ug-13-add-course-filter.png
Capture: The Academic Information section with a department selected and the Course list showing only courses from that department.
```

> **Note:** If the student number already exists, the page shows “That student number may already exist.” Check the existing record before trying again.

### 5.6 Editing a student

1. Open the edit form in either of these ways:
   - In the student list, click **Edit** on the target row.
   - On the student profile, click **Edit Student**.
2. Change the needed fields. The current values are already filled in.
3. Click **Save Changes**.

If the update succeeds, the student list opens with this green message:

```text
Student updated successfully!
```

> **Note:** If you change the **Department**, the **Course** selection is cleared. Choose a new course from the newly selected department before saving.

To leave without saving, click **Cancel**. Changes are discarded immediately and there is no confirmation prompt.

```text
[ SCREENSHOT — EDIT STUDENT FORM ]
File: docs/screenshots/ug-15-edit-student.png
Capture: The Edit Student form with an existing record loaded, the department and course preselected, and the Save Changes and Cancel buttons visible.
```

### 5.7 Deleting a student

> **WARNING — PERMANENT DELETION:** Deleting a student removes the record permanently. There is no undo, recycle bin, or restore option.

1. Go to the student list.
2. Click **Delete** on the target row.
3. A browser confirmation appears:

   ```text
   Are you sure you want to delete this student?
   ```

4. Click **OK** or **Confirm** to delete, or **Cancel** to keep the record.
5. If you confirm, the list reloads with this green message:

   ```text
   Student deleted successfully!
   ```

Deletion is available only from the student list. It is not available on the profile page.

> **Caution:** The confirmation prompt is provided by JavaScript. If JavaScript is disabled in the browser, clicking **Delete** submits the deletion without showing the prompt.

```text
[ SCREENSHOT — DELETE CONFIRMATION ]
File: docs/screenshots/ug-16-delete-confirm.png
Capture: The student list with the browser confirmation dialog open, showing the message Are you sure you want to delete this student?
```

---

## 6. Regular User Guide

This section applies to regular user accounts. Public registration creates this type of account.

### 6.1 Browsing the student list

1. Sign in. A regular user is taken directly to the student list.
2. The sidebar shows **Students** as the only navigation link.
3. Browse the table. The columns are Student Number, First Name, Last Name, Course, Department, Year Level, Block, and Actions.

In the Actions column, regular users see only **View**. There is no **+ Add New Student** button, and no **Edit** or **Delete** controls.

### 6.2 Searching for a student

1. Type part or all of a student number, first name, or last name in the search field.
2. Click **Search** or press `Enter`.
3. The list updates and the count changes to “Search results: N”.
4. Click **Clear Search** to return to the full list.

Search does not cover course, department, year level, block, or email address.

### 6.3 Viewing a student profile

1. Click **View** on the target row.
2. Review the personal, academic, and record information.
3. Click **Back to Student Records** to return to the list.

A regular user's profile view does not include the **Edit Student** button.

```text
[ SCREENSHOT — STUDENT PROFILE FOR REGULAR USERS ]
File: docs/screenshots/ug-11-student-profile-user.png
Capture: The same student profile viewed as a regular user, showing the profile sections without any Edit Student button.
```

### 6.4 Actions that are not available to you

A regular user cannot:

- Open the administrator dashboard.
- Add a student.
- Edit a student.
- Delete a student.
- Manage user accounts or reference data.

If you open an administrator-only page directly, the system returns a plain page with:

```text
Access denied. Admin privileges are required.
```

The controls are hidden in the interface, but the restriction is enforced by the server. If a student record needs to be changed, ask an administrator.

---

## 7. Student Form Reference

This section explains the fields on the **Add New Student** and **Edit Student** forms.

### 7.1 Required and optional fields

| Field | Required? | Guidance |
|---|---|---|
| Student Number | Yes | Must be unique. The database stores up to 30 characters. |
| First Name | Yes | Up to 100 characters. |
| Last Name | Yes | Up to 100 characters. |
| Birthdate | No | Use the date field. Leave blank if unknown. |
| Gender | No | Choose **Select Gender**, **Male**, or **Female**. |
| Contact Number | No | Up to 20 characters. No format check is applied. |
| Email Address | No | Must look like a valid email address if filled. Up to 150 characters. Duplicate addresses are allowed. |
| Address | No | Up to 255 characters. |
| Department | Yes | Used to filter the course list. Not stored on the student record. |
| Course | Yes | Must belong to the selected department. |
| Year Level | Yes | Choose one of the available year levels. |
| Block | No | Up to 20 characters. |

> **Note:** The form does not display these length limits. If a value is too long for the database, the save may fail with a general error. Keep entries reasonably short.

### 7.2 How department and course selection works

1. The **Course** list is disabled at first and shows “Select a department first”.
2. After you choose a **Department**, the Course list becomes available.
3. Only courses that belong to that department are shown. The placeholder reads “Select Course”.
4. If you change the department, the previous course is cleared. Choose a course again.
5. If a department had no courses, the list would show “No courses available”. All current departments have courses.

Changing the department clears the course because a course belongs to exactly one department. Keeping the old course would create an invalid combination.

The form displays this hint:

```text
Available courses update based on the selected department.
```

If JavaScript is disabled, all courses are shown instead. The server still checks that the selected course belongs to the selected department before saving.

### 7.3 Form tips

- Complete the required fields first; the browser may show its own “Please fill out this field” message.
- Use a unique student number. The database enforces uniqueness.
- Check the email format if you enter an email address.
- Use the date field for the birthdate rather than typing an unusual format.
- Review the department and course before saving.
- On **Edit Student**, click **Save Changes** only when you are finished; **Cancel** discards changes immediately.

---

## 8. Messages and Troubleshooting

### 8.1 Success messages

| Message | Appears when |
|---|---|
| `Registration successful! You can now log in to your account.` | A new account was created and the login page reopened |
| `Student added successfully!` | A new student record was saved |
| `Student updated successfully!` | An edited record was saved and the list reopened |
| `Student deleted successfully!` | A record was deleted and the list reopened |

### 8.2 Validation messages

Validation errors appear in a red panel headed “Please check the following:”.

| Message | Meaning | What to do |
|---|---|---|
| `Student number is required.` | The student number is blank. | Enter a student number. |
| `First name is required.` | The first name is blank. | Enter the first name. |
| `Last name is required.` | The last name is blank. | Enter the last name. |
| `Please select a department.` | No department was chosen. | Choose a department. |
| `Please select a course.` | No course was chosen. | Choose a course from that department. |
| `Please select a year level.` | No year level was chosen. | Choose a year level. |
| `Please enter a valid email address.` | The email format is invalid. | Correct the email or clear the field. |
| `Please enter a valid birthdate.` | The birthdate is not a valid date. | Use the date field to choose a valid date. |
| `Selected department does not exist.` | The submitted department is no longer valid. | Refresh the page and choose a department again. |
| `Selected course does not exist.` | The submitted course is no longer valid. | Refresh the page and choose a course again. |
| `Selected course does not belong to the selected department.` | The course and department do not match. | Choose a course from the selected department. |
| `Selected year level does not exist.` | The submitted year level is no longer valid. | Refresh the page and choose a year level again. |
| `That student number may already exist.` | The student number is already used. | Check the existing record or use the correct number. |
| `Unable to save the student. Please try again.` | The record could not be saved. | Check the values and try again. |
| `Unable to update the student. Please try again.` | The edit could not be saved. | Check the values and try again. |
| `Invalid security token. Please refresh the page and try again.` | The form expired or the session changed. | Refresh the page and submit the form again. |

```text
[ SCREENSHOT — FORM VALIDATION ERRORS ]
File: docs/screenshots/ug-14-form-errors.png
Capture: The Add New Student form after an invalid submission, showing the red Please check the following panel with at least two validation messages.
```

### 8.3 Access and session messages

| Message or behaviour | Meaning | What to do |
|---|---|---|
| `Access denied. Admin privileges are required.` | A regular user opened an administrator-only page. | Return to **Students**. Ask an administrator if a change is needed. |
| `Invalid username or password.` | The login details did not match an account. | Check the spelling and try again. |
| `Please enter your username and password.` | One or both login fields were empty. | Enter both values. |
| `Invalid security token. Please refresh the page.` | The login form token was not accepted. | Refresh the page and log in again. |
| `Invalid student ID.` | A profile or edit link has a missing or invalid ID. | Return to the student list and open the record again. |
| `Student record not found.` | The record no longer exists. | Return to the student list. |
| Redirected to login with no message | You are signed out or your session ended. | Log in again. |

### 8.4 Troubleshooting

| Problem | What to do |
|---|---|
| I cannot log in. | Check the username and password. The error does not say which is wrong. If you forgot the password, contact the system maintainer; there is no reset link. |
| I registered but I am still on the login page. | This is expected. Use your new username and password to log in. |
| I cannot see **Add Student**, **Edit**, or **Delete**. | Your account is a regular user. These actions are administrator-only. |
| The **Course** list is disabled. | Select a **Department** first. |
| My course disappeared after I changed the department. | This is expected. Choose a course again from the new department. |
| The form says my student number may already exist. | Search the student list for that number. Use **Edit** on the existing record instead of adding a new one. |
| The email address is rejected. | Use a complete address in the usual `name@example.com` form, or leave the field blank. |
| The birthdate is rejected. | Choose a valid date with the date field. |
| I clicked **Add Student** and the form is empty again. | The green message confirms it was saved. Open **Students** to see the record, or add another student. |
| I saved an edit but I do not see the change. | The list reopens with “Student updated successfully!”. Search for the record or click **View** to confirm the values. |
| The Delete button deleted the record without asking. | The confirmation depends on JavaScript. Enable JavaScript, or be especially careful with **Delete**. |
| I deleted a record by mistake. | Deletion is permanent. There is no undo. |
| I opened an administrator page and received an error. | Regular users cannot open administrator pages. Return to **Students**. |
| My link shows “Invalid student ID” or “Student record not found”. | The record may have been deleted. Return to the student list and choose a current record. |
| A long value will not save. | Shorten it. The database has length limits, such as 30 characters for the student number. |
| I was signed out unexpectedly. | The session may have ended when the browser closed. Log in again. |

---

## 9. Access Restrictions and Security

### 9.1 Permission matrix

| Action | Guest | Regular User | Administrator |
|---|---|---|---|
| Open the login page | Yes | Redirected | Redirected |
| Register an account | Yes | Redirected | Redirected |
| View the student list | No | Yes | Yes |
| Search students | No | Yes | Yes |
| View a student profile | No | Yes | Yes |
| Open the administrator dashboard | No | 403 error | Yes |
| Add a student | No | 403 error | Yes |
| Edit a student | No | 403 error | Yes |
| Delete a student | No | 403 error | Yes |
| Manage accounts or reference data | No | No | No |

### 9.2 How restrictions are applied

- Menus and buttons are hidden when they are not available to your role.
- The server also checks every protected page. Hiding a button is not the only protection.
- A regular user who types an administrator URL directly receives the plain “Access denied. Admin privileges are required.” page.
- A guest who opens a protected page is redirected to the login page without an explanatory message.

### 9.3 Account and session reminders

- Public registration is open and always produces a regular user account.
- There is no administrator approval step and no email verification.
- There is no password reset, change-password page, or account settings page.
- There is no user-to-student link; accounts are for system access only.
- The session lasts for the browser session. Click **Logout** on shared computers.
- Do not share accounts. Actions performed through an account are not individually tracked in an audit log.

### 9.4 Current limitations

The following features are **not available** in the current version:

- Pagination of the student list.
- Sorting controls or advanced filters.
- Searching by course, department, year level, block, or email.
- Password reset, password change, or account settings.
- User management screens.
- Screens for managing departments, courses, or year levels.
- Attendance, grades, schedules, or payments.
- Export to PDF, Excel, or CSV.
- Student photo uploads.
- Email notifications.
- Audit logs, restore, or undo for deleted records.
- A friendly, styled error page for access-denied and invalid-link errors.

---

## 10. Quick Reference and FAQ

### 10.1 Control and term glossary

| Item | Meaning |
|---|---|
| **Login** | Signs you in with your username and password. |
| **Sign up now** | Opens the registration page from the login page. |
| **Register** | Creates a new regular user account. |
| **Dashboard** | The administrator's home page with statistics. |
| **Students** | Opens the student list. |
| **Add Student** | Sidebar link to the add form (administrators only). |
| **Add New Student** | Button on the dashboard or student list that opens the add form. |
| **Manage Students** | Dashboard link to the student list. |
| **View** | Opens a student profile. |
| **Edit** | Opens the edit form from the student list (administrators only). |
| **Edit Student** | Opens the edit form from a profile (administrators only). |
| **Delete** | Removes a record after confirmation (administrators only). |
| **Save Changes** | Saves an edited record. |
| **Cancel** | Leaves the form without saving. |
| **Search** | Filters the list using the search field. |
| **Clear Search** | Restores the complete student list. |
| **Appearance** | Sidebar section containing the theme button. |
| **Logout** | Ends your session and returns to the login page. |
| Student number | The school-issued identifier for a student. |
| Department | The academic unit that offers a course. |
| Course | The program a student belongs to. |
| Year level | First Year through Fourth Year. |
| Block | An optional block or section label. |
| Session | The period during which you remain signed in. |

### 10.2 Frequently asked questions

**Why can't I see Add Student, Edit, or Delete?**
Your account is a regular user. Only administrators can change records.

**Why is the Course list disabled?**
Choose a Department first. The Course list then shows only that department's courses.

**Why did my course selection disappear?**
Changing the department clears the course so that an invalid course–department combination is not saved. Choose a course again.

**Can I undo a deletion?**
No. Deletion is permanent and there is no recycle bin or restore option.

**How do I change my password?**
There is no password-change page. Account maintenance must be done outside the application by the person who maintains the system.

**Where is the Forgot Password link?**
It does not exist in the current version.

**Why did my search return nothing?**
Search covers only student number, first name, and last name. It does not search course, department, year level, block, or email. Click **Clear Search** to try again.

**Why does the Add page stay open after I save?**
The same page reloads with “Student added successfully!” and an empty form so you can add another record. Open **Students** to see the saved record.

**Why am I taken to the login page when I open a page directly?**
You are signed out or your session has ended. Log in again.

**Why do I get “Access denied” when I open a dashboard link?**
The dashboard and student-management pages are restricted to administrators.

**Can I create another administrator account through registration?**
No. Registration always creates a regular user account. Administrator access is assigned during setup.

**Is there a mobile app?**
No. The system runs in a web browser and adapts to mobile screen sizes.

---

## Appendix: Screenshot Index

Screenshots should be stored in `docs/screenshots/`. Use demo records and redact real student information or usernames before capturing.

### A.1 Essential screenshots

| # | Filename | What it shows | Used in |
|---|---|---|---|
| 1 | `ug-01-login.png` | Login page, light mode, signed out | 3.1 |
| 2 | `ug-02-register.png` | Registration page with all three fields | 3.3 |
| 3 | `ug-03-registration-success.png` | Green registration success message on the login page | 3.3 |
| 4 | `ug-04-admin-dashboard.png` | Dashboard statistics and Management links | 5.1 |
| 5 | `ug-05-admin-navigation.png` | Administrator sidebar and footer | 4.1 |
| 6 | `ug-06-user-navigation.png` | Regular-user sidebar with Students only | 4.1 |
| 7 | `ug-07-student-list.png` | Student list as an administrator | 5.2 |
| 8 | `ug-08-search-results.png` | Filtered student list and result count | 5.3 |
| 9 | `ug-09-no-results.png` | “No student records found.” state | 5.3 |
| 10 | `ug-10-student-profile-admin.png` | Profile with Edit Student button | 5.4 |
| 11 | `ug-11-student-profile-user.png` | Profile without administrator controls | 6.3 |
| 12 | `ug-12-add-personal.png` | Add form, Personal Information section | 5.5 |
| 13 | `ug-13-add-course-filter.png` | Department selected and filtered Course list | 5.5 |
| 14 | `ug-14-form-errors.png` | Validation error panel on the add form | 8.2 |
| 15 | `ug-15-edit-student.png` | Pre-filled Edit Student form | 5.6 |
| 16 | `ug-16-delete-confirm.png` | Browser delete confirmation dialog | 5.7 |
| 17 | `ug-17-dark-mode.png` | Application in dark mode | 4.3 |
| 18 | `ug-18-mobile-drawer.png` | Mobile layout with navigation drawer open | 4.2 |

### A.2 Optional screenshots

| # | Filename | What it shows |
|---|---|---|
| 19 | `ug-19-duplicate-number.png` | Duplicate student number error message |
| 20 | `ug-20-update-success.png` | “Student updated successfully!” message on the list |
| 21 | `ug-21-delete-success.png` | “Student deleted successfully!” message on the list |
| 22 | `ug-22-access-denied.png` | Plain access-denied page for a regular user |
| 23 | `ug-23-invalid-student-id.png` | Plain invalid-ID page for a broken profile link |

### A.3 Capture guidelines

- Use sample or test records; do not capture real student information or real usernames.
- Use the same browser and window width for the desktop screenshots.
- Capture light mode unless the screenshot is specifically for dark mode.
- Show only the controls needed to explain the step; avoid unrelated browser tabs or bookmarks.
- Keep filenames exactly as listed so the placeholders can be replaced without editing the surrounding text.
- Replace each plain-text placeholder with the matching image and caption when screenshots are ready.

---

**Related documentation:** [Main README](../README.md) · [Database Documentation](DATABASE.md)
