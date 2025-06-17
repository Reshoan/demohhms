CREATE OR REPLACE PROCEDURE registerChauffer (
    p_name IN VARCHAR2,
    p_pass IN VARCHAR2,
    p_addr IN VARCHAR2,
    p_phone IN VARCHAR2,
    p_email IN VARCHAR2,
    p_experience      IN NUMBER,
    p_gender          IN VARCHAR2,
    p_dob             IN DATE,
    p_nid_no          IN VARCHAR2,
    p_expected_salary IN NUMBER,
    p_education       IN VARCHAR2,
    p_certification   IN VARCHAR2,
    p_provider_type   IN VARCHAR2,
    p_vehicle_types IN VARCHAR2,
    p_licence_doc IN VARCHAR2,
    p_valid_until IN DATE
) AS
    new_id NUMBER;
BEGIN
    SELECT user_seq.NEXTVAL INTO new_id FROM dual;

    INSERT INTO Users (us_id, us_name, us_password, us_address, us_phone_no, us_email, us_type)
    VALUES (new_id, p_name, p_pass, p_addr, p_phone, p_email, 'service_provider');

    INSERT INTO Service_Provider (sp_id, sp_experience, sp_gender, sp_dob, sp_nid_no, sp_expected_salary,
                                  sp_education, sp_certification, sp_type)
    VALUES (new_id, p_experience, p_gender, p_dob, p_nid_no, p_expected_salary,
            p_education, p_certification, p_provider_type);

    INSERT INTO Chauffer_Details (sp_id, ch_vehicle_types, ch_licence_doc, ch_licence_valid_until)
    VALUES (new_id, p_vehicle_types, p_licence_doc, p_valid_until);
END;
/
