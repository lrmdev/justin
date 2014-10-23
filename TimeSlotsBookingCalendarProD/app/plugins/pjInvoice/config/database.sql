DROP TABLE IF EXISTS `plugin_invoice`;
CREATE TABLE IF NOT EXISTS `plugin_invoice` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(12) DEFAULT NULL,
  `order_id` varchar(12) DEFAULT NULL,
  `foreign_id` int(10) unsigned DEFAULT NULL,
  `issue_date` date DEFAULT NULL,
  `due_date` date DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  `status` enum('not_paid','paid','cancelled') DEFAULT NULL,
  `txn_id` varchar(255) DEFAULT NULL,
  `processed_on` datetime DEFAULT NULL,
  `subtotal` decimal(9,2) unsigned DEFAULT NULL,
  `discount` decimal(9,2) unsigned DEFAULT NULL,
  `tax` decimal(9,2) unsigned DEFAULT NULL,
  `shipping` decimal(9,2) unsigned DEFAULT NULL,
  `total` decimal(9,2) unsigned DEFAULT NULL,
  `paid_deposit` decimal(9,2) unsigned DEFAULT NULL,
  `amount_due` decimal(9,2) unsigned DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `notes` text,
  `y_logo` varchar(255) DEFAULT NULL,
  `y_company` varchar(255) DEFAULT NULL,
  `y_name` varchar(255) DEFAULT NULL,
  `y_street_address` varchar(255) DEFAULT NULL,
  `y_city` varchar(255) DEFAULT NULL,
  `y_state` varchar(255) DEFAULT NULL,
  `y_zip` varchar(255) DEFAULT NULL,
  `y_phone` varchar(255) DEFAULT NULL,
  `y_fax` varchar(255) DEFAULT NULL,
  `y_email` varchar(255) DEFAULT NULL,
  `y_url` varchar(255) DEFAULT NULL,
  `b_billing_address` varchar(255) DEFAULT NULL,
  `b_company` varchar(255) DEFAULT NULL,
  `b_name` varchar(255) DEFAULT NULL,
  `b_address` varchar(255) DEFAULT NULL,
  `b_street_address` varchar(255) DEFAULT NULL,
  `b_city` varchar(255) DEFAULT NULL,
  `b_state` varchar(255) DEFAULT NULL,
  `b_zip` varchar(255) DEFAULT NULL,
  `b_phone` varchar(255) DEFAULT NULL,
  `b_fax` varchar(255) DEFAULT NULL,
  `b_email` varchar(255) DEFAULT NULL,
  `b_url` varchar(255) DEFAULT NULL,
  `s_shipping_address` varchar(255) DEFAULT NULL,
  `s_company` varchar(255) DEFAULT NULL,
  `s_name` varchar(255) DEFAULT NULL,
  `s_address` varchar(255) DEFAULT NULL,
  `s_street_address` varchar(255) DEFAULT NULL,
  `s_city` varchar(255) DEFAULT NULL,
  `s_state` varchar(255) DEFAULT NULL,
  `s_zip` varchar(255) DEFAULT NULL,
  `s_phone` varchar(255) DEFAULT NULL,
  `s_fax` varchar(255) DEFAULT NULL,
  `s_email` varchar(255) DEFAULT NULL,
  `s_url` varchar(255) DEFAULT NULL,
  `s_date` date DEFAULT NULL,
  `s_terms` text,
  `s_is_shipped` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `uuid` (`uuid`),
  KEY `order_id` (`order_id`),
  KEY `foreign_id` (`foreign_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `plugin_invoice_config`;
CREATE TABLE IF NOT EXISTS `plugin_invoice_config` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `y_logo` varchar(255) DEFAULT NULL,
  `y_company` varchar(255) DEFAULT NULL,
  `y_name` varchar(255) DEFAULT NULL,
  `y_street_address` varchar(255) DEFAULT NULL,
  `y_city` varchar(255) DEFAULT NULL,
  `y_state` varchar(255) DEFAULT NULL,
  `y_zip` varchar(255) DEFAULT NULL,
  `y_phone` varchar(255) DEFAULT NULL,
  `y_fax` varchar(255) DEFAULT NULL,
  `y_email` varchar(255) DEFAULT NULL,
  `y_url` varchar(255) DEFAULT NULL,
  `y_template` text,
  `p_accept_payments` tinyint(1) unsigned DEFAULT '0',
  `p_accept_paypal` tinyint(1) unsigned DEFAULT '0',
  `p_accept_authorize` tinyint(1) unsigned DEFAULT '0',
  `p_accept_creditcard` tinyint(1) unsigned DEFAULT '0',
  `p_accept_bank` tinyint(1) unsigned DEFAULT '0',
  `p_paypal_address` varchar(255) DEFAULT NULL,
  `p_authorize_tz` varchar(255) DEFAULT NULL,
  `p_authorize_key` varchar(255) DEFAULT NULL,
  `p_authorize_mid` varchar(255) DEFAULT NULL,
  `p_authorize_hash` varchar(255) DEFAULT NULL,
  `p_bank_account` tinytext,
  `si_include` tinyint(1) unsigned DEFAULT '0',
  `si_shipping_address` tinyint(1) unsigned DEFAULT '0',
  `si_company` tinyint(1) unsigned DEFAULT '0',
  `si_name` tinyint(1) unsigned DEFAULT '0',
  `si_address` tinyint(1) unsigned DEFAULT '0',
  `si_street_address` tinyint(1) unsigned DEFAULT '0',
  `si_city` tinyint(1) unsigned DEFAULT '0',
  `si_state` tinyint(1) unsigned DEFAULT '0',
  `si_zip` tinyint(1) unsigned DEFAULT '0',
  `si_phone` tinyint(1) unsigned DEFAULT '0',
  `si_fax` tinyint(1) unsigned DEFAULT '0',
  `si_email` tinyint(1) unsigned DEFAULT '0',
  `si_url` tinyint(1) unsigned DEFAULT '0',
  `si_date` tinyint(1) unsigned DEFAULT '0',
  `si_terms` tinyint(1) unsigned DEFAULT '0',
  `si_is_shipped` tinyint(1) unsigned DEFAULT '0',
  `si_shipping` tinyint(1) unsigned DEFAULT '0',
  `o_booking_url` varchar(255) DEFAULT NULL,
  `o_qty_is_int` tinyint(1) unsigned DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `plugin_invoice_config` (`id`, `y_logo`, `y_company`, `y_name`, `y_street_address`, `y_city`, `y_state`, `y_zip`, `y_phone`, `y_fax`, `y_email`, `y_url`, `y_template`, `p_accept_payments`, `p_accept_paypal`, `p_accept_authorize`, `p_accept_creditcard`, `p_accept_bank`, `p_paypal_address`, `p_authorize_tz`, `p_authorize_key`, `p_authorize_mid`, `p_authorize_hash`, `p_bank_account`, `si_include`, `si_shipping_address`, `si_company`, `si_name`, `si_address`, `si_street_address`, `si_city`, `si_state`, `si_zip`, `si_phone`, `si_fax`, `si_email`, `si_url`, `si_date`, `si_terms`, `si_is_shipped`, `si_shipping`, `o_booking_url`, `o_qty_is_int`) VALUES
(1, NULL, 'New York Knicks', 'John Smith', 'Madison Square', 'New York City', 'NY', '11222', '(111) 222 3333', '(222) 333 4444', 'info@domain.com', 'http://www.google.com/', '<table style="width: 100%;" border="0">\r\n<tbody>\r\n<tr>\r\n<td style="width: 50%;"><strong>{y_company}</strong></td>\r\n<td><strong>Invoice no.</strong> {uuid}</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td><strong>Date</strong> {issue_date}</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<table style="width: 85%;" border="0" align="center">\r\n<tbody>\r\n<tr>\r\n<td style="border-bottom-style: solid; border-bottom-width: 1px;"><strong>Bill To:</strong></td>\r\n</tr>\r\n<tr>\r\n<td><strong>{b_name}</strong></td>\r\n</tr>\r\n<tr>\r\n<td><strong>{b_company}</strong></td>\r\n</tr>\r\n<tr>\r\n<td>{b_billing_address}</td>\r\n</tr>\r\n<tr>\r\n<td>{b_city}</td>\r\n</tr>\r\n<tr>\r\n<td>{b_state} {b_zip}</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>Phone: {b_phone}, Fax: {b_fax}</td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<p style="text-align: center;"><span style="font-size: large;"><strong>Invoice</strong></span></p>\r\n<p>{items}</p>\r\n<p>&nbsp;</p>\r\n<table style="width: 100%;" border="0">\r\n<tbody>\r\n<tr>\r\n<td>Note:</td>\r\n<td style="text-align: right;">SubTotal:</td>\r\n<td style="text-align: right;">{subtotal}</td>\r\n</tr>\r\n<tr>\r\n<td>Thanks for your business!</td>\r\n<td style="text-align: right;">Discount:</td>\r\n<td style="text-align: right;">{discount}</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td style="text-align: right;"><strong>Total:</strong></td>\r\n<td style="text-align: right;"><strong>{total}</strong></td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td style="text-align: right;">Deposit:</td>\r\n<td style="text-align: right;">{paid_deposit}</td>\r\n</tr>\r\n<tr>\r\n<td>&nbsp;</td>\r\n<td style="text-align: right;"><strong>Amount Due:</strong></td>\r\n<td style="text-align: right;"><strong>{amount_due}</strong></td>\r\n</tr>\r\n</tbody>\r\n</table>\r\n<p>&nbsp;</p>\r\n<table style="width: 100%; border-collapse: collapse;" border="0">\r\n<tbody>\r\n<tr>\r\n<td style="border-bottom-style: solid; border-bottom-width: 1px;"><strong>{y_company}</strong></td>\r\n<td style="border-bottom-style: solid; border-bottom-width: 1px;">&nbsp;</td>\r\n</tr>\r\n<tr>\r\n<td>{y_street_address}</td>\r\n<td>Phone: {y_phone}</td>\r\n</tr>\r\n<tr>\r\n<td>{y_city}</td>\r\n<td>Email: {y_email}</td>\r\n</tr>\r\n<tr>\r\n<td style="border-bottom-style: solid; border-bottom-width: 1px;">{y_state} {y_zip}</td>\r\n<td style="border-bottom-style: solid; border-bottom-width: 1px;">Website: {y_url}</td>\r\n</tr>\r\n</tbody>\r\n</table>', 1, 1, 0, 1, 1, 'info@domain.com', '0', NULL, NULL, NULL, 'bank account information goes here', 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 'index.php?controller=pjAdminReservations&action=pjActionUpdate&uuid={ORDER_ID}', 0);

DROP TABLE IF EXISTS `plugin_invoice_items`;
CREATE TABLE IF NOT EXISTS `plugin_invoice_items` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `invoice_id` int(10) unsigned DEFAULT NULL,
  `tmp` varchar(255) DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` tinytext,
  `qty` decimal(9,2) unsigned DEFAULT NULL,
  `unit_price` decimal(9,2) unsigned DEFAULT NULL,
  `amount` decimal(9,2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_menu_invoices', 'backend', 'Invoice plugin / Menu Invoices', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoices', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoices', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoices', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_config', 'backend', 'Invoice plugin / Invoice config', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice Config', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice Config', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice Config', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_logo', 'backend', 'Invoice plugin / Company logo', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Company logo', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Company logo', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Company logo', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_company', 'backend', 'Invoice plugin / Company name', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Company name', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Company name', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Company name', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_name', 'backend', 'Invoice plugin / Name', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Name', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Name', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Name', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_street_address', 'backend', 'Invoice plugin / Street address', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Street address', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Street address', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Street address', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_city', 'backend', 'Invoice plugin / City', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'City', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'City', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'City', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_state', 'backend', 'Invoice plugin / State', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'State', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'State', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'State', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_zip', 'backend', 'Invoice plugin / Zip', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Zip', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Zip', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Zip', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_phone', 'backend', 'Invoice plugin / Phone', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Phone', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Phone', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Phone', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_fax', 'backend', 'Invoice plugin / Fax', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Fax', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Fax', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Fax', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_email', 'backend', 'Invoice plugin / Email', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Email', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Email', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Email', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_url', 'backend', 'Invoice plugin / Website', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Website', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Website', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Website', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN01', 'arrays', 'Invoice plugin / Info title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN01', 'arrays', 'Invoice plugin / Info body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'In order to configure the invoices module you need to fill in your company details. To view all invoices <a href="index.php?controller=pjInvoice&action=pjActionInvoices">click here</a>', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'In order to configure the invoices module you need to fill in your company details. To view all invoices <a href="index.php?controller=pjInvoice&action=pjActionInvoices">click here</a>', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'In order to configure the invoices module you need to fill in your company details. To view all invoices <a href="index.php?controller=pjInvoice&action=pjActionInvoices">click here</a>', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN02', 'arrays', 'Invoice plugin / Invoice config updated title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice config updated!', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice config updated!', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice config updated!', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN02', 'arrays', 'Invoice plugin / Info body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice config data has been properly updated.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice config data has been properly updated.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice config data has been properly updated.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN03', 'arrays', 'Invoice plugin / Upload failed', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Upload failed', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Upload failed', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Upload failed', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_template', 'backend', 'Invoice plugin / Invoice Template', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice Template', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice Template', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice Template', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_delete_logo_title', 'backend', 'Invoice plugin / Delete logo title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Delete confirmation', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Delete confirmation', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Delete confirmation', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_delete_logo_body', 'backend', 'Invoice plugin / Delete logo body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Are you sure you want to delete selected logo?', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Are you sure you want to delete selected logo?', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Are you sure you want to delete selected logo?', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_billing_info', 'backend', 'Invoice plugin / Billing information', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Billing information', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Billing information', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Billing information', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_shipping_info', 'backend', 'Invoice plugin / Shipping information', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Shipping information', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Shipping information', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Shipping information', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_company_info', 'backend', 'Invoice plugin / Company information', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Company information', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Company information', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Company information', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_payment_info', 'backend', 'Invoice plugin / Payment information', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Payment information', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Payment information', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Payment information', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_address', 'backend', 'Invoice plugin / Address', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Address', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Address', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Address', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_billing_address', 'backend', 'Invoice plugin / Billing address', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Billing address', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Billing address', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Billing address', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_general_info', 'backend', 'Invoice plugin / General information', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'General information', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'General information', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'General information', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_uuid', 'backend', 'Invoice plugin / Invoice no.', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice no.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice no.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice no.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_order_id', 'backend', 'Invoice plugin / Order no.', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Order no.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Order no.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Order no.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_issue_date', 'backend', 'Invoice plugin / Issue date', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Issue date', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Issue date', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Issue date', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_due_date', 'backend', 'Invoice plugin / Due date', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Due date', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Due date', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Due date', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_shipping_date', 'backend', 'Invoice plugin / Shipping date', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Shipping date', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Shipping date', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Shipping date', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_shipping_terms', 'backend', 'Invoice plugin / Shipping terms', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Shipping terms', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Shipping terms', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Shipping terms', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_subtotal', 'backend', 'Invoice plugin / Subtotal', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Subtotal', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Subtotal', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Subtotal', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_discount', 'backend', 'Invoice plugin / Discount', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Discount', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Discount', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Discount', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_tax', 'backend', 'Invoice plugin / Tax', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Tax', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Tax', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Tax', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_shipping', 'backend', 'Invoice plugin / Tax', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Shipping', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Shipping', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Shipping', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_total', 'backend', 'Invoice plugin / Total', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Total', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Total', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Total', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_paid_deposit', 'backend', 'Invoice plugin / Paid deposit', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Paid deposit', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Paid deposit', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Paid deposit', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_amount_due', 'backend', 'Invoice plugin / Amount due', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Amount due', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Amount due', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Amount due', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_currency', 'backend', 'Invoice plugin / Currency', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Currency', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Currency', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Currency', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_notes', 'backend', 'Invoice plugin / Notes', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Notes', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Notes', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Notes', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_shipping_address', 'backend', 'Invoice plugin / Shipping address', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Shipping address', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Shipping address', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Shipping address', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_created', 'backend', 'Invoice plugin / Created', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Created', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Created', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Created', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_modified', 'backend', 'Invoice plugin / Modified', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Modified', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Modified', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Modified', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_item', 'backend', 'Invoice plugin / Item', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Item', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Item', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Item', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_qty', 'backend', 'Invoice plugin / Qty', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Qty', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Qty', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Qty', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_unit', 'backend', 'Invoice plugin / Unit price', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Unit price', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Unit price', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Unit price', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_amount', 'backend', 'Invoice plugin / Amount', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Amount', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Amount', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Amount', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_add_item_title', 'backend', 'Invoice plugin / Add item title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Add item', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Add item', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Add item', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_edit_item_title', 'backend', 'Invoice plugin / Update item title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Update item', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Update item', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Update item', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_description', 'backend', 'Invoice plugin / Description', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Description', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Description', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Description', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_accept_payments', 'backend', 'Invoice plugin / Accept payments', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Accept payments', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Accept payments', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Accept payments', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_print', 'backend', 'Invoice plugin / Print invoice', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'PRINT', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'PRINT', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'PRINT', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_send', 'backend', 'Invoice plugin / Send invoice', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'EMAIL', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'EMAIL', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'EMAIL', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_view', 'backend', 'Invoice plugin / View invoice', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'VIEW', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'VIEW', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'VIEW', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_send_invoice_title', 'backend', 'Invoice plugin / Send invoice dialog title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Send invoice', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Send invoice', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Send invoice', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_send_subject', 'backend', 'Invoice plugin / Send invoice subject', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_items_info', 'backend', 'Invoice plugin / Items information', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Items information', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Items information', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Items information', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_accept_paypal', 'backend', 'Invoice plugin / Accept payments with PayPal', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Accept payments with PayPal', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Accept payments with PayPal', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Accept payments with PayPal', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_accept_authorize', 'backend', 'Invoice plugin / Accept payments with Authorize.NET', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Accept payments with Authorize.NET', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Accept payments with Authorize.NET', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Accept payments with Authorize.NET', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_accept_creditcard', 'backend', 'Invoice plugin / Accept payments with Credit Card', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Accept payments with Credit Card', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Accept payments with Credit Card', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Accept payments with Credit Card', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_accept_bank', 'backend', 'Invoice plugin / Accept payments with Bank Account', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Accept payments with Bank Account', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Accept payments with Bank Account', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Accept payments with Bank Account', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_include', 'backend', 'Invoice plugin / Include Shipping information', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Shipping information', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Shipping information', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Shipping information', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_shipping_address', 'backend', 'Invoice plugin / Include Shipping address', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Shipping address', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Shipping address', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Shipping address', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_company', 'backend', 'Invoice plugin / Include Company', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Company', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Company', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Company', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_name', 'backend', 'Invoice plugin / Include Name', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Name', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Name', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Name', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_address', 'backend', 'Invoice plugin / Include Address', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Address', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Address', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Address', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_city', 'backend', 'Invoice plugin / Include City', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include City', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include City', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include City', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_state', 'backend', 'Invoice plugin / Include State', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include State', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include State', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include State', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_zip', 'backend', 'Invoice plugin / Include Zip', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Zip', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Zip', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Zip', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_phone', 'backend', 'Invoice plugin / Include Phone', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Phone', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Phone', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Phone', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_fax', 'backend', 'Invoice plugin / Include Fax', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Fax', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Fax', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Fax', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_email', 'backend', 'Invoice plugin / Include Email', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Email', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Email', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Email', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_url', 'backend', 'Invoice plugin / Include Website', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Website', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Website', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Website', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_street_address', 'backend', 'Invoice plugin / Include Street address', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Street address', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Street address', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Street address', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN05', 'arrays', 'Invoice plugin / Invoice updated title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice updated!', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice updated!', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice updated!', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN05', 'arrays', 'Invoice plugin / Invoice updated body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice has been updated.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice has been updated.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice has been updated.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN04', 'arrays', 'Invoice plugin / Invoice Not Found title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice Not Found', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice Not Found', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice Not Found', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN04', 'arrays', 'Invoice plugin / Invoice Not Found body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice with such ID was not found.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice with such ID was not found.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice with such ID was not found.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN06', 'arrays', 'Invoice plugin / Invalid data title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Update failed', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Update failed', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Update failed', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN06', 'arrays', 'Invoice plugin / Invalid data body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Some of the data is not valid.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Some of the data is not valid.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Some of the data is not valid.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_status', 'backend', 'Invoice plugin / Status', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Status', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Status', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Status', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_pay_with_paypal', 'backend', 'Invoice plugin / Pay with Paypal', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Pay with Paypal', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Pay with Paypal', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Pay with Paypal', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_pay_with_authorize', 'backend', 'Invoice plugin / Pay with Authorize.Net', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Pay with Authorize.Net', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Pay with Authorize.Net', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Pay with Authorize.Net', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_pay_with_creditcard', 'backend', 'Invoice plugin / Pay with Credit Card', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Pay with Credit Card', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Pay with Credit Card', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Pay with Credit Card', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_pay_with_bank', 'backend', 'Invoice plugin / Pay with Bank Account', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Pay with Bank Account', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Pay with Bank Account', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Pay with Bank Account', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_pay_now', 'backend', 'Invoice plugin / Pay Now', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Pay Now', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Pay Now', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Pay Now', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_paypal_title', 'frontend', 'Invoice plugin / Paypal title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice module', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice module', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice module', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_authorize_title', 'frontend', 'Invoice plugin / Payment Authorize title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice module', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice module', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice module', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_paypal_address', 'backend', 'Invoice plugin / Paypal address', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Paypal address', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Paypal address', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Paypal address', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_authorize_tz', 'backend', 'Invoice plugin / Authorize.Net Timezone', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Authorize.Net Timezone', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Authorize.Net Timezone', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Authorize.Net Timezone', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_authorize_mid', 'backend', 'Invoice plugin / Authorize.Net Merchant ID', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Authorize.Net Merchant ID', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Authorize.Net Merchant ID', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Authorize.Net Merchant ID', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_authorize_key', 'backend', 'Invoice plugin / Authorize.Net Transaction Key', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Authorize.Net Transaction Key', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Authorize.Net Transaction Key', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Authorize.Net Transaction Key', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_bank_account', 'backend', 'Invoice plugin / Bank Account', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Bank Account', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Bank Account', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Bank Account', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_paypal_redirect', 'backend', 'Invoice plugin / Paypal redirect', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'You will be redirected to Paypal in 3 seconds. If not please click on the button.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'You will be redirected to Paypal in 3 seconds. If not please click on the button.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'You will be redirected to Paypal in 3 seconds. If not please click on the button.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_authorize_redirect', 'backend', 'Invoice plugin / Authorize.Net redirect', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'You will be redirected to Authorize.net in 3 seconds. If not please click on the button.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'You will be redirected to Authorize.net in 3 seconds. If not please click on the button.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'You will be redirected to Authorize.net in 3 seconds. If not please click on the button.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_paypal_proceed', 'backend', 'Invoice plugin / Paypal proceed button', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Proceed with payment', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Proceed with payment', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Proceed with payment', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_authorize_proceed', 'backend', 'Invoice plugin / Authorize.Net proceed button', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Proceed with payment', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Proceed with payment', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Proceed with payment', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_delete_title', 'backend', 'Invoice plugin / Delete title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Delete selected', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Delete selected', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Delete selected', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_delete_body', 'backend', 'Invoice plugin / Delete body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Are you sure you want to delete selected invoices?', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Are you sure you want to delete selected invoices?', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Are you sure you want to delete selected invoices?', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_is_shipped', 'backend', 'Invoice plugin / Is shipped', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Is shipped', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Is shipped', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Is shipped', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_date', 'backend', 'Invoice plugin / Include Shipping date', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Shipping date', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Shipping date', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Shipping date', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_terms', 'backend', 'Invoice plugin / Include Shipping terms', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Shipping terms', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Shipping terms', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Shipping terms', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_is_shipped', 'backend', 'Invoice plugin / Include Is Shipped', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Is Shipped', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Is Shipped', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Is Shipped', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_statuses_ARRAY_not_paid', 'arrays', 'Invoice plugin / Status: Not Paid', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'NOT PAID', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'NOT PAID', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'NOT PAID', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_statuses_ARRAY_paid', 'arrays', 'Invoice plugin / Status: Paid', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'PAID', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'PAID', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'PAID', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_statuses_ARRAY_cancelled', 'arrays', 'Invoice plugin / Status: Cancelled', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'CANCELLED', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'CANCELLED', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'CANCELLED', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_num', 'backend', 'Invoice plugin / No.', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'No.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'No.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'No.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_add', 'backend', 'Invoice plugin / Add', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'ADD +', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'ADD +', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'ADD +', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_save', 'backend', 'Invoice plugin / Save', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'SAVE', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'SAVE', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'SAVE', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_booking_url', 'backend', 'Invoice plugin / Booking URL - Token: {ORDER_ID}', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Booking URL - Token: {ORDER_ID}', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Booking URL - Token: {ORDER_ID}', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Booking URL - Token: {ORDER_ID}', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_s_shipping', 'backend', 'Invoice plugin / Include Shipping', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Include Shipping', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Include Shipping', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Include Shipping', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN07', 'arrays', 'Invoice plugin / Invoice added title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice added!', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice added!', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice added!', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN07', 'arrays', 'Invoice plugin / Invoice added body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice has been added.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice has been added.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice has been added.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN08', 'arrays', 'Invoice plugin / Invoice failed to add title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice has not been added.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice has not been added.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice has not been added.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN08', 'arrays', 'Invoice plugin / Invoice failed to add body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice failed to add!', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice failed to add!', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice failed to add!', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN09', 'arrays', 'Invoice plugin / Invoice Send title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Notice', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Notice', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Notice', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN09', 'arrays', 'Invoice plugin / Invoice send body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Check the email address(es) where invoice should be sent.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Check the email address(es) where invoice should be sent.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Check the email address(es) where invoice should be sent.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN10', 'arrays', 'Invoice plugin / Invoice heading title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Invoice details', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Invoice details', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Invoice details', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN10', 'arrays', 'Invoice plugin / Invoice heading body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Fill in invoice details and use the buttons below to view, print or email the invoice.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Fill in invoice details and use the buttons below to view, print or email the invoice.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Fill in invoice details and use the buttons below to view, print or email the invoice.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_titles_ARRAY_PIN11', 'arrays', 'Invoice plugin / Invoice billing title', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Billing details', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Billing details', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Billing details', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'error_bodies_ARRAY_PIN11', 'arrays', 'Invoice plugin / Invoice billing body', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Under "Billing information" you can edit your customer billing details. Under "Company information" is your company billing information which will be used for the invoice.', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Under "Billing information" you can edit your customer billing details. Under "Company information" is your company billing information which will be used for the invoice.', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Under "Billing information" you can edit your customer billing details. Under "Company information" is your company billing information which will be used for the invoice.', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_qty_is_int', 'backend', 'Invoice plugin / Quantity format', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Quantity format', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Quantity format', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Quantity format', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_qty_int', 'backend', 'Invoice plugin / Quantity INT instead of FLOAT', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Format as INT instead of FLOAT', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Format as INT instead of FLOAT', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Format as INT instead of FLOAT', 'plugin');

INSERT INTO `fields` (`id`, `key`, `type`, `label`, `source`, `modified`) VALUES
(NULL, 'plugin_invoice_i_authorize_hash', 'backend', 'Invoice plugin / Authorize.Net hash value', 'plugin', NULL);

SET @id := (SELECT LAST_INSERT_ID());

INSERT INTO `multi_lang` (`id`, `foreign_id`, `model`, `locale`, `field`, `content`, `source`) VALUES
(NULL, @id, 'pjField', 1, 'title', 'Authorize.Net hash value', 'plugin'),
(NULL, @id, 'pjField', 2, 'title', 'Authorize.Net hash value', 'plugin'),
(NULL, @id, 'pjField', 3, 'title', 'Authorize.Net hash value', 'plugin');