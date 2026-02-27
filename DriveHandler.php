<?php
require_once __DIR__ . '/vendor/autoload.php';

class DriveHandler {
    private $service;
    private $folderId;

    public function __construct() {
        $clientId     = getenv('GOOGLE_DRIVE_CLIENT_ID');
        $clientSecret = getenv('GOOGLE_DRIVE_CLIENT_SECRET');
        $refreshToken = getenv('GOOGLE_DRIVE_REFRESH_TOKEN');
        $this->folderId = getenv('GOOGLE_DRIVE_FOLDER');

        if (!$clientId || !$clientSecret || !$refreshToken) {
            throw new Exception("Google Drive Environment Variables are missing!");
        }

        $client = new \Google\Client();
        $client->setClientId($clientId);
        $client->setClientSecret($clientSecret);
        $client->refreshToken($refreshToken);
        
        $this->service = new \Google\Service\Drive($client);
    }

    public function uploadFile($fileTmp, $fileName, $mimeType) {
        $fileMetadata = new \Google\Service\Drive\DriveFile([
            'name' => $fileName,
            'parents' => [$this->folderId]
        ]);

        $content = file_get_contents($fileTmp);

        return $this->service->files->create($fileMetadata, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
    }

    public function deleteFile($fileId) {
        return $this->service->files->delete($fileId);
    }
}