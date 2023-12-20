<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

class ScanQrPage extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?int $navigationSort = 3;

    protected static string $view = 'filament.pages.scan-qr-page';
}
