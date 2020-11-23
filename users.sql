
CREATE TABLE IF NOT EXISTS  `users` (
    `id` INT( 7 ) NOT NULL AUTO_INCREMENT ,
    `name` VARCHAR( 250 ) NOT NULL ,
    `file_ext` VARCHAR( 10 ) NOT NULL ,
    `email` VARCHAR( 150 ) NOT NULL ,
    `password` VARCHAR( 150 ) NOT NULL ,
    `hash` varchar(50) DEFAULT NULL,
    `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
    PRIMARY KEY (  `id` ) ,
    UNIQUE KEY  `email` (  `email` ) ,
    KEY  `hash` (  `hash` ) ,
    KEY  `login` (  `email` ,  `password` )
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
