<?php

namespace App\Service;

use Hashids\Hashids;

class HashidsHelper
{
    public const POST = 2;
    public const PAGE = 3;

    private $hashids;

    public function __construct()
    {
        $this->hashids = new Hashids(
            'kn9LhFaf4xAdn4VEZ5D9QsVA',
            6,
            'abcdefghijklmnopqrstuvwxyz1234567890'
        );
    }

    public function encodePostId(int $id): string
    {
        return $this->hashids->encode(self::POST, $id);
    }

    public function decodePostId(string $hashid): int
    {
        $decoded = $this->hashids->decode($hashid);

        if (2 !== \count($decoded)) {
            return -1;
        }

        [$type, $id] = $decoded;

        if ($type !== self::POST) {
            return -1;
        }

        return $id;
    }

    public function encodePageId(int $id): string
    {
        return $this->hashids->encode(self::PAGE, $id);
    }

    public function decodePageId(string $hashid): int
    {
        $decoded = $this->hashids->decode($hashid);

        if (2 !== \count($decoded)) {
            return -1;
        }

        [$type, $id] = $decoded;

        if ($type !== self::PAGE) {
            return -1;
        }

        return $id;

    }

    public function decodeTypeAndId(string $hashid): array
    {
        $decoded = $this->hashids->decode($hashid);

        if (2 !== \count($decoded)) {
            return -1;
        }

        return $decoded;

    }

}