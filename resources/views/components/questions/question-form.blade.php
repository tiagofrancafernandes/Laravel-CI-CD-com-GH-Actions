<div
    x-data="{}"
    x-sortable
    x-on:end="console.log('Sorting ended!', $event)"
    class="flex flex-col gap-2 space-y-2"
>
    @foreach($getState() as $key => $input)
    <div
        x-sortable-handle
        x-sortable-item="{{ $key }}"
        x-data="{
            showChild: false,
            showActions: false,
        }"
        class="space-y-2 mb-2 p-0 rounded-lg border border-gray-300 dark:border-gray-600"
    >
        <div class="relative group">
            <div @class([
                'bg-white rounded-lg border border-gray-300 w-full flex',
                'dark:bg-gray-700 dark:border-gray-600' => config('filament.dark_mode'),
            ])>
                <button type="button" @class([
                    'flex items-center bg-gray-50 rounded-l-lg border-r border-gray-300 px-px',
                    'dark:bg-gray-800 dark:border-gray-600' => config('filament.dark_mode'),
                ]) data-sortable-handle>
                    @svg('heroicon-o-dots-vertical', 'text-gray-400 w-4 h-4 -mr-2')
                    @svg('heroicon-o-dots-vertical', 'text-gray-400 w-4 h-4')
                </button>

                <button
                    type="button"
                    @click.stop="(showChild = !showChild); (showActions = false)"
                    class="appearance-none px-3 py-2 text-left w-full"
                    x-tooltip.raw.duration.0="{{ __('Click here to expand...') }}"
                >

                    {{
                        \Arr::get(
                            $input,
                            str(config('app.locale'))->lower()->replace('_', '-')->prepend('label.')->toString()
                        ) ?? \Arr::get(
                            $input,
                            str('default')->lower()->replace('_', '-')->prepend('label.')->toString()
                        )
                    }} &nbsp;
                </button>
            </div>

            <div
                class="absolute top-1 right-0 h-full divide-x rounded-bl-lg rounded-tr-lg overflow-hidden rtl:right-auto rtl:left-0 rtl:rounded-bl-none rtl:rounded-br-lg rtl:rounded-tr-none rtl:rounded-tl-lg  group-hover:flex"
            >
            <button
                @class([
                    'space-y-2 mb-2 p-0 py-2 px-4 m-0 mr-1 border border-gray-300 dark:border-gray-600',
                    'inline-flex items-center justify-center text-center bg-secondary-500 hover:bg-secondary-700 text-white',
                    'font-bold rounded-lg focus:outline-none',
                ])
                title="{{ __('Show actions') }}"
                data-sortable-handle
                x-init=""
                x-tooltip.raw.duration.0="{{ __('Show actions') }}"
                type="button"
                @click.stop="showActions = !showActions"
            >
                @svg('heroicon-o-dots-horizontal', 'text-gray-400 w-4 h-4')
                </button>
            </div>
        </div>

        <div
            x-show="showActions"
            class="mb-2 p-1"
            x-transition:enter="transition ease-in-out duration-500"
            x-transition:leave="transition ease-in-out duration-500 opacity-0"
        >
            <div class="space-y-2 flex justify-end p-3">
                <x-filament::button
                    type="button"
                    size="md"
                    color="danger"
                    icon="heroicon-o-trash"
                    class="filament-link inline-flex items-center justify-center"
                >
                    {{ __('Remove question') }}
                </x-filament::button>
            </div>
        </div>

        <div
            x-show="showChild"
            class="mb-2 p-1"
            x-transition:enter="transition fade-in-out opacity-0"
            x-transition:leave="transition fade-in-out opacity-0"
        >
            <div class="grid grid-cols-1">
                <div class="flex-1"></div>
            </div>

            <div
                class="grid grid-cols-1"
                x-data="{ editLabel: false }"
            >
                <div class="p-2 filament-forms-text-input-component mb-4">
                    <div class="grid grid-cols-1">
                        <div class="p-1">
                            <label x-on:click="editLabel = !editLabel" class="cursor-pointer">
                                <input
                                    type="checkbox"
                                    class="form-checkbox h-5 w-5 text-success-600 cursor-pointer"
                                    x-on:click="editLabel = !editLabel" x-bind:checked="editLabel"
                                >
                                    @lang('Enable edit label')
                            </label>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                        <div class="p-1">
                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="mountedTableActionData.default_title">
                                    <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                        @lang('Default label')
                                        <span class="whitespace-nowrap">
                                            <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
                                        </span>
                                    </span>
                                </label>
                            </div>

                            <input
                                type="text"
                                x-bind:disabled="!editLabel"
                                x-bind:class= "{
                                    'cursor-not-allowed opacity-50': !editLabel
                                }"
                                @class([
                                    'w-full py-2 px-3 mx-3 rounded-lg bg-gray-100 border-gray-200',
                                    ' dark:bg-gray-900 dark:border-gray-700'=>config('filament.dark_mode')
                                ])
                                wire:model="{{ $getStatePath() . '.' . $key }}.label.default"
                                placeholder="Default label"
                            />
                        </div>

                        <div class="p-1">
                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="mountedTableActionData.default_title">
                                    <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                        @lang('Label for pt_BR')
                                    </span>
                                </label>
                            </div>

                            <input
                                type="text"
                                x-bind:disabled="!editLabel"
                                x-bind:class= "{
                                    'cursor-not-allowed opacity-50': !editLabel
                                }"
                                @class([
                                    'w-full py-2 px-3 mx-3 rounded-lg bg-gray-100 border-gray-200',
                                    ' dark:bg-gray-900 dark:border-gray-700'=>config('filament.dark_mode')
                                ])
                                wire:model="{{ $getStatePath() . '.' . $key }}.label.pt-br"
                                placeholder="{{ __('Label for pt_BR') }}"
                            />
                        </div>
                    </div>
                </div>

                {{-- INPUTS START --}}

                <x-questions.input-clone-base
                    :key="$key"
                    :getState="$getState"
                    :getId="$getId"
                    :getStatePath="$getStatePath"
                    inputReferencePath="{{ $getStatePath().'.'. $key . '.label.default' }}"
                />
            </div>
        </div>
    </div>
    @endforeach

    <div class="space-y-2 flex justify-end p-3">
        <x-filament::button
            type="button"
            size="md"
            color="secondary"
            icon="heroicon-o-plus"
            class="filament-link inline-flex items-center justify-center"
            wire:click="addNewInput()"
        >
            {{ __('Add input') }}
        </x-filament::button>
    </div>
</div>
