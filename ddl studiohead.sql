CREATE DATABASE studiohead;
USE studiohead;

CREATE TABLE roles (
    id_role INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(50) NOT NULL,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL
);

CREATE TABLE users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    id_role INT NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    profile_picture VARCHAR(255),
    status ENUM('active','inactive') DEFAULT 'active',
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    CONSTRAINT fk_users_roles
    FOREIGN KEY (id_role)
    REFERENCES roles(id_role)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE membership_tiers (
    id_tier INT AUTO_INCREMENT PRIMARY KEY,
    tier_name VARCHAR(50) NOT NULL,
    min_transaction DECIMAL(12,2) DEFAULT 0,
    discount_percent INT DEFAULT 0,
    priority_level INT DEFAULT 1,
    bonus_hour INT DEFAULT 0,
    status ENUM('active','inactive') DEFAULT 'active',
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL
);

CREATE TABLE user_memberships (
    id_membership INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    id_tier INT NOT NULL,
    total_transaction DECIMAL(12,2) DEFAULT 0,
    total_booking_hours INT DEFAULT 0,
    joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    CONSTRAINT fk_membership_user
    FOREIGN KEY (id_user)
    REFERENCES users(id_user)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    CONSTRAINT fk_membership_tier
    FOREIGN KEY (id_tier)
    REFERENCES membership_tiers(id_tier)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE studios (
    id_studio INT AUTO_INCREMENT PRIMARY KEY,
    studio_name VARCHAR(100) NOT NULL,
    category VARCHAR(100),
    description TEXT,
    price_per_hour DECIMAL(12,2) NOT NULL,
    capacity INT DEFAULT 1,
    thumbnail VARCHAR(255),
    status VARCHAR (30),
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL
);

CREATE TABLE studio_facilities (
    id_facility INT AUTO_INCREMENT PRIMARY KEY,
    id_studio INT NOT NULL,
    facility_name VARCHAR(100) NOT NULL,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    CONSTRAINT fk_facility_studio
    FOREIGN KEY (id_studio)
    REFERENCES studios(id_studio)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE packages (
    id_package INT AUTO_INCREMENT PRIMARY KEY,
    package_name VARCHAR(100) NOT NULL,
    description TEXT,
    duration_hour INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    thumbnail VARCHAR(255),
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL
);

CREATE TABLE package_items (
    id_package_item INT AUTO_INCREMENT PRIMARY KEY,
    id_package INT NOT NULL,
    item_name VARCHAR(100) NOT NULL,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    CONSTRAINT fk_package_items
    FOREIGN KEY (id_package)
    REFERENCES packages(id_package)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE addons (
    id_addon INT AUTO_INCREMENT PRIMARY KEY,
    addon_name VARCHAR(100) NOT NULL,
    description TEXT,
    stock INT DEFAULT 0,
    price DECIMAL(12,2) NOT NULL,
    thumbnail VARCHAR(255),
    status ENUM('active','inactive') DEFAULT 'active',
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL
);

CREATE TABLE bookings (
    id_booking INT AUTO_INCREMENT PRIMARY KEY,
    booking_code VARCHAR(50) NOT NULL UNIQUE,
    id_user INT NOT NULL,
    id_studio INT NOT NULL,
    id_package INT NULL,
    booking_date DATE NOT NULL,
    start_time TIME NOT NULL,
    end_time TIME NOT NULL,
    duration_hour INT NOT NULL,
    subtotal DECIMAL(12,2) DEFAULT 0,
    discount DECIMAL(12,2) DEFAULT 0,
    total_price DECIMAL(12,2) DEFAULT 0,
    notes TEXT,
    booking_status ENUM(
        'pending',
        'waiting_approval',
        'approved',
        'ongoing',
        'completed',
        'cancelled'
    ) DEFAULT 'pending',
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    CONSTRAINT fk_booking_user
    FOREIGN KEY (id_user)
    REFERENCES users(id_user)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    CONSTRAINT fk_booking_studio
    FOREIGN KEY (id_studio)
    REFERENCES studios(id_studio)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    CONSTRAINT fk_booking_package
    FOREIGN KEY (id_package)
    REFERENCES packages(id_package)
    ON UPDATE CASCADE
    ON DELETE SET NULL
);

CREATE TABLE booking_addons (
    id_booking_addon INT AUTO_INCREMENT PRIMARY KEY,
    id_booking INT NOT NULL,
    id_addon INT NOT NULL,
    qty INT DEFAULT 1,
    price DECIMAL(12,2) DEFAULT 0,
    subtotal DECIMAL(12,2) DEFAULT 0,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    CONSTRAINT fk_booking_addon_booking
    FOREIGN KEY (id_booking)
    REFERENCES bookings(id_booking)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    CONSTRAINT fk_booking_addon_addon
    FOREIGN KEY (id_addon)
    REFERENCES addons(id_addon)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE payments (
    id_payment INT AUTO_INCREMENT PRIMARY KEY,
    id_booking INT NOT NULL,
    verified_by INT NULL,
    payment_method VARCHAR(50),
    transfer_proof VARCHAR(255),
    amount DECIMAL(12,2) NOT NULL,
    payment_status ENUM(
        'unpaid',
        'waiting',
        'paid',
        'rejected'
    ) DEFAULT 'unpaid',
    payment_date DATETIME NULL,
    verified_at DATETIME NULL,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    CONSTRAINT fk_payment_booking
    FOREIGN KEY (id_booking)
    REFERENCES bookings(id_booking)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);

CREATE TABLE reviews (
    id_review INT AUTO_INCREMENT PRIMARY KEY,
    id_booking INT NOT NULL,
    id_user INT NOT NULL,
    id_studio INT NOT NULL,
    rating INT NOT NULL,
    review_text TEXT,
    review_status ENUM(
        'show',
        'hidden'
    ) DEFAULT 'show',
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    CONSTRAINT fk_review_booking
    FOREIGN KEY (id_booking)
    REFERENCES bookings(id_booking)
    ON UPDATE CASCADE
    ON DELETE CASCADE,
    CONSTRAINT fk_review_user
    FOREIGN KEY (id_user)
    REFERENCES users(id_user)
    ON UPDATE CASCADE
    ON DELETE RESTRICT,
    CONSTRAINT fk_review_studio
    FOREIGN KEY (id_studio)
    REFERENCES studios(id_studio)
    ON UPDATE CASCADE
    ON DELETE RESTRICT
);

CREATE TABLE booking_logs (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    id_booking INT NOT NULL,
    changed_by INT NOT NULL,
    status_from VARCHAR(50),
    status_to VARCHAR(50),
    changed_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    created_by INT NULL,
    updated_date DATETIME DEFAULT CURRENT_TIMESTAMP
    ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT NULL,
    CONSTRAINT fk_logs_booking
    FOREIGN KEY (id_booking)
    REFERENCES bookings(id_booking)
    ON UPDATE CASCADE
    ON DELETE CASCADE
);