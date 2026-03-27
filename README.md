# CampusConnect

CampusConnect is a mini social networking web application built for the Web Systems and Technologies final project. It follows a PHP MVC structure with MySQL as the database and Bootstrap-based responsive views.

## Core Features

- User registration, login, logout, and password hashing
- Profile management with bio and profile photo upload
- Newsfeed/timeline with latest posts from all users
- Full CRUD for posts
- Full CRUD for comments
- Like/unlike reactions with counters
- User search and discovery
- Direct messaging with polling-based refresh
- Session-based authorization and ownership checks

## Tech Stack

- Front-end: HTML, CSS, Bootstrap, JavaScript
- Back-end: PHP MVC
- Database: MySQL

## Folder Structure

```text
app/
  controllers/
  models/
  views/
public/
  index.php
  assets/
config/
  database.php
sql/
  social_app.sql
docs/
  FINAL_DOCUMENTATION.md
  PRESENTATION_SCRIPT.md
  SCREENSHOT_CHECKLIST.md
```

## Setup

1. Start Apache and MySQL in XAMPP.
2. Create or import the database using [`sql/social_app.sql`](C:\xampp\htdocs\campusconnect\sql\social_app.sql).
3. Open the app in your browser through `http://localhost/campusconnect/public/index.php`.

## Demo Accounts

If you import the SQL seed data:

- Username: `demo_admin`
- Password: `password123`

- Username: `demo_student`
- Password: `password123`

## Documentation

See the following files inside [`docs`](C:\xampp\htdocs\campusconnect\docs):

- [`FINAL_DOCUMENTATION.md`](C:\xampp\htdocs\campusconnect\docs\FINAL_DOCUMENTATION.md)
- [`PRESENTATION_SCRIPT.md`](C:\xampp\htdocs\campusconnect\docs\PRESENTATION_SCRIPT.md)
- [`SCREENSHOT_CHECKLIST.md`](C:\xampp\htdocs\campusconnect\docs\SCREENSHOT_CHECKLIST.md)
