DELIMITER $$

DROP PROCEDURE IF EXISTS sp_update_appointment_count_for_slot$$

CREATE PROCEDURE sp_update_appointment_count_for_slot (
    IN appointment_slot_id_old INT,
    IN appointment_slot_id_current INT,
    IN appointment_status_category_old INT,
    IN appointment_status_category_current INT
)
BEGIN
    -- Handle appointment slot change (This is from registration/appointments page)
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
		
		-- Reducing the appointments_checkedin count for old category == 1
		IF appointment_status_category_old = 1 THEN
			UPDATE appointment_slot 
			SET appointments_checkedin = CASE 
											WHEN appointments_checkedin = 0 THEN 0 
											ELSE appointments_checkedin - 1 
										 END 
			WHERE slot_id = appointment_slot_id_old;
			
			UPDATE appointment_slot 
			SET appointments_checkedin = appointments_checkedin + 1
			WHERE slot_id = appointment_slot_id_current;
		END IF;
        
        -- Reducing the appointments_cancelled count for old status == 2
		IF appointment_status_category_old = 2 THEN
			UPDATE appointment_slot 
			SET appointments_cancelled = CASE 
											WHEN appointments_cancelled = 0 THEN 0 
											ELSE appointments_cancelled - 1 
										 END 
			WHERE slot_id = appointment_slot_id_old;
			
			UPDATE appointment_slot 
			SET appointments_cancelled = appointments_cancelled + 1
			WHERE slot_id = appointment_slot_id_current;
		END IF;

    -- Handle appointment status change (This is from appointments status page)
    ELSEIF appointment_status_category_old != appointment_status_category_current THEN
        -- Reducing the appointments_checkedin count for old category == 1
		IF appointment_status_category_old = 1 THEN
			UPDATE appointment_slot 
			SET appointments_checkedin = CASE 
											WHEN appointments_checkedin = 0 THEN 0 
											ELSE appointments_checkedin - 1 
										 END 
			WHERE slot_id = appointment_slot_id_old;
		END IF;
        
        -- Reducing the appointments_cancelled count for old status == 2
		IF appointment_status_category_old = 2 THEN
			UPDATE appointment_slot 
			SET appointments_cancelled = CASE 
											WHEN appointments_cancelled = 0 THEN 0 
											ELSE appointments_cancelled - 1 
										 END 
			WHERE slot_id = appointment_slot_id_old;
		END IF;
		
        
        -- Increasing the appointments_checkedin count for current category == 1	
		IF appointment_status_category_current = 1 THEN
			UPDATE appointment_slot 
			SET appointments_checkedin = appointments_checkedin + 1
			WHERE slot_id = appointment_slot_id_current;
		END IF;
		
		
		-- Increasing the appointments_checkedin count for current category == 2	
		IF appointment_status_category_current = 2 THEN
			UPDATE appointment_slot 
			SET appointments_cancelled = appointments_cancelled + 1
			WHERE slot_id = appointment_slot_id_current;
		END IF;
    END IF;
END$$

DELIMITER ;
