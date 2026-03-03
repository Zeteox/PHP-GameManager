CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS genres (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS games (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    image TEXT NOT NULL,
    difficulty ENUM('Easy', 'Medium', 'Hard', 'Infernal') NOT NULL,
    release_year INT NOT NULL,
    description TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    points INT NOT NULL
);

CREATE TABLE IF NOT EXISTS game_genres (
    game_id INT NOT NULL,
    genre_id INT NOT NULL,
    PRIMARY KEY (game_id, genre_id),
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE,
    FOREIGN KEY (genre_id) REFERENCES genres(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS user_achievements (
    user_id INT NOT NULL,
    achievement_id INT NOT NULL,
    PRIMARY KEY (user_id, achievement_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (achievement_id) REFERENCES achievements(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS user_games (
    user_id INT NOT NULL,
    game_id INT NOT NULL,
    added_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    played_times INT NOT NULL DEFAULT 0,
    PRIMARY KEY (user_id, game_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (game_id) REFERENCES games(id) ON DELETE CASCADE
);

INSERT INTO genres (name) VALUES
('Action'),
('Adventure'),
('RPG'),
('Strategy'),
('Simulation'),
('Sports'),
('Puzzle');

INSERT INTO users (username, email, password, role) VALUES
('defaultadmin', 'admin@example.com', '$2y$12$.1bWmrDxoy4LHqoFf4HVhekhldvwq9nWLKqS97ocPWG3PKQG8Jgp2', 'admin');

INSERT INTO achievements (name, description, points) VALUES
('First of Many', 'Add a game to your collection.', 10),
('Collector', 'Add 10 games to your collection.', 25),
('Enthusiast', 'Add 50 games to your collection.', 50),
('Completionist', 'Add 100 games to your collection.', 100),
('Genre Explorer', 'Add a game from each genre to your collection.', 25),
('Achievement Hunter', 'Earn 10 achievements.', 50),
('Master Collector', 'Earn all achievements.', 100);

