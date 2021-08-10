create table IF NOT EXISTS products
(
    product_id     INTEGER not null
        primary key autoincrement,
    productname    TEXT,
    quantity    TEXT,
    price        TEXT,
    image  TEXT,
    category TEXT
);