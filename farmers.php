<?php
require 'config.php';
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['full_name'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $location = trim($_POST['location'] ?? '');
    if ($name === '' || $phone === '' || $location === '') {
        $error = 'Please complete all fields.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO farmers (full_name, phone, location) VALUES (?, ?, ?)');
        $stmt->execute([$name, $phone, $location]);
        header('Location: farmers.php?added=1');
        exit;
    }
}
$farmers = $pdo->query('SELECT f.*, COALESCE(h.lactating_cows,0) lactating_cows, COALESCE(h.dry_cows,0) dry_cows, COALESCE(h.heifers,0) heifers, COALESCE(h.calves,0) calves FROM farmers f LEFT JOIN herds h ON h.farmer_id=f.id ORDER BY f.full_name')->fetchAll();
$pageTitle = 'Farmers';
require 'header.php';
?>
<div class="page-heading"><div><p class="eyebrow">FARM MANAGEMENT</p><h1>Farmers</h1><p>Register farmers and keep their contact details.</p></div></div>
<?php if (isset($_GET['added'])): ?><div class="success">Farmer registered successfully.</div><?php endif; ?>
<?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
<section class="panel">
  <h2>Register a farmer</h2>
  <form method="post" class="form-grid">
    <label>Full name<input name="full_name" maxlength="120" required></label>
    <label>Phone number<input name="phone" maxlength="30" required></label>
    <label>Village / district<input name="location" maxlength="120" required></label>
    <div class="form-action"><button class="btn" type="submit">Save farmer</button></div>
  </form>
</section>
<section class="panel">
  <h2>Registered farmers (<?= count($farmers) ?>)</h2>
  <div class="table-wrap"><table><thead><tr><th>Name</th><th>Phone</th><th>Location</th><th>Animals</th></tr></thead><tbody>
  <?php foreach ($farmers as $f): ?>
  <tr><td><?= e($f['full_name']) ?></td><td><?= e($f['phone']) ?></td><td><?= e($f['location']) ?></td><td><?= (int)$f['lactating_cows'] + (int)$f['dry_cows'] + (int)$f['heifers'] + (int)$f['calves'] ?></td></tr>
  <?php endforeach; ?>
  </tbody></table></div>
</section>
<?php require 'footer.php'; ?>
