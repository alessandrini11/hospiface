<?php

namespace App\model;

use Symfony\Component\HttpFoundation\Request;

class PaginationModel
{
    public ?int $perPage;
    public ?int $actualPage;
    public ?string $query;
    public function __construct(Request $request)
    {
        $this->perPage = (int) $request->query->get('perPage', 1);
        $this->actualPage = (int) $request->query->get('actualPage', 1);
        $this->query = $request->query->get('query' );
    }
}