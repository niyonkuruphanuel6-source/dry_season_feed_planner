<?php
$pageTitle = $pageTitle ?? 'Dry Season Feed & Silage Planner';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pageTitle) ?></title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="topbar">
  <div class="brand">🌱 Feed & Silage Planner</div>
  <nav>
    <a href="index.php">Dashboard</a>
    <a href="farmers.php">Farmers</a>
    <a href="herds.php">Herds</a>
    <a href="calculator.php">Silage Calculator</a>
    <a href="inventory.php">Inventory</a>
  </nav>
</header>
<main class="container">
