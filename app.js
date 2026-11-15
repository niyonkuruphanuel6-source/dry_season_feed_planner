document.addEventListener('DOMContentLoaded', () => {
  const farmer = document.getElementById('farmer');
  if (farmer) {
    farmer.addEventListener('change', () => {
      const opt = farmer.options[farmer.selectedIndex];
      if (!opt || !opt.value) return;
      document.getElementById('lactating').value = opt.dataset.lactating || 0;
      document.getElementById('dry').value = opt.dataset.dry || 0;
      document.getElementById('heifers').value = opt.dataset.heifers || 0;
      document.getElementById('calves').value = opt.dataset.calves || 0;
    });
  }

  const form = document.getElementById('silageForm');
  if (form) {
    form.addEventListener('submit', (event) => {
      event.preventDefault();
      const val = id => Number(document.getElementById(id).value);
      const ids = ['lactating','dry','heifers','calves','days','feedLactating','feedDry','feedHeifer','feedCalf','loss','dm'];
      if (ids.some(id => !Number.isFinite(val(id)) || val(id) < 0)) {
        alert('Please enter valid non-negative numbers.');
        return;
      }
      const lactating = val('lactating'), dry = val('dry'), heifers = val('heifers'), calves = val('calves');
      const days = val('days'), loss = val('loss'), dm = val('dm');
      if (days < 1 || days > 730 || loss > 50 || dm < 10 || dm > 60) {
        alert('Check days (1–730), loss (0–50%) and dry matter (10–60%).');
        return;
      }
      const daily = lactating*val('feedLactating') + dry*val('feedDry') + heifers*val('feedHeifer') + calves*val('feedCalf');
      const base = daily * days;
      const target = base / (1 - loss/100);
      const dryMatter = target * dm/100;
      const volume = target / 650;
      document.getElementById('results').hidden = false;
      document.getElementById('targetTonnes').textContent = (target/1000).toFixed(2) + ' tonnes fresh silage';
      document.getElementById('daily').textContent = daily.toLocaleString(undefined,{maximumFractionDigits:1}) + ' kg/day';
      document.getElementById('base').textContent = (base/1000).toFixed(2) + ' tonnes';
      document.getElementById('dryMatter').textContent = (dryMatter/1000).toFixed(2) + ' tonnes DM';
      document.getElementById('volume').textContent = volume.toFixed(1) + ' m³';
      document.getElementById('weekly').textContent = 'During the dry season, estimated consumption is approximately ' + (target/Math.max(1,days)*7/1000).toFixed(2) + ' tonnes per week. Adjust for actual forage availability and harvesting capacity.';
      document.getElementById('results').scrollIntoView({behavior:'smooth',block:'start'});
    });
  }
});
