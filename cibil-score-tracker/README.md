CIBIL Score Tracker
A modern, responsive website for tracking CIBIL scores, now with PHP backend and MySQL database.
Setup

Set up a PHP server (e.g., XAMPP) with MySQL.
Create the database using db/init.sql (run in phpMyAdmin or MySQL console).
Update config.php with your DB credentials if needed.
Place files in the server root.
Open index.php in a browser.
Default admin: username admin, password admin123.

Folder Structure

api/: PHP API endpoints (e.g., fetch_score.php).
assets/: CSS, JS, images.
db/: SQL script for setup.
pages/: Admin and user pages (now .php).
config.php: DB connection.
logout.php: Logout handler.
index.php: Home page.

Notes

Backend uses PDO for secure DB interactions.
Authentication uses sessions.
Scores and tips are stored/fetched from DB.
Replace logo.png with an actual image.
For production, secure passwords and use HTTPS.
