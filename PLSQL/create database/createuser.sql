-- Step 1: Create the user
CREATE USER DemoHHMS IDENTIFIED BY DemoHHMS;

-- Step 2: Grant basic connection privilege
GRANT CREATE SESSION TO DemoHHMS;

-- Step 3: Grant object creation and manipulation privileges
GRANT CREATE TABLE TO DemoHHMS;
GRANT ALTER ANY TABLE TO DemoHHMS;
GRANT DROP ANY TABLE TO DemoHHMS;

-- Step 4: Grant data manipulation privileges
GRANT INSERT ANY TABLE TO DemoHHMS;
GRANT UPDATE ANY TABLE TO DemoHHMS;
GRANT DELETE ANY TABLE TO DemoHHMS;
GRANT SELECT ANY TABLE TO DemoHHMS;

-- Step 5: Grant PL/SQL development privileges
GRANT CREATE PROCEDURE TO DemoHHMS;
GRANT CREATE TRIGGER TO DemoHHMS;
GRANT CREATE SEQUENCE TO DemoHHMS;
GRANT CREATE VIEW TO DemoHHMS;

-- Step 6: Grant unlimited tablespace usage (optional but helpful)
GRANT UNLIMITED TABLESPACE TO DemoHHMS;

-- Optional: Grant predefined RESOURCE role
-- GRANT RESOURCE TO DemoHHMS;
