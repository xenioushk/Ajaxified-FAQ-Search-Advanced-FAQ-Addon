<?php

$updaterBase = 'https://projects.bluewindlab.net/wpplugin/zipped/plugins/';
$pluginRemoteUpdater = $updaterBase . 'baf/notifier_afs.php';
new WpAutoUpdater(AFS_PLUGIN_VERSION, $pluginRemoteUpdater, AFS_PLUGIN_UPDATER_SLUG);
