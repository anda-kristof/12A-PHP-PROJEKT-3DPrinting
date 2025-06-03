

<div id="dashboard-content"></div>
<script>
function frissites() {
  fetch('pages/dashboard_content.php')
    .then(r => r.text())
    .then(html => document.getElementById('dashboard-content').innerHTML = html)
    .catch(e => document.getElementById('dashboard-content').innerHTML = "<div style='color:red'>Hiba történt!</div>");
}
frissites(); 
setInterval(frissites, 1000); 
setInterval(function() {
  fetch("Functionality/checkjobs.php", { credentials: "same-origin" });
}, 10000);
</script>