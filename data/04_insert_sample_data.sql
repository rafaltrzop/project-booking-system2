# Add mod (password: password)
INSERT INTO users(role_id, first_name, last_name, email, password) VALUES
(2, 'Foo', 'Bar', 'mod@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w==');

# Add groups
INSERT INTO groups(name, mod_user_id) VALUES
('2014/2015', 1),
('2015/2016', 2),
('2016/2017', 2);

# Add projects
INSERT INTO projects(topic, group_id) VALUES
('Rejestracja czasu pracy', 1),
('Ewidencja płatności za wynajem mieszkań', 1),
('Strona z wynikami ligowymi', 1),
('Magazyn towarów', 1),
('Wypożyczalnia filmów', 1),
('Biblioteka książek', 1),
('Stacja krwiodawstwa', 2),
('Wypożyczalnia samochodów', 2),
('System rezerwacji biletów', 2),
('Pizzeria', 2),
('Rezerwacja terminów dla zakładu usługowego', 2),
('System rezerwacji tematów projektów', 2),
('System parkingowy', 3),
('Dziennik ocen', 3),
('System zarządzania szpitalem', 3),
('System zarządzania wypłatami pracowników', 3),
('Galeria obrazów', 3),
('Hurtownia', 3);

# Add example user (password: password)
INSERT INTO users(group_id, first_name, last_name, email, password) VALUES
(1, 'Foo', 'Bar', 'user@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w==');

# Add random users (password: password)
INSERT INTO users(group_id, first_name, last_name, email, password) VALUES
(1, 'Stanisław', 'Olszewski', 'solszewski@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(1, 'Agata', 'Kania', 'akania@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(1, 'Paulina', 'Szewczyk', 'pszewczyk@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(1, 'Jagoda', 'Kamińska', 'jkaminska@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(2, 'Mateusz', 'Lewandowski', 'mlewandowski@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(2, 'Amanda', 'Rogowska', 'arogowska@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(2, 'Igor', 'Zieliński', 'izielinski@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(2, 'Maria', 'Matusiak', 'mmatusiak@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(3, 'Adam', 'Malinowski', 'amalinowski@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(3, 'Krzysztof', 'Walczak', 'kwalczak@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(3, 'Julia', 'Sawicka', 'jsawicka@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w=='),
(3, 'Marcin', 'Bielecki', 'mbielecki@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w==');

# Book projects
UPDATE projects SET user_id = 4 WHERE id = 2;
UPDATE projects SET user_id = 8 WHERE id = 7;
UPDATE projects SET user_id = 12 WHERE id = 17;
UPDATE projects SET user_id = 5 WHERE id = 6;
UPDATE projects SET user_id = 6 WHERE id = 3;
UPDATE projects SET user_id = 7 WHERE id = 11;
UPDATE projects SET user_id = 10 WHERE id = 8;
UPDATE projects SET user_id = 11 WHERE id = 18;
UPDATE projects SET user_id = 13 WHERE id = 15;

# Add rated submissions
INSERT INTO submissions(user_id, project_id, submitted_at, mod_user_id, mark) VALUES
(4, 2, '2016-05-09', 1, 5.0),
(8, 7, '2016-05-11', 2, 3.5),
(12, 17, '2016-05-17', 2, 2.0);

# Add new submissions
INSERT INTO submissions(user_id, project_id, submitted_at, mod_user_id) VALUES
(5, 6, '2016-05-19', 1),
(6, 3, '2016-05-20', 1),
(7, 11, '2016-05-25', 2),
(10, 8, '2016-05-27', 2),
(11, 18, '2016-05-30', 2),
(13, 15, '2016-05-31', 2);
