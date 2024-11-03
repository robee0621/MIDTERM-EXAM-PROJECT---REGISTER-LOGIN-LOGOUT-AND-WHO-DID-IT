CREATE TABLE bartenders (
   bartenderID INT AUTO_INCREMENT PRIMARY KEY,
   fname VARCHAR(255),
   lname VARCHAR(255),
   experience INT,  -- years of experience
   date_hired DATETIME DEFAULT CURRENT_TIMESTAMP,
   added_by VARCHAR(255) NOT NULL, -- user who added the bartender
   last_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- timestamp for last update
);

CREATE TABLE customers (
   customerID INT AUTO_INCREMENT PRIMARY KEY,
   fname VARCHAR(255),
   lname VARCHAR(255),
   phone VARCHAR(15),
   email VARCHAR(255),
   date_registered DATETIME DEFAULT CURRENT_TIMESTAMP,
   added_by VARCHAR(255) NOT NULL, -- user who added the customer
   last_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP -- timestamp for last update
);

CREATE TABLE orders (
   orderID INT AUTO_INCREMENT PRIMARY KEY,
   customerID INT,
   bartenderID INT,
   orderDetails TEXT,  -- details of the order (e.g., list of drinks)
   orderStatus VARCHAR(50),  -- e.g., "Pending", "Completed", "Cancelled"
   date_ordered DATETIME DEFAULT CURRENT_TIMESTAMP,
   last_updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, -- timestamp for last update
   added_by VARCHAR(255) NOT NULL, -- user who created the order
   FOREIGN KEY (customerID) REFERENCES customers(customerID),
   FOREIGN KEY (bartenderID) REFERENCES bartenders(bartenderID)
);

CREATE TABLE accounts (
   user_id INT AUTO_INCREMENT PRIMARY KEY,
   username VARCHAR(255) UNIQUE,
   password VARCHAR(255),
   date_added TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
