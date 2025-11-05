<?php

class ReleaseManager extends EntityManager
{
    public function find(int $id): array|false
    {
        $request = $this->connection->prepare('SELECT * FROM releases WHERE id =:id');
        $request->execute(['id' => $id]);

        return $request->fetch();
    }

    public function findAll(bool $joinArtist = false): array
    {
        $sql = $joinArtist ? '
            SELECT r.*, a.name as artist_name, a.thumbnailUrl as artist_thumbnailUrl
            FROM releases r
            LEFT JOIN artists a ON a.id = r.artist_id
            ORDER BY r.title ASC
        ' : '
            SELECT * FROM releases ORDER BY title ASC
        ';
        $request = $this->connection->query($sql);

        return $request->fetchAll();
    }

    public function persist(string $title, string $thumbnailUrl, DateTimeImmutable $releasedAt, int $artistId): void
    {
        $request = $this->connection->prepare('
            INSERT INTO releases(title, thumbnailUrl, releasedAt, artist_id)
            VALUES(:title, :thumbnailUrl, :releasedAt, :artist_id)
        ');
        $request->execute([
            'title' => $title,
            'thumbnailUrl' => $thumbnailUrl,
            'releasedAt' => $releasedAt->format('Y-m-d'),
            'artist_id' => $artistId,
        ]);
    }

    public function update(int $id, string $title, string $thumbnailUrl, DateTimeImmutable $releasedAt, int $artistId): void
    {
        $request = $this->connection->prepare('
            UPDATE releases
            SET title = :title, thumbnailUrl = :thumbnailUrl, releasedAt = :releasedAt, artist_id = :artist_id
            WHERE id = :id
        ');
        $request->execute([
            'id' => $id,
            'title' => $title,
            'thumbnailUrl' => $thumbnailUrl,
            'releasedAt' => $releasedAt->format('Y-m-d'),
            'artist_id' => $artistId,
        ]);
    }
}
