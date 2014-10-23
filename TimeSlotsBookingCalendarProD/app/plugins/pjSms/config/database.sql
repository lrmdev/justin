DROP TABLE IF EXISTS `plugin_sms`;
CREATE TABLE IF NOT EXISTS `plugin_sms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `number` varchar(255) DEFAULT NULL,
  `text` varchar(255) DEFAULT NULL,
  `status` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_sms_menu_sms', 'backend', 'SMS plugin / Menu SMS', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'SMS', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'SMS', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'SMS', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_sms_config', 'backend', 'SMS plugin / SMS config', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'SMS Config', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'SMS Config', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'SMS Config', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_sms_number', 'backend', 'SMS plugin / Number', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Phone number', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Phone number', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Phone number', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_sms_text', 'backend', 'SMS plugin / Text', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Message', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Message', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Message', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_sms_status', 'backend', 'SMS plugin / Status', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Status', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Status', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Status', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_sms_created', 'backend', 'SMS plugin / Date & Time', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Date/Time sent', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Date/Time sent', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Date/Time sent', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_sms_api', 'backend', 'SMS plugin / API Key', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'API Key', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'API Key', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'API Key', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PSS01', 'arrays', 'SMS plugin / Info title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'SMS', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'SMS', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'SMS', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PSS01', 'arrays', 'SMS plugin / Info body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'To send SMS you need a valid API Key. Please, contact StivaSoft to purchase an API key.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'To send SMS you need a valid API Key. Please, contact StivaSoft to purchase an API key.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'To send SMS you need a valid API Key. Please, contact StivaSoft to purchase an API key.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PSS02', 'arrays', 'SMS plugin / API key updates info title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'SMS API key updated!', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'SMS API key updated!', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'SMS API key updated!', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PSS02', 'arrays', 'SMS plugin / API key updates info body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'All changes have been saved.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'All changes have been saved.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'All changes have been saved.', 'plugin');