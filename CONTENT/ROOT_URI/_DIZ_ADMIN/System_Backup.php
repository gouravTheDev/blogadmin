<?php
echo exec('tar zcf _BACKUP/CONTENT/$(date +%F)_my-backup.tar.gz CONTENT/*'); //vescapeshellarg(
// echo exec('tar zcf _BACKUP/CONTENT/$(date +%F)_my-backup.tar.gz CONTENT/*', $output, $return);

echo '...Done...';

?>
