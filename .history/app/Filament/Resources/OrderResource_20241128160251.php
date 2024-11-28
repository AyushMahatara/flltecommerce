<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Group;
use function Laravel\Prompts\select;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;

use Filament\Forms\Components\ToggleButtons;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    Section::make('Order Information')->schema([
                        Select::make('user_id')->label('Customer')->searchable()->preload()->required()->searchable()->relationship('user', 'name'),
                        Select::make('payment_method')->label('Payment Method')->options([
                            'cod' => 'Cash on Delivery',
                            'online' => 'Online Payment',
                        ])->required(),

                        Select::make('payment_status')->label('Payment Status')->options([
                            'pending' => 'Pending',
                            'paid' => 'Paid',
                            'failed' => 'Failed',
                        ])->required()->default('pending'),

                        ToggleButtons::make('status')->inline()->default('new')->required()->options([
                            'new' => 'New',
                            'processing' => 'Processing',
                            'shipped' => 'Shipped',
                            'delivered' => 'Delivered',
                            'cancelled' => 'Cancelled',
                        ])
                            ->colors([
                                'new' => 'primary',
                                'processing' => 'gray',
                                'shipped' => 'info',
                                'cancelled' => 'danger',
                                'delivered' => 'success',
                            ])
                            ->icons([
                                'new' => 'heroicon-m-sparkles',
                                'processing' => 'heroicon-m-arrow-path',
                                'shipped' => 'heroicon-m-truck',
                                'cancelled' => 'heroicon-m-x-circle',
                                'delivered' => 'heroicon-m-check-badge',

                            ]),
                        Select::make('currency')->label('Currency')->options([
                            'NRS' => 'NRS',
                            'USD' => 'USD',
                            'EUR' => 'EUR',
                            'GBP' => 'GBP',
                            'INR' => 'INR',
                            'JPY' => 'JPY',
                            'CNY' => 'CNY',
                        ])->default('NRS')->required(),
                        Select::make('shipping_method')->label('Shipping Method')->options([
                            'standard' => 'Standard',
                            'express' => 'Express',
                        ])->default('standard')->required(),
                        Textarea::make('notes')->columnSpanFull(),
                    ])->columns(2),

                    Section::make('Order Items')->schema([
                        Repeater::make('items')->relationship()->schema([
                            Select::make('product_id')
                                ->label('Product')
                                ->searchable()
                                ->preload()
                                ->required()
                                ->distinct()
                                ->relationship('product', 'name')
                                ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                                ->columnSpan(4)
                                ->reactive()
                                ->afterStateUpdated(fn($state, Set $set) => $set('unit_amount', Product::find($state)?->price ?? 0))
                                ->afterStateUpdated(fn($state, Set $set) => $set('total_amount', Product::find($state)?->price ?? 0)),
                            TextInput::make('quantity')->required()->numeric()->default(1)->minValue(1)->columnSpan(2),
                            TextInput::make('unit_amount')->required()->numeric()->disabled()->default(0)->columnSpan(3),
                            TextInput::make('total_amount')->required()->numeric()->default(0)->columnSpan(3),
                        ])->columns(12),
                    ])
                ])->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'view' => Pages\ViewOrder::route('/{record}'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
