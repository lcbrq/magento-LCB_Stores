<?php

$installer = $this;
$installer->startSetup();
$sql = <<<SQLTEXT
        
DROP TABLE IF EXISTS `{$this->getTable('lcb_stores')}`;
CREATE TABLE `{$this->getTable('lcb_stores')}` (
  `id` smallint(6) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `x` float NULL,
  `y` float NULL,
  `address` text NULL,
  `photo` varchar(255) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

		
SQLTEXT;

$installer->run($sql);
$installer->endSetup();
