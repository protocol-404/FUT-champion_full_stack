-- Insert sample nationalities
INSERT INTO nationalities (name, code, flag_url) VALUES
('England', 'EN', 'path/to/england_flag.png'),
('France', 'FR', 'path/to/france_flag.png'),
('Spain', 'ES', 'path/to/spain_flag.png'),
('Germany', 'DE', 'path/to/germany_flag.png'),
('Italy', 'IT', 'path/to/italy_flag.png');

-- Insert sample teams
INSERT INTO teams (name, rating, flag_url) VALUES
('Manchester United', 85, 'path/to/manchester_united_flag.png'),
('Paris Saint-Germain', 87, 'path/to/psg_flag.png'),
('Real Madrid', 88, 'path/to/real_madrid_flag.png'),
('Bayern Munich', 86, 'path/to/bayern_munich_flag.png'),
('Juventus', 84, 'path/to/juventus_flag.png');

-- Insert sample players
INSERT INTO players (first_name, last_name, nationality_id, team_id, position, rating, pace, shooting, passing, dribbling, defending, physical) VALUES
('Marcus', 'Rashford', 1, 1, 'ST', 85, 90, 83, 78, 85, 45, 75),
('Kylian', 'Mbappe', 2, 2, 'ST', 91, 97, 88, 80, 92, 36, 78),
('Luka', 'Modric', 3, 3, 'CM', 87, 72, 76, 89, 88, 72, 66),
('Joshua', 'Kimmich', 4, 4, 'CDM', 88, 71, 71, 87, 84, 82, 80),
('Federico', 'Chiesa', 5, 5, 'RW', 84, 91, 81, 78, 86, 45, 68);
