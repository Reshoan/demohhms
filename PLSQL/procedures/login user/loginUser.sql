CREATE OR REPLACE PROCEDURE loginUser (
    p_email     IN VARCHAR2,
    p_user_id   OUT NUMBER,
    p_user_type OUT VARCHAR2,
    p_user_name OUT VARCHAR2,
    p_hashed_pw OUT VARCHAR2
)
AS
BEGIN
    SELECT us_id, us_type, us_name, us_password
    INTO p_user_id, p_user_type, p_user_name, p_hashed_pw
    FROM Users
    WHERE LOWER(us_email) = LOWER(p_email);

EXCEPTION
    WHEN NO_DATA_FOUND THEN
        p_user_id := NULL;
        p_user_type := NULL;
        p_user_name := NULL;
        p_hashed_pw := NULL;
END;
/
