<?php

namespace PHPMaker2022\juzmatch;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Google\Cloud\Storage\StorageClient;

// Page object
$DownloadFileFromCloud = &$Page;
?>
<?php
$Page->showMessage();
?>


<?php

// echo $_GET['fileName'];
download_object($_GET['fileName']);
/**
 * Download an object from Cloud Storage and save it as a local file.
 *
 * @param string $bucketName The name of your Cloud Storage bucket.
 * @param string $objectName The name of your Cloud Storage object.
 * @param string $destination The local destination to save the object.
 */
function download_object($objectName)
{
    $bucketName = 'juzmatch_1';
    $destination = './upload/tem/cloud/'.$objectName;


    $storage = new StorageClient([
        'keyFilePath' => './bg-server-aefde8e14329.json',
    ]);
    $bucket = $storage->bucket($bucketName);
    $object = $bucket->object($objectName);
    $object->downloadToFile($destination);
    printf(
        'Downloaded gs://%s/%s to %s' . PHP_EOL,
        $bucketName,
        $objectName,
        basename($destination)
    );

    $file = $destination;

    if (file_exists($file)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.basename($file));
        header('Content-Transfer-Encoding: binary');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header('Pragma: public');
        header('Content-Length: ' . filesize($file));
        ob_clean();
        flush();
        readfile($file);
        if (readfile($file))
        {
        unlink($file);
        }
        exit;
    }
}

?>

<table class="table table-striped table-sm ew-view-table">
</table>
<?= GetDebugMessage() ?>
