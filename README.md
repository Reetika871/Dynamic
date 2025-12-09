Team: SR

1. Overview

This project is a Dynamic Meal Planning System built with Laravel. It allows users to create recipes, plan meals by date, and view daily meal schedules. The system includes authentication, a dashboard, JavaScript-based interactions, and uses SQLite for easy setup.

2. Features Implemented

User authentication (login and registration)

Recipe management (add, edit, delete, list recipes)

Meal planning for specific dates

Dashboard with daily summary

JavaScript for small UI interactions

Automated tests included

SQLite database for simple and portable setup

3. Requirements

PHP 8.1 or newer

Composer

Laravel 

SQLite support

4. Installation Instructions

Step 1: Extract the project

Unzip the.zip archive to any folder.

Step 2: Install dependencies

Install Composer packages.

Step 3: Create the environment file

Copy the example environment file to create the .env file.

Step 4: Generate the application key

Generate the Laravel application key.

5. Database Setup
Option A: Using the included SQLite file

If the archive includes a database file:

Ensure the file database/database.sqlite is present.

Update the .env file:

Set the database connection to SQLite.

Set the database path to the included SQLite file.

No further setup is required.

Option B: Creating a new SQLite database

Create a new SQLite database file in the database folder.

Update the .env file:

Set the database connection to SQLite.

Set the database path to the newly created file.

Run database migrations.

If seeders are included, run the database seeders afterward.

6. Running the Application

Start the Laravel development server.

Open the application in a web browser at the default local URL.

7. Example Login (Optional)

If a demo user is included in the provided database, list the email and password here. Otherwise, this section can be left empty.

8. Important Folders

app/: Application logic, controllers, models

resources/views/: Blade templates for the UI

resources/js/: JavaScript used in the project

routes/web.php: Application routes

database/migrations/: Database structure

tests/: Automated tests

9. Running Tests

Run the automated tests included in the tests folder.

10. Why SQLite?

SQLite is used because it requires no external installation, works immediately with Laravel, and is easy to share. The entire database is contained in a single file, making setup simple for anyone reviewing the project.

11. Team Information

Team SR
All groups members completed the project together.