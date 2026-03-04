<?php
class Database
{
    private static ?PDO $connection = null;

    public static function connect(string $dsn, string $username, string $password): void
    {
        if (self::$connection === null) {
            self::$connection = new PDO($dsn, $username, $password);
            self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    public static function getConnection(): PDO
    {
        if (self::$connection === null) {
            throw new Exception("Database connection not established.");
        }
        return self::$connection;
    }

    public static function disconnect(): void
    {
        self::$connection = null;
    }

    /**
     * Exécute une requête SQL préparée avec paramètres.
     *
     * @param string $sql    Requête SQL avec placeholders (?)
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function executeQuery(string $sql, array $params = []): PDOStatement
    {
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Ajoute un utilisateur administrateur avec les informations données.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function addAdminUser(array $params = []): PDOStatement
    {
        $sql = "INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'admin')";
        $stmt = self::getConnection()->prepare($sql);

        $hashedPassword = password_hash($params[2], PASSWORD_DEFAULT);
        $params[2] = $hashedPassword;

        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Ajoute un utilisateur lambda avec les informations données.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function addUser(array $params = []): PDOStatement
    {
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = self::getConnection()->prepare($sql);

        $hashedPassword = password_hash($params[2], PASSWORD_DEFAULT);
        $params[2] = $hashedPassword;

        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Met à jour les informations d'un utilisateur dans la base de données, y compris le mot de passe.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function updateUser(array $params = []): PDOStatement
    {
        $sql = "UPDATE users SET username = ?, email = ?, password = ? WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);

        $hashedPassword = password_hash($params[2], PASSWORD_DEFAULT);
        $params[2] = $hashedPassword;

        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Met à jour les informations d'un utilisateur dans la base de données sans modifier le mot de passe.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function updateUserWithoutPassword(array $params = []): PDOStatement
    {
        $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Met à jour le rôle d'un utilisateur dans la base de données.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function updateUserRole(array $params = []): PDOStatement
    {
        $sql = "UPDATE users SET role = ? WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Supprime un utilisateur de la base de données en fonction de son ID.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function deleteUser(array $params = []): PDOStatement
    {
        $sql = "DELETE FROM users WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Retourne tous les utilisateurs de la base de données sous forme de tableau associatif.
     *
     * @return \PDOStatement Retourne le statement exécuté
     */
    public static function getAllUsers(): array
    {
        $sql = "SELECT * FROM users";
        $stmt = self::getConnection()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne un utilisateur de la base de données en fonction de son nom d'utilisateur ou de son adresse e-mail.
     *
     * @param string $usernameOrEmail Nom d'utilisateur ou adresse e-mail de l'utilisateur à récupérer
     *
     * @return \PDOStatement Retourne le statement exécuté
     */
    public static function getUserByUsernameOrEmail(string $usernameOrEmail): ?array
    {
        $sql = "SELECT * FROM users WHERE username = ? OR email = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$usernameOrEmail, $usernameOrEmail]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Retourne un utilisateur de la base de données en fonction de son ID.
     *
     * @param int $userId ID de l'utilisateur à récupérer
     *
     * @return \PDOStatement Retourne le statement exécuté
     */
    public static function getUserById(int $userId): ?array
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$userId]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        return $user ?: null;
    }

    /**
     * Crée un nouveau jeu dans la base de données avec les informations données.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function createGame(array $params = []): PDOStatement
    {
        $sql = "INSERT INTO games (title, id_genre, image, difficulty, release_year, description) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Retourne tous les jeux de la base de données sous forme de tableau associatif.
     *
     * @return \PDOStatement Retourne le statement exécuté
     */
    public static function getAllGames(): array
    {
        $sql = "SELECT * FROM games";
        $stmt = self::getConnection()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne tous les jeux associés à un utilisateur spécifique, y compris les informations sur l'ajout et le nombre de temps jouées.
     *
     * @param int $userId ID de l'utilisateur dont les jeux doivent être récupérés
     *
     * @return \PDOStatement Retourne le statement exécuté
     */
    public static function getAllGamesFromUser(int $userId): array
    {
        $sql = "SELECT g.*, ug.added_at, ug.played_times FROM games g
                JOIN user_games ug ON g.id = ug.game_id
                WHERE ug.user_id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne un jeu de la base de données en fonction de son ID.
     *
     * @param int $gameId ID du jeu à récupérer
     *
     * @return \PDOStatement Retourne le statement exécuté
     */
    public static function getGameById(int $gameId): ?array
    {
        $sql = "SELECT * FROM games WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$gameId]);
        $game = $stmt->fetch(PDO::FETCH_ASSOC);
        return $game ?: null;
    }

    /**
     * Met a jour les informations d'un jeu dans la base de données.
     *
     * @param array  $params Paramètres à binder dans la requête (ordre : title, image, difficulty, release_year, description, id)
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function updateGame(array $params = []): PDOStatement
    {
        $sql = "UPDATE games SET title = ?, id_genre = ?, image = ?, difficulty = ?, release_year = ?, description = ? WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Ajoute un jeu à un utilisateur dans la base de données en insérant un enregistrement dans la table user_games, ce qui signifie que le jeu sera associé à cet utilisateur spécifique, mais il restera dans la base de données pour les autres utilisateurs qui pourraient l'avoir ajouté.
     *
     * @param int $userId ID de l'utilisateur à qui ajouter le jeu
     * @param int $gameId ID du jeu à ajouter à l'utilisateur
     */
    public static function addGameToUser(int $userId, int $gameId): void
    {
        $sql = "INSERT INTO user_games (user_id, game_id) VALUES (?, ?)";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$userId, $gameId]);
    }

    /**
     * Supprime un jeu de la base de données en fonction de son ID, ce qui signifie que le jeu sera supprimé pour tous les utilisateurs qui l'ont ajouté, ainsi que toutes les associations avec les utilisateurs dans la table user_games.
     *
     * @param int $gameId ID du jeu à supprimer
     */
    public static function deleteGame(int $gameId): void
    {
        $sql = "DELETE FROM games WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$gameId]);
    }

    /**
     * Supprime l'association entre un utilisateur et un jeu spécifique de la base de données, ce qui signifie que le jeu ne sera plus associé à cet utilisateur, mais il restera dans la base de données pour les autres utilisateurs qui pourraient l'avoir ajouté.
     *
     * @param int $userId ID de l'utilisateur dont le jeu doit être supprimé
     * @param int $gameId ID du jeu à supprimer de l'utilisateur
     */
    public static function deleteGameFromUser(int $userId, int $gameId): void
    {
        $sql = "DELETE FROM user_games WHERE user_id = ? AND game_id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$userId, $gameId]);
    }

    /**
     * Crée un nouveau achievement dans la base de données avec les informations données.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function createAchievement(array $params = []): PDOStatement
    {
        $sql = "INSERT INTO achievements (name, description, points) VALUES (?, ?, ?)";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Retourne tous les achievements de la base de données sous forme de tableau associatif.
     *
     * @return \PDOStatement Retourne le statement exécuté
     */
    public static function getAllAchievements(): array
    {
        $sql = "SELECT * FROM achievements";
        $stmt = self::getConnection()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne tous les achievements associés à un utilisateur spécifique, y compris les informations sur l'ajout et le nombre de points obtenus.
     *
     * @param int $userId ID de l'utilisateur dont les achievements doivent être récupérés
     *
     * @return \PDOStatement Retourne le statement exécuté
     */
    public static function getAllAchievementsFromUser(int $userId): array
    {
        $sql = "SELECT a.* FROM achievements a
                JOIN user_achievements ua ON a.id = ua.achievement_id
                WHERE ua.user_id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Retourne un achievement de la base de données en fonction de son ID.
     *
     * @param int $achievementId ID de l'achievement à récupérer
     *
     * @return \PDOStatement Retourne le statement exécuté  
     */
    public static function getAchievementById(int $achievementId): ?array
    {
        $sql = "SELECT * FROM achievements WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$achievementId]);
        $achievement = $stmt->fetch(PDO::FETCH_ASSOC);
        return $achievement ?: null;
    }

    /**
     * Met à jour les informations d'un achievement dans la base de données.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function updateAchievement(array $params = []): PDOStatement
    {
        $sql = "UPDATE achievements SET name = ?, description = ?, points = ? WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Supprime un achievement de la base de données en fonction de son ID.
     *
     * @param int $achievementId ID de l'achievement à supprimer
     */
    public static function deleteAchievement(int $achievementId): void
    {
        $sql = "DELETE FROM achievements WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$achievementId]);
    }

    /**
     * Add an achievement to a user in the database by inserting a record into the user_achievements table.
     *
     * @param int $userId ID de l'utilisateur à qui ajouter l'achievement
     * @param int $achievementId ID de l'achievement à ajouter
     */
    public static function addAchievementToUser(int $userId, int $achievementId): void
    {
        $sql = "INSERT INTO user_achievements (user_id, achievement_id) VALUES (?, ?)";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$userId, $achievementId]);
    }

    /**
     * Supprime tous les achievements associés à un utilisateur spécifique de la base de données.
     *
     * @param int $userId ID de l'utilisateur dont les achievements doivent être supprimés
     *
     */
    public static function deleteAchievementFromUser(int $userId): void
    {
        $sql = "DELETE FROM user_achievements WHERE user_id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$userId]);
    }

    /**
     * Retourne tous les genres de la base de données sous forme de tableau associatif.
     *
     * @return \PDOStatement Retourne le statement exécuté
     */
    public static function getAllGenres(): array
    {
        $sql = "SELECT * FROM genres";
        $stmt = self::getConnection()->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Exécute une requête SQL préparée avec paramètres.
     *
     * @param int $genreId ID du genre à récupérer
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     */
    public static function getGenreById(int $genreId): ?array
    {
        $sql = "SELECT * FROM genres WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$genreId]);
        $genre = $stmt->fetch(PDO::FETCH_ASSOC);
        return $genre ?: null;
    }

    /**
     * Crée un nouveau genre dans la base de données avec les informations données.
     *
     * @param array  $params Paramètres à binder dans la requête
     *
     * @return \PDOStatement Retourne le statement exécuté
     *
     * @throws \PDOException Si la requête échoue
     */
    public static function createGenre(array $params = []): PDOStatement
    {
        $sql = "INSERT INTO genres (name) VALUES (?)";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Supprime un genre de la base de données en fonction de son ID.
     *
     * @param int $genreId ID du genre à supprimer
     *
     */
    public static function deleteGenre(int $genreId): void
    {
        $sql = "DELETE FROM genres WHERE id = ?";
        $stmt = self::getConnection()->prepare($sql);
        $stmt->execute([$genreId]);
    }
}
?>