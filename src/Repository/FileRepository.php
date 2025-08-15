<?php
namespace App\Repository;

use App\Database\Connection;
use MongoDB\GridFS\Bucket;
use MongoDB\BSON\ObjectId;

/**
 * Repository for storing and retrieving files in MongoDB (GridFS).
 */
class FileRepository
{
    private Bucket $bucket;

    public function __construct(Connection $conn)
    {
        // GridFS bucket (default: two collections files.chunks + files.files)
        $this->bucket = new Bucket(
            $conn->manager(),
            ['bucketName' => 'files', 'database' => $conn->db()]
        );
    }

    /**
     * Store a file into MongoDB GridFS.
     */
    public function storeFile(string $path, string $filename): string
    {
        $stream = fopen($path, 'rb'); // open file for reading
        $id = $this->bucket->uploadFromStream($filename, $stream); // send to MongoDB
        fclose($stream); // close local file
        return (string) $id; // return file ID
    }

    /**
     * Retrieve a file from MongoDB GridFS and save it locally.
     * In a normal webapp we would not save it locally this is for the sake of the demo
     * Unless we wpimd serve it as a static file or export it or something like that
     */
    public function getFile(string $id, string $savePath): void
    {
        $stream = fopen($savePath, 'wb'); // open file for writting
        $this->bucket->downloadToStream(new ObjectId($id), $stream); // read from MongoDB
        fclose($stream); // close local file
    }
}
