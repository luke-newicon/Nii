CREATE  TABLE IF NOT EXISTS `project_manager`.`notes` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `user_id` INT UNSIGNED NULL ,
  `added` DATE NULL ,
  `area` VARCHAR(50) NULL ,
  `item_id` INT NULL ,
  `note` VARCHAR(45) NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `noteId` (`item_id` ASC) )
ENGINE = InnoDB