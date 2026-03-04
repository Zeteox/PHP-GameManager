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
    id_genre INT NOT NULL,
    image TEXT NOT NULL,
    difficulty ENUM('Easy', 'Medium', 'Hard', 'Infernal') NOT NULL,
    release_year INT NOT NULL,
    description TEXT NOT NULL,
    FOREIGN KEY (id_genre) REFERENCES genres(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS achievements (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    points INT NOT NULL,
    id_picture INT NOT NULL DEFAULT 1
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
('admin', 'admin@example.com', '$2y$12$Q77FjdWrRl.ZpaF1M06LLuvWuzTjoxdsv7zIaaUs/I4qZHJ5HKaku', 'admin');

INSERT INTO achievements (name, description, points, id_picture) VALUES
('First of Many', 'Add a game to your collection.', 10, 1),
('Collector', 'Add 10 games to your collection.', 25, 2),
('Enthusiast', 'Add 50 games to your collection.', 50, 3),
('Completionist', 'Add 100 games to your collection.', 100, 4),
('Genre Explorer', 'Add a game from each genre to your collection.', 25, 5),
('Achievement Hunter', 'Earn 10 achievements.', 50, 6),
('Master Collector', 'Earn all achievements.', 100, 7);

INSERT INTO games (title, id_genre, image, difficulty, release_year, description) VALUES
('Cyberpunk 2077', 1, 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1091500/header.jpg', 'Medium', 2020, 'Dive into a dystopian future filled with technology and danger.'),
('Hollow Knight', 2, 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/367520/header.jpg', 'Hard', 2017, 'Explore a beautifully hand-drawn world filled with secrets and challenging enemies.'),
('Stardew Valley', 5, 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/413150/header.jpg', 'Easy', 2016, 'Build your farm and live off the land in this charming simulation game.'),
('Elden Ring', 3, 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/1245620/header.jpg', 'Infernal', 2022, 'Embark on a dark fantasy adventure in a vast open world filled with danger and mystery.'),
('The Witcher 3: Wild Hunt', 3, 'https://shared.cloudflare.steamstatic.com/store_item_assets/steam/apps/292030/header.jpg', 'Hard', 2015, 'Embark on a monster-hunting adventure in a richly detailed open world.');
