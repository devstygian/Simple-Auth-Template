CREATE DATABASE IF NOT EXISTS simple_auth;

USE simple_auth;

CREATE TABLE IF NOT EXISTS users (
    id          INT(11) AUTO_INCREMENT PRIMARY KEY,
    username    VARCHAR(100) NOT NULL,
    email       VARCHAR(150) NOT NULL UNIQUE,
    password    VARCHAR(255) NOT NULL,
    provider    VARCHAR(50) NOT NULL DEFAULT 'local',
    provider_id VARCHAR(255) DEFAULT NULL,
    created_at  TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY uniq_provider_account (provider, provider_id)
);
