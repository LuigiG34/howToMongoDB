<?php

namespace App\Repository;

use App\Database\Connection;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Query;

/**
 * Repository for managing users in MongoDB.
 * Covers: insert, update (upsert), find, search by regex, delete.
 */
class UserRepository
{
    public function __construct(private Connection $conn) {}

    /**
     * Insert or update a user by email (UPSERT).
     */
    public function upsertUser(string $email, array $data): void
    {
        $bulk = new BulkWrite();
        $bulk->update(
            ['email' => $email], // filtre
            ['$set' => $data], // champs à modifier
            ['upsert' => true]  // crée si n'existe pas
        );
        $this->conn->write($this->conn->ns('users'), $bulk);
    }

    /**
     * Find a user by email.
     */
    public function findByEmail(string $email): array
    {
        $cursor = $this->conn->query($this->conn->ns('users'), ['email' => $email]);
        return $cursor->toArray();
    }

    /**
     * Search users by name (case-insensitive).
     */
    public function searchByName(string $name): array
    {
        $cursor = $this->conn->query(
            $this->conn->ns('users'),
            ['name' => [
                '$regex' => $name, // Search by regex pattern
                '$options' => 'i' // Case insensitive so e.g. 'john', 'JOHN doe', 'johny'
                ]
            ]
        );
        return $cursor->toArray();
    }

    /**
     * Delete a user by email.
     */
    public function deleteByEmail(string $email): void
    {
        $bulk = new BulkWrite();
        $bulk->delete(['email' => $email], ['limit' => 1]);
        $this->conn->write($this->conn->ns('users'), $bulk);
    }
}
