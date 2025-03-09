<?php

namespace App\Traits;

use Carbon\Carbon;

trait FormatsDate
{
    // Formatte la date en français et évite un rendu dégeu dans le template
    protected function formatDate(string $date): string
    {
        return Carbon::parse($date)->locale('fr')->isoFormat('D MMMM YYYY à HH:mm');
    }
} 