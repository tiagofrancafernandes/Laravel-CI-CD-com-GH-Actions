<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\User;
use App\Helpers\HtmlableMaker;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class UserNumbersWidget extends BaseWidget
{
    protected static ?string $pollingInterval = null;
    protected int | string | array $columnSpan = 'full';

    protected function getColumns(): int
    {
        return 3;
    }

    protected function getCards(): array
    {
        $clearCache = \config('app.debug') && !app()->environment('production');

        $userNumbers = User::userNumbers(
            clearCache: $clearCache
        );

        $verifiedUsersUrl = urldecode(
            route(
                'filament.resources.users.index',
                [
                    "tableFilters" => [
                        "verified" => [
                            "isActive" => "1",
                        ],
                        "Not_verified" => [
                            "isActive" => "0",
                        ],
                    ],
                ]
            )
        );

        $notVerifiedUsersUrl = urldecode(
            route(
                'filament.resources.users.index',
                [
                    "tableFilters" => [
                        "verified" => [
                            "isActive" => "0",
                        ],
                        "Not_verified" => [
                            "isActive" => "1",
                        ],
                    ],
                ]
            )
        );

        return [
            Card::make(
                HtmlableMaker::blade(
                    <<<'BLADE'
                    <a href="{{ route('filament.resources.users.index') }}">
                        <h1 class="flex items-center space-x-1 rtl:space-x-reverse font-semibold text-lg text-secondary-600">
                            <span>@lang('Registered users')</span>
                            @svg('heroicon-o-users', 'w-10 h-10')
                        </h1>
                    </a>
                    BLADE
                ),
                $userNumbers->{'total'} ?? 0
            )
                ->color('secondary'),

            Card::make(
                HtmlableMaker::blade(
                    <<<BLADE
                    <a href="{$verifiedUsersUrl}">
                        <h1 class="flex items-center space-x-1 rtl:space-x-reverse font-semibold text-lg text-success-600">
                            <span>@lang('Verified users')</span>
                            @svg('heroicon-o-users', 'w-10 h-10')
                            @svg('heroicon-o-check', 'w-10 h-10')
                        </h1>
                    </a>
                    BLADE
                ),
                $userNumbers->{'total_verified'} ?? 0
            )
                ->color('success'),

            Card::make(
                HtmlableMaker::blade(
                    <<<BLADE
                    <a href="{$notVerifiedUsersUrl}">
                        <h1 class="flex items-center space-x-1 rtl:space-x-reverse font-semibold text-lg text-danger-600">
                            <span>@lang('Not verified users')</span>
                            @svg('heroicon-o-users', 'w-10 h-10')
                            @svg('heroicon-o-x', 'w-10 h-10')
                        </h1>
                    </a>
                    BLADE
                ),
                $userNumbers->{'not_verified'} ?? 0
            )
                ->color('danger'),
        ];
    }
}
