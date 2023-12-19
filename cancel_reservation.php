<!-- cancel_reservation.php -->
<?php
include 'db_config.php';

$isbn = $_GET['isbn'] ?? '';

$cancelQuery = "UPDATE Books SET is_reserved = 'N', reservation_date = NULL WHERE ISBN = '$isbn'";
$conn->query($cancelQuery);

echo
