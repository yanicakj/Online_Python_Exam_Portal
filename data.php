<?php
$hostname = 'sql.njit.edu';
$username = 'am2272';
$password = 'zy0sqcm7'; //NJIT given password
$database = 'am2272';

$conn = mysqli_connect($hostname, $username, $password, $database);

if(!$conn)
{
	die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM Questions";
$result = $conn->query($sql);

$table = "<table>";
while ($row = mysqli_fetch_assoc($result))
{
	$table = $table. "<tr>";
	foreach ($row as $field => $value)
	{
		$table = $table. "<td>" . (string)$value . "</td>";
	}
	$table = $table. "</tr>";
}
$table = $table. "</table>";

$arr = array("results" => $table);
echo json_encode($arr);
?>
