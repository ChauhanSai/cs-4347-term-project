-- Disable FK checks for safe loading
SET FOREIGN_KEY_CHECKS = 0;

-- USER
LOAD DATA INFILE 'User.csv'
INTO TABLE “User”
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
(user_id, name, email, password, phone_number, role);

-- CATEGORY
LOAD DATA INFILE 'Category.csv'
INTO TABLE Category
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
(category_id, category_name, description);

-- SERVICE LISTING
LOAD DATA INFILE 'ServiceListing.csv'
INTO TABLE ServiceListing
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
(listing_id, provider_id, category_id, title, description, price, availability);

-- BOOKING
LOAD DATA INFILE 'Booking.csv'
INTO TABLE Booking
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
(booking_id, listing_id, customer_id, booking_date, scheduled_time, status);

-- PAYMENT
LOAD DATA INFILE 'Payment.csv'
INTO TABLE Payment
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
(payment_id, booking_id, payment_date, amount, payment_status);

-- REVIEW
LOAD DATA INFILE 'Review.csv'
INTO TABLE Review
FIELDS TERMINATED BY ','
LINES TERMINATED BY '\n'
(review_id, booking_id, reviewer_id, rating, comment, review_date);

-- Re-enable FK checks
SET FOREIGN_KEY_CHECKS = 1;

