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

$sql = "SELECT * FROM Exams";

$result = $conn->query($sql);

$var = 1;
$table = "<table border='1' width='100%' id='viewexams'><tr><td>Exam #</td><td>Date Published</td><td>Select</td></tr>";
while ($row = mysqli_fetch_assoc($result))
{
	$table = $table. "<tr>";
	foreach ($row as $field => $value)
	{
		if ($var != 2) {
			$table = $table. "<td>" . (string)$value . "</td>";
		}
		$var++;
		if ($var == 4) {
			$var = 1;
			break;
		}
	}
	$table = $table . "<td><input type='checkbox'></td>";
	$table = $table. "</tr>";
}
$table = $table. "</table>";

$arr = array("results" => $table);
echo json_encode($arr);
?>
