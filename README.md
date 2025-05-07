# 🎓 GestionConcours

**GestionConcours** is a simple yet functional online election management system built during my **first year of Computer Engineering** studies. It allows students to register, authenticate, and participate in secure elections, with real-time result tracking and PDF generation. 

> 💬 *Looking back, I can see that it's messy — yet functional. It reflects my early learning phase and how much I've grown since then.*

## 🛠 Technologies Used

- **PHP** (Core server-side logic)
- **MySQL** (Database management)
- **HTML/CSS** (Frontend structure and styling)
- **AJAX (JavaScript)** (Real-time updates)
- **FPDF** (PDF generation)
- **PHPMailer** (Email notifications)

## 📁 Project Structure

| File / Folder            | Description |
|-------------------------|-------------|
| `authen.php`            | Handles user login and authentication |
| `connect.php`           | Database connection setup |
| `inscription.php`       | Registration form for users |
| `traitement_inscr2.php` | Processes registration form submissions |
| `administration.php`    | Admin panel for managing the contest |
| `lister.php`            | Lists registered participants |
| `modifier_infos.php`    | Allows updating user information |
| `supprimer.php`         | Deletes participant records |
| `generate_pdf.php`      | Generates PDF summaries of registrations |
| `recap.php`             | Displays a recap of votes or registrations |
| `search.php`            | Simple search/filter functionality |
| `sql_queries.txt`       | Stores SQL queries for development reference |
| `fpdf186/`              | FPDF library folder for generating PDFs |
| `PHPMailer/`            | PHPMailer library folder for email sending |
| `uploads/`              | Directory for storing uploaded files |
| `inscriptionstyle.css`  | CSS styling for the registration page |

## ✅ Features

- 🔐 User login system with authentication
- 🗳️ Voting or registration handling with validation
- 📄 PDF export of participant data
- 📬 Email notifications using PHPMailer
- 🔍 Admin functionalities: list, update, delete users
- ⚡ Real-time results via AJAX
- 🎨 Basic form styling with CSS

## 🚀 How to Run

1. Clone or download the repository.
2. Import the MySQL database using the provided `sql_queries.txt`.
3. Configure database credentials in `connect.php`.
4. Place the project in your web server directory (e.g., `htdocs` for XAMPP).
5. Start Apache and MySQL, then navigate to `localhost/Voting-system` in your browser.

## 📌 Notes

- This project was created as a **learning project in my first year of Computer Science**.
- It’s a functional but simple system focused on learning the basics of full-stack web development with PHP.

## 📬 Contact

latifahfall888@gmail.com
If you have questions or feedback, feel free to reach out!

---


