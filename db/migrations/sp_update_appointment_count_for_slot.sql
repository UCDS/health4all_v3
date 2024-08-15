DELIMITER $$

DROP PROCEDURE IF EXISTS sp_update_appointment_count_for_slot$$

CREATE PROCEDURE sp_update_appointment_count_for_slot (
    IN appointment_slot_id_old INT,
    IN appointment_slot_id_current INT
)
BEGIN
    IF appointment_slot_id_old != appointment_slot_id_current THEN
        -- Reducing the appointments_taken count for old slot
        UPDATE appointment_slot 
        SET appointments_taken = CASE 
                                    WHEN appointments_taken = 0 THEN 0 
                                    ELSE appointments_taken - 1 
                                 END 
        WHERE slot_id = appointment_slot_id_old;

        -- Increasing the appointments_taken count for current slot
        UPDATE appointment_slot 
        SET appointments_taken = appointments_taken + 1 
        WHERE slot_id = appointment_slot_id_current;
    END IF;
END$$

DELIMITER ;
