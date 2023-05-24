@isset($inputReferencePath)
<div
    class="p-2 filament-forms-text-input-component mb-4"
    data-dinamic-input=""
    x-data="{
        inputType: 'text',
        required: false,
    }"
>
    <x-f2.hr-full />

    <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
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
                @class([
                    'w-full py-2 px-3 mx-3 rounded-lg bg-gray-100 border-gray-200',
                    ' dark:bg-gray-900 dark:border-gray-700'=>config('filament.dark_mode')
                ])
                wire:model="{{ $inputReferencePath }}"
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
                @class([
                    'w-full py-2 px-3 mx-3 rounded-lg bg-gray-100 border-gray-200',
                    ' dark:bg-gray-900 dark:border-gray-700'=>config('filament.dark_mode')
                ])
                wire:model="{{ $getStatePath() . '.' . $key }}.label.pt-br"
                placeholder="{{ __('Label for pt_BR') }}"
            />
        </div>

        <div class="p-1">
            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="mountedTableActionData.default_title">
                    <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                        @lang('Type of input')
                    </span>
                </label>
            </div>

            <select
                class="filament-forms-input text-gray-900 block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600"
            >
                <option value="">@lang('Type of input')</option>

                <option value="single_line_text">@lang('Single line text')</option>
                <option value="multi_line_text">@lang('Multi line (textarea)')</option>
                <option value="single_select">@lang('Single select (radio)')</option>
                <option value="multi_select">@lang('Multi select (checkbox)')</option>
            </select>
        </div>
    </div>

    <div class="grid grid-cols-1">
        <div class="p-1">
            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="mountedTableActionData.default_title">
                    <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                        @lang('Validations')
                    </span>
                </label>
            </div>

            <div class="grid grid-cols-3">
                <div class="p-1">
                    <label
                        class="cursor-pointer">
                        <input
                            type="checkbox"
                            class="form-checkbox h-5 w-5 text-success-600 cursor-pointer"
                        >
                            @lang('Required')
                    </label>
                </div>

                <div class="p-1">
                    <label
                        class="cursor-pointer">
                        <input
                            type="checkbox"
                            class="form-checkbox h-5 w-5 text-success-600 cursor-pointer"
                        >
                            @lang('Countable (stats)')
                    </label>
                </div>

                <div class="p-1">
                    <select
                        x-show="inputType === 'text'"
                        class="filament-forms-input text-gray-900 block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600">
                        <option value="">@lang('Input variante')</option>

                        <option value="text">@lang('Text')</option>
                        <option value="email">@lang('E-mail')</option>
                        <option value="number">@lang('Number')</option>
                        <option value="date">@lang('Date (ISO format)')</option>
                        <option value="checkbox">@lang('Checkbox')</option>
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>
@endisset
