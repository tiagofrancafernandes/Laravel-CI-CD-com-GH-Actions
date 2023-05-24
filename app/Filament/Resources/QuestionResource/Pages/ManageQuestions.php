<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\ManageRecords;
use App\Filament\Resources\QuestionResource;

class ManageQuestions extends ManageRecords
{
    public function mount(): void
    {
        parent::mount();
    }

    protected static string $resource = QuestionResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make()->using(fn (array $data): Model => static::getModel()::create($data)),
        ];
    }

    public function createItem()
    {
        // $this->mountedItem = null;
        // $this->mountedItemData = [];
        // $this->mountedActionData = [];

        // $this->mountAction('item');
    }

    protected function getHeaderWidgets(): array
    {
        return [
            \App\Filament\Resources\UserResource\Widgets\QuestionNumbersWidget::class,
        ];
    }

    public function addNewInput()
    {
        $this->mountedTableActionData['questions'][] = [
            'label' => [
                'default' => \null,
            ],
            'type' => 'single_line_text',
            'input_variant' => 'text',
            'required' => false,
            'name' => \null,
        ];
    }
}
