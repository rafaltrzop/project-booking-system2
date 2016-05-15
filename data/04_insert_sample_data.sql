USE srtp2;

# Add mod (password: qAWfMuqyVEe5)
INSERT INTO users(role_id, first_name, last_name, email, password) VALUES
(2, 'Jane', 'Plain', 'jane.plain@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg==');

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

# Add users (password: qAWfMuqyVEe5)
INSERT INTO users(group_id, first_name, last_name, email, password) VALUES
(1, 'Cynthia', 'Dixon', 'cynthia.dixon@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg=='),
(1, 'George', 'Henderson', 'george.henderson@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg=='),
(1, 'Julia', 'Fields', 'julia.fields@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg=='),
(2, 'Jeremy', 'Stone', 'jeremy.stone@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg=='),
(2, 'Julia', 'Perry', 'julia.perry@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg=='),
(2, 'Earl', 'Bell', 'earl.bell@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg=='),
(3, 'Wanda', 'Marshall', 'wanda.marshall@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg=='),
(3, 'Aaron', 'Berry', 'aaron.berry@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg=='),
(3, 'Donna', 'Ray', 'donna.ray@gmail.com', '31sJZ7dGw9iFvJUqKIuS34JHj3D0MPLplLN+dxTq3vL3zz8pxkUSUCamau8UW1nGBOyNlQ0NE1NLWXYZNSV/Hg==');
