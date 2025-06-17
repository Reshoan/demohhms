CREATE TABLE Masseuse_Details (
    sp_id NUMBER PRIMARY KEY,
    ms_speciality VARCHAR2(100), -- e.g., "post operational"
    FOREIGN KEY (sp_id) REFERENCES Service_Provider(sp_id)
);
