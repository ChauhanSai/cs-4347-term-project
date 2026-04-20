-- Disable foreign key checks to ensure a clean wipe without constraint errors
SET FOREIGN_KEY_CHECKS = 0;

-- Drop child tables first (those that depend on others)
DROP TABLE IF EXISTS Review;
DROP TABLE IF EXISTS Payment;
DROP TABLE IF EXISTS Booking;
DROP TABLE IF EXISTS ServiceListing;

-- Drop parent tables last
DROP TABLE IF EXISTS Category;
DROP TABLE IF EXISTS “User”;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS = 1;