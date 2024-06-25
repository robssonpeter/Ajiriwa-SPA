<?php
include 'conn.php'; 

// Retrieve data securely from GET parameter
$old_id = filter_input(INPUT_GET, 'data', FILTER_VALIDATE_INT);

if ($old_id === null || $old_id === false) {
    die("Invalid data parameter.");
}

// Create a PDO connection (instead of mysqli)
try {
    $conn = new PDO("mysql:host={$db_config['servername']};dbname={$db_config['database']}", $db_config['username'], $db_config['password']);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Prepare SQL statement with parameterized query
$sql = "SELECT id, slug FROM jobs WHERE old_id = :old_id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':old_id', $old_id, PDO::PARAM_INT);
$stmt->execute();

// Fetch job data
$job = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$job) {
    die("Job not found.");
}

// Redirect to view job page
$slug = $job['slug'];
header('HTTP/1.1 301 Moved Permanently');
header('Location: /view-job/' . urlencode($slug));
exit();
?>

