USE srtp2;

# Add roles
INSERT INTO roles(id, name) VALUES
(1, 'ROLE_ADMIN'),
(2, 'ROLE_MOD'),
(3, 'ROLE_USER');

# Add admin (password: password)
INSERT INTO users(role_id, first_name, last_name, email, password) VALUES
(1, 'Foo', 'Bar', 'admin@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w==');
