CREATE OR REPLACE PROCEDURE updateCleanerProfile (
    p_user_id           IN NUMBER,
    p_name              IN VARCHAR2,
    p_password          IN VARCHAR2,
    p_address           IN VARCHAR2,
    p_phone             IN VARCHAR2,
    p_email             IN VARCHAR2,
    p_experience        IN NUMBER,
    p_gender            IN VARCHAR2,
    p_dob               IN DATE,
    p_nid_no            IN VARCHAR2,
    p_expected_salary   IN NUMBER,
    p_education         IN VARCHAR2,
    p_certification     IN VARCHAR2,
    p_employment_type   IN VARCHAR2
) AS
BEGIN
    UPDATE Users
    SET us_name = p_name,
        us_password = p_password,
        us_address = p_address,
        us_phone_no = p_phone,
        us_email = p_email
    WHERE us_id = p_user_id;

    UPDATE Service_Provider
    SET sp_experience = p_experience,
        sp_gender = p_gender,
        sp_dob = p_dob,
        sp_nid_no = p_nid_no,
        sp_expected_salary = p_expected_salary,
        sp_education = p_education,
        sp_certification = p_certification
    WHERE sp_id = p_user_id;

    UPDATE Cleaner_Details
    SET cl_employment_type = p_employment_type
    WHERE sp_id = p_user_id;
END;
/
