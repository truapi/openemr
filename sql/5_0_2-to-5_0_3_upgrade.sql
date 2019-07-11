-- DROP PROCEDURE IF EXISTS schema_change;

-- DELIMITER ';;'
-- CREATE PROCEDURE schema_change() BEGIN
--  IF EXISTS (SELECT * FROM information_schema.columns WHERE table_name = 'test' AND column_name = 'test2') THEN
--   ALTER TABLE test DROP COLUMN `test2`;
--  END IF;
--  /* add columns */
--  ALTER TABLE test ADD COLUMN `test2` VARCHAR(255) NULL;
-- END;;

-- DELIMITER ';'
-- CALL schema_change();

-- DROP PROCEDURE IF EXISTS schema_change;

-- ALTER TABLE `openemr_postcalendar_events` DROP COLUMN `pc_p_s_pid`;
ALTER TABLE `openemr_postcalendar_events` ADD COLUMN `pc_p_s_pid` VARCHAR(11);

-- ALTER TABLE `form_encounter` DROP COLUMN `supported_patient`;
ALTER TABLE `form_encounter` ADD COLUMN `supported_patient` INT;

DROP TABLE IF EXISTS `patient_support`;
CREATE TABLE `patient_support` (
  `pid` int(11) NOT NULL,
  `sid` int(11) NOT NULL,
  PRIMARY KEY (`pid`,`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

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


/*Table structure for table `form_assessment_answers` */

DROP TABLE IF EXISTS `form_assessment_answers`;

CREATE TABLE `form_assessment_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `answer` longtext,
  `encounter` int(11) DEFAULT NULL,
  `more` longtext,
  `parent_reg` int(11) DEFAULT NULL,
  `date` datetime DEFAULT NULL,
  KEY `id` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=137 DEFAULT CHARSET=utf8;

/* Primary Support Patient->Primary Support(should be Primary Support instead of Primary Support Patient for category) */
DELETE FROM `openemr_postcalendar_categories` WHERE `pc_catname`='Primary Support';
INSERT INTO `openemr_postcalendar_categories` (`pc_catid`,`pc_constant_id`,`pc_catname`,`pc_catcolor`,`pc_catdesc`,`pc_recurrtype`,`pc_duration`,`aco_spec`) VALUES (16,'primary_support','Primary Support','#CCFFFF','Primary Support','a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}',1800,'encounters|notes');

/* create new table form_assessment_questions */
DROP TABLE IF EXISTS `form_assessment_questions`;

CREATE TABLE `form_assessment_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registry_id` int(11) DEFAULT NULL,
  `question` text,
  `type` varchar(20) DEFAULT NULL,
  `options` text,
  `frequency` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

/*Data for the table `form_assessment_questions` */

insert  into `form_assessment_questions`(`id`,`registry_id`,`question`,`type`,`options`,`frequency`) values

(19,25,'How would you rate your quality of life?','radio','Good|Neither poor nor good|Poor|Very Good|Very Poor',NULL),

(20,25,'How satisfied are you with your health?','radio','Dissatisfied|Neither satisified nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(21,25,'To what extent do you feel that physical pain prevents you from doing what you need to do?','radio','A little|A moderate amount|An extreme amount|Not at all|Very much',NULL),

(22,25,'How much do you need any medical treatment to function in your daily life?','radio','A little|A moderate amount|An extreme amount|Not at all|Very much',NULL),

(23,25,'How much do you enjoy life?','radio','A little|A moderate amount|An extreme amount|Not at all|Very much',NULL),

(24,25,'To what extent do you feel your life to be meaningful?','radio','A little|A moderate amount|An extreme amount|Not at all|Very much',NULL),

(25,25,'How well are you able to concentrate?','radio','A little|A moderate amount|Extremely|Not at all|Very much',NULL),

(26,25,'How safe do you feel in your daily life?','radio','A little|A moderate amount|Extremely|Not at all|Very much',NULL),

(27,25,'How healthy is your physical environment?','radio','A little|A moderate amount|Extremely|Not at all|Very much',NULL),

(28,25,'Do you have enough energe for your everyday life?','radio','A little|A moderate amount|Extremely|Not at all|Very much',NULL),

(29,25,'Are you able to accept your bodily apprearance?','radio','A little|A moderate amount|Extremely|Not at all|Very much',NULL),

(30,25,'Have you enough money to meet your needs?','radio','A little|A moderate amount|Extremely|Not at all|Very much',NULL),

(31,25,'How available to you is the information that you need in your day-to-day life?','radio','A little|A moderate amount|Extremely|Not at all|Very much',NULL),

(32,25,'To what extend do you have the opportunity for leisure activities?','radio','A little|A moderate amount|Extremely|Not at all|Very much',NULL),

(33,25,'How well are you able to get around?','radio','A little|A moderate amount|Extremely|Not at all|Very much',NULL),

(34,25,'How satisfied are you with your sleep?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(35,25,'How satisfied are you with your ability to perform your daily living activities?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(36,25,'How satisfied are you with your capacity for work?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(37,25,'How satisfied are you with yourself?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(38,25,'How satisfied are you with your personal relationships?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(39,25,'How satisfied are you with your sex life?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(40,25,'How satisfied are you with the support you get from your friends?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(41,25,'How satisfied are you with the conditions of your living place?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(42,25,'How satisfied are you with your access to health services?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(43,25,'How satisfied are you with your transport?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(44,25,'How often do you have negative feelings such as blue mood, dispair, anxiety, depression?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied',NULL),

(45,26,'How many 12 step meetings do you go to per week?','text','',14),

(46,26,'How healthy is your work or school environment for your recovery?','radio','Very healthy|Healthy|Neutral|Unhealthy|Very unhealthy',30),

(47,26,'How happy are you today?','radio','Very unhappy|Unhappy|Neutral|Happy|Very happy',14),

(48,26,'How supportive of your recovery is your significant other?','radio','Not at all supportive|Not very supportive|Neutral|Somewhat supportive|Very supportive',14),

(49,26,'How would you describe your level of integrity?','radio','Good|Medium|Poor|Very good|Very poor',30),

(50,26,'Did you consciously lie in the last week?','raido','No|Yes',30),

(51,26,'How much resentment are you currently feeling in your life?','radio','Significant|Some|Very little|None',30),

(52,26,'How much fear are you feeling in your life?','radio','Significant|Some|Very little|None',30),

(53,26,'Who do you live with?','radio','Alone|Friend|Grilfriend/boyfriend|Homeless|Kids and no spouse|Parent|Roommate|Sibling|Sober house|Spouse|Spouse and kids',30),

(54,26,'I have recovery rituals that are now part of my daily life.','radio','True|False',14),

(55,26,'Did you recently start or stop taking medication? If yes, what medications?','radio','No, I am not on any meds|No, my meds have no changed|Yes, I started taking medication|Yes, I stopped talking all prescribed medications|Yes, I stop talking some of my medications',14),

(56,26,'How are you currently dealing with stress?','raido','Discuss with another support person|Discussing with friends|I don\'t know how to deal with my stress(no stress soping skills)|Meditation|Physical exercise|Recovery tools|Therapy',14),

(57,26,'How there been a change in your romantic status?','radio','No change|Yes, I started one|Yes, it ended and I am happy about it|Yes, it ended and I am sad/upset about it',60),

(58,26,'Has your living situation changed since we last spoke?','radio','No|Yes',14),

(59,26,'I have a sponsor(or equivalent) who serves as a special mentor related to my recovery','radio','True|False',30),

(60,26,'Are you dong program related service work?','radio','No|Yes',14),

(61,26,'How would you rate your spiritual condition?','radio','Excellent|Fair|Good|Poor|Very good',14),

(62,26,'Are you actively working the steps with your sponsor?','radio','No|Yes',14),

(63,26,'Do you have a home meeting/group?','radio','No|Yes',14),

(64,26,'Are the people you live with abusing drugs or alcohol?','radio','I don\'t know|No|Yes',30),

(65,26,'I have a stable job (and/or am in school) that I enjoy and that provides my basic necessities.','radio','True|False',14),

(66,26,'Does your significant other abuse drugs or alcohol?','radio','No|Yes',30),

(67,26,'I know what each of my medications do','radio','I do not take medication|No|Yes',30),

(68,26,'Are you having thoughts of harming yourself?','radio','No|Yes',14),

(69,26,'How likely are you to procrastinate?','radio','Unlikely|Somewhat likely|Likely|Very likely|Not at all',30),

(70,26,'Do you have any big changes or events in the near future?(ex-marriages;jobs;recovery;relationships etc)(If yes, note in \"Add Commend\" field)','radio','Yes|No',60),

(71,26,'Are you currently sponsoring individuals in recovery?','radio','Yes|No',60),

(72,26,'Are you having any physical pain or discomfort?','radio','Yes|No',14),

(73,26,'How supportive to your recovery is your living situation?','radio','Neutral|Not at all supportive|Not very supportive|Supportive|Very supportive',30),

(74,26,'Are you struggling with other addictive behaviors?','radio','Yes|No',30),

(75,26,'Are you still sober?','radio','No|Yes',14),

(76,26,'How supportive of your recovery are your family and/or friends?','radio','Not at all supportive|Not very supportive|Neutral|Supportive|Very supportive',14),

(77,26,'How would you describe your stress level?','radio','Significant/high|Some|Very little|None',14),

(78,26,'Are you currently residing in a sober living facility?','radio','Yes|No',30),

(79,26,'Has your consumption of nicotine changed recently?','radio','It has stayed the same|Yes, I have quit using nicotine|Yes, it has decreased|Yes, it has increased',60),

(80,26,'What is your occupation?','radio','Accounting/Finance|Administrative|Architecture|Art/Media/Design|Bartender|Biotech/Science|Business owner|Construction|Customer service|Education|Engineering|Fitness|Food/Beverage/Hospitality|General labor|Government|Human resources|Internet|Legal/Paralegal|Management|Manufacturing|Marketing/PR/Advertising|Medical/Health|Non-profit|None|Other|Real estate|Retail/Wholesale|Retried|Sales|Salon/Spa|Security|Skilled trade/Craft|Software|Student|Technical support|Television/Film/Video|Therapy|Transport|Warehouse|Writing/Editing',60),

(81,26,'Do you currently hold a license for your occupation?','radio','No|Yes',60),

(82,26,'What is your medical/health occupation?','radio','Ancillary Provider(Podiatrist Chiropractor, etc)|Anesthesiologist/CRNA|Counselor(LCSW, LPC, QCSW, LCPC, LMSW)|Dentistry(DDS, DMD)|EMT, First Responder, Paramedic|LPN, LVN, RN| MA, CPhT, Dental Hygienist|MD, DO (enter specialty in comments)|Medical Examiner|Medical Technologies, Lab Tech, Mecial Laboratory Scientise, Philbotomist|Midwife, Massage Therapist|NP, APN, PA, APRN, DNP with APN/APRN|Oriental Medicine, Acupuncture, Hypnotherapy|OT, PT, DPT, PTA, OTA, Athletic Trainer|Other|Pharmacist(PharmD/RPh)|Psychiatrist|Psychologist|Public Health Professional|Respiratory Therapist|Veterinary Medicine(DVM, Vet tech, etc)',60),

(83,26,'Do you handle medications?','radio','No|Yes',60),

(84,26,'Are you currently active duty?','radio','No|Yes',90),

(85,26,'What is your current religious affiliation(if any)?','radio','Agnostic|Atheist|Baptist|Buddhist|Catholic|Christian|Jewish|Lutheran|Mormon/LDS|Muslim|Non-denominational|None|Other|Protestant|Spiritual|Taoist',90),

(86,26,'Do you have any other addictions?','radio','Body dysmorphic disorder|caffeiene|codependency|eating disorder|food|gambling|gaming|internet|love addiction|nicotine|none|other|porn|self-harm|sex|shopping|work',60),

(87,26,'I have people close to me(intimate partner, family members, or friends) who are also in recovery','radio','True|False',60),

(88,26,'How many times have you been to inpatient or residential treatment?','text',NULL,90),

(89,26,'Have you ever been hospitalized due to mental health concerns?','radio','No|Yes',30),

(90,26,'Have you ever been hospitalized due to physical health problems?','radio','No|Yes',30),

(91,26,'How many days in all were you in Emergency Room for the last 30 days?','text',NULL,30),

(92,26,'How many days in all were you in Urgent Care for the last 30 days?','text',NULL,30),

(93,26,'Any changes to your prefered Primary Care Provider?','radio','Yes|No',30),

(94,26,'Did you visit your preferred Primary Care Provider in the last 30 days?','radio','Yes|No',30),

(95,26,'Did you visit your preferred BH Counselor in the last 30 days?','radio','Yes|No',30),

(96,26,'Did you visit your preferred Psychiatrist in the last 30 days?','radio','Yes|No',30),

(97,26,'Any changes to your preferred BH Counselor?','radio','Yes|No',30),

(98,26,'Any changes to your preferred Psychiatirst?','radio','Yes|No',30),

(99,27,'Have you asked for help when you\'ve needed it?','radio','Yes|No',NULL),

(100,27,'Are you practicing any forms of self-care on a regular basis?','radio','Yes|No',NULL),

(101,27,'Do you have a spiritual pranctise?','radio','Yes|No',NULL),

(102,27,'Have you been able to stop from worrying about your loved one?','radio','No|Yes',NULL),

(103,27,'Have you attended any therapy prior to now for help dealing specifically with alcoholism/addiction?','radio','Yes|No',NULL),

(104,27,'Have you set any boundaries for yourself?','radio','No|Yes',NULL),

(105,27,'Are your feelings of well-being and happiness determined by whether your loved one is doing well or not?','radio','No|Yes|Maybe/Not sure',NULL),

(106,27,'Do you participate in some form of recovery for yourself? This would be things like AI-Anon, Nar-Anon, Families Anonymous, Co-Anon, or threapy?','radio','Yes|No, but I\'m open to suggestions|Yes, with a sponsor|No, and I am not open to suggestions',NULL),

(107,28,'How would you assess the case\'s risk level?','chart','Risk Level Slider',NULL),

(108,28,'Do you suspect the Primary Support is making excuses or covering up for the Case?','radio','Yes|No|Maybe/Not sure',NULL),

(109,28,'Do you suspect delusion or denial with this Primary Support?','radio','Healthy|Severe Enabling|Enmeshed|In Denial|Not Involved/Estranged|Enabling|Codependent|Hypervigilant|Not Supportive',NULL),

(110,28,'Do you suspect alcohol or drug abuse with this consent?','radio','Yes|No|Maybe/Not sure',NULL),

(111,29,'How would you assess the case\'s risk level?','chart','Risk Level Slider',NULL),

(112,29,'When I called the Case:','radio','they answered|it went to voicemail and I did not leave a message|it went to voicemail and I left a message|they called MAP|we used video',NULL),

(113,29,'How consistent is contract with this case?','radio','This Case is easy to reach, returns phone calls and does not evade MAP\'s attempts at contact.|Contact with this Case is inconsistent and he/she rarely returns voice mails.|This Case is fairly easy to reach, usually returns calls and mostly responsive.|This case is consistently evasive, rarely returns phone calls, and/or is often unreachable.',NULL),

(114,29,'How would  you describe the Case\'s urgency to get off the phone on a scale of 1 to 10. 1 means the case had no urgency to get off the phone, 10 means the case was urgently trying to get off the phone.','radio','1-2|3-4|5-6|7-8|9-10',NULL),

(115,29,'Were there any red flags during the conversation?','radio','Yes|No',NULL),

(116,29,'How would you describe this case\'s chance of relapse in the near future?','radio','Highly Unlikely|Unlikely, but definitely possible|Very Likely|Unlikely|Fairly Likely',NULL),

(117,29,'How would you describe the family system?','radio','Healthy|Severe Enabling|Enmeshed|In Denial|Not Involved/Estranged|Enabling|Codependent|Hypervigilant/policing|Not Supportive',NULL),

(118,30,'How healthy is your work or school environment for your recovery?','radio','Very healthy|Healthy|Neutral|Unhealthy|Very unhealthy',30),

(119,30,'How happy are you today?','radio','Very unhappy|Unhappy|Neutral|Happy|Very happy',14),

(120,30,'Who do you live with?','radio','Alone|Friend|Girlfriend/bodyfriend|Homeless|Kids and no spouse|Parent|Roomate|Sibling|Sober house|Spouse|Spouse and kids',30),

(121,30,'I have recovery rituals that are now part of my daily life.','radio','True|False',14),

(122,30,'Did you recently start or stop taking medication? If yes, what medications?','radio','No, I am not on any meds.|No, my meds have no changed.|Yes, I started taking medication|Yes, I stopped talking all prescribed medications|Yes, I stopped talking some of my medications',14),

(123,30,'Are you currently dealing with stress?','radio','Discuss with another support person|Discussing with friends|I don\'t know how to deal with my stress(no stress coping skills)|Meditation|Other|Physical exercise|Recovery tools|Therapy',14),

(124,30,'Has your living situation changed since we last spoke?','radio','No|Yes',14),

(125,30,'I have a sponsor(or equivalent) who serves as a special mentor related to my recovery','radio','True|False',30),

(126,30,'Are the people you live with abusing drugs or alcohol?','radio','I don\'t know|No|Yes',30),

(127,30,'I know what each of my medications do','radio','I do not take medication|No|Yes',30),

(128,30,'Are you having thoughts of harming yourself?','radio','No|Yes',14),

(129,30,'Are you having any physical pain or discomfort?','radio','No and I rarely do|No but I typically do|Yes and it\'s chronic|Yes but I don\'t frequently',14),

(130,30,'How supportive to your recovery is your living situation?','radio','Neutral|Not at all supportive|Not very supportive|Supportive|Very supportive',30),

(131,30,'Are you struggling with other addictive behaviors?','radio','Yes|No',30),

(132,30,'Are you still sober?','radio','No|Yes',14),

(133,30,'How supportive of your recovery are your family and /or friends?','radio','Not at all supportive|Not very supportive|Netural|Supportive|Very Supportive',14),

(134,30,'Has your consumption of nicotine changed recently?','radio','It has stayed the same|Yes, I have quit using nicotine|Yes, it has decreased|Yes, it has increased',60),

(135,30,'What is your current religious affiliation(If any)?','radio','Agnostic|Atheist|Baptist|Buddhist|Catholic|Christian|Jewish|Lutheran|Mormon/LDS|Muslim|Non-denominational|None|Other|Protestant|Spiritual|Taoist',90),

(136,30,'Do you have any other addictions?','radio','Body dysmorphic disorder|caffeiene|codependency|eating disorder|food|gambling|gaming|internet|love addiction|nicotine|none|other|porn|self-harm|sex|shopping|work',60),

(137,30,'I have people close to me(intimate partner, family members, or friends) who are also in recovery','radio','True|False',60),

(138,30,'How many times have you been to inpatient or residential treatment?','text',NULL,90),

(139,30,'Have you ever been hospitalized due to mental health concerns?','radio','No|Yes',30),

(140,30,'Have you ever been hospitalized due to physical health problems?','radio','No|Yes',30),

(141,30,'How many days in all were you in Emergency Room for the last 30 days?','text',NULL,30),

(142,30,'How many days in all were you in Urgent Care for the last 30 days?','text',NULL,30),

(143,30,'Any changes to your preferred Primary Care Provider?','radio','Yes|No',30),

(144,30,'Did you visit your preferred Behavioral Health Counselor in the last 30 days?','radio','Yes|No',30),

(145,30,'Did you visit your preferred preferred Behavioral Health Counselor in the last 30 days?','radio','Yes|No',30),

(146,30,'Did you visit your preferred Psychiatrist in the last 30 days?','radio','Yes|No',30),

(147,30,'Any changes to your preferred Behavioral Health Counselor?','radio','Yes|No',30),

(148,30,'Any changes to your preferred Psychiatrist?','radio','Yes|No',30),

(149,30,'How would you rate your spiritual condition?','radio','Excellent|Fair|Good|Poor|Very poor',14),

(150,30,'I have a stable job, or am in school that I enjoy and that provides my basic necessities.','radio','True|False',14),

(151,30,'How would you describe your level of integrity?','radio','Good|Medium|Poor|Very poor|Very good',30),

(152,30,'Do you feel pressure to succeed? If yes, how much pressure are you currently feeling?','radio','No, none|Yes moderate|Yes, high|Yes, extreme',30),

(153,31,'In the past 30 days, would you say your physical health has been?\r\n','radio','Excellent|Very Good|Good|Fair|Poor',NULL),

(154,31,'In the past 30 days, how many nights did you have trouble falling asleep or staying asleep?','radio','0|1-3|4-8|9-15|16-30',NULL),

(155,31,'In the past 30 days, how many days have you felt depressed, anxious, angry or very upset throughout most of the day?','radio','0|1-3|4-8|9-15|16-30',NULL),

(156,31,'In the past 30 days, how many days did you drink ANY alcohol?','radio','0|1-3|4-8|9-15|16-30',NULL),

(157,31,'In the past 30 days, how many days did you ahve at least 5 drinks (man), or at least 4 drinks (woman)? (One drink is considered one shot of hard liquor (1.5 oz.) or 12 ounce can/bottle of beer, or 5 ounce glass of wine.)\r\n','radio','0|1-3|4-8|9-15|16-30',NULL),

(158,31,'In the past 30 days, how many days did you use any illegal/street drugs or abuse any prescription medications?','radio','0|1-3|4-8|9-15|16-30',NULL),

(159,31,'In the past 30 days, how many days did you use 7a Marijuana (cannabis, pot, weed)?','radio','0|1-3|4-8|9-15|16-30',NULL),

(160,31,'In the past 30 days, how many days did you use Sedatives/Tranquilizers (eg, benzos, Valium, Xanax, Ativan, Ambien, barbs, Phenobarbital, downers, etc.)?','radio','0|1-3|4-8|9-15|16-30',NULL),

(161,31,'In the past 30 days, how many days did you use Cocaine/Crack?','radio','0|1-3|4-8|9-15|16-30',NULL),

(162,31,'In the past 30 days, how many days did you use Oher Stimulants (amphetamine, methamphetamine, Dexedrine, Ritalin, Adderall, speed, crystal meth, ice, etc.)?','radio','0|1-3|4-8|9-15|16-30',NULL),

(163,31,'In the past 30 days, how many days did you use Opiates (heroin, morphine, dilaudid, demerol, oxycontin, oxy, codeine, Tylenol #2/3/4, Percocet, Vicodin, Fentanyl, etc.)?','radio','0|1-3|4-8|9-15|16-30',NULL),

(164,31,'In the past 30 days, how many days did you use Inhalants (glues/adhesives, mail polish remover, paint thinner, etc.)?','radio','0|1-3|4-8|9-15|16-30',NULL),

(165,31,'In the past 30 days, how many days did you use Other drugs (steroids, non-prescription sleep.diet pills, Benadryl, Ephedra, other over-the-counter/unknown medications)? ','radio','0|1-3|4-8|9-15|16-30',NULL),

(166,31,'In the past 30 days, how much were you bothered by cravings or urges to drink alcohol or use drugs?','radio','Not at all|Slightly|Moderately|Considerably|Extremely',NULL),

(167,31,'How confident are you in your ability to be completely abstinent (clean) form alcohol and drugs in the next 30 days?','radio','Not at all|Slightly|Moderately|Considerably|Extremely',NULL),

(168,31,'In the past 30 days, how many days did you attend self-help meetings like AA or NA to support your recovery?','radio','Not at all|Slightly|Moderately|Considerably|Extremely',NULL),

(169,31,'In the past 30 days, how many days were you in any situations or with any people that might put you at an increased risk for using alcohol or drugs (around risky people, places, or things)?','radio','0|1-3|4-8|9-15|16-30',NULL),

(170,31,'Does your religion or spirituality help support your recovery? ','radio','Not at all|Slightly|Moderately|Considerably|Extremely',NULL),

(171,31,'In the past 30 days, how many days did you spend much of th etime at work, school, or doing volunteer work?','radio','0|1-3|4-8|9-15|16-30',NULL),

(172,31,'Do you have enough income (from legal sources) to pay for necessities such as housing, transportation, food and clothing, for yourself and your dependents?','radio','No|Yes',NULL),

(173,31,'In the past 30 days, how much have you been bothered by arguments or problems getting along with any family members or friends?','radio','Not at all|Slightly|Moderately|Considerably|Extremely',NULL),

(174,31,'In the past 30 days, how many days were you in contact or spent time with any family members or friends who are supportive of your recovery?','radio','Not at all|Slightly|Moderately|Considerably|Extremely',NULL),

(175,31,'How satisfied are you with your progress toward achieving your recovery goals?','radio','Not at all|Slightly|Moderately|Considerably|Extremely',NULL);


/* Create new table patient_meta to store recent assessment value and others */
DROP TABLE IF EXISTS `patient_meta`;

CREATE TABLE `patient_meta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `encounter` int(11) DEFAULT NULL,
  `value` varchar(50) DEFAULT NULL,
  `date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

/* Create new table form_encounter_review to store Assessment review state */
DROP TABLE IF EXISTS `form_encounter_review`;
CREATE TABLE `form_encounter_review` (
  `encounter` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `registry` int(11) NOT NULL,
  PRIMARY KEY (`encounter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

/* Remove all existing categories and Primary Support & Patient is left */
INSERT INTO `openemr_postcalendar_categories`
(`pc_catid`, `pc_constant_id`,  `pc_catname`,  `pc_catcolor`,  `pc_catdesc`,  `pc_recurrtype`,  `pc_enddate`,  `pc_recurrspec`,  `pc_recurrfreq`,
`pc_duration`, `pc_end_date_flag`, `pc_end_date_type`, `pc_end_date_freq`, `pc_end_all_day`, `pc_dailylimit`, `pc_cattype`, `pc_active`, `pc_seq`, `aco_spec`
) VALUES
(17, `patient_enc`, `Patient`, `#FFFFCC`, `Patient category for normal patient Another category is Primary Support - 16`, 0, NULL, `a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}`, 0, 900,
0, 0, 0, 0, 0, 0, 1, 17, `encounters|notes`);
