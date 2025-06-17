CREATE TABLE Cleaner_Details (
    sp_id NUMBER PRIMARY KEY,
    cl_employment_type VARCHAR2(20), -- "part time" or "full time"
    FOREIGN KEY (sp_id) REFERENCES Service_Provider(sp_id)
);
