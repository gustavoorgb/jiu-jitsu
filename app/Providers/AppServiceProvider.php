<?php

namespace App\Providers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Facades\Filament;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
    /**
     * Register any application services.
     */
    public function register(): void {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        FilamentIcon::register([
            'panels::pages.dashboard.navigation-item' => 'icon-dashboard',
        ]);
        // Filament::serving(function () {
        //     CreateAction::configureUsing(function (CreateAction $action) {
        //         $action->successNotificationTitle('Registro criado com sucesso!');
        //     });

        //     EditAction::configureUsing(function (EditAction $action) {
        //         $action->successNotificationTitle('Registro atualizado com sucesso!');
        //     });

        //     DeleteAction::configureUsing(function (DeleteAction $action) {
        //         $action->successNotificationTitle('Registro excluído com sucesso!');
        //     });
        // });

    }
}
