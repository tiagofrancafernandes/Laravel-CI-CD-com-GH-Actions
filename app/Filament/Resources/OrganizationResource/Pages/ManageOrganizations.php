<?php

namespace App\Filament\Resources\OrganizationResource\Pages;

use App\Filament\Resources\OrganizationResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOrganizations extends ManageRecords
{
    protected static string $resource = OrganizationResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
