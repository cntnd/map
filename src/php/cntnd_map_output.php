<?php
// cntnd_map_output
$cntnd_module = "cntnd_map";

// assert framework initialization
defined('CON_FRAMEWORK') || die('Illegal call: Missing framework initialization - request aborted.');

// editmode
$editmode = cRegistry::isBackendEditMode();

// includes
if ($editmode) {
    cInclude('module', 'includes/script.cntnd_map.php');
    cInclude('module', 'includes/style.cntnd_map.php');
}

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

// module
if ($editmode){
    echo '<span class="module_box"><label class="module_label">'.mi18n("MODULE").'</label></span>';
}

$tpl = cSmartyFrontend::getInstance();
$tpl->assign('lat', $lat);
$tpl->assign('long', $long);
$tpl->assign('zoom', $zoom);
$tpl->display('default.html');
?>
