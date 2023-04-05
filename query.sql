CREATE TABLE users(user_id SERIAL PRIMARY KEY ,
name VARCHAR NOT NULL,
email VARCHAR NOT NULL,
password VARCHAR NOT NULL,
mobile VARCHAR NOT NULL,
token VARCHAR,
status INTEGER DEFAULT(0));


CREATE TABLE sellers(seller_id SERIAL PRIMARY KEY ,
seller_name VARCHAR NOT NULL,
bussiness_name Varchar NOT NULL,
emial VARCHAR NOT NULL,
password VARCHAR NOT NULL,
mobile VARCHAR NOT NULL,
address VARCHAR NOT NULL,
gst VARCHAR ,
token VARCHAR,
status INTEGER DEFAULT(0));

CREATE TABLE products(product_id SERIAL PRIMARY KEY,
title VARCHAR NOT NULL,
description VARCHAR NOT NULL,
price INTEGER CHECK(price>1),
stock INTEGER CHECK(stock>0),
seller_id INTEGER REFERENCES sellers(seller_id),
imageurl VARCHAR NOT NULL,
status INTEGER DEFAULT(0));


CREATE TABLE CART (cart_id SERIAL PRIMARY KEY,
user_id INTEGER REFERENCES users(user_id),
product_id INTEGER REFERENCES products(product_id),
quantity INTEGER CHECK(quantity>0) DEFAULT(1));

CREATE TABLE address(address_id SERIAL PRIMARY KEY,
user_id INTEGER REFERENCES users(user_id),
address VARCHAR NOT NULL);