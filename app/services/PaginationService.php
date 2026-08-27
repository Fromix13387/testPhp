<?php

namespace app\services;

class PaginationService
{
    public static function paginate(
        int $total,
        int $page = 1,
        int $perPage = 10
    ): array {
        $totalPages = max(1, (int) ceil($total / $perPage));

        $page = max(1, min($page, $totalPages));

        return [
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'totalPages' => $totalPages,
            'offset' => ($page - 1) * $perPage,
            'pages' => range(1, $totalPages),
        ];
    }
}