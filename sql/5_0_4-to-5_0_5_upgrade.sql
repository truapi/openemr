DELETE FROM `registry` WHERE `directory`='primary_support';
insert  into `registry`(`name`,`state`,`directory`,`id`,`sql_run`,`unpackaged`,`date`,`priority`,`category`,`nickname`,`patient_encounter`,`therapy_group_encounter`,`aco_spec`) values

('WHOQOL Bref',1,'patient_question',25,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Regular Session',1,'patient_question',26,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Primary Support Questions',1,'primary_support_question',27,1,1,'2019-05-22 21:51:27',1,'Assessments','',1,0,'encounters|notes'),

('Primary Support Impression Questions',1,'primary_support_impression_question',28,1,1,'2019-05-22 21:51:27',2,'Assessments','',1,0,'encounters|notes'),

('Patient Impression Questions',1,'patient_impression_question',29,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Adolescent Session',1,'patient_question',30,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes'),

('Brief Addiction Monitor',1,'patient_question',31,1,1,'2019-05-22 21:51:27',0,'Assessments','',1,0,'encounters|notes');
