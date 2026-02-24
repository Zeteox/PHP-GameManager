<?php
class DatabaseScrapper {
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

    public static function executeQuery(string $sql, array $params = []): PDOStatement  
    {  
        $stmt = self::getConnection()->prepare($sql);  
        $stmt->execute($params);  
        return $stmt;  
    }
}
?>