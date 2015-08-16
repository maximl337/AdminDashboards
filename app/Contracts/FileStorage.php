<?php

namespace App\Contracts;

interface FileStorage {

    public function put($remoteFilePath, $file);

    public function getTempUrl($filePath);

    public function getPublicUrl($filePath);

}

