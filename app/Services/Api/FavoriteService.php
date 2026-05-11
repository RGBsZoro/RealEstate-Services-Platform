<?php

namespace App\Services\Api;

use App\Models\Service;
use App\Models\User;

class FavoriteService
{
    public function getUserFavorites(User $user)
    {
        return $user->favoriteServices()
            ->with([
                'media',
                'businessAccount:id,user_id,name'
            ])
            ->cursorPaginate(15);
    }

    public function addFavorite(User $user, array $data)
    {
        $user->favoriteServices()->attach($data['service_id']);
    }

    public function removeFavorite(User $user, Service $service)
    {
        $user->favoriteServices()->detach($service->id);
    }
}
