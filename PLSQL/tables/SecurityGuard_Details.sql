CREATE TABLE SecurityGuard_Details (
    sp_id NUMBER PRIMARY KEY,
    sg_weapons_training CHAR(1), -- 'Y' or 'N'
    FOREIGN KEY (sp_id) REFERENCES Service_Provider(sp_id)
);
