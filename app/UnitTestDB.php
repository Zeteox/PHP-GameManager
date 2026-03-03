<?php

require_once 'app/database/Database.php';

// Load environment variables from .env file
$env = parse_ini_file(__DIR__ . '/../.env');
foreach ($env as $key => $value) {
    putenv("$key=$value");
}

$db_host = getenv('PHP_DB_HOST');
$db_name = getenv('PHP_DB_NAME');
$db_user = getenv('PHP_DB_USER');
$db_pass = getenv('PHP_DB_PSSWD');

Database::connect("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
$pdo = Database::getConnection();

// ─────────────────────────────────────────────
// Setup
// ─────────────────────────────────────────────

$passed = 0;
$failed = 0;

function assert_test(string $name, bool $condition): void
{
    global $passed, $failed;
    if ($condition) {
        echo "[PASS] $name\n";
        $passed++;
    } else {
        echo "[FAIL] $name\n";
        $failed++;
    }
}

function reset_tables(): void
{
    $pdo = Database::getConnection();
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 0");
    foreach (['user_achievements', 'user_games', 'game_genres', 'achievements', 'genres', 'games', 'users'] as $table) {
        $pdo->exec("DELETE FROM $table");
    }
    $pdo->exec("SET FOREIGN_KEY_CHECKS = 1");
}

function insert_game(string $title = 'TestGame'): int
{
    Database::executeQuery(
        "INSERT INTO games (title, image, difficulty, release_year, description) VALUES (?, ?, ?, ?, ?)",
        [$title, 'img.png', 'easy', 2020, 'A test game']
    );
    return (int) Database::getConnection()->lastInsertId();
}

function insert_achievement(string $title = 'TestAch', int $gameId = 1): int
{
    Database::executeQuery(
        "INSERT INTO achievements (name, description, points) VALUES (?, ?, ?)",
        [$title, 'Ach desc', 10]
    );
    return (int) Database::getConnection()->lastInsertId();
}

function insert_genre(string $name = 'RPG'): int
{
    Database::executeQuery("INSERT INTO genres (name) VALUES (?)", [$name]);
    return (int) Database::getConnection()->lastInsertId();
}

// ─────────────────────────────────────────────
// Connection tests
// ─────────────────────────────────────────────

echo "\n=== Connection ===\n";

assert_test('getConnection() returns a PDO instance', Database::getConnection() instanceof PDO);

Database::disconnect();
try {
    Database::getConnection();
    assert_test('getConnection() throws after disconnect', false);
} catch (Exception $e) {
    assert_test('getConnection() throws after disconnect', str_contains($e->getMessage(), 'not established'));
}

Database::connect("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);

// ─────────────────────────────────────────────
// User tests
// ─────────────────────────────────────────────

echo "\n=== Users ===\n";
reset_tables();

Database::addUser(['alice', 'alice@example.com', 'secret']);
$user = Database::getUserByUsernameOrEmail('alice');
assert_test('addUser() inserts a record', $user !== null);
assert_test('addUser() stores the correct username', $user['username'] === 'alice');
assert_test('addUser() stores the correct email', $user['email'] === 'alice@example.com');
assert_test('addUser() sets default role to user', $user['role'] === 'user');
assert_test('addUser() hashes the password', password_verify('secret', $user['password']));

Database::addAdminUser(['superadmin', 'admin@example.com', 'adminpass']);
$admin = Database::getUserByUsernameOrEmail('superadmin');
assert_test('addAdminUser() sets role to admin', $admin['role'] === 'admin');
assert_test('addAdminUser() hashes the password', password_verify('adminpass', $admin['password']));

$byEmail = Database::getUserByUsernameOrEmail('alice@example.com');
assert_test('getUserByUsernameOrEmail() works with email', $byEmail !== null && $byEmail['username'] === 'alice');

$unknown = Database::getUserByUsernameOrEmail('nobody');
assert_test('getUserByUsernameOrEmail() returns null for unknown', $unknown === null);

$userId = $user['id'];
Database::updateUser(['alice_updated', 'new@example.com', 'newpass', $userId]);
$updated = Database::getUserByUsernameOrEmail('alice_updated');
assert_test('updateUser() changes username', $updated !== null);
assert_test('updateUser() changes email', $updated['email'] === 'new@example.com');
assert_test('updateUser() hashes new password', password_verify('newpass', $updated['password']));

Database::addUser(['todelete', 'del@example.com', 'pass']);
$del = Database::getUserByUsernameOrEmail('todelete');
Database::deleteUser([$del['id']]);
assert_test('deleteUser() removes the record', Database::getUserByUsernameOrEmail('todelete') === null);

// ─────────────────────────────────────────────
// Game tests
// ─────────────────────────────────────────────

echo "\n=== Games ===\n";
reset_tables();

insert_game('Game A');
insert_game('Game B');
assert_test('getAllGames() returns all records', count(Database::getAllGames()) === 2);

$gameId = insert_game('UniqueGame');
$game = Database::getGameById($gameId);
assert_test('getGameById() returns the correct game', $game !== null && $game['title'] === 'UniqueGame');
assert_test('getGameById() returns null for missing id', Database::getGameById(99999) === null);

Database::addUser(['gamer', 'gamer@example.com', 'pass']);
$gamer = Database::getUserByUsernameOrEmail('gamer');
Database::executeQuery("INSERT INTO user_games (user_id, game_id) VALUES (?, ?)", [$gamer['id'], $gameId]);
$userGames = Database::getAllGamesFromUser($gamer['id']);
assert_test("getAllGamesFromUser() returns the user's games", count($userGames) === 1 && $userGames[0]['title'] === 'UniqueGame');

Database::updateGame(['UpdatedTitle', 'new.png', 'Hard', 2023, 'Updated desc', $gameId]);
$updatedGame = Database::getGameById($gameId);
assert_test('updateGame() changes title', $updatedGame['title'] === 'UpdatedTitle');
assert_test('updateGame() changes difficulty', $updatedGame['difficulty'] === 'Hard');

$deleteGameId = insert_game('ToDelete');
Database::deleteGame($deleteGameId);
assert_test('deleteGame() removes the record', Database::getGameById($deleteGameId) === null);

Database::deleteGameFromUser($gamer['id']);
assert_test("deleteGameFromUser() removes user-game relations", count(Database::getAllGamesFromUser($gamer['id'])) === 0);

// ─────────────────────────────────────────────
// Achievement tests
// ─────────────────────────────────────────────

echo "\n=== Achievements ===\n";
reset_tables();

insert_achievement('Ach1');
insert_achievement('Ach2');
assert_test('getAllAchievements() returns all records', count(Database::getAllAchievements()) === 2);

$achId = insert_achievement('MyAch');
$ach = Database::getAchievementById($achId);
assert_test('getAchievementById() returns the correct achievement', $ach !== null && $ach['name'] === 'MyAch');
assert_test('getAchievementById() returns null for missing id', Database::getAchievementById(99999) === null);

Database::addUser(['achiever', 'achiever@example.com', 'pass']);
$achiever = Database::getUserByUsernameOrEmail('achiever');
Database::executeQuery("INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, ?)", [$achiever['id'], $achId]);
$userAchs = Database::getAllAchievementsFromUser($achiever['id']);
assert_test("getAllAchievementsFromUser() returns the user's achievements", count($userAchs) === 1 && $userAchs[0]['name'] === 'MyAch');

Database::updateAchievement(['UpdatedAch', 'New desc', 0, $achId]);
$updatedAch = Database::getAchievementById($achId);
assert_test('updateAchievement() changes name', $updatedAch['name'] === 'UpdatedAch');
assert_test('updateAchievement() changes description', $updatedAch['description'] === 'New desc');

$delAchId = insert_achievement('ToDelete');
Database::deleteAchievement($delAchId);
assert_test('deleteAchievement() removes the record', Database::getAchievementById($delAchId) === null);

Database::deleteAchievementFromUser($achiever['id']);
assert_test("deleteAchievementFromUser() removes user-achievement relations", count(Database::getAllAchievementsFromUser($achiever['id'])) === 0);

// ─────────────────────────────────────────────
// Genre tests
// ─────────────────────────────────────────────

echo "\n=== Genres ===\n";
reset_tables();

insert_genre('Action');
insert_genre('RPG');
assert_test('getAllGenres() returns all records', count(Database::getAllGenres()) === 2);

$genreId = insert_genre('Strategy');
$genre = Database::getGenreById($genreId);
assert_test('getGenreById() returns the correct genre', $genre !== null && $genre['name'] === 'Strategy');
assert_test('getGenreById() returns null for missing id', Database::getGenreById(99999) === null);

Database::addUser(['genreuser', 'genre@example.com', 'pass']);
$genreUser = Database::getUserByUsernameOrEmail('genreuser');
$genreGameId = insert_game('GenreGame');
Database::executeQuery("INSERT INTO user_games (user_id, game_id) VALUES (?, ?)", [$genreUser['id'], $genreGameId]);
Database::executeQuery("INSERT INTO game_genres (game_id, genre_id) VALUES (?, ?)", [$genreGameId, $genreId]);
$gameGenres = Database::getAllGenresFromGame($genreUser['id']);
assert_test("getAllGenresFromGame() returns genres for user's games", count($gameGenres) === 1 && $gameGenres[0]['name'] === 'Strategy');

$delGenreId = insert_genre('ToDelete');
Database::deleteGenre($delGenreId);
assert_test('deleteGenre() removes the record', Database::getGenreById($delGenreId) === null);

Database::deleteGenreFromGame($genreGameId);
$stmt = $pdo->prepare("SELECT * FROM game_genres WHERE game_id = ?");
$stmt->execute([$genreGameId]);
assert_test('deleteGenreFromGame() removes game-genre relations', count($stmt->fetchAll()) === 0);

// ─────────────────────────────────────────────
// Summary
// ─────────────────────────────────────────────

echo "\n=== Results ===\n";
echo "Passed: $passed | Failed: $failed | Total: " . ($passed + $failed) . "\n";

Database::disconnect();