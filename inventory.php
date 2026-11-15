<?php
require 'config.php';
$farmers = $pdo->query('SELECT id,full_name FROM farmers ORDER BY full_name')->fetchAll();
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $farmerId = filter_input(INPUT_POST, 'farmer_id', FILTER_VALIDATE_INT);
    $type = $_POST['entry_type'] ?? '';
    $quantity = filter_input(INPUT_POST, 'quantity_kg', FILTER_VALIDATE_FLOAT);
    $date = $_POST['entry_date'] ?? date('Y-m-d');
    $notes = trim($_POST['notes'] ?? '');
    $validDate = DateTime::createFromFormat('Y-m-d', $date);
    if (!$farmerId || !in_array($farmerId, array_column($farmers, 'id'))) $error = 'Choose a valid farmer.';
    elseif (!in_array($type, ['made','fed','adjustment'], true)) $error = 'Choose a valid entry type.';
    elseif ($quantity === false || $quantity === null || $quantity <= 0) $error = 'Quantity must be greater than zero.';
    elseif (!$validDate || $validDate->format('Y-m-d') !== $date) $error = 'Enter a valid date.';
    else {
        $stmt = $pdo->prepare('INSERT INTO silage_inventory (farmer_id,entry_type,quantity_kg,entry_date,notes) VALUES (?,?,?,?,?)');
        $stmt->execute([$farmerId,$type,$quantity,$date,$notes]);
        header('Location: inventory.php?saved=1'); exit;
    }
}
$entries = $pdo->query('SELECT i.*,f.full_name FROM silage_inventory i JOIN farmers f ON f.id=i.farmer_id ORDER BY entry_date DESC,i.id DESC LIMIT 100')->fetchAll();
$made = (float)$pdo->query("SELECT COALESCE(SUM(quantity_kg),0) FROM silage_inventory WHERE entry_type='made'")->fetchColumn();
$fed = (float)$pdo->query("SELECT COALESCE(SUM(quantity_kg),0) FROM silage_inventory WHERE entry_type='fed'")->fetchColumn();
$stock = $made - $fed;
$pageTitle = 'Silage inventory';
require 'header.php';
?>
<div class="page-heading"><div><p class="eyebrow">STOCK CONTROL</p><h1>Silage inventory</h1><p>Record conserved silage and daily feeding use.</p></div></div>
<?php if (isset($_GET['saved'])): ?><div class="success">Inventory entry saved.</div><?php endif; ?>
<?php if ($error): ?><div class="error"><?= e($error) ?></div><?php endif; ?>
<section class="stats">
<article class="stat"><span>Total made</span><strong><?= number_format($made/1000,2) ?> t</strong></article>
<article class="stat"><span>Total fed</span><strong><?= number_format($fed/1000,2) ?> t</strong></article>
<article class="stat"><span>Estimated stock</span><strong><?= number_format($stock/1000,2) ?> t</strong></article>
</section>
<section class="panel"><h2>Record an entry</h2>
<?php if (!$farmers): ?><p>Register a farmer first.</p><?php else: ?>
<form method="post" class="form-grid">
<label>Farmer<select name="farmer_id" required><option value="">Choose farmer</option><?php foreach ($farmers as $f): ?><option value="<?= (int)$f['id'] ?>"><?= e($f['full_name']) ?></option><?php endforeach; ?></select></label>
<label>Entry type<select name="entry_type" required><option value="made">Silage made (+)</option><option value="fed">Silage fed (-)</option><option value="adjustment">Adjustment (+)</option></select></label>
<label>Quantity (kg)<input type="number" name="quantity_kg" min="0.01" step="0.01" required></label>
<label>Date<input type="date" name="entry_date" value="<?= e(date('Y-m-d')) ?>" required></label>
<label class="wide">Notes<input name="notes" maxlength="255" placeholder="e.g. Napier grass, bunker 1"></label>
<div class="form-action"><button class="btn" type="submit">Save entry</button></div>
</form>
<?php endif; ?></section>
<section class="panel"><h2>Recent entries</h2><div class="table-wrap"><table><thead><tr><th>Date</th><th>Farmer</th><th>Type</th><th>Quantity</th><th>Notes</th></tr></thead><tbody>
<?php foreach ($entries as $entry): ?><tr><td><?= e($entry['entry_date']) ?></td><td><?= e($entry['full_name']) ?></td><td><?= e(ucfirst($entry['entry_type'])) ?></td><td><?= number_format((float)$entry['quantity_kg'],2) ?> kg</td><td><?= e($entry['notes']) ?></td></tr><?php endforeach; ?>
</tbody></table></div></section>
<?php require 'footer.php'; ?>
