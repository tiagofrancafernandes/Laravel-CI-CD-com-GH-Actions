<?php

namespace App\Libs\TiagoF2\Filament;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Filament\Facades\Filament;
use Illuminate\Database\Eloquent\Model;

class UiAvatarsProvider implements \Filament\AvatarProviders\Contracts\AvatarProvider
{
    public function get(Model $user): string
    {
        $name = Str::of(Filament::getUserName($user))
            ->trim()
            ->explode(' ')
            ->map(fn (string $segment): string => filled($segment) ? mb_substr($segment, 0, 1) : '')
            ->join(' ');

        return \Illuminate\Support\Facades\Cache::remember(
            md5(implode('', [__METHOD__, $name])),
            (30 * 24 * 60) /*secs*/,
            function () use ($name) {
                $colorPreset = Arr::random([
                    ['color' => '54cde3', 'background' => '633916', ],
                    ['color' => '4ec3ca', 'background' => '5969a9', ],
                    ['color' => 'b6e2ae', 'background' => '94eb47', ],
                    ['color' => 'FFFFFF', 'background' => '633916', ],
                ]);

                $colorPreset = http_build_query($colorPreset);

                // return 'https://ui-avatars.com/api/?name=' . urlencode($name) . '&color=FFFFFF&background=633916';
                return 'https://ui-avatars.com/api/?name=' . urlencode($name) . "&{$colorPreset}";
            }
        );
    }
}
