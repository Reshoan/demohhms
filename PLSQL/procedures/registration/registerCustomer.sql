CREATE OR REPLACE PROCEDURE registerCustomer (
    p_name IN VARCHAR2,
    p_pass IN VARCHAR2,
    p_addr IN VARCHAR2,
    p_phone IN VARCHAR2,
    p_email IN VARCHAR2
) AS
    new_id NUMBER;
BEGIN
    SELECT user_seq.NEXTVAL INTO new_id FROM dual;
    INSERT INTO Users (us_id, us_name, us_password, us_address, us_phone_no, us_email, us_type)
    VALUES (new_id, p_name, p_pass, p_addr, p_phone, p_email, 'customer');
END;
/
