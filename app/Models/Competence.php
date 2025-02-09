<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\CompetenceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

final class Competence extends Model
{
    /** @use HasFactory<CompetenceFactory> */
    use HasFactory;
}
