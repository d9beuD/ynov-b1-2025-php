<?php

class ArtistManager
{
    public function __construct(
        protected PDO $connection
    ) {
    }

    public function find(int $id): array|false
    {
        $request = $this->connection->prepare('SELECT * FROM artists WHERE id = :id');
        $request->execute(['id' => $id]);

        return $request->fetch();
    }

    public function findAll(): array
    {
        $request = $this->connection->query('SELECT * FROM artists ORDER BY name ASC');

        return $request->fetchAll();
    }

    public function findReleases(int $id): array
    {
        $request = $this->connection->prepare('SELECT * FROM releases WHERE artist_id = :id');
        $request->execute(['id' => $id]);

        return $request->fetchAll();
    }

    public function persist(string $name, string $thumbnailUrl, string $description): void
    {
        $request = $this->connection->prepare('
            INSERT INTO artists(name, thumbnailUrl, description) 
            VALUES(:name, :thumbnailUrl, :description)
        ');
        $request->execute([
            'name' => $name,
            'thumbnailUrl' => $thumbnailUrl,
            'description' => $description,
        ]);
    }
}