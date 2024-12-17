-- Insert sample nationalities
INSERT INTO nationalities (name, code) VALUES
('England', 'EN'),
('France', 'FR'),
('Spain', 'ES'),
('Germany', 'DE'),
('Italy', 'IT');

-- Insert sample teams
INSERT INTO teams (name, rating) VALUES
('Manchester United', 85),
('Paris Saint-Germain', 87),
('Real Madrid', 88),
('Bayern Munich', 86),
('Juventus', 84);

-- Insert sample players
INSERT INTO players (first_name, last_name, nationality_id, team_id, position, rating, pace, shooting, passing, dribbling, defending, physical) VALUES
('Marcus', 'Rashford', 1, 1, 'ST', 85, 90, 83, 78, 85, 45, 75),
('Kylian', 'Mbappe', 2, 2, 'ST', 91, 97, 88, 80, 92, 36, 78),
('Luka', 'Modric', 3, 3, 'CM', 87, 72, 76, 89, 88, 72, 66),
('Joshua', 'Kimmich', 4, 4, 'CDM', 88, 71, 71, 87, 84, 82, 80),
('Federico', 'Chiesa', 5, 5, 'RW', 84, 91, 81, 78, 86, 45, 68);
