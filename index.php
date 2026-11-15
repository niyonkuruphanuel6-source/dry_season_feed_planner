<?php
require 'config.php';
$pageTitle = 'Dashboard';
$farmerCount = (int)$pdo->query('SELECT COUNT(*) FROM farmers')->fetchColumn();
$animalCount = (int)$pdo->query('SELECT COALESCE(SUM(lactating_cows + dry_cows + heifers + calves),0) FROM herds')->fetchColumn();
$made = (float)$pdo->query("SELECT COALESCE(SUM(quantity_kg),0) FROM silage_inventory WHERE entry_type='made'")->fetchColumn();
$fed = (float)$pdo->query("SELECT COALESCE(SUM(quantity_kg),0) FROM silage_inventory WHERE entry_type='fed'")->fetchColumn();
$stock = max(0, $made - $fed);
$recent = $pdo->query('SELECT id, full_name, phone, location, created_at FROM farmers ORDER BY id DESC LIMIT 5')->fetchAll();
require 'header.php';
?>
<section class="hero">
  <div>
    <p class="eyebrow">DAIRY FARM DECISION SUPPORT</p>
    <h1>Plan today. Feed through the dry season.</h1>
    <p>Manage farmers, estimate silage needs and track conserved feed in one place.</p>
    <a class="btn" href="calculator.php">Calculate silage target</a>
  </div>
</section>
<section class="stats">
  <article class="stat"><span>Registered farmers</span><strong><?= $farmerCount ?></strong></article>
  <article class="stat"><span>Animals recorded</span><strong><?= $animalCount ?></strong></article>
  <article class="stat"><span>Silage made</span><strong><?= number_format($made/1000, 2) ?> t</strong></article>
  <article class="stat"><span>Estimated stock remaining</span><strong><?= number_format($stock/1000, 2) ?> t</strong></article>
</section>
<section class="panel">
  <div class="section-heading"><h2>Recently registered farmers</h2><a href="farmers.php">View all →</a></div>
  <?php if (!$recent): ?><p>No farmers registered yet.</p><?php else: ?>
  <div class="table-wrap"><table><thead><tr><th>Name</th><th>Phone</th><th>Location</th><th>Registered</th></tr></thead><tbody>
  <?php foreach ($recent as $farmer): ?>
    <tr><td><?= e($farmer['full_name']) ?></td><td><?= e($farmer['phone']) ?></td><td><?= e($farmer['location']) ?></td><td><?= e(substr($farmer['created_at'],0,10)) ?></td></tr>
  <?php endforeach; ?>
  </tbody></table></div>
  <?php endif; ?>
</section>
<section class="notice"><strong>Reminder:</strong> the calculator gives planning estimates. Confirm ration and forage decisions with a qualified livestock adviser.</section>
<?php require 'footer.php'; ?>
