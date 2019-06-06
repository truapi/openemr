DELETE FROM `registry` WHERE `directory`='primary_support';
/* add assessment to registry to display inside 'Clinical' menu */
insert into `registry` (`name`, `state`, `directory`, `id`, `sql_run`, `unpackaged`, `date`, `priority`, `category`, `nickname`, `patient_encounter`, `therapy_group_encounter`, `aco_spec`) values('Test Assessment','1','primary_support','24','1','1','2019-05-22 21:51:27','0','Assessments','','1','0','encounters|notes');
insert into `registry` (`name`, `state`, `directory`, `id`, `sql_run`, `unpackaged`, `date`, `priority`, `category`, `nickname`, `patient_encounter`, `therapy_group_encounter`, `aco_spec`) values('WHOQOL Bref','1','primary_support','25','1','1','2019-05-22 21:51:27','0','Assessments','','1','0','encounters|notes');
insert into `registry` (`name`, `state`, `directory`, `id`, `sql_run`, `unpackaged`, `date`, `priority`, `category`, `nickname`, `patient_encounter`, `therapy_group_encounter`, `aco_spec`) values('Regular Session','1','primary_support','26','1','1','2019-05-22 21:51:27','0','Assessments','','1','0','encounters|notes');
insert into `registry` (`name`, `state`, `directory`, `id`, `sql_run`, `unpackaged`, `date`, `priority`, `category`, `nickname`, `patient_encounter`, `therapy_group_encounter`, `aco_spec`) values('Primary Support Questions','1','primary_support','27','1','1','2019-05-22 21:51:27','0','Assessments','','1','0','encounters|notes');
insert into `registry` (`name`, `state`, `directory`, `id`, `sql_run`, `unpackaged`, `date`, `priority`, `category`, `nickname`, `patient_encounter`, `therapy_group_encounter`, `aco_spec`) values('Primary Support Impression Questions','1','primary_support','28','1','1','2019-05-22 21:51:27','0','Assessments','','1','0','encounters|notes');
insert into `registry` (`name`, `state`, `directory`, `id`, `sql_run`, `unpackaged`, `date`, `priority`, `category`, `nickname`, `patient_encounter`, `therapy_group_encounter`, `aco_spec`) values('Patient Impression Questions','1','primary_support','29','1','1','2019-05-22 21:51:27','0','Assessments','','1','0','encounters|notes');
insert into `registry` (`name`, `state`, `directory`, `id`, `sql_run`, `unpackaged`, `date`, `priority`, `category`, `nickname`, `patient_encounter`, `therapy_group_encounter`, `aco_spec`) values('Adolescent Session','1','primary_support','30','1','1','2019-05-22 21:51:27','0','Assessments','','1','0','encounters|notes');

/* create new table form_assessment_questions */
DROP TABLE IF EXISTS `form_assessment_questions`;

CREATE TABLE `form_assessment_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `registry_id` int(11) DEFAULT NULL,
  `question` text,
  `type` varchar(20) DEFAULT NULL,
  `options` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=153 DEFAULT CHARSET=utf8;

/*Data for the table `form_assessment_questions` */

insert  into `form_assessment_questions`(`id`,`registry_id`,`question`,`type`,`options`) values

(10,24,'Do you participate in some form of recovery for yourself? This would be thinking like Al-Anon, Families Anonymous, Co-Anon, or therapy?','radio','Yes|Yes with a sponsor|No, but I am open to suggestions|No, and I am not open to suggestions'),

(11,24,'Have you noticed any positive or negative behavioral changes in Virginia Benji?','radio','Positive|Negative|No Change'),

(12,24,'Are your feelings of well-being and happiness determined by whether your loved one is doing well or not?','radio','Yes|No|Maybe/Not Sure'),

(13,24,'How would you assess the Case\'s Risk Level?','chart',''),

(14,24,'Do you suspect the consent is making excuses, or covering up for the Case?','radio','Yes|No|Maybe/Not Sure'),

(15,24,'Do you suspect delusion or denial with this consent?','radio','Yes|No|Maybe/Not Sure'),

(16,24,'How would you describe the family system?','checkbox','Healthy|Enabling|Severe Enabling|Codependent|Enmeshed|Hypervigilant/Policiing|In Denial|Not Supportive|Not Involved/Estranged'),

(17,24,'Do you suspect alcohol or drug abuse with this consent?','radio','Yes|No|Maybe/Not Sure'),

(18,24,'Impression Notes','final',''),

(19,25,'How would you rate your quality of life?','radio','Good|Neither poor nor good|Poor|Very Good|Very Poor'),

(20,25,'How satisfied are you with your health?','radio','Dissatisfied|Neither satisified nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(21,25,'To what extent do you feel that physical pain prevents you from doing what you need to do?','radio','A little|A moderate amount|An extreme amount|Not at all|Very much'),

(22,25,'How much do you need any medical treatment to function in your daily life?','radio','A little|A moderate amount|An extreme amount|Not at all|Very much'),

(23,25,'How much do you enjoy life?','radio','A little|A moderate amount|An extreme amount|Not at all|Very much'),

(24,25,'To what extent do you feel your life to be meaningful?','radio','A little|A moderate amount|An extreme amount|Not at all|Very much'),

(25,25,'How well are you able to concentrate?','radio','A little|A moderate amount|Extremely|Not at all|Very much'),

(26,25,'How safe do you feel in your daily life?','radio','A little|A moderate amount|Extremely|Not at all|Very much'),

(27,25,'How healthy is your physical environment?','radio','A little|A moderate amount|Extremely|Not at all|Very much'),

(28,25,'Do you have enough energe for your everyday life?','radio','A little|A moderate amount|Extremely|Not at all|Very much'),

(29,25,'Are you able to accept your bodily apprearance?','radio','A little|A moderate amount|Extremely|Not at all|Very much'),

(30,25,'Have you enough money to meet your needs?','radio','A little|A moderate amount|Extremely|Not at all|Very much'),

(31,25,'How available to you is the information that you need in your day-to-day life?','radio','A little|A moderate amount|Extremely|Not at all|Very much'),

(32,25,'To what extend do you have the opportunity for leisure activities?','radio','A little|A moderate amount|Extremely|Not at all|Very much'),

(33,25,'How well are you able to get around?','radio','A little|A moderate amount|Extremely|Not at all|Very much'),

(34,25,'How satisfied are you with your sleep?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(35,25,'How satisfied are you with your ability to perform your daily living activities?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(36,25,'How satisfied are you with your capacity for work?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(37,25,'How satisfied are you with yourself?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(38,25,'How satisfied are you with your personal relationships?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(39,25,'How satisfied are you with your sex life?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(40,25,'How satisfied are you with the support you get from your friends?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(41,25,'How satisfied are you with the conditions of your living place?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(42,25,'How satisfied are you with your access to health services?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(43,25,'How satisfied are you with your transport?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(44,25,'How often do you have negative feelings such as blue mood, dispair, anxiety, depression?','radio','Dissatisfied|Neigher satisfied nor dissatisfied|Satisfied|Very dissatisfied|Very satisfied'),

(45,26,'How many 12 step meetings do you go to per week?','text',''),

(46,26,'How healthy is your work or school environment for your recovery?','radio','Very healthy|Healthy|Neutral|Unhealthy|Very unhealthy'),

(47,26,'How happy are you today?','radio','Very unhappy|Unhappy|Neutral|Happy|Very happy'),

(48,26,'How supportive of your recovery is your significant other?','radio','Not at all supportive|Not very supportive|Neutral|Somewhat supportive|Very supportive'),

(49,26,'How would you describe your level of integrity?','radio','Good|Medium|Poor|Very good|Very poor'),

(50,26,'Did you consciously lie in the last week?','raido','No|Yes'),

(51,26,'How much resentment are you currently feeling in your life?','radio','Significant|Some|Very little|None'),

(52,26,'How much fear are you feeling in your life?','radio','Significant|Some|Very little|None'),

(53,26,'Who do you live with?','radio','Alone|Friend|Grilfriend/boyfriend|Homeless|Kids and no spouse|Parent|Roommate|Sibling|Sober house|Spouse|Spouse and kids'),

(54,26,'I have recovery rituals that are now part of my daily life.','radio','True|False'),

(55,26,'Did you recently start or stop taking medication? If yes, what medications?','radio','No, I am not on any meds|No, my meds have no changed|Yes, I started taking medication|Yes, I stopped talking all prescribed medications|Yes, I stop talking some of my medications'),

(56,26,'How are you currently dealing with stress?','raido','Discuss with another support person|Discussing with friends|I don\'t know how to deal with my stress(no stress soping skills)|Meditation|Physical exercise|Recovery tools|Therapy'),

(57,26,'How there been a change in your romantic status?','radio','No change|Yes, I started one|Yes, it ended and I am happy about it|Yes, it ended and I am sad/upset about it'),

(58,26,'Has your living situation changed since we last spoke?','radio','No|Yes'),

(59,26,'I have a sponsor(or equivalent) who serves as a special mentor related to my recovery','radio','True|False'),

(60,26,'Are you dong program related service work?','radio','No|Yes'),

(61,26,'How would you rate your spiritual condition?','radio','Excellent|Fair|Good|Poor|Very good'),

(62,26,'Are you actively working the steps with your sponsor?','radio','No|Yes'),

(63,26,'Do you have a home meeting/group?','radio','No|Yes'),

(64,26,'Are the people you live with abusing drugs or alcohol?','radio','I don\'t know|No|Yes'),

(65,26,'I have a stable job (and/or am in school) that I enjoy and that provides my basic necessities.','radio','True|False'),

(66,26,'Does your significant other abuse drugs or alcohol?','radio','No|Yes'),

(67,26,'I know what each of my medications do','radio','I do not take medication|No|Yes'),

(68,26,'Are you having thoughts of harming yourself?','radio','No|Yes'),

(69,26,'How likely are you to procrastinate?','radio','Unlikely|Somewhat likely|Likely|Very likely|Not at all'),

(70,26,'Do you have any big changes or events in the near future?(ex-marriages;jobs;recovery;relationships etc)(If yes, note in \"Add Commend\" field)','radio','Yes|No'),

(71,26,'Are you currently sponsoring individuals in recovery?','radio','Yes|No'),

(72,26,'Are you having any physical pain or discomfort?','radio','Yes|No'),

(73,26,'How supportive to your recovery is your living situation?','radio','Neutral|Not at all supportive|Not very supportive|Supportive|Very supportive'),

(74,26,'Are you struggling with other addictive behaviors?','radio','Yes|No'),

(75,26,'Are you still sober?','radio','No|Yes'),

(76,26,'How supportive of your recovery are your family and/or friends?','radio','Not at all supportive|Not very supportive|Neutral|Supportive|Very supportive'),

(77,26,'How would you describe your stress level?','radio','Significant/high|Some|Very little|None'),

(78,26,'Are you currently residing in a sober living facility?','radio','Yes|No'),

(79,26,'Has your consumption of nicotine changed recently?','radio','It has stayed the same|Yes, I have quit using nicotine|Yes, it has decreased|Yes, it has increased'),

(80,26,'What is your occupation?','radio','Accounting/Finance|Administrative|Architecture|Art/Media/Design|Bartender|Biotech/Science|Business owner|Construction|Customer service|Education|Engineering|Fitness|Food/Beverage/Hospitality|General labor|Government|Human resources|Internet|Legal/Paralegal|Management|Manufacturing|Marketing/PR/Advertising|Medical/Health|Non-profit|None|Other|Real estate|Retail/Wholesale|Retried|Sales|Salon/Spa|Security|Skilled trade/Craft|Software|Student|Technical support|Television/Film/Video|Therapy|Transport|Warehouse|Writing/Editing'),

(81,26,'Do you currently hold a license for your occupation?','radio','No|Yes'),

(82,26,'What is your medical/health occupation?','radio','Ancillary Provider(Podiatrist Chiropractor, etc)|Anesthesiologist/CRNA|Counselor(LCSW, LPC, QCSW, LCPC, LMSW)|Dentistry(DDS, DMD)|EMT, First Responder, Paramedic|LPN, LVN, RN| MA, CPhT, Dental Hygienist|MD, DO (enter specialty in comments)|Medical Examiner|Medical Technologies, Lab Tech, Mecial Laboratory Scientise, Philbotomist|Midwife, Massage Therapist|NP, APN, PA, APRN, DNP with APN/APRN|Oriental Medicine, Acupuncture, Hypnotherapy|OT, PT, DPT, PTA, OTA, Athletic Trainer|Other|Pharmacist(PharmD/RPh)|Psychiatrist|Psychologist|Public Health Professional|Respiratory Therapist|Veterinary Medicine(DVM, Vet tech, etc)'),

(83,26,'Do you handle medications?','radio','No|Yes'),

(84,26,'Are you currently active duty?','radio','No|Yes'),

(85,26,'What is your current religious affiliation(if any)?','radio','Agnostic|Atheist|Baptist|Buddhist|Catholic|Christian|Jewish|Lutheran|Mormon/LDS|Muslim|Non-denominational|None|Other|Protestant|Spiritual|Taoist'),

(86,26,'Do you have any other addictions?','radio','Body dysmorphic disorder|caffeiene|codependency|eating disorder|food|gambling|gaming|internet|love addiction|nicotine|none|other|porn|self-harm|sex|shopping|work'),

(87,26,'I have people close to me(intimate partner, family members, or friends) who are also in recovery','radio','True|False'),

(88,26,'How many times have you been to inpatient or residential treatment?','text',NULL),

(89,26,'Have you ever been hospitalized due to mental health concerns?','radio','No|Yes'),

(90,26,'Have you ever been hospitalized due to physical health problems?','radio','No|Yes'),

(91,26,'How many days in all were you in Emergency Room for the last 30 days?','text',NULL),

(92,26,'How many days in all were you in Urgent Care for the last 30 days?','text',NULL),

(93,26,'Any changes to your prefered Primary Care Provider?','radio','Yes|No'),

(94,26,'Did you visit your preferred Primary Care Provider in the last 30 days?','radio','Yes|No'),

(95,26,'Did you visit your preferred BH Counselor in the last 30 days?','radio','Yes|No'),

(96,26,'Did you visit your preferred Psychiatrist in the last 30 days?','radio','Yes|No'),

(97,26,'Any changes to your preferred BH Counselor?','radio','Yes|No'),

(98,26,'Any changes to your preferred Psychiatirst?','radio','Yes|No'),

(99,27,'Have you asked for help when you\'ve needed it?','radio','Yes|No'),

(100,27,'Are you practicing any forms of self-care on a regular basis?','radio','Yes|No'),

(101,27,'Do you have a spiritual pranctise?','radio','Yes|No'),

(102,27,'Have you been able to stop from worrying about your loved one?','radio','No|Yes'),

(103,27,'Have you attended any therapy prior to now for help dealing specifically with alcoholism/addiction?','radio','Yes|No'),

(104,27,'Have you set any boundaries for yourself?','radio','No|Yes'),

(105,27,'Are your feelings of well-being and happiness determined by whether your loved one is doing well or not?','radio','No|Yes|Maybe/Not sure'),

(106,27,'Do you participate in some form of recovery for yourself? This would be things like AI-Anon, Nar-Anon, Families Anonymous, Co-Anon, or threapy?','radio','Yes|No, but I\'m open to suggestions|Yes, with a sponsor|No, and I am not open to suggestions'),

(107,28,'How would you assess the case\'s risk level?','checkbox','Risk Level Slider'),

(108,28,'Do you suspect the Primary Support is making excuses or covering up for the Case?','radio','Yes|No|Maybe/Not sure'),

(109,28,'Do you suspect delusion or denial with this Primary Support?','radio','Healthy|Severe Enabling|Enmeshed|In Denial|Not Involved/Estranged|Enabling|Codependent|Hypervigilant|Not Supportive'),

(110,28,'Do you suspect alcohol or drug abuse with this consent?','radio','Yes|No|Maybe/Not sure'),

(111,29,'How would you assess the case\'s risk level?','checkbox','Risk Level Slider'),

(112,29,'When I called the Case:','radio','they answered|it went to voicemail and I did not leave a message|it went to voicemail and I left a message|they called MAP|we used video'),

(113,29,'How consistent is contract with this case?','radio','This Case is easy to reach, returns phone calls and does not evade MAP\'s attempts at contact.|Contact with this Case is inconsistent and he/she rarely returns voice mails.|This Case is fairly easy to reach, usually returns calls and mostly responsive.|This case is consistently evasive, rarely returns phone calls, and/or is often unreachable.'),

(114,29,'How would  you describe the Case\'s urgency to get off the phone on a scale of 1 to 10. 1 means the case had no urgency to get off the phone, 10 means the case was urgently trying to get off the phone.','radio','1-2|3-4|5-6|7-8|9-10'),

(115,29,'Were there any red flags during the conversation?','radio','Yes|No'),

(116,29,'How would you describe this case\'s chance of relapse in the near future?','radio','Highly Unlikely|Unlikely, but definitely possible|Very Likely|Unlikely|Fairly Likely'),

(117,29,'How would you describe the family system?','radio','Healthy|Severe Enabling|Enmeshed|In Denial|Not Involved/Estranged|Enabling|Codependent|Hypervigilant/policing|Not Supportive'),

(118,30,'How healthy is your work or school environment for your recovery?','radio','Very healthy|Healthy|Neutral|Unhealthy|Very unhealthy'),

(119,30,'How happy are you today?','radio','Very unhappy|Unhappy|Neutral|Happy|Very happy'),

(120,30,'Who do you live with?','radio','Alone|Friend|Girlfriend/bodyfriend|Homeless|Kids and no spouse|Parent|Roomate|Sibling|Sober house|Spouse|Spouse and kids'),

(121,30,'I have recovery rituals that are now part of my daily life.','radio','True|False'),

(122,30,'Did you recently start or stop taking medication? If yes, what medications?','radio','No, I am not on any meds.|No, my meds have no changed.|Yes, I started taking medication|Yes, I stopped talking all prescribed medications|Yes, I stopped talking some of my medications'),

(123,30,'Are you currently dealing with stress?','radio','Discuss with another support person|Discussing with friends|I don\'t know how to deal with my stress(no stress coping skills)|Meditation|Other|Physical exercise|Recovery tools|Therapy'),

(124,30,'Has your living situation changed since we last spoke?','radio','No|Yes'),

(125,30,'I have a sponsor(or equivalent) who serves as a special mentor related to my recovery','radio','True|False'),

(126,30,'Are the people you live with abusing drugs or alcohol?','radio','I don\'t know|No|Yes'),

(127,30,'I know what each of my medications do','radio','I do not take medication|No|Yes'),

(128,30,'Are you having thoughts of harming yourself?','radio','No|Yes'),

(129,30,'Are you having any physical pain or discomfort?','radio','No and I rarely do|No but I typically do|Yes and it\'s chronic|Yes but I don\'t frequently'),

(130,30,'How supportive to your recovery is your living situation?','radio','Neutral|Not at all supportive|Not very supportive|Supportive|Very supportive'),

(131,30,'Are you struggling with other addictive behaviors?','radio','Yes|No'),

(132,30,'Are you still sober?','radio','No|Yes'),

(133,30,'How supportive of your recovery are your family and /or friends?','radio','Not at all supportive|Not very supportive|Netural|Supportive|Very Supportive'),

(134,30,'Has your consumption of nicotine changed recently?','radio','It has stayed the same|Yes, I have quit using nicotine|Yes, it has decreased|Yes, it has increased'),

(135,30,'What is your current religious affiliation(If any)?','radio','Agnostic|Atheist|Baptist|Buddhist|Catholic|Christian|Jewish|Lutheran|Mormon/LDS|Muslim|Non-denominational|None|Other|Protestant|Spiritual|Taoist'),

(136,30,'Do you have any other addictions?','radio','Body dysmorphic disorder|caffeiene|codependency|eating disorder|food|gambling|gaming|internet|love addiction|nicotine|none|other|porn|self-harm|sex|shopping|work'),

(137,30,'I have people close to me(intimate partner, family members, or friends) who are also in recovery','radio','True|False'),

(138,30,'How many times have you been to inpatient or residential treatment?','text',NULL),

(139,30,'Have you ever been hospitalized due to mental health concerns?','radio','No|Yes'),

(140,30,'Have you ever been hospitalized due to physical health problems?','radio','No|Yes'),

(141,30,'How many days in all were you in Emergency Room for the last 30 days?','text',NULL),

(142,30,'How many days in all were you in Urgent Care for the last 30 days?','text',NULL),

(143,30,'Any changes to your preferred Primary Care Provider?','radio','Yes|No'),

(144,30,'Did you visit your preferred Behavioral Health Counselor in the last 30 days?','radio','Yes|No'),

(145,30,'Did you visit your preferred preferred Behavioral Health Counselor in the last 30 days?','radio','Yes|No'),

(146,30,'Did you visit your preferred Psychiatrist in the last 30 days?','radio','Yes|No'),

(147,30,'Any changes to your preferred Behavioral Health Counselor?','radio','Yes|No'),

(148,30,'Any changes to your preferred Psychiatrist?','radio','Yes|No'),

(149,30,'How would you rate your spiritual condition?','radio','Excellent|Fair|Good|Poor|Very poor'),

(150,30,'I have a stable job, or am in school that I enjoy and that provides my basic necessities.','radio','True|False'),

(151,30,'How would you describe your level of integrity?','radio','Good|Medium|Poor|Very poor|Very good'),

(152,30,'Do you feel pressure to succeed? If yes, how much pressure are you currently feeling?','radio','No, none|Yes moderate|Yes, high|Yes, extreme');

/* Create new table form_encounter_review to store Assessment review state */
DROP TABLE IF EXISTS `form_encounter_review`;

CREATE TABLE `form_encounter_review` (
  `encounter` int(11) NOT NULL,
  `status` tinyint(1) DEFAULT '0',
  `registry` int(11) NOT NULL,
  PRIMARY KEY (`encounter`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
