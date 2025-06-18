CREATE OR REPLACE PROCEDURE getProfile(
    p_user_id     IN  NUMBER,
    p_name        OUT VARCHAR2,
    p_phone       OUT VARCHAR2,
    p_email       OUT VARCHAR2,
    p_address     OUT VARCHAR2,
    p_us_type     OUT VARCHAR2,
    p_experience        OUT NUMBER,
    p_gender            OUT VARCHAR2,
    p_dob               OUT DATE,
    p_nid_no            OUT VARCHAR2,
    p_expected_salary   OUT NUMBER,
    p_education         OUT VARCHAR2,
    p_certification     OUT VARCHAR2,
    p_status            OUT CHAR,
    p_sp_type           OUT VARCHAR2,
    p_languages         OUT VARCHAR2,
    p_vehicle_types    OUT VARCHAR2,
    p_licence_doc      OUT VARCHAR2,
    p_valid_until      OUT DATE,
    p_employment_type   OUT VARCHAR2,
    p_cuisine_expertise    OUT VARCHAR2,
    p_max_people_served    OUT NUMBER,
    p_speciality   OUT VARCHAR2,
    p_vehicle_type  OUT VARCHAR2,
    p_weapons_training  OUT CHAR

)  AS
    v_sp_type VARCHAR2(30);
BEGIN
    -- Step 1: Fetch from Users
    SELECT us_type, us_name, us_phone_no, us_email, us_address
    INTO p_us_type, p_name, p_phone, p_email, p_address
    FROM Users
    WHERE us_id = p_user_id;

    -- If customer, exit early
    IF p_us_type = 'customer' THEN
        p_experience := NULL;
        p_gender := NULL;
        p_dob := NULL;
        p_nid_no := NULL;
        p_expected_salary := NULL;
        p_education := NULL;
        p_certification := NULL;
        p_sp_type := NULL;
        p_languages := NULL;
        p_vehicle_types := NULL;
        p_licence_doc := NULL;
        p_valid_until := NULL;
        p_employment_type := NULL;
        p_cuisine_expertise := NULL;
        p_max_people_served := NULL;
        p_speciality := NULL;
        p_vehicle_type := NULL;
        p_weapons_training := NULL;
        RETURN;
    END IF;

    -- Step 2: Fetch base service provider info
    SELECT sp_experience, sp_gender, sp_dob, sp_nid_no,
           sp_expected_salary, sp_education, sp_certification, sp_type, sp_status
    INTO p_experience, p_gender, p_dob, p_nid_no,
         p_expected_salary, p_education, p_certification, v_sp_type, p_status
    FROM Service_Provider
    WHERE sp_id = p_user_id;

    p_sp_type := v_sp_type;

    -- Step 3: Fetch extra info based on sp_type
    CASE LOWER(v_sp_type)
        WHEN 'cleaner' THEN
            SELECT cl_employment_type
            INTO p_employment_type
            FROM Cleaner_Details
            WHERE sp_id = p_user_id;
        WHEN 'cook' THEN
            SELECT ck_cuisine_expertise, ck_max_people_served
            INTO p_cuisine_expertise, p_max_people_served
            FROM Cook_Details
            WHERE sp_id = p_user_id;
        WHEN 'chauffeur' THEN
            SELECT ch_vehicle_types, ch_licence_doc, ch_licence_valid_until
            INTO p_vehicle_types, p_licence_doc, p_valid_until
            FROM Chauffer_Details
            WHERE sp_id = p_user_id;
        WHEN 'security guard' THEN
            SELECT sg_weapons_training
            INTO p_weapons_training
            FROM SecurityGuard_Details
            WHERE sp_id = p_user_id;
        WHEN 're-locator' THEN
            SELECT rl_vehicle_type
            INTO p_vehicle_type
            FROM Relocator_Details
            WHERE sp_id = p_user_id;
        WHEN 'baby sitter' THEN
            SELECT bs_languages
            INTO p_languages
            FROM Babysitter_Details
            WHERE sp_id = p_user_id;
        WHEN 'masseuse' THEN
            SELECT ms_speciality
            INTO p_speciality
            FROM Masseuse_Details
            WHERE sp_id = p_user_id;
        ELSE
            RETURN;
    END CASE;
END;
/