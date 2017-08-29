<?php require 'vendor/autoload.php';

// Create a new Container
$container = new \Slim\Container([
    // Add Guzzle as 'http'
    'http' => function () {
        return new GuzzleHttp\Client();
    },
    // Add mysqli as 'mysql'
    'mysql' => function () {
        $mysqli = new mysqli(
            getenv('DATABASE_HOST'),
            getenv('DATABASE_USER'),
            getenv('DATABASE_PASSWORD'),
            getenv('DATABASE_NAME')
        );
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: " . $mysqli->connect_error;
            exit;
        } else {
            return $mysqli;
        }
    },
]);

// Instantiate the App object
$app = new \Slim\App($container);

// Get weather by location ID
$app->get('/locations/{id}', function ($request, $response, $args) {

    // Get the location from the database
    $id = $this->mysql->real_escape_string($args['id']);
    $results = $this->mysql->query("SELECT * FROM locations WHERE id='{$id}'");

    // If location found, then show it from the DB, otherwise, query MetaWeather
    if ($results->num_rows > 0) {
        $result = $results->fetch_assoc()['weather'];
    } else {
        $result = $this->http->get("https://www.metaweather.com/api/location/{$id}")
            ->getBody()
            ->getContents();
        $cleanResult = $this->mysql->real_escape_string($result);
        if (!$this->mysql->query("INSERT into locations (id, weather) VALUES ('{$id}', '{$cleanResult}')")) {
            throw new Exception("Location could not be updated.");
        }
    }

    // Return the results as JSON
    return $response->withStatus(200)->withJson(json_decode($result));
});

$app->delete('/locations/{id}', function ($request, $response, $args) {

    // Get the location from the database
    $id = $this->mysql->real_escape_string($args['id']);
    $results = $this->mysql->query("SELECT * FROM locations WHERE id='{$id}'");

    // If it exists, delete it, otherwise send a 404
    if (
        $results->num_rows > 0 &&
        $this->mysql->query("DELETE FROM locations WHERE id='{$id}'")
    ) {
        return $response->withStatus(200)->write("Location {$args['id']} deleted.");
    } else {
        return $response->withStatus(404)->write("Location {$args['id']} not found.");
    }
});

// Run the application
$app->run();
