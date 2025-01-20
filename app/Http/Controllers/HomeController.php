<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Competence;
use Illuminate\View\View;

final class HomeController extends Controller
{
    public function __invoke(): View
    {
        $competences = Competence::all();

        return view('welcome', [
            'competences' => $competences,
        ]);
    }
}
