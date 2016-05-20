DROP TABLE IF EXISTS submissions, projects, users, roles;

SET storage_engine = INNODB;

CREATE TABLE roles
(
id INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(30) NOT NULL UNIQUE
);

CREATE TABLE users
(
id INT PRIMARY KEY AUTO_INCREMENT,
role_id INT DEFAULT 3,
group_id INT DEFAULT NULL,
first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
email VARCHAR(60) NOT NULL UNIQUE,
password CHAR(128) NOT NULL,
FOREIGN KEY (role_id) REFERENCES roles(id)
);

CREATE TABLE groups
(
id INT PRIMARY KEY AUTO_INCREMENT,
name VARCHAR(30) NOT NULL UNIQUE,
mod_user_id INT NOT NULL,
FOREIGN KEY (mod_user_id) REFERENCES users(id)
);

ALTER TABLE users ADD FOREIGN KEY (group_id) REFERENCES groups(id);

CREATE TABLE projects
(
id INT PRIMARY KEY AUTO_INCREMENT,
topic VARCHAR(180) NOT NULL UNIQUE,
group_id INT NOT NULL,
user_id INT DEFAULT NULL,
FOREIGN KEY (group_id) REFERENCES groups(id),
FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE submissions
(
id INT PRIMARY KEY AUTO_INCREMENT,
user_id INT NOT NULL,
project_id INT NOT NULL,
submitted_at DATE DEFAULT NULL,
mod_user_id INT DEFAULT NULL,
mark DECIMAL(2,1) DEFAULT NULL,
FOREIGN KEY (project_id) REFERENCES projects(id),
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (mod_user_id) REFERENCES users(id)
);
