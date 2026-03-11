CREATE DATABASE IF NOT EXISTS thigazh_db;
USE thigazh_db;

CREATE TABLE IF NOT EXISTS registrations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    team_name VARCHAR(100) NOT NULL,
    leader_name VARCHAR(100) NOT NULL,
    member2 VARCHAR(100) DEFAULT NULL,
    member2_phone VARCHAR(20) DEFAULT NULL,
    member3 VARCHAR(100) DEFAULT NULL,
    member4 VARCHAR(100) DEFAULT NULL,
    college VARCHAR(255) NOT NULL,
    department VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    email VARCHAR(100) NOT NULL,
    pass_type VARCHAR(20) NOT NULL,
    selected_events JSON NOT NULL,
    amount INT NOT NULL DEFAULT 0,
    payment_status VARCHAR(20) DEFAULT 'Pending',
    transaction_id VARCHAR(100) DEFAULT NULL,
    screenshot_path VARCHAR(255) DEFAULT NULL,
    is_verified TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS otp_verifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    registration_id INT NOT NULL,
    otp_code VARCHAR(6) NOT NULL,
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (registration_id) REFERENCES registrations(id) ON DELETE CASCADE
);




