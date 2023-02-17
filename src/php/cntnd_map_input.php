?><?php
// cntnd_map_input
$cntnd_module = "cntnd_map";

// includes
cInclude('module', 'includes/script.cntnd_map.php');
cInclude('module', 'includes/style.cntnd_map.php');

// input/vars
$lat = "CMS_VALUE[1]";
$long = "CMS_VALUE[2]";
$zoom = (int) "CMS_VALUE[3]";
if (empty($lat) OR empty($long)) {
    $lat = "46.94798";
    $long = "7.44743";
}
if ($zoom<=0) {
    $zoom = 9;
}

// other vars
$uuid = rand();
?>
<div class="form-vertical">
    <fieldset style="height: 300px; width: 500px;">
        <legend><?= mi18n("LOCATION") ?></legend>
        <div id="cntnd_map"></div>
    </fieldset>

    <div class="form-group">
        <label for="lat_<?= $uuid ?>"><?= mi18n("LAT") ?></label>
        <input id="lat_<?= $uuid ?>" name="CMS_VAR[1]" type="text" value="<?= $lat ?>" />
    </div>

    <div class="form-group">
        <label for="long_<?= $uuid ?>"><?= mi18n("LONG") ?></label>
        <input id="long_<?= $uuid ?>" name="CMS_VAR[2]" type="text" value="<?= $long ?>" />
    </div>

    <div class="form-group">
        <label for="zoom_<?= $uuid ?>"><?= mi18n("ZOOM") ?></label>
        <input id="zoom_<?= $uuid ?>" name="CMS_VAR[3]" type="number" value="<?= $zoom ?>" />
    </div>
</div>
<script>
    $(document).ready(function(){
        var map = new L.Map('cntnd_map', {
            crs: L.CRS.EPSG3857,
            continuousWorld: true,
            worldCopyJump: false
        });
        var url = 'https://wmts20.geo.admin.ch/1.0.0/ch.swisstopo.pixelkarte-farbe/default/current/3857/{z}/{x}/{y}.jpeg';
        map.addLayer(new L.tileLayer(url));
        map.setView([<?= $lat ?>, <?= $long ?>], <?= $zoom ?>);
        var searchControl = new L.Control.Search({
            url: 'https://nominatim.openstreetmap.org/search?format=json&q={s}',
            jsonpParam: 'json_callback',
            propertyName: 'display_name',
            propertyLoc: ['lat','lon'],
            marker: L.circleMarker([0,0],{radius:30}),
            autoCollapse: true,
            autoType: false,
            minLength: 2
        });
        // lat/long
        searchControl.on('search:locationfound', function(e) {
            $("#lat_<?= $uuid ?>").val(e.latlng.lat);
            $("#long_<?= $uuid ?>").val(e.latlng.lng);
        });
        map.addControl(searchControl);
        // zoom
        map.on('zoom',function(){
            var currZoom = map.getZoom();
            $("#zoom_<?= $uuid ?>").val(currZoom);
        });
    });
</script>
<?php
