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
INSERT INTO submissions(user_id, project_id, submitted_at) VALUES
(5, 6, '2016-05-19'),
(6, 3, '2016-05-20'),
(7, 11, '2016-05-25'),
(10, 8, '2016-05-27'),
(11, 18, '2016-05-30'),
(13, 15, '2016-05-31');
