# Student Services Marketplace - MacOS Setup Guide

This project was developed as part of **CS 4347: Database Systems**. Follow the instructions below to set up the local environment on macOS using XAMPP.

## Setup Instructions

1.  **Download MySQL**: Ensure you have the standalone MySQL server installed on your machine.
    * [https://dev.mysql.com/downloads/mysql/](https://dev.mysql.com/downloads/mysql/)
3.  **Download XAMPP**: Install the XAMPP stack to manage the Apache web server and PHP environment.
    * [https://www.apachefriends.org](https://www.apachefriends.org)
4.  **Create the Database**: 
    * Start the MySQL service using `sudo /Applications/XAMPP/xamppfiles/xampp startmysql`
    * Log in to the MySQL monitor (MySQL CLI) using `/Applications/XAMPP/bin/mysql -u root`
    * Create a new database named `cs4347` using `CREATE DATABASE cs4347;`
    * Set current database to `cs4347` using `USE cs4347;`
5.  **Move Database Variables**: 
    * Locate the `xampp-var` folder in the GitHub repository.
    * Move its contents to the local path: `/Applications/XAMPP/xamppfiles/var/cs4347/`.
    * You will have to use `sudo` or update permissions for the `var/cs4347/` folder
6.  **Move Htdocs Base**: 
    * Locate the `xampp-htdocs` folder in the GitHub repository.
    * Move its contents to: `/Applications/XAMPP/xamppfiles/htdocs/cs4347/`.
7.  **Move Project Source**: 
    * Locate the `student_services_market` folder in the repository.
    * Move it to: `/Applications/XAMPP/xamppfiles/htdocs/cs4347/student_services_market/`.
8.  **Start Services**: 
    * Open the XAMPP Control Panel.
    * Start **Apache** (for PHP) and **MySQL**.
    * OR start using terminal: `sudo /Applications/XAMPP/xamppfiles/xampp startapache;` `sudo /Applications/XAMPP/xamppfiles/xampp startmysql`
    * If you want to check the current status of your services to ensure they are actually running, use `sudo /Applications/XAMPP/xamppfiles/xampp status`
9.  **Initialize Schema**: 
    * In the MySQL terminal, run:
        ```sql
        SOURCE /Applications/XAMPP/xamppfiles/htdocs/cs4347/setup.sql;
        ```
10.  **Load Data**: 
    * In the MySQL terminal, run:
        ```sql
        SOURCE /Applications/XAMPP/xamppfiles/htdocs/cs4347/load.sql;
        ```
11. **Launch Application**: 
    * Open your browser and navigate to:
        [http://localhost/cs4347/student_services_market/register.html](http://localhost/cs4347/student_services_market/register.html)

---

### Tip
To ensure the database is correctly configured, you can view the structure and tables via phpMyAdmin:
[http://localhost/phpmyadmin/index.php?route=/database/structure&db=cs4347](http://localhost/phpmyadmin/index.php?route=/database/structure&db=cs4347)

### Reset
To reset the environment to the initial state, you can run the following commands in the MySQL CLI:
```sql
SOURCE /Applications/XAMPP/xamppfiles/htdocs/cs4347/drop.sql;
```
```sql
SOURCE /Applications/XAMPP/xamppfiles/htdocs/cs4347/setup.sql;
```
```sql
SOURCE /Applications/XAMPP/xamppfiles/htdocs/cs4347/load.sql;
```
