DELETE FROM `form_encounter`;

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

DELETE FROM `registry` WHERE `directory`='primary_support';
insert  into `registry`(`name`,`state`,`directory`,`id`,`sql_run`,`unpackaged`,`date`,`priority`,`category`,`nickname`,`patient_encounter`,`therapy_group_encounter`,`aco_spec`) values

('WHOQOL Bref',1,'patient_question',25,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Regular Session',1,'patient_question',26,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Primary Support Questions',1,'primary_support_question',27,1,1,'2019-05-22 21:51:27',1,'Assessments','',1,0,'encounters|notes'),

('Primary Support Impression Questions',1,'primary_support_impression_question',28,1,1,'2019-05-22 21:51:27',2,'Assessments','',1,0,'encounters|notes'),

('Patient Impression Questions',1,'patient_impression_question',29,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Adolescent Session',1,'patient_question',30,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Brief Addiction Monitor',1,'patient_question',31,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes');


ALTER TABLE `form_assessment_answers` ADD COLUMN `parent_reg` INT;

insert  into `form_assessment_questions`(`id`,`registry_id`,`question`,`type`,`options`) values

(153,31,'In the past 30 days, would you say your physical health has been?\r\n','radio','Excellent|Very Good|Good|Fair|Poor'),

(154,31,'In the past 30 days, how many nights did you have trouble falling asleep or staying asleep?','radio','0|1-3|4-8|9-15|16-30'),

(155,31,'In the past 30 days, how many days have you felt depressed, anxious, angry or very upset throughout most of the day?','radio','0|1-3|4-8|9-15|16-30'),

(156,31,'In the past 30 days, how many days did you drink ANY alcohol?','radio','0|1-3|4-8|9-15|16-30'),

(157,31,'In the past 30 days, how many days did you ahve at least 5 drinks (man), or at least 4 drinks (woman)? (One drink is considered one shot of hard liquor (1.5 oz.) or 12 ounce can/bottle of beer, or 5 ounce glass of wine.)\r\n','radio','0|1-3|4-8|9-15|16-30'),

(158,31,'In the past 30 days, how many days did you use any illegal/street drugs or abuse any prescription medications?','radio','0|1-3|4-8|9-15|16-30'),

(159,31,'In the past 30 days, how many days did you use 7a Marijuana (cannabis, pot, weed)?','radio','0|1-3|4-8|9-15|16-30'),

(160,31,'In the past 30 days, how many days did you use Sedatives/Tranquilizers (eg, benzos, Valium, Xanax, Ativan, Ambien, barbs, Phenobarbital, downers, etc.)?','radio','0|1-3|4-8|9-15|16-30'),

(161,31,'In the past 30 days, how many days did you use Cocaine/Crack?','radio','0|1-3|4-8|9-15|16-30'),

(162,31,'In the past 30 days, how many days did you use Oher Stimulants (amphetamine, methamphetamine, Dexedrine, Ritalin, Adderall, speed, crystal meth, ice, etc.)?','radio','0|1-3|4-8|9-15|16-30'),

(163,31,'In the past 30 days, how many days did you use Opiates (heroin, morphine, dilaudid, demerol, oxycontin, oxy, codeine, Tylenol #2/3/4, Percocet, Vicodin, Fentanyl, etc.)?','radio','0|1-3|4-8|9-15|16-30'),

(164,31,'In the past 30 days, how many days did you use Inhalants (glues/adhesives, mail polish remover, paint thinner, etc.)?','radio','0|1-3|4-8|9-15|16-30'),

(165,31,'In the past 30 days, how many days did you use Other drugs (steroids, non-prescription sleep.diet pills, Benadryl, Ephedra, other over-the-counter/unknown medications)? ','radio','0|1-3|4-8|9-15|16-30'),

(166,31,'In the past 30 days, how much were you bothered by cravings or urges to drink alcohol or use drugs?','radio','Not at all|Slightly|Moderately|Considerably|Extremely'),

(167,31,'How confident are you in your ability to be completely abstinent (clean) form alcohol and drugs in the next 30 days?','radio','Not at all|Slightly|Moderately|Considerably|Extremely'),

(168,31,'In the past 30 days, how many days did you attend self-help meetings like AA or NA to support your recovery?','radio','Not at all|Slightly|Moderately|Considerably|Extremely'),

(169,31,'In the past 30 days, how many days were you in any situations or with any people that might put you at an increased risk for using alcohol or drugs (around risky people, places, or things)?','radio','0|1-3|4-8|9-15|16-30'),

(170,31,'Does your religion or spirituality help support your recovery? ','radio','Not at all|Slightly|Moderately|Considerably|Extremely'),

(171,31,'In the past 30 days, how many days did you spend much of th etime at work, school, or doing volunteer work?','radio','0|1-3|4-8|9-15|16-30'),

(172,31,'Do you have enough income (from legal sources) to pay for necessities such as housing, transportation, food and clothing, for yourself and your dependents?','radio','No|Yes'),

(173,31,'In the past 30 days, how much have you been bothered by arguments or problems getting along with any family members or friends?','radio','Not at all|Slightly|Moderately|Considerably|Extremely'),

(174,31,'In the past 30 days, how many days were you in contact or spent time with any family members or friends who are supportive of your recovery?','radio','Not at all|Slightly|Moderately|Considerably|Extremely'),

(175,31,'How satisfied are you with your progress toward achieving your recovery goals?','radio','Not at all|Slightly|Moderately|Considerably|Extremely');
