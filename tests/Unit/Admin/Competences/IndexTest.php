<?php

declare(strict_types=1);

use App\Filament\Resources\CompetenceResource;
use App\Filament\Resources\CompetenceResource\Pages\ListCompetences;
use App\Models\Competence;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('can render page', function () {
    $user = User::factory()->admin()->create();

    actingAs($user)
        ->get(CompetenceResource::getUrl('index'))
        ->assertSuccessful();
});

it('can be listed', function () {
    $competences = Competence::factory()->count(10)->create();

    Livewire::test(ListCompetences::class)
        ->assertCanSeeTableRecords($competences);
});

it('can delete', function () {
    $competence = Competence::factory()->create();
    $otherCompetence = Competence::factory()->create();

    Livewire::test(ListCompetences::class)
        ->callTableAction('delete', $competence);

    $this->assertDatabaseCount('competences', 1);
});
