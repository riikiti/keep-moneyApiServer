<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\NotificationStoreRequest;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $Notification = NotificationResource::collection(Notification::all());


        if ($Notification->count() > 0) {
            $data = [
                'status' => 200,
                'data' => $Notification
            ];
        } else {
            $data = [
                'status' => 404,
                'msg' => 'no record found'
            ];
        }

        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NotificationStoreRequest $request)
    {
        $created_Notification = Notification::create($request->validated());

        return new NotificationResource($created_Notification);
    }

    /**
     * Display the specified resource.
     */
    public function show(Notification $Notification)
    {
        return new NotificationResource($Notification);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NotificationStoreRequest $request, Notification $Notification)
    {
        $Notification->update($request->validated());
        return new NotificationResource($Notification);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Notification $Notification)
    {
        $Notification->delete();

        return response(null);
    }
}
