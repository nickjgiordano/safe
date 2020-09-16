-- delete tables if they exist, to be recreated later
DROP TABLE IF EXISTS Purchase, Account, Product;

-- create furniture product table
CREATE TABLE Product(
	ID INT NOT NULL AUTO_INCREMENT,
	Category VARCHAR(70),
	Subcategory VARCHAR(70),
	Name VARCHAR(70),
	Price DECIMAL(8,2),
	PRIMARY KEY (ID)
);

-- create user account table
CREATE TABLE Account(
	ID INT NOT NULL AUTO_INCREMENT,
	Username VARCHAR(70),
	Phone VARCHAR(13),
	Email VARCHAR(70),
	Password VARCHAR(128),
	PRIMARY KEY (ID)
);
-- add indexes to ensure duplicate usernames and emails can't exist
ALTER TABLE Account ADD UNIQUE INDEX (Username);
ALTER TABLE Account ADD UNIQUE INDEX (Email);

-- create user purchase table
CREATE TABLE Purchase(
	ID INT NOT NULL AUTO_INCREMENT,
	Account_ID INT,
	Username VARCHAR(70),
	Phone VARCHAR(13),
	Email VARCHAR(70),
	Product_ID INT,
	Name VARCHAR(70),
	Price DECIMAL(8,2),
	PRIMARY KEY (ID),
	FOREIGN KEY (Account_ID) REFERENCES Account(ID),
	FOREIGN KEY (Product_ID) REFERENCES Product(ID)
);

-- insert products into database to be displayed on website
INSERT INTO Product(Category, Subcategory, Name, Price) VALUES
('Bedroom', 'Beds', 'Malm', 350),
('Living Room', 'TV stands', 'Vince', 90),
('Kitchen', 'Fridges', 'Bush', 550),
('Living Room', 'Sofas', 'Carlton', 1200),
('Bedroom', 'Beds', 'Hoxton', 600),
('Bedroom', 'Mattresses', 'Romantica', 180),
('Bedroom', 'Beds', 'Aubrey', 400),
('Bathroom', 'Baths', 'Woodbridge', 580),
('Bedroom', 'Wardrobes', 'Camberley', 900),
('Bedroom', 'Bedding', 'Sheets', 50),
('Dining Room', 'Dining chairs', 'BL', 90),
('Study', 'Computer desks', 'Chester', 80),
('Bedroom', 'Beds', 'Heathdon', 480),
('Bathroom', 'Sinks', 'Shroud', 60),
('Dining Room', 'Dining tables', 'Modi', 300),
('Bedroom', 'Bedding', 'Pillows', 30),
('Kitchen', 'Fridges', 'Truth', 1200),
('Dining Room', 'Dining chairs', 'Leonora', 50),
('Kitchen', 'Cookers', 'Rangemaster', 680),
('Study', 'Computer desks', 'Hampstead', 60),
('Kitchen', 'Fridges', 'Beko', 700),
('Dining Room', 'Dining tables', 'Etta', 80),
('Living Room', 'Coffee tables', 'Ercol', 80),
('Garden', 'Garden seats', 'Melbourne', 40),
('Bathroom', 'Showers', 'Mira', 50),
('Bedroom', 'Wardrobes', 'Lexington', 400),
('Kitchen', 'Fridges', 'Kylslagen', 520),
('Bedroom', 'Beds', 'Finn', 250),
('Garden', 'Garden tables', 'Bistro', 40),
('Kitchen', 'Cookers', 'Kenwood', 500),
('Living Room', 'TV stands', 'Fearnley', 50),
('Living Room', 'Sofas', 'Ulswater', 800),
('Living Room', 'Sofas', 'Ace', 500),
('Living Room', 'Sofas', 'Indivi', 600),
('Living Room', 'Sofas', 'Frankie', 1750),
('Living Room', 'Coffee tables', 'Kesterport', 200),
('Bathroom', 'Toilets', 'Reve', 230),
('Bathroom', 'Toilets', 'Portland', 80),
('Bathroom', 'Showers', 'Aqualisa', 140),
('Garden', 'Garden seats', 'Lutyens', 70),
('Garden', 'Garden tables', 'Polywood', 45),
('Study', 'Computer desks', 'Woodford', 85),
('Study', 'Computer chairs', 'Songmics', 70),
('Study', 'Computer desks', 'Calgary', 90),
('Kitchen', 'Fridges', 'LG', 1150),
('Dining Room', 'Dining chairs', 'Rosehill', 110),
('Living Room', 'Sofas', 'Conza', 900),
('Kitchen', 'Fridges', 'Hotpoint', 655),
('Dining Room', 'Dining tables', 'Krona', 60),
('Dining Room', 'Dining tables', 'Milano', 120),
('Bathroom', 'Baths', 'Duravit', 590),
('Kitchen', 'Cookers', 'Haden', 300),
('Study', 'Computer chairs', 'Jonas', 100),
('Bathroom', 'Sinks', 'Langham', 200),
('Kitchen', 'Fridges', 'Samsung', 800),
('Living Room', 'Coffee tables', 'Zeke', 120),
('Study', 'Computer chairs', 'Boss', 300),
('Bedroom', 'Wardrobes', 'Radius', 600),
('Bedroom', 'Bedding', 'Duvet', 60),
('Dining Room', 'Dining chairs', 'Edwalton', 90);