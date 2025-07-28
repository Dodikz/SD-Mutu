<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Banner;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BannerResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BannerResource\RelationManagers;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $pluralLabel = 'Banner';

    public static function getNavigationLabel(): string
    {
        return 'Banner';
    }

    public static function getNavigationGroup(): ?string
    {
        return 'Konten Website';
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('judul_banner')
                        ->label('Judul Banner')
                        ->maxLength(255),
                    FileUpload::make('gambar_banner')
                        ->label('Gambar Banner')
                        ->image()
                        ->maxSize(1024)
                        ->directory('banners'),
                    Textarea::make('deskripsi_banner')
                        ->label('Deskripsi Banner')
                        ->maxLength(500),
                    TextInput::make('link_banner')
                        ->label('Link Banner')
                        ->url()
                        ->maxLength(255),
                ])
            ])
            ->columns([
                'sm' => 1,
                'md' => 2,
                'lg' => 2,
                'xl' => 2,
                '2xl' => 2,
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_banner')
                    ->label('Judul Banner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('gambar_banner')
                    ->label('Gambar Banner')
                    ->rounded()
                    ->size(50),
                Tables\Columns\TextColumn::make('deskripsi_banner')
                    ->label('Deskripsi Banner')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('link_banner')
                    ->label('Link Banner')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
