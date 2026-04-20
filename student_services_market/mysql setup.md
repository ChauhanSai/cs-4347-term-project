`create.sql`  
---

`CREATE TABLE “User” (`  
    `user_id INT PRIMARY KEY,`  
    `name VARCHAR(100) NOT NULL,`  
    `email VARCHAR(100) UNIQUE NOT NULL,`  
    `password VARCHAR(255) NOT NULL,`  
    `phone_number VARCHAR(15),`  
    `role VARCHAR(20) DEFAULT 'customer'`  
`);`

`CREATE TABLE Category (`  
    `category_id INT PRIMARY KEY,`  
    `category_name VARCHAR(50) NOT NULL,`  
    `description TEXT`  
`);`

`CREATE TABLE ServiceListing (`  
    `listing_id INT PRIMARY KEY,`  
    `provider_id INT NOT NULL,`  
    `category_id INT,`  
    `title VARCHAR(100) NOT NULL,`  
    `description TEXT,`  
    `price DECIMAL(10,2) NOT NULL,`  
    `availability VARCHAR(100),`

    `FOREIGN KEY (provider_id) REFERENCES “User”(user_id)`  
        `ON DELETE CASCADE,`

    `FOREIGN KEY (category_id) REFERENCES Category(category_id)`  
        `ON DELETE SET NULL`  
`);`

`CREATE TABLE Booking (`  
    `booking_id INT PRIMARY KEY,`  
    `listing_id INT NOT NULL,`  
    `customer_id INT NOT NULL,`  
    `booking_date DATE,`  
    `scheduled_time TIMESTAMP,`  
    `status VARCHAR(20) DEFAULT 'pending',`

    `FOREIGN KEY (listing_id) REFERENCES ServiceListing(listing_id)`  
        `ON DELETE CASCADE,`

    `FOREIGN KEY (customer_id) REFERENCES “User”(user_id)`  
        `ON DELETE CASCADE`  
`);`

`CREATE TABLE Payment (`  
    `payment_id INT PRIMARY KEY,`  
    `booking_id INT UNIQUE,`  
    `payment_date DATE,`  
    `amount DECIMAL(10,2),`  
    `payment_status VARCHAR(20),`

    `FOREIGN KEY (booking_id) REFERENCES Booking(booking_id)`  
        `ON DELETE CASCADE`  
`);`

`CREATE TABLE Review (`  
    `review_id INT PRIMARY KEY,`  
    `booking_id INT UNIQUE,`  
    `reviewer_id INT,`  
    `rating INT CHECK (rating BETWEEN 1 AND 5),`  
    `comment TEXT,`  
    `review_date DATE,`

    `FOREIGN KEY (booking_id) REFERENCES Booking(booking_id)`  
        `ON DELETE CASCADE,`

    `FOREIGN KEY (reviewer_id) REFERENCES “User”(user_id)`  
        `ON DELETE CASCADE`  
`);`  
`User.csv`  
---

`1,Alice Smith,alice@example.com,pass123,1234567890,provider`  
`2,Bob Johnson,bob@example.com,pass123,9876543210,customer`  
`3,Charlie Lee,charlie@example.com,pass123,5555555555,provider`

`Category.csv`  
---

`1,Academic,Tutoring and education services`  
`2,Creative,Design and art services`  
`3,Tech,Programming and IT help`

`ServiceListing.csv`  
---

`1,1,1,Math Tutoring,Algebra and Calculus help,20.00,Weekends`  
`2,3,3,Web Development Help,HTML/CSS/JS tutoring,30.00,Evenings`

`Booking.csv`  
---

`1,1,2,2026-04-01,2026-04-02 14:00:00,completed`  
`2,2,2,2026-04-03,2026-04-04 16:00:00,pending`

`Payment.csv`  
---

`1,1,2026-04-02,20.00,completed`

`Review.csv`  
---

`1,1,2,5,Great tutoring session!,2026-04-03`

`load.sql`  
---

`-- Disable FK checks for safe loading`  
`SET FOREIGN_KEY_CHECKS = 0;`

`-- USER`  
`LOAD DATA INFILE 'User.csv'`  
`INTO TABLE “User”`  
`FIELDS TERMINATED BY ','`  
`LINES TERMINATED BY '\n'`  
`(user_id, name, email, password, phone_number, role);`

`-- CATEGORY`  
`LOAD DATA INFILE 'Category.csv'`  
`INTO TABLE Category`  
`FIELDS TERMINATED BY ','`  
`LINES TERMINATED BY '\n'`  
`(category_id, category_name, description);`

`-- SERVICE LISTING`  
`LOAD DATA INFILE 'ServiceListing.csv'`  
`INTO TABLE ServiceListing`  
`FIELDS TERMINATED BY ','`  
`LINES TERMINATED BY '\n'`  
`(listing_id, provider_id, category_id, title, description, price, availability);`

`-- BOOKING`  
`LOAD DATA INFILE 'Booking.csv'`  
`INTO TABLE Booking`  
`FIELDS TERMINATED BY ','`  
`LINES TERMINATED BY '\n'`  
`(booking_id, listing_id, customer_id, booking_date, scheduled_time, status);`

`-- PAYMENT`  
`LOAD DATA INFILE 'Payment.csv'`  
`INTO TABLE Payment`  
`FIELDS TERMINATED BY ','`  
`LINES TERMINATED BY '\n'`  
`(payment_id, booking_id, payment_date, amount, payment_status);`

`-- REVIEW`  
`LOAD DATA INFILE 'Review.csv'`  
`INTO TABLE Review`  
`FIELDS TERMINATED BY ','`  
`LINES TERMINATED BY '\n'`  
`(review_id, booking_id, reviewer_id, rating, comment, review_date);`

`-- Re-enable FK checks`  
`SET FOREIGN_KEY_CHECKS = 1;`  
