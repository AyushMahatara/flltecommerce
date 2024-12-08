<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Support\Markdown;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;

use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\MarkdownEditor;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\ProductResource\RelationManagers;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?int $navigationSort = 4;
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Product Information')
                        ->schema([
                            TextInput::make('name')->required()->live(onBlur: true)->afterStateUpdated(fn(Set $set, ?string $state) => $set('slug', Str::slug($state))),
                            TextInput::make('slug')->required()->disabled()
                                ->dehydrated()
                                ->unique(Product::class, 'slug', ignoreRecord: true),
                            MarkdownEditor::make('description')->required()->columnSpanFull()->fileAttachmentsDirectory('products'),
                        ])->columns(2),
                    Section::make('Images')->schema([
                        SpatieMediaLibraryFileUpload::make('images')->collection('products.thumbnails')->multiple()->reorderable()->maxFiles(5),
                    ])
                ])->columnSpan(2),
                Group::make()->schema([
                    Section::make('Price')->schema([
                        TextInput::make('price')->required()->numeric()->prefix('Rs. '),
                    ]),
                    Section::make('Association')->schema([
                        Select::make('category_id')->required()->searchable()->preload()->relationship('category', 'name'),
                        Select::make('brand_id')->required()->searchable()->preload()->relationship('brand', 'name'),

                    ]),
                    Section::make('Status')->schema([
                        Toggle::make('in_stock')->default(true),
                        Toggle::make('is_active')->default(true),
                        Toggle::make('is_featured')->default(true),
                        Toggle::make('on_sale')->default(true),
                    ])
                ])
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('category.name')->searchable()->sortable(),
                TextColumn::make('brand.name')->searchable()->sortable(),
                TextColumn::make('price')->searchable()->sortable()->money('Rs. '),
                IconColumn::make('in_stock')->boolean(),
                ToggleColumn::make('is_active'),
                ToggleColumn::make('is_featured'),
                IconColumn::make('on_sale')->boolean()
                    ->falseIcon('heroicon-o-x-mark')
                    ->falseColor('warning'),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')->relationship('category', 'name'),
                SelectFilter::make('brand')->relationship('brand', 'name'),
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ])
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
