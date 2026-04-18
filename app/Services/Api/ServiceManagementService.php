<?php

namespace App\Services\Api;

use App\Models\Admin;
use App\Models\Service;
use App\Notifications\AddServiceRequestNotification;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class ServiceManagementService
{
    public function initialize(array $data)
    {
        $service = Service::create([
            'business_account_id' => $data['business_account_id'],
            'category_id' => $data['category_id'],
        ]);

        return $service;
    }

    public function updateDetails(array $data, Service $service)
    {
        $this->ensureStep(1, $service);

        $service->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'quantity' => $data['quantity'],
            'type' => $data['type'],
            'price_syp' => $data['price_syp'],
            'price_usd' => $data['price_usd'],
            'current_step' => 2
        ]);
    }

    public function updateMedia(array $data, Service $service)
    {
        $this->ensureStep(2, $service);

        $service->addMedia($data['main_image'])->toMediaCollection('main_image_service');

        if (!empty($data['gallery'])) {
            foreach ($data['gallery'] as $image) {
                $service->addMedia($image)->toMediaCollection('gallery_services');
            }
        }

        $service->update(['current_step' => 3]);

        $category = $service->category()->first();
        $dynamicFields = $category->allDynamicFields();

        if ($dynamicFields == null) {
            $service->update(['current_step' => 4]);
            dd($service->current_step);
        }

        return $dynamicFields;
    }

    public function syncDynamicFields(array $data, Service $service)
    {
        $this->ensureStep(3, $service);

        DB::transaction(function () use ($service, $data) {
            $service->fieldValues()->delete();

            foreach ($data['fields'] as $field) {
                $service->fieldValues()->create([
                    'dynamic_field_id' => $field['id'],
                    'value' => $field['value'],
                ]);
            }

            $service->update(['current_step' => 4]);
        });
    }

    public function submitService(array $data, Service $service)
    {
        $this->ensureStep(4, $service);

        // send notification
        $admins = Admin::permission('manage-services')->get();
        Notification::send($admins, new AddServiceRequestNotification($service));

        $service->update([
            'latitude'     => $data['latitude'],
            'longitude'    => $data['longitude'],
            'status'       => 'pending',
            'current_step' => null,
        ]);
    }

    private function ensureStep($current_step, Service $service)
    {
        if ($service->current_step < $current_step)
            throw new AuthorizationException();
    }
}
