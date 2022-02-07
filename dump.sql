-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`dia_horarios`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`dia_horarios` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dataHora` TIMESTAMP NOT NULL,
  `reservado` TINYINT(1) NOT NULL DEFAULT '0',
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`users`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`users` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `telefone` VARCHAR(255) NOT NULL,
  `email_verified_at` TIMESTAMP NULL DEFAULT NULL,
  `senha` VARCHAR(255) NOT NULL,
  `role` ENUM('cliente', 'admin') NOT NULL DEFAULT 'cliente',
  `remember_token` VARCHAR(100) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `users_email_unique` (`email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`enderecos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`enderecos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `logradouro` VARCHAR(255) NOT NULL,
  `numero` VARCHAR(255) NULL DEFAULT 's/n',
  `bairro` VARCHAR(255) NOT NULL,
  `principal` TINYINT(1) NOT NULL DEFAULT '0',
  `user_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `enderecos_user_id_foreign` (`user_id` ASC) VISIBLE,
  CONSTRAINT `enderecos_user_id_foreign`
    FOREIGN KEY (`user_id`)
    REFERENCES `u225134551_restaurante`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`failed_jobs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`failed_jobs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `uuid` VARCHAR(255) NOT NULL,
  `connection` TEXT NOT NULL,
  `queue` TEXT NOT NULL,
  `payload` LONGTEXT NOT NULL,
  `exception` LONGTEXT NOT NULL,
  `failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `failed_jobs_uuid_unique` (`uuid` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`items` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `nome` VARCHAR(255) NOT NULL,
  `preco` DECIMAL(6,2) NOT NULL,
  `image` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`pedidos` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `finalizado` TINYINT(1) NOT NULL DEFAULT '0',
  `user_id` INT UNSIGNED NOT NULL,
  `endereco_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `pedidos_user_id_foreign` (`user_id` ASC) VISIBLE,
  INDEX `pedidos_endereco_id_foreign` (`endereco_id` ASC) VISIBLE,
  CONSTRAINT `pedidos_endereco_id_foreign`
    FOREIGN KEY (`endereco_id`)
    REFERENCES `u225134551_restaurante`.`enderecos` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `pedidos_user_id_foreign`
    FOREIGN KEY (`user_id`)
    REFERENCES `u225134551_restaurante`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`item_pedido`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`item_pedido` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `pedido_id` INT UNSIGNED NOT NULL,
  `item_id` INT UNSIGNED NOT NULL,
  `quant` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `item_pedido_pedido_id_foreign` (`pedido_id` ASC) VISIBLE,
  INDEX `item_pedido_item_id_foreign` (`item_id` ASC) VISIBLE,
  CONSTRAINT `item_pedido_item_id_foreign`
    FOREIGN KEY (`item_id`)
    REFERENCES `u225134551_restaurante`.`items` (`id`)
    ON DELETE CASCADE,
  CONSTRAINT `item_pedido_pedido_id_foreign`
    FOREIGN KEY (`pedido_id`)
    REFERENCES `u225134551_restaurante`.`pedidos` (`id`)
    ON DELETE CASCADE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`migrations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
AUTO_INCREMENT = 11
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`password_resets`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`password_resets` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  INDEX `password_resets_email_index` (`email` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`personal_access_tokens`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` VARCHAR(255) NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT NULL DEFAULT NULL,
  `last_used_at` TIMESTAMP NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `personal_access_tokens_token_unique` (`token` ASC) VISIBLE,
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type` ASC, `tokenable_id` ASC) VISIBLE)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;


-- -----------------------------------------------------
-- Table `u225134551_restaurante`.`reservas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `u225134551_restaurante`.`reservas` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `dataHora` TIMESTAMP NOT NULL,
  `convidados` INT UNSIGNED NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `reservas_user_id_foreign` (`user_id` ASC) VISIBLE,
  CONSTRAINT `reservas_user_id_foreign`
    FOREIGN KEY (`user_id`)
    REFERENCES `u225134551_restaurante`.`users` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4
COLLATE = utf8mb4_unicode_ci;
