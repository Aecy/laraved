<?php

declare(strict_types=1);

use App\Filament\Resources\CompetenceResource;
use App\Filament\Resources\CompetenceResource\Pages\EditCompetence;
use App\Models\Competence;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('can render page', function () {
    $user = User::factory()->create();

    actingAs($user)
        ->get(CompetenceResource::getUrl('edit', [
            'record' => Competence::factory()->create(),
        ]))->assertSuccessful();
});

it('can retrieve data', function () {
    $competence = Competence::factory()->create();

    Livewire::test(EditCompetence::class, [
        'record' => $competence->getRouteKey(),
    ])->assertFormSet([
        'name' => $competence->name,
        'url' => $competence->url,
    ]);
});

it('can save', function () {
    Storage::fake();
    $image = UploadedFile::fake()->image('test.jpg', 80);

    $competence = Competence::factory()->create();
    $newCompetence = Competence::factory()->make();

    Livewire::test(EditCompetence::class, [
        'record' => $competence->getRouteKey(),
    ])->fillForm([
        'name' => $newCompetence->name,
        'url' => $newCompetence->url,
        'image' => $image,
    ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($competence->refresh())
        ->name->toBe($newCompetence->name)
        ->url->toBe($newCompetence->url);
});
