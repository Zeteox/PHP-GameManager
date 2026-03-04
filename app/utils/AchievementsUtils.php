<?php
function updateAchievements($userId)
{
    $user_achievements = Database::getAllAchievementsFromUser($userId);
    $all_achievements = Database::getAllAchievements();
    $games = Database::getAllGamesFromUser($userId);
    $user_games_genre_id = array_column($games, 'id_genre');
    $all_genres = Database::getAllGenres();
    $have_all_genres = true;

    // Achievement 1 : Have at least 1 game in library
    if (count($games) > 0 && !in_array($all_achievements[0], $user_achievements)) {
        Database::addAchievementToUser($userId, $all_achievements[0]['id']);
    }

    // Achievement 2 : Have at least 10 games in library
    if (count($games) >= 10 && !in_array($all_achievements[1], $user_achievements)) {
        Database::addAchievementToUser($userId, $all_achievements[1]['id']);
    }

    // Achievement 3 : Have at least 50 games in library
    if (count($games) >= 50 && !in_array($all_achievements[2], $user_achievements)) {
        Database::addAchievementToUser($userId, $all_achievements[2]['id']);
    }

    // Achievement 4 : Have at least 100 games in library
    if (count($games) >= 100 && !in_array($all_achievements[3], $user_achievements)) {
        Database::addAchievementToUser($userId, $all_achievements[3]['id']);
    }

    // Achievement 5 : Have a game for each genre
    foreach ($all_genres as $genre) {
        if (!in_array($genre['id'], $user_games_genre_id)) {
            $have_all_genres = false;
            break;
        }
    }

    if ($have_all_genres && !in_array($all_achievements[4], $user_achievements)) {
        Database::addAchievementToUser($userId, $all_achievements[4]['id']);
    }

    $user_achievements = Database::getAllAchievementsFromUser($userId);

    // Achievement 6 : Have at least 5 achievements unlocked
    if (count($user_achievements) >= 5 && !in_array($all_achievements[5], $user_achievements)) {
        Database::addAchievementToUser($userId, $all_achievements[5]['id']);
    }

    // Achievement 7 : Have all achievements unlocked
    if (count($user_achievements) == (count($all_achievements) - 1) && !in_array($all_achievements[6], $user_achievements)) {
        Database::addAchievementToUser($userId, $all_achievements[6]['id']);
    }
}
?>