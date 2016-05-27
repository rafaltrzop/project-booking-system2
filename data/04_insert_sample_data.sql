# Add mod (password: password)
INSERT INTO users(role_id, first_name, last_name, email, password) VALUES
(2, 'Foo', 'Bar', 'mod@example.com', 'BFEQkknI/c+Nd7BaG7AaiyTfUFby/pkMHy3UsYqKqDcmvHoPRX/ame9TnVuOV2GrBH0JK9g4koW+CgTYI9mK+w==');

# Add groups
INSERT INTO groups(name, mod_user_id) VALUES
('2014/2015', 2), ('2015/2016', 2), ('2016/2017', 2);

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
