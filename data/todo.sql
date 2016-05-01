-- -----------------------------------------------------
-- Table `tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tags` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(128) NOT NULL,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `tasks`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tasks` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `notes` TEXT NULL,
  `created_at` TIMESTAMP NULL,
  `is_finished` TINYINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`))
  ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `tasks_tags`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `tasks_tags` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tag_id` INT UNSIGNED NOT NULL,
  `task_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_tasks_tags_tags_idx` (`tag_id` ASC),
  INDEX `fk_tasks_tags_tasks1_idx` (`task_id` ASC),
  CONSTRAINT `fk_tasks_tags_tags`
  FOREIGN KEY (`tag_id`)
  REFERENCES `tags` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION,
  CONSTRAINT `fk_tasks_tags_tasks1`
  FOREIGN KEY (`task_id`)
  REFERENCES `tasks` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION)
  ENGINE = InnoDB;
