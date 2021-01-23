# UoS Hack Camp 2021 - Group 8
## Introduction
Project X is an interactive learning tool designed to assist people in learning about online learning tool designed to educate users about online threats aimed at stealing their information.

## Requirements
Web Server running PHP 7 or higher
MySQL compatible database

## Setup
1. Using database client of your choice (Data Grip, MySQL Workbench etc.):
   - Run the db/setup.sql file to create necessary tables.
   - Run the db/data.sql file to insert content into the tables. You may skip this step if you are creating your own data.

2. Copy all directories and files from the project into the root directory of your web server.
   - It is not necessary to copy and files or directories starting with a '.'
   
3. Create a file at the root directory of the web server called secrets.php and insert the following code
   - ```
     <?php
     define('DB_HOST', '<YOUR_DB_HOST_NAME>');
     define('DB_USER', '<YOUR_DB_USER_NAME>');
     define('DB_PASSWORD', '<YOUR_DB_PASSWORD>');
     define('DB_NAME', '<YOUR_DB_SCHEMA_NAME>');
     ```
 And that's it. The website should now be up and running!