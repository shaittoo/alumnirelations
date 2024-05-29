CREATE TABLE academic_organizations (
    org_id INT AUTO_INCREMENT PRIMARY KEY,
    organization_name VARCHAR(255) NOT NULL UNIQUE
);
CREATE TABLE degree_programs (
    program_id INT AUTO_INCREMENT PRIMARY KEY,
    degree_program VARCHAR(255) NOT NULL UNIQUE,
    academic_organization_id INT,
    FOREIGN KEY (academic_organization_id) REFERENCES academic_organizations(org_id) ON DELETE
    SET NULL
);
CREATE TABLE users (
    user_id int(11) NOT NULL,
    first_name varchar(255) NOT NULL,
    last_name varchar(255) NOT NULL,
    address varchar(255) DEFAULT NULL,
    contact_number varchar(20) DEFAULT NULL,
    email varchar(255) NOT NULL,
    occupation varchar(255) DEFAULT NULL,
    graduating_year year(4) DEFAULT NULL,
    degree_program_id int(11) DEFAULT NULL,
    academic_organization_id int(11) DEFAULT NULL,
    bio text DEFAULT NULL,
    password varchar(255) NOT NULL,
    user_type varchar(255) DEFAULT NULL,
    cpassword varchar(255) NOT NULL,
    FOREIGN KEY (degree_program_id) REFERENCES degree_programs(program_id) ON DELETE
    SET NULL,
        FOREIGN KEY (academic_organization_id) REFERENCES academic_organizations(org_id) ON DELETE
    SET NULL
);
CREATE TABLE events (
    event_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    event_date DATE,
    image_url VARCHAR(255)
);
CREATE TABLE event_participants (
    participant_id INT AUTO_INCREMENT PRIMARY KEY,
    event_id INT,
    user_id INT,
    status ENUM('going', 'not going') NOT NULL,
    FOREIGN KEY (event_id) REFERENCES events(event_id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);
CREATE TABLE galleries (
    gallery_id INT AUTO_INCREMENT PRIMARY KEY,
    batch_year YEAR NOT NULL,
    gallery_name VARCHAR(255)
);
CREATE TABLE memories (
    memory_id INT AUTO_INCREMENT PRIMARY KEY,
    gallery_id INT,
    memory_date DATE,
    image_url VARCHAR(255),
    description TEXT,
    uploader_id INT,
    FOREIGN KEY (gallery_id) REFERENCES galleries(gallery_id) ON DELETE CASCADE,
    FOREIGN KEY (uploader_id) REFERENCES users(user_id) ON DELETE
    SET NULL
);