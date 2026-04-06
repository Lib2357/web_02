<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationGroup = 'sv23810310276 Admin';

    protected static ?string $slug = 'sv23810310276/products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(12)
                    ->schema([
                        Forms\Components\Select::make('category_id')
                            ->label('Danh muc')
                            ->relationship('category', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpan(4),
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                                'out_of_stock' => 'Out of stock',
                            ])
                            ->required()
                            ->default('draft')
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('discount_percent')
                            ->label('Giam gia (%)')
                            ->numeric()
                            ->integer()
                            ->default(0)
                            ->minValue(0)
                            ->maxValue(100)
                            ->helperText('Truong sang tao: tu dong tinh gia sau giam.')
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('name')
                            ->label('Ten san pham')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state)))
                            ->columnSpan(6),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->rule(fn (?Product $record) => Rule::unique('sv23810310276_products', 'slug')->ignore($record))
                            ->columnSpan(6),
                        Forms\Components\TextInput::make('price')
                            ->label('Gia')
                            ->numeric()
                            ->inputMode('decimal')
                            ->required()
                            ->minValue(0)
                            ->suffix('VND')
                            ->columnSpan(4),
                        Forms\Components\TextInput::make('stock_quantity')
                            ->label('Ton kho')
                            ->numeric()
                            ->integer()
                            ->required()
                            ->minValue(0)
                            ->columnSpan(4),
                        Forms\Components\Placeholder::make('discounted_price_preview')
                            ->label('Gia sau giam')
                            ->content(function (Get $get): string {
                                $price = (float) ($get('price') ?: 0);
                                $discount = max(0, min(100, (int) ($get('discount_percent') ?: 0)));
                                $finalPrice = $price * (100 - $discount) / 100;

                                return number_format($finalPrice, 0, ',', '.') . ' VND';
                            })
                            ->columnSpan(4),
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Anh dai dien')
                            ->image()
                            ->imageEditor()
                            ->directory('products')
                            ->maxFiles(1)
                            ->columnSpan(4),
                        Forms\Components\RichEditor::make('description')
                            ->label('Mo ta')
                            ->toolbarButtons([
                                'bold',
                                'bulletList',
                                'h2',
                                'h3',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'underline',
                                'undo',
                            ])
                            ->columnSpan(8),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Anh'),
                Tables\Columns\TextColumn::make('name')
                    ->label('Ten san pham')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Danh muc')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Gia')
                    ->formatStateUsing(fn ($state): string => number_format((float) $state, 0, ',', '.') . ' VND')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_percent')
                    ->label('Giam gia')
                    ->suffix('%'),
                Tables\Columns\TextColumn::make('discounted_price')
                    ->label('Gia sau giam')
                    ->getStateUsing(fn (Product $record): string => number_format($record->discounted_price, 0, ',', '.') . ' VND'),
                Tables\Columns\TextColumn::make('stock_quantity')
                    ->label('Ton kho')
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'gray' => 'draft',
                        'success' => 'published',
                        'danger' => 'out_of_stock',
                    ]),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Danh muc')
                    ->relationship('category', 'name'),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
