CREATE TABLE Service_Provider (
    sp_id NUMBER PRIMARY KEY,
    sp_experience NUMBER,
    sp_gender VARCHAR2(10),
    sp_dob DATE,
    sp_nid_no VARCHAR2(20),
    sp_expected_salary NUMBER,
    sp_education VARCHAR2(100),
    sp_certification VARCHAR2(100),
    sp_type VARCHAR2(30),
    sp_status CHAR(1) DEFAULT 'A', -- 'A' for active, 'I' for inactive
    CONSTRAINT chk_sp_type CHECK (
        sp_type IN (
            'cook', 'chauffeur', 'security guard', 're-locator',
            'cleaner', 'baby sitter', 'masseuse',
            'plumber', 'electrician', 'gardener'
        )
    ),
    CONSTRAINT fk_sp_user FOREIGN KEY (sp_id) REFERENCES Users(us_id)
);
