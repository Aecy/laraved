<?php

declare(strict_types=1);

namespace App\Filament\Resources;

use App\Filament\Resources\CompetenceResource\Pages;
use App\Models\Competence;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

final class CompetenceResource extends Resource
{
    /**
     * The model the resource corresponds to.
     */
    protected static ?string $model = Competence::class;

    /**
     * The label of the resource.
     */
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    /**
     * The label of the resource.
     */
    protected static ?string $modelLabel = 'Compétence';

    /**
     * The plural label of the resource.
     */
    protected static ?string $pluralModelLabel = 'Compétences';

    /**
     * Configures the form for the resource.
     */
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\FileUpload::make('image')->required(),
                Forms\Components\TextInput::make('url')->required(),
            ]);
    }

    /**
     * Configures the table for the resource.
     */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->height(20),
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('url'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Configures the pages for the resource.
     */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCompetences::route('/'),
            'create' => Pages\CreateCompetence::route('/create'),
            'edit' => Pages\EditCompetence::route('/{record}/edit'),
        ];
    }
}
