CREATE TABLE `system_queue` (
  `queue_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `function` varchar(255) DEFAULT NULL,
  `run_date` timestamp NULL DEFAULT NULL,
  `status` enum('pending','in-process','process') DEFAULT NULL,
  PRIMARY KEY (`queue_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;