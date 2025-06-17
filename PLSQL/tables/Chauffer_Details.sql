CREATE TABLE Chauffer_Details (
    sp_id NUMBER PRIMARY KEY,
    ch_vehicle_types VARCHAR2(100), -- e.g., "light, heavy"
    ch_licence_doc VARCHAR2(100),
    ch_licence_valid_until DATE,
    FOREIGN KEY (sp_id) REFERENCES Service_Provider(sp_id)
);
