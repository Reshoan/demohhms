CREATE TABLE Relocator_Details (
    sp_id NUMBER PRIMARY KEY,
    rl_vehicle_type VARCHAR2(100),
    FOREIGN KEY (sp_id) REFERENCES Service_Provider(sp_id)
);
