<?php

namespace App\Services\Api;

use App\Enum\StatusEnum;
use App\Models\Admin;
use App\Models\Service;
use App\Notifications\AddServiceRequestNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Notification;

use function PHPUnit\Framework\isEmpty;

class ServiceManagementService
{
    public function store(array $data)
    {
        $service = DB::transaction(function () use ($data) {

            $service = Service::create([
                'business_account_id' => $data['business_account_id'],
                'category_id' => $data['category_id'],
                'title' => $data['title'],
                'description' => $data['description'],
                'quantity' => $data['quantity'],
                'type' => $data['type'],
                'price_syp' => $data['price_syp'],
                'price_usd' => $data['price_usd'],
                'latitude' => $data['latitude'],
                'longitude' => $data['longitude'],
            ]);

            $service->addMedia($data['main_image'])->toMediaCollection('main_image_service');

            if (!empty($data['gallery'])) {
                foreach ($data['gallery'] as $image) {
                    $service->addMedia($image)->toMediaCollection('gallery_services');
                }
            }

            if (!empty($data['fields'])) {
                $service->fieldValues()->createMany(
                    collect($data['fields'])->map(fn($field) => [
                        'dynamic_field_id' => $field['id'],
                        'value' => $field['value'],
                    ])->toArray()
                );
            }

            return $service;
        });
        // send notification
        $admins = Admin::permission('manage-services')->get();
        Notification::send($admins, new AddServiceRequestNotification($service));
    }

    public function getAllServices(array $filters, $businessAccountId = null, $perPage = 10)
    {
        $query = Service::with(['category', 'businessAccount', 'media'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating');

        if ($businessAccountId) {
            $query->where('business_account_id', $businessAccountId);

            if (!empty($filters['status'])) {
                $query->where('status', $filters['status']);
            }
        } else {
            $query->where('status', StatusEnum::APPROVED->value);

            if (auth('api')->check()) {
                $userBusinessAccounts = auth('api')->user()->businessAccounts()->pluck('id')->toArray();
                if (!empty($userBusinessAccounts)) {
                    $query->whereNotIn('business_account_id', $userBusinessAccounts);
                }
            }
        }

        // 1. Search by Title or Description
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'LIKE', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $filters['search'] . '%');
            });
        }

        // 2. Filter by Category
        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        // 3. Filter by Type
        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        // 4. Filter by Price Range
        if (!empty($filters['min_price'])) {
            $query->where('price_usd', '>=', $filters['min_price']);
        }
        if (!empty($filters['max_price'])) {
            $query->where('price_usd', '<=', $filters['max_price']);
        }

        // 5. Sorting
        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDir = $filters['sort_dir'] ?? 'desc';
        $allowedSorts = ['created_at', 'price_usd', 'title'];

        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir);
        }

        return $query->cursorPaginate($perPage);
    }

    public function showServiceDetails(Service $service, $businessAccountId = null)
    {
        if ($businessAccountId) {
            if ($service->business_account_id != $businessAccountId) {
                throw new AuthorizationException();
            }
        } else {
            if ($service->status->value != StatusEnum::APPROVED->value) {
                throw new AuthorizationException();
            }
        }

        $service->load(['businessAccount', 'category', 'fieldValues.dynamicField'])
            ->loadCount('reviews')
            ->loadAvg('reviews', 'rating');;

        return $service;
    }

    public function updateService(Service $service, array $data)
    {
        DB::transaction(function () use ($service, $data) {
            $service->update([
                'title' => $data['title'] ?? $service->title,
                'description' => $data['description'] ?? $service->description,
                'quantity' => $data['quantity'] ?? $service->quantity,
                'price_syp' => $data['price_syp'] ?? $service->price_syp,
                'price_usd' => $data['price_usd'] ?? $service->price_usd,
                'type' => $data['type'] ?? $service->type,
                'latitude' => $data['latitude'] ?? $service->latitude,
                'longitude' => $data['longitude'] ?? $service->longitude,
                'status' => StatusEnum::PENDING->value,
            ]);

            if (isset($data['main_image'])) {
                $service->clearMediaCollection('main_image_service');
                $service->addMedia($data['main_image'])->toMediaCollection('main_image_service');
            }

            if (!empty($data['gallery'])) {
                foreach ($data['gallery'] as $image) {
                    $service->addMedia($image)->toMediaCollection('gallery_services');
                }
            }

            if (!empty($data['fields'])) {
                $service->fieldValues()->delete();
                foreach ($data['fields'] as $field) {
                    $service->fieldValues()->create([
                        'dynamic_field_id' => $field['id'],
                        'value' => $field['value'],
                    ]);
                }
            }
        });

        return $service->refresh();
    }

    public function deleteMedia(Service $service, int $mediaId)
    {
        Gate::allows('update', $service) || throw new AuthorizationException();

        $media = $service->media()->where('collection_name', 'gallery_services')->findOrFail($mediaId);

        $media->delete();
    }

    public function deleteService(Service $service)
    {
        Gate::allows('delete', $service) || throw new AuthorizationException();

        $service->delete();
    }
}
