CREATE TABLE “User” (
    user_id INT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone_number VARCHAR(15),
    role VARCHAR(20) DEFAULT 'customer'
);

CREATE TABLE Category (
    category_id INT PRIMARY KEY,
    category_name VARCHAR(50) NOT NULL,
    description TEXT
);

CREATE TABLE ServiceListing (
    listing_id INT PRIMARY KEY,
    provider_id INT NOT NULL,
    category_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    availability VARCHAR(100),

    FOREIGN KEY (provider_id) REFERENCES “User”(user_id)
        ON DELETE CASCADE,

    FOREIGN KEY (category_id) REFERENCES Category(category_id)
        ON DELETE SET NULL
);

CREATE TABLE Booking (
    booking_id INT PRIMARY KEY,
    listing_id INT NOT NULL,
    customer_id INT NOT NULL,
    booking_date DATE,
    scheduled_time TIMESTAMP,
    status VARCHAR(20) DEFAULT 'pending',

    FOREIGN KEY (listing_id) REFERENCES ServiceListing(listing_id)
        ON DELETE CASCADE,

    FOREIGN KEY (customer_id) REFERENCES “User”(user_id)
        ON DELETE CASCADE
);

CREATE TABLE Payment (
    payment_id INT PRIMARY KEY,
    booking_id INT UNIQUE,
    payment_date DATE,
    amount DECIMAL(10,2),
    payment_status VARCHAR(20),

    FOREIGN KEY (booking_id) REFERENCES Booking(booking_id)
        ON DELETE CASCADE
);

CREATE TABLE Review (
    review_id INT PRIMARY KEY,
    booking_id INT UNIQUE,
    reviewer_id INT,
    rating INT CHECK (rating BETWEEN 1 AND 5),
    comment TEXT,
    review_date DATE,

    FOREIGN KEY (booking_id) REFERENCES Booking(booking_id)
        ON DELETE CASCADE,

    FOREIGN KEY (reviewer_id) REFERENCES “User”(user_id)
        ON DELETE CASCADE
);
