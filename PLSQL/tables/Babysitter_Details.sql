CREATE TABLE Babysitter_Details (
    sp_id NUMBER PRIMARY KEY,
    bs_languages VARCHAR2(100), -- e.g., "English, Bengali"
    FOREIGN KEY (sp_id) REFERENCES Service_Provider(sp_id)
);
