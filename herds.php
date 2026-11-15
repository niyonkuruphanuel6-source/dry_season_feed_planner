<?php
require 'config.php';
$error = '';
$farmers = $pdo->query('SELECT id, full_name FROM farmers ORDER BY full_name')->fetchAll();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $farmerId = filter_input(INPUT_POST, 'farmer_id', FILTER_VALIDATE_INT);
    $keys = ['lactating_cows','dry_cows','heifers','calves'];
    $counts = [];
    foreach ($keys as $key) {
        $v = filter_input(INPUT_POST, $key, FILTER_VALIDATE_INT);
        if ($v === false || $v === null || $v < 0) { $error = 'Animal counts must be zero or a positive whole number.'; break; }
        $counts[] = $v;
    }
    if (!$farmerId || !in_array($farmerId, array_column($farmers, 'id')) || $error) {
        $error = $error ?: 'Choose a valid farmer.';
    } else {
        $stmt = $pdo->prepare('INSERT INTO herds (farmer_id,lactating_cows,dry_cows,heifers,calves) VALUES (?,?,?,?,?) ON DUPLICATE KEY UPDATE lactating_cows=VALUES(lactating_cows), dry_cows=VALUES(dry_cows), heifers=VALUES(heifers), calves=VALUES(calves)');
        // Keep one herd record per farmer; enforced by the unique index added below if upgrading an existing database.
        $check = $pdo->prepare('SELECT id FROM herds WHERE farmer_id=?');
        $check->execute([$farmerId]);
        if ($check->fetch()) {
            $up = $pdo->prepare('UPDATE herds SET lactating_cows=?, dry_cows=?, heifers=?, calves=? WHERE farmer_id=?');
            $up->execute([...$counts, $farmerId]);
        } else {
            $ins = $pdo->prepare('INSERT INTO herds (farmer_id,lactating_cows,dry_cows,heifers,calves) VALUES (?,?,?,?,?)');
            $ins->execute([$farmerId, ...$counts]);
        }
        header('Location: herds.php?saved=1'); exit;
    }
}
$rows = $pdo->query('SELECT f.full_name,h.* FROM herds h JOIN farmers f ON f.id=h.farmer_id ORDER BY f.full_name')->fetchAll();
$pageTitle = 'Herd management';
require 'header.php';
?>
<div class="page-heading"><div><p class="eyebrow">LIVESTOCK RECORDS</p><h1>Herd management</h1><p>Record the number of animals in each group.</p></div></div>
<?php if (isset($_GET['saved'])): ?><div class="success">Herd information saved.</div><?php endif; ?>
<?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
<section class="panel">
<h2>Add or update herd profile</h2>
<?php if (!$farmers): ?><p>Register a farmer first on the Farmers page.</p><?php else: ?>
<form method="post" class="form-grid">
<label>Farmer<select name="farmer_id" required><option value="">Choose farmer</option><?php foreach ($farmers as $f): ?><option value="<?= (int)$f['id'] ?>"><?= e($f['full_name']) ?></option><?php endforeach; ?></select></label>
<label>Lactating cows<input type="number" name="lactating_cows" min="0" value="0" required></label>
<label>Dry cows<input type="number" name="dry_cows" min="0" value="0" required></label>
<label>Heifers<input type="number" name="heifers" min="0" value="0" required></label>
<label>Calves<input type="number" name="calves" min="0" value="0" required></label>
<div class="form-action"><button class="btn" type="submit">Save herd profile</button></div>
</form>
<?php endif; ?>
</section>
<section class="panel"><h2>Herd profiles</h2><div class="table-wrap"><table><thead><tr><th>Farmer</th><th>Lactating</th><th>Dry</th><th>Heifers</th><th>Calves</th><th>Total</th></tr></thead><tbody>
<?php foreach ($rows as $r): $total=(int)$r['lactating_cows']+(int)$r['dry_cows']+(int)$r['heifers']+(int)$r['calves']; ?>
<tr><td><?= e($r['full_name']) ?></td><td><?= (int)$r['lactating_cows'] ?></td><td><?= (int)$r['dry_cows'] ?></td><td><?= (int)$r['heifers'] ?></td><td><?= (int)$r['calves'] ?></td><td><?= $total ?></td></tr>
<?php endforeach; ?>
</tbody></table></div></section>
<?php require 'footer.php'; ?>
