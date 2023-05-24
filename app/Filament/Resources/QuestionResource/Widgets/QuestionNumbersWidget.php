<?php

namespace App\Filament\Resources\QuestionResource\Widgets;

use App\Helpers\HtmlableMaker;
use App\Models\Question;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class QuestionNumbersWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 2;
    }

    protected function getCards(): array
    {
        $clearCache = \config('app.debug') && !app()->environment('production');

        $questionNumbers = Question::stats(
            clearCache: $clearCache
        );

        return [
            Card::make(
                HtmlableMaker::blade(
                    <<<'BLADE'
                    <a href="{{ route('filament.resources.questions.index') }}">
                        <h1 class="flex items-center space-x-1 rtl:space-x-reverse font-semibold text-lg text-secondary-600">
                            <span>@lang('Total of questions')</span>
                            @svg('heroicon-o-clipboard', 'w-10 h-10')
                        </h1>
                    </a>
                    BLADE
                ),
                $questionNumbers->{'total'} ?? 0
            )
                ->color('secondary')
                ->extraAttributes([
                    'class' => "text-center text-lg"
                ])
                ->description('Total of questions'),
        ];
    }
}
