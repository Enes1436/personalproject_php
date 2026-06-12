<?php
require 'config.php';

$results = [];

if(isset($_GET['search']))
{
    $keyword = "%" . $_GET['search'] . "%";

    $stmt = $pdo->prepare(
    "SELECT * FROM students
     WHERE fullname LIKE ?"
    );

    $stmt->execute([$keyword]);

    $results = $stmt->fetchAll();
}
?>
<link rel="stylesheet" href="style.css">
<form method="GET">

<input
type="text"
name="search"
placeholder="Search student">

<button>
Search
</button>

</form>

<?php foreach($results as $student): ?>

<p>
<?= $student['fullname'] ?>
</p>

<?php endforeach; ?>