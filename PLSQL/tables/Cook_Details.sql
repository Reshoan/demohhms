CREATE TABLE Cook_Details (
    sp_id NUMBER PRIMARY KEY,
    ck_cuisine_expertise VARCHAR2(100), -- e.g., "Chinese, Indian"
    ck_max_people_served NUMBER,
    FOREIGN KEY (sp_id) REFERENCES Service_Provider(sp_id)
);
