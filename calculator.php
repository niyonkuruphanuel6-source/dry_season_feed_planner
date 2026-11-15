<?php
require 'config.php';
$farmers = $pdo->query('SELECT f.id,f.full_name,h.lactating_cows,h.dry_cows,h.heifers,h.calves FROM farmers f LEFT JOIN herds h ON h.farmer_id=f.id ORDER BY f.full_name')->fetchAll();
$pageTitle = 'Silage calculator';
require 'header.php';
?>
<div class="page-heading"><div><p class="eyebrow">CONSERVATION PLANNING</p><h1>Silage requirement calculator</h1><p>Estimate a target from herd size, days to cover and feeding assumptions.</p></div></div>
<section class="panel">
<form id="silageForm" class="form-grid">
<label>Farmer / herd<select id="farmer" name="farmer"><option value="">Enter numbers manually</option><?php foreach ($farmers as $f): ?><option value="<?= (int)$f['id'] ?>" data-lactating="<?= (int)($f['lactating_cows'] ?? 0) ?>" data-dry="<?= (int)($f['dry_cows'] ?? 0) ?>" data-heifers="<?= (int)($f['heifers'] ?? 0) ?>" data-calves="<?= (int)($f['calves'] ?? 0) ?>"><?= e($f['full_name']) ?></option><?php endforeach; ?></select></label>
<label>Lactating cows<input id="lactating" type="number" min="0" value="8" required></label>
<label>Dry cows<input id="dry" type="number" min="0" value="2" required></label>
<label>Heifers<input id="heifers" type="number" min="0" value="3" required></label>
<label>Calves<input id="calves" type="number" min="0" value="2" required></label>
<label>Days to cover<input id="days" type="number" min="1" max="730" value="98" required></label>
<label>Fresh silage kg / lactating cow / day<input id="feedLactating" type="number" min="0" step="0.5" value="20" required></label>
<label>Fresh silage kg / dry cow / day<input id="feedDry" type="number" min="0" step="0.5" value="10" required></label>
<label>Fresh silage kg / heifer / day<input id="feedHeifer" type="number" min="0" step="0.5" value="8" required></label>
<label>Fresh silage kg / calf / day<input id="feedCalf" type="number" min="0" step="0.5" value="3" required></label>
<label>Conservation / storage loss (%)<input id="loss" type="number" min="0" max="50" step="1" value="15" required></label>
<label>Fresh forage dry matter (%)<input id="dm" type="number" min="10" max="60" step="1" value="30" required></label>
<div class="form-action"><button class="btn" type="submit">Calculate target</button></div>
</form>
</section>
<section class="results panel" id="results" hidden aria-live="polite">
<p class="eyebrow">ESTIMATED TARGET</p><h2 id="targetTonnes">—</h2>
<div class="stats result-stats">
<article class="stat"><span>Daily fresh silage</span><strong id="daily">—</strong></article>
<article class="stat"><span>Base amount for period</span><strong id="base">—</strong></article>
<article class="stat"><span>Fresh forage dry matter</span><strong id="dryMatter">—</strong></article>
<article class="stat"><span>Approx. silo volume at 650 kg/m³</span><strong id="volume">—</strong></article>
</div>
<p id="weekly" class="notice"></p>
<p class="small">Estimate only. The example feeding rates are editable assumptions, not a complete balanced ration. Silage should not be the only feed. Confirm dry matter, animal needs, storage density and ration with a livestock nutritionist or extension officer.</p>
</section>
<?php require 'footer.php'; ?>
