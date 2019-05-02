--  Add 'Assessment' to translation

-- Insert into openemr_postcalendar_categories
INSERT INTO `openemr_postcalendar_categories` (`pc_constant_id`,`pc_catname`,`pc_catcolor`,`pc_catdesc`,`pc_recurrtype`,`pc_duration`,`aco_spec`) VALUES ('primary_support_patient','Primary Support Patient','#CCFFFF','Primary Support Patient','a:5:{s:17:"event_repeat_freq";s:1:"0";s:22:"event_repeat_freq_type";s:1:"0";s:19:"event_repeat_on_num";s:1:"1";s:19:"event_repeat_on_day";s:1:"0";s:20:"event_repeat_on_freq";s:1:"0";}',1800,'encounters|notes');

-- add primary_support field to form_encounter ***
ALTER TABLE form_encounter ADD primary_support INT;

-- add assessment to registry
INSERT INTO `registry` (`name`, `state`, `directory`, `sql_run`, `unpackaged`, `date`, `priority`, `category`, `nickname`, `patient_encounter`, `therapy_group_encounter`, `aco_spec`) VALUES ("Assessment", 1, "primary_support", 1, 1, CURRENT_TIMESTAMP, 0, 'Clinical', '', 1, 0, 'encounters|notes');

-- add pc_p_s_pid into openemr_postcalendar_events
ALTER TABLE openemr_postcalendar_events ADD pc_p_s_pid VARCHAR(11);

-- create new table form_assessment_questions
DROP TABLE IF EXISTS `form_assessment_questions`;

CREATE TABLE `form_assessment_questions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question` text,
  `type` varchar(20) DEFAULT NULL,
  `options` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

INSERT INTO `form_assessment_questions` (`question`, `type`, `options`) VALUES ("Do you participate in some form of recovery for yourself? This would be thinking like Al-Anon, Families Anonymous, Co-Anon, or therapy?", 'radio', 'Yes|Yes with a sponsor|No, but I am open to suggestions|No, and I am not open to suggestions');
INSERT INTO `form_assessment_questions` (`question`, `type`, `options`) VALUES ("Have you noticed any positive or negative behavioral changes in Virginia Benji?", 'radio', 'Positive|Negative|No Change');
INSERT INTO `form_assessment_questions` (`question`, `type`, `options`) VALUES ("Are your feelings of well-being and happiness determined by whether your loved one is doing well or not?", 'radio', 'Yes|No|Maybe/Not Sure');
INSERT INTO `form_assessment_questions` (`question`, `type`, `options`) VALUES ("How would you assess the Case's Risk Level?", 'chart', '');
INSERT INTO `form_assessment_questions` (`question`, `type`, `options`) VALUES ("Do you suspect the consent is making excuses, or covering up for the Case?", 'radio', 'Yes|No|Maybe/Not Sure');
INSERT INTO `form_assessment_questions` (`question`, `type`, `options`) VALUES ("Do you suspect delusion or denial with this consent?", 'radio', 'Yes|No|Maybe/Not Sure');
INSERT INTO `form_assessment_questions` (`question`, `type`, `options`) VALUES ("How would you describe the family system?", 'checkbox', 'Healthy|Enabling|Severe Enabling|Codependent|Enmeshed|Hypervigilant/Policiing|In Denial|Not Supportive|Not Involved/Estranged');
INSERT INTO `form_assessment_questions` (`question`, `type`, `options`) VALUES ("Do you suspect alcohol or drug abuse with this consent?", 'radio', 'Yes|No|Maybe/Not Sure');
INSERT INTO `form_assessment_questions` (`question`, `type`, `options`) VALUES ("Impression Notes", 'final', '');

-- crate new table form_assessment_answers
DROP TABLE IF EXISTS `form_assessment_answers`;

CREATE TABLE `form_assessment_answers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `question_id` int(11) DEFAULT NULL,
  `answer` longtext DEFAULT NULL,
  `encounter` int(11) DEFAULT NULL,
  `more` longtext,
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
