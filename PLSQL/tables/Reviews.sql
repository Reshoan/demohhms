CREATE TABLE Reviews (
    review_id NUMBER PRIMARY KEY,
    us_id NUMBER, -- References Users table (customer)
    sp_id NUMBER, -- References Service_Provider table (service provider)
    review_date DATE, -- Date the review was submitted
    review_rating NUMBER(1,1), -- Rating out of 5 (e.g., 4.5)
    review_text VARCHAR2(500), -- Review text/description
    FOREIGN KEY (us_id) REFERENCES Users(us_id),
    FOREIGN KEY (sp_id) REFERENCES Service_Provider(sp_id),
    CONSTRAINT uq_user_provider UNIQUE (us_id, sp_id)
);
