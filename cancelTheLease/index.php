
<?php
    // print_r($_GET);
    echo __DIR__;
    use Google\Cloud\Storage\StorageClient;

/**
 * Download a byte range from Cloud Storage and save it as a local file.
 *
 * @param string $bucketName The name of your Cloud Storage bucket.
 * @param string $objectName The name of your Cloud Storage object.
 * @param int $startByte The starting byte at which to begin the download.
 * @param int $endByte The ending byte at which to end the download.
 * @param string $destination The local destination to save the object.
 */

// download_byte_range($_GET['fileName']);

// function download_byte_range(
//     // string $bucketName,
//     string $objectName
//     // int $startByte,
//     // int $endByte,
//     // string $destination
    
// ): void {
    $bucketName = 'juzmatch_1';
    $objectName = $_GET['fileName'];
    $startByte = 1;
    $endByte = 5;
    $destination = 'upload/tem/';

    $storage = new StorageClient([
        'keyFilePath' => '../bg-server-aefde8e14329.json',
    ]);
    $bucket = $storage->bucket($bucketName);
    $object = $bucket->object($objectName);
    $object->downloadToFile($destination, [
        'restOptions' => [
            'headers' => [
                'Range' => "bytes=$startByte-$endByte",
            ],
        ],
    ]);
    printf(
        'Downloaded gs://%s/%s to %s' . PHP_EOL,
        $bucketName,
        $objectName,
        basename($destination)
    );
// }
?>




<table class="table table-striped table-sm ew-view-table">
</table>