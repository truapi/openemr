ALTER TABLE `openemr_postcalendar_events` DROP COLUMN `pc_p_s_pid`;
ALTER TABLE `form_encounter` DROP COLUMN `supported_patient`;
ALTER TABLE `openemr_postcalendar_events` ADD COLUMN `pc_p_s_pid` VARCHAR(11);
ALTER TABLE `form_encounter` ADD COLUMN `supported_patient` INT;
