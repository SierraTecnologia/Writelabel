<?php

namespace WriteLabel\Services;

class MenuService
{

    /**
     * @return array[]
     *
     * @psalm-return non-empty-list<array<empty, empty>>
     */
    public static function getAdminMenu(): array
    {
        $writelabel = [];
        $writelabel[] = [
        ];

        return $writelabel;
    }
}
