CREATE TABLE Users (
    us_id NUMBER PRIMARY KEY,
    us_name VARCHAR2(100),
    us_password VARCHAR2(100),
    us_address VARCHAR2(255),
    us_phone_no VARCHAR2(15),
    us_email VARCHAR2(100),
    us_type VARCHAR2(20),
    CONSTRAINT chk_us_type CHECK (us_type IN ('customer', 'service_provider'))
);
