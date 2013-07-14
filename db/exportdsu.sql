CREATE TABLE CategoryList
(short_code VARCHAR(2),
description VARCHAR(20),
rec_status VARCHAR(2),
create_dt VARCHAR(25) DEFAULT 'CURRENT_TIMESTAMP');

CREATE TABLE ChainKit
(kit_row_id INTEGER,
kit_part_number_row_id INTEGER,
kit_front_sprocket_row_id INTEGER,
kit_rear_sprocket_row_id INTEGER,
misc1_part_row_id INTEGER,
misc2_part_row_id INTEGER,
front_sprocket_size NUMERIC(25),
rear_sprocket_size NUMERIC(25),
chain_length INTEGER,
rec_status VARCHAR(2),
create_dt VARCHAR(25) DEFAULT 'CURRENT_TIMESTAMP',
modified_dt VARCHAR(25) );

CREATE TABLE Customer
(dba VARCHAR(50),
contact_name VARCHAR(50),
customer_number VARCHAR(30) NOT NULL,
address VARCHAR(50),
city VARCHAR(30),
state VARCHAR(2),
zip VARCHAR(10),
phone1 VARCHAR(12),
phone2 VARCHAR(12),
fax VARCHAR(12),
email VARCHAR(50),
discount INTEGER,
cc_num1 VARCHAR(19),
cc_exp1 VARCHAR(7),
cc_cvv1 VARCHAR(3),
cc_num2 VARCHAR(19),
cc_exp2 VARCHAR(7),
cc_cvv2 VARCHAR(3),
notes TEXT(255),
rec_status VARCHAR(2),
create_dt VARCHAR(25) DEFAULT 'CURRENT_TIMESTAMP',
modified_dt VARCHAR(25), customer_id INTEGER,
UNIQUE (customer_number));

CREATE TABLE MFGList
(short_code VARCHAR(3),
description VARCHAR(20),
rec_status VARCHAR(2),
create_dt VARCHAR(25) DEFAULT 'CURRENT_TIMESTAMP');

CREATE TABLE Invoice
(order_number VARCHAR(25) NOT NULL,
customer_number VARCHAR(30),
order_date VARCHAR(25) DEFAULT 'CURRENT_DATE',
order_total REAL DEFAULT 0.00,
order_tax REAL DEFAULT 0.00,
order_shipping REAL DEFAULT 0.00,
customer_po VARCHAR(25),
carrier_code VARCHAR(5),
tracking_number VARCHAR(30),
order_status_code VARCHAR(10),
rec_status VARCHAR(2),
create_dt VARCHAR(25) DEFAULT 'CURRENT_TIMESTAMP',
modified_dt VARCHAR(25) DEFAULT 'CURRENT_DATE',
PRIMARY KEY (order_number));

CREATE TABLE InvoiceItems
(order_number_row_id INTEGER,
part_number_row_id INTEGER,
kit_front_sprocket_row_id INTEGER,
kit_rear_sprocket_row_id INTEGER,
misc1_part_row_id INTEGER,
misc2_part_row_id INTEGER,
front_sprocket_size NUMERIC(25),
rear_sprocket_size NUMERIC(25),
qty INTEGER,
qty_back_order INTEGER,
item_cost REAL,
rec_status VARCHAR(2),
create_dt VARCHAR(25) DEFAULT 'CURRENT_DATE',
modified_dt VARCHAR(25) DEFAULT 'CURRENT_DATE');

CREATE TABLE Part
(part_number VARCHAR(30),
part_description TEXT(255),
category_code VARCHAR(10),
pitch_code VARCHAR(10),
product_brand_code VARCHAR(10),
msrp REAL DEFAULT 0.00,
dealer_cost REAL DEFAULT 0.00,
import_cost REAL DEFAULT 0.00,
chain_chart_part VARCHAR(30),
stock_level NUMERIC DEFAULT 0,
kit_id INTEGER,
rec_status VARCHAR(2),
clip_code VARCHAR(2),
create_dt VARCHAR(25) DEFAULT 'CURRENT_TIMESTAMP',
modified_dt VARCHAR(25));

CREATE TABLE PitchList
(short_code VARCHAR(3),
description VARCHAR(20),
rec_status VARCHAR(2),
create_dt VARCHAR(25) DEFAULT 'CURRENT_TIMESTAMP');

CREATE TABLE ProductBrandList
(short_code VARCHAR(3),
description VARCHAR(20),
rec_status VARCHAR(2),
create_dt VARCHAR(25) DEFAULT 'CURRENT_TIMESTAMP');

INSERT INTO CategoryList(short_code, description, rec_status, create_dt) VALUES ('FS', 'Front Sprocket', '0', '2013-6-19');
INSERT INTO CategoryList(short_code, description, rec_status, create_dt) VALUES ('RS', 'Rear Sprocket', '0', '2013-6-19');
INSERT INTO CategoryList(short_code, description, rec_status, create_dt) VALUES ('CH', 'Chain', '0', '2013-6-19');
INSERT INTO CategoryList(short_code, description, rec_status, create_dt) VALUES ('KT', 'Chain Kit', '0', '2013-6-19');
INSERT INTO CategoryList(short_code, description, rec_status, create_dt) VALUES ('OT', 'Other', '0', '2013-6-19');
INSERT INTO Customer(dba, contact_name, customer_number, address, city, state, zip, phone1, phone2, fax, email, discount, cc_num1, cc_exp1, cc_cvv1, cc_num2, cc_exp2, cc_cvv2, notes, rec_status, create_dt, modified_dt, customer_id) VALUES ('Huntington Beach Honda', 'Mike Moto', '121212', '1234 Dirt Track Way', 'Huntington Beach ', 'CA', '92649', '714-888-8888', '714-888-8881', '714-888-8882', 'mikemoto@gmail.com', '17', '4532-1111-1111-1111', '01/2013', '123', '4532-1111-1111-1111', '01/2014', '123', 'This is a really nice customer allways pays bills on time', '00', '', '', null);
INSERT INTO MFGList(short_code, description, rec_status, create_dt) VALUES ('YAMAHA', 'Yamaha Motors', '0', '2013-6-19');
INSERT INTO MFGList(short_code, description, rec_status, create_dt) VALUES ('HONDA', 'Honda Motors', '0', '2013-6-19');
INSERT INTO MFGList(short_code, description, rec_status, create_dt) VALUES ('KAWASAKI', 'Kawasaki Motors', '0', '2013-6-19');
INSERT INTO Part(part_number, part_description, category_code, pitch_code, product_brand_code, msrp, dealer_cost, import_cost, chain_chart_part, stock_level, kit_id, rec_status, clip_code, create_dt, modified_dt) VALUES ('', '', '', '', '', null, null, null, '', null, null, '', '', '', '');
INSERT INTO PitchList(short_code, description, rec_status, create_dt) VALUES ('420', '420 Pitch', '0', '2013-6-19');
INSERT INTO PitchList(short_code, description, rec_status, create_dt) VALUES ('428', '428 Pitch', '0', '2013-6-19');
INSERT INTO PitchList(short_code, description, rec_status, create_dt) VALUES ('520', '520 Pitch', '0', '2013-6-19');
INSERT INTO PitchList(short_code, description, rec_status, create_dt) VALUES ('525', '525 Pitch', '0', '2013-6-19');
INSERT INTO PitchList(short_code, description, rec_status, create_dt) VALUES ('530', '530 Pitch', '0', '2013-6-19');
INSERT INTO ProductBrandList(short_code, description, rec_status, create_dt) VALUES ('DID', 'D.I.D', '0', '2013-6-19');
INSERT INTO ProductBrandList(short_code, description, rec_status, create_dt) VALUES ('SUPERLITE', 'Superlite', '0', '2013-6-19');
