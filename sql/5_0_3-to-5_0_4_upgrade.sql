INSERT INTO `openemr`.`openemr_postcalendar_categories`
(`pc_catid`, `pc_constant_id`,  `pc_catname`,  `pc_catcolor`,  `pc_catdesc`,  `pc_recurrtype`,  `pc_enddate`,  `pc_recurrspec`,  `pc_recurrfreq`,
`pc_duration`, `pc_end_date_flag`, `pc_end_date_type`, `pc_end_date_freq`, `pc_end_all_day`, `pc_dailylimit`, `pc_cattype`, `pc_active`, `pc_seq`, `aco_spec`
) VALUES
(17, 'patient_enc', 'Patient', '#FFFFCC', 'Patient category for normal patient Another category is Primary Support - 16', 0, NULL, 'a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}', 0, 900,
0, 0, 0, 0, 0, 0, 1, 17, 'encounters|notes');

UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 1 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 2 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 3 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 4 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 5 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 6 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 7 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 8 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 9 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 10 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 11 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 12 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 13 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 14 ;
UPDATE `openemr_postcalendar_categories` SET `pc_active` = 0 WHERE `pc_catid` = 15 ;

UPDATE `registry` SET `state` = 0 WHERE `category` = 'Clinical' ;
UPDATE `registry` SET `state` = 0 WHERE `category` = 'Administrative' AND `name` <> 'New Encounter Form' ;

ALTER TABLE `form_assessment_answers` ADD COLUMN `parent_reg` INT;
