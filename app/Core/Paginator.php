<?php

namespace Mktr\Core;

class Paginator
{
    /** @var int */
    private $total;
    /** @var int */
    private $perPage;
    /** @var int */
    private $current;
    /** @var string */
    private $baseUrl;

    public function __construct(int $total, int $perPage, int $current, string $baseUrl)
    {
        $this->total   = max(0, $total);
        $this->perPage = max(1, $perPage);
        $this->current = max(1, $current);
        $this->baseUrl = $baseUrl;
    }

    public function lastPage(): int
    {
        return max(1, (int) ceil($this->total / $this->perPage));
    }

    public function currentPage(): int
    {
        return min($this->current, $this->lastPage());
    }

    public function offset(): int
    {
        return ($this->currentPage() - 1) * $this->perPage;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function hasPages(): bool
    {
        return $this->lastPage() > 1;
    }

    public function urlFor(int $page): string
    {
        $separator = strpos($this->baseUrl, '?') === false ? '?' : '&';

        return $page <= 1 ? $this->baseUrl : $this->baseUrl . $separator . 'page=' . $page;
    }

    /**
     * Page numbers to render, with 0 meaning an ellipsis.
     *
     * @return int[]
     */
    public function window(int $each = 2): array
    {
        $last    = $this->lastPage();
        $current = $this->currentPage();
        $pages   = [];

        for ($i = 1; $i <= $last; $i++) {
            $isEdge   = $i === 1 || $i === $last;
            $isNearby = abs($i - $current) <= $each;

            if ($isEdge || $isNearby) {
                $pages[] = $i;
            } elseif (end($pages) !== 0) {
                $pages[] = 0;
            }
        }

        return $pages;
    }
}
