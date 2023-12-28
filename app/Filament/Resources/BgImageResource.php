<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BgImageResource\Pages;
use App\Filament\Resources\BgImageResource\RelationManagers;
use App\Models\Api\backgroundImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Wiebenieuwenhuis\FilamentCodeEditor\Components\CodeEditor;

class BgImageResource extends Resource
{
    protected static ?string $model = backgroundImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('urls')->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('urls')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBgImages::route('/'),
            'create' => Pages\CreateBgImage::route('/create'),
            'edit' => Pages\EditBgImage::route('/{record}/edit'),
        ];
    }
}
