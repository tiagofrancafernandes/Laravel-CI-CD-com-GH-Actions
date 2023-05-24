<?php

namespace App\Filament\Resources;

use Filament\Tables;
use App\Models\Question;
use App\Filament\Resources\QuestionResource\Pages;
use Closure;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\View;
use Filament\Forms\Components\ViewField;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Illuminate\Support\Str;
use RyanChandler\FilamentNavigation\Models\Navigation;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make([
                    TextInput::make('default_title')
                        ->label('Title')
                        ->translateLabel()
                        ->reactive()
                        // ->afterStateUpdated(function (?string $state, Closure $set) {
                        //     if (!$state) {
                        //         return;
                        //     }

                        //     $set('handle', Str::slug($state));
                        // })
                        ->required(),
                    ViewField::make('questions')
                        ->label(__('Questions'))
                        ->translateLabel()
                        ->default([])
                        ->view('components.questions.question-form')
                    // ->view('filament-navigation::no-commit')
                    ,
                ])
                    ->columnSpan([
                        12,
                        'lg' => 10,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('default_title')
                    ->searchable()
                    ->label('Title')
                    ->translateLabel(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->sortable()
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQuestions::route('/'),
        ];
    }
}
