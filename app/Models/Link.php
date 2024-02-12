<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    public function scopeSortBy($query, string $sort): void
    {
        if (! $sort) {
            return;
        }

        $sort = explode('.', $sort);

        if (count($sort) != 2) {
            return;
        }

        if (in_array($sort[0], ['id', 'clicks', 'created_at'])) {
            $query->orderBy($sort[0], $sort[1] == 'desc' ? 'desc' : 'asc');
        }
    }
}
