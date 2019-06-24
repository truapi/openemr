DELETE FROM `registry` WHERE `directory`='primary_support';
insert  into `registry`(`name`,`state`,`directory`,`id`,`sql_run`,`unpackaged`,`date`,`priority`,`category`,`nickname`,`patient_encounter`,`therapy_group_encounter`,`aco_spec`) values

('New Encounter Form',1,'newpatient',1,1,1,'2003-09-14 15:16:45',0,'Administrative','',1,0,'patients|appt'),

('Review of Systems Checks',0,'reviewofs',9,1,1,'2003-09-14 15:16:45',0,'Clinical','',1,0,'encounters|notes'),

('Speech Dictation',0,'dictation',10,1,1,'2003-09-14 15:16:45',0,'Clinical','',1,0,'encounters|notes'),

('SOAP',0,'soap',11,1,1,'2005-03-03 00:16:35',0,'Clinical','',1,0,'encounters|notes'),

('Vitals',0,'vitals',12,1,1,'2005-03-03 00:16:34',0,'Clinical','',1,0,'encounters|notes'),

('Review Of Systems',0,'ros',13,1,1,'2005-03-03 00:16:30',0,'Clinical','',1,0,'encounters|notes'),

('Fee Sheet',0,'fee_sheet',14,1,1,'2007-07-28 00:00:00',0,'Administrative','',1,0,'encounters|coding'),

('Misc Billing Options HCFA',0,'misc_billing_options',15,1,1,'2007-07-28 00:00:00',0,'Administrative','',1,0,'encounters|coding'),

('Procedure Order',0,'procedure_order',16,1,1,'2010-02-25 00:00:00',0,'Administrative','',1,0,'patients|lab'),

('Observation',0,'observation',17,1,1,'2015-09-09 00:00:00',0,'Clinical','',1,0,'encounters|notes'),

('Care Plan',0,'care_plan',18,1,1,'2015-09-09 00:00:00',0,'Clinical','',1,0,'encounters|notes'),

('Functional and Cognitive Status',0,'functional_cognitive_status',19,1,1,'2015-09-09 00:00:00',0,'Clinical','',1,0,'encounters|notes'),

('Clinical Instructions',0,'clinical_instructions',20,1,1,'2015-09-09 00:00:00',0,'Clinical','',1,0,'encounters|notes'),

('Eye Exam',0,'eye_mag',21,1,1,'2015-10-15 00:00:00',0,'Clinical','',1,0,'encounters|notes'),

('Group Attendance Form',0,'group_attendance',22,1,1,'2015-10-15 00:00:00',0,'Clinical','',0,1,'encounters|notes'),

('New Group Encounter Form',0,'newGroupEncounter',23,1,1,'2015-10-15 00:00:00',0,'Clinical','',0,1,'patients|appt'),

('WHOQOL Bref',1,'patient_question',25,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Regular Session',1,'patient_question',26,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Primary Support Questions',1,'primary_support_question',27,1,1,'2019-05-22 21:51:27',1,'Assessments','',1,0,'encounters|notes'),

('Primary Support Impression Questions',1,'primary_support_impression_question',28,1,1,'2019-05-22 21:51:27',2,'Assessments','',1,0,'encounters|notes'),

('Patient Impression Questions',1,'patient_impression_question',29,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Adolescent Session',1,'patient_question',30,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Brief Addiction Monitor',1,'patient_question',31,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes');
