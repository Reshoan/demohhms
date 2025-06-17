CREATE OR REPLACE PROCEDURE getCleanerProfile (
    p_user_id         IN  NUMBER,
    p_name            OUT VARCHAR2,
    p_phone           OUT VARCHAR2,
    p_email           OUT VARCHAR2,
    p_address         OUT VARCHAR2,
    p_experience      OUT NUMBER,
    p_gender          OUT VARCHAR2,
    p_dob             OUT DATE,
    p_nid_no          OUT VARCHAR2,
    p_expected_salary OUT NUMBER,
    p_education       OUT VARCHAR2,
    p_certification   OUT VARCHAR2,
    p_cleaning_types  OUT VARCHAR2
) AS
BEGIN
    SELECT u.us_name, u.us_phone_no, u.us_email, u.us_address,
           s.sp_experience, s.sp_gender, s.sp_dob, s.sp_nid_no, 
           s.sp_expected_salary, s.sp_education, s.sp_certification,
           c.cl_cleaning_types
    INTO p_name, p_phone, p_email, p_address,
         p_experience, p_gender, p_dob, p_nid_no,
         p_expected_salary, p_education, p_certification,
         p_cleaning_types
    FROM Users u
    JOIN Service_Provider s ON u.us_id = s.sp_id
    JOIN Cleaner_Details c ON s.sp_id = c.sp_id
    WHERE u.us_id = p_user_id;
END;
/
