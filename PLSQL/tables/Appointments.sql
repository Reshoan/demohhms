CREATE TABLE Appointments (
    appt_id NUMBER PRIMARY KEY,
    us_id NUMBER, -- References Users table (customer)
    sp_id NUMBER, -- References Service_Provider table (service provider)
    appt_date DATE, -- Date and time of the appointment
    status_id NUMBER, -- Foreign key to Appointment_Status table
    appt_description VARCHAR2(255), -- Optional description/details of the appointment
    appt_deleted CHAR(1) DEFAULT 'N', -- 'N' for not deleted, 'Y' for deleted
    FOREIGN KEY (us_id) REFERENCES Users(us_id),
    FOREIGN KEY (sp_id) REFERENCES Service_Provider(sp_id),
    FOREIGN KEY (status_id) REFERENCES Appointment_Status(status_id)
);
