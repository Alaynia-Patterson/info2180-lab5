<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

if (isset($_GET['country'])) {
    $country = $_GET['country'];

    if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
        // Fetch cities for the specified country
        $stmt = $conn->prepare("SELECT cities.name, cities.district, cities.population
            FROM cities
            JOIN countries ON cities.country_code = countries.code
            WHERE countries.name LIKE :country
        ");
    } else {
        // Fetch country information
        $stmt = $conn->prepare("
            SELECT name, continent, independence_year, head_of_state 
            FROM countries 
            WHERE name LIKE :country
        ");
    }

    $stmt->execute([':country' => "%$country%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
    $stmt = $conn->query("SELECT name, continent, independence_year, head_of_state FROM countries");
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Output results
if (isset($_GET['lookup']) && $_GET['lookup'] === 'cities') {
    echo "<table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>District</th>
                    <th>Population</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['district']) . "</td>
                <td>" . htmlspecialchars($row['population']) . "</td>
              </tr>";
    }
    echo "</tbody>
          </table>";
} else {
    echo "<table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Continent</th>
                    <th>Independence Year</th>
                    <th>Head of State</th>
                </tr>
            </thead>
            <tbody>";
    foreach ($results as $row) {
        echo "<tr>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['continent']) . "</td>
                <td>" . htmlspecialchars($row['independence_year'] ?? 'N/A') . "</td>
                <td>" . htmlspecialchars($row['head_of_state'] ?? 'N/A') . "</td>
              </tr>";
    }
    echo "</tbody>
          </table>";
}
?>
