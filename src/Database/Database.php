<?php

namespace App\Database;

use MongoDB\Driver\Manager;
use MongoDB\Driver\Command;
use MongoDB\Driver\Query;
use MongoDB\Driver\BulkWrite;

final class Connection
{
    private Manager $manager; // Core MongoDB connection handler

    public function __construct(
        private readonly string $uri, // "mongodb://mongo:27017"
        private readonly string $db, // "howto"
    ) {
        // Connect to MongoDB when creating the object
        $this->manager = new Manager($this->uri);
    }

    // Getter for the raw Manager (if you need low-level control)
    // Manager here is kind of the equivalent to PDO
    public function manager(): Manager { 
        return $this->manager; 
    }

    // Getter for the database name
    public function db(): string 
    { 
        return $this->db; 
    }

    // Helper to build "namespace" strings: "database.table_name"
    public function ns(string $collection): string 
    { 
        return $this->db . '.' . $collection; 
    }

    // Run a database command (e.g. createIndexes, aggregate, etc.)
    // This is for non-query operations
    public function command(array $cmd)
    { 
        return $this->manager->executeCommand($this->db, new Command($cmd)); 
    }

    // Run a query on a given namespace (collection)
    // Use to do SELECT
    public function query(string $ns, array $filter = [], array $opts = [])
    { 
        return $this->manager->executeQuery($ns, new Query($filter, $opts)); 
    }

    // Perform inserts, updates, deletes via BulkWrite
    // Use to do INSERT, UPDATE and DELETE
    public function write(string $ns, BulkWrite $bulk)
    { 
        return $this->manager->executeBulkWrite($ns, $bulk); 
    }
}