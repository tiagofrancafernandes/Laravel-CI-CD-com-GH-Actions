@php
    $user = \Filament\Facades\Filament::auth()->user();
    $impersonated = $user?->is_admin
        && session('impersonate_as');

    $organization = $impersonated
        ? \App\Models\Organization::getByIdAndCache(session('impersonate_as'))
        : $user->cachedOrganization();
@endphp

@if ($organization)
<x-filament::widget class="filament-account-widget">
    <x-filament::card>
        <div class="h-12 flex items-center space-x-4 rtl:space-x-reverse">
            <div
                class="w-10 h-10 rounded bg-gray-200 bg-cover bg-center dark:bg-gray-900"
                style="background-image: url('https://ui-avatars.com/api/?name=A+C+C+D&amp;color=FFFFFF&amp;background=BF3039')"
            ></div>

            <div>
                <h5>@lang('Organization:')</h5>
                <h2 class="text-lg sm:text-xl font-bold tracking-tight">
                    {{ $organization?->name }}
                </h2>
            </div>

            @if ($impersonated)
            <div>
                <strong
                    style="
                        vertical-align: 0px;
                        padding: 2px 8px 3px 8px;
                        text-align: center;
                        background: #fa5661;
                        font-size: 11px;
                        font-family: monospace;
                        color: #fff;
                        text-shadow: 1px 1px #bf3039;
                        border-radius: 10px;
                        top: -1px;
                        position: relative;
                        margin:0 0.5rem;
                    "
                >
                    @lang('Impersonated')
                </strong>
                <form action="#outOfPersonate" method="post" class="text-sm">
                    @csrf
                    <button
                        type="submit"
                        @class([
                            'text-gray-600 hover:text-primary-500 outline-none focus:underline',
                            'dark:text-gray-300 dark:hover:text-primary-500' => config('filament.dark_mode'),
                        ])
                    >
                        @lang('Out of personate')
                    </button>
                </form>
            </div>
            @endif
        </div>
    </x-filament::card>
</x-filament::widget>
@endif
