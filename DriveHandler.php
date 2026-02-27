<?php
require_once __DIR__ . '/vendor/autoload.php';

class DriveHandler
{
    private $service;
    private $folderId;

    public function __construct()
    {
        $clientId = getenv('GOOGLE_DRIVE_CLIENT_ID');
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

    /**
     * Upload a new file to the specified Google Drive folder.
     */
    public function uploadFile($fileTmp, $fileName, $mimeType)
    {
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

    /**
     * Download/Stream file content. 
     * Used by view_file.php to show PDFs in the browser.
     */
    public function download($fileId)
    {
        $response = $this->service->files->get($fileId, ['alt' => 'media']);
        return $response->getBody()->getContents();
    }

    /**
     * Delete a file from Google Drive.
     */
    public function deleteFile($fileId)
    {
        try {
            return $this->service->files->delete($fileId);
        } catch (Exception $e) {
            // If file is already deleted on Drive, we don't want to crash the app
            error_log("Drive Deletion Warning: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an existing file on Google Drive (replaces content).
     * This is useful if you want to keep the same Drive ID but change the file.
     */
    public function updateFile($fileId, $fileTmp, $mimeType)
    {
        $emptyFile = new \Google\Service\Drive\DriveFile();
        $content = file_get_contents($fileTmp);

        return $this->service->files->update($fileId, $emptyFile, [
            'data' => $content,
            'mimeType' => $mimeType,
            'uploadType' => 'multipart',
            'fields' => 'id'
        ]);
    }
}