<?php
namespace App;

use App\Repository\UserRepository;
use App\Repository\FileRepository;

/**
 * Runs a sequence of MongoDB tests for both UserRepository and FileRepository.
 */
class DemoRunner
{
    public function __construct(
        private UserRepository $userRepo,
        private FileRepository $fileRepo
    ) {}

    public function run(): void
    {
        echo "\n==== USER DEMO ====\n";

        // Create a user
        $this->userRepo->upsertUser('john@example.com', ['name' => 'John Doe']);
        print_r($this->userRepo->findByEmail('john@example.com'));

        // Update the same user
        $this->userRepo->upsertUser('john@example.com', ['name' => 'Johnny Updated']);
        print_r($this->userRepo->searchByName('john'));

        // Delete the user
        $this->userRepo->deleteByEmail('john@example.com');
        echo "User deleted.\n";

        echo "\n==== FILE DEMO ====\n";

        // Store a test image
        $testImagePath = __DIR__ . '/../img/default.jpg';
        $fileId = $this->fileRepo->storeFile($testImagePath, 'image.png');
        echo "Stored file with ID: $fileId\n";

        // Retrieve it back from GridFS
        $downloadPath = __DIR__ . '/../img/image_downloaded.jpg';
        $this->fileRepo->getFile($fileId, $downloadPath);
        echo "Downloaded file to: $downloadPath\n";
    }
}
