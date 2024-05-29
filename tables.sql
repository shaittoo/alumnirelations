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
CREATE TABLE user (
    user_id int(11) NOT NULL,
    fname varchar(255) NOT NULL,
    lname varchar(255) NOT NULL,
    address varchar(255) NOT NULL,
    contact_num varchar(20) NOT NULL,
    email varchar(255) NOT NULL,
    occupation varchar(255) NOT NULL,
    grad_year year(4) NOT NULL,
    degree_program varchar(255) NOT NULL,
    academic_org varchar(255) NOT NULL,
    bio varchar(255) NOT NULL,
    password varchar(255) NOT NULL,
    user_type varchar(255) NOT NULL DEFAULT 'user'
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