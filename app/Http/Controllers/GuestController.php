<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use App\Http\Requests\CreateGuestRequest;
use App\Http\Requests\UpdateGuestRequest;

use App\Models\Guest;
use App\Services\GuestService;
use App\Http\Resources\GuestResource;
use App\Http\Resources\GuestCollection;

class GuestController
{
    private $guestService;

    public function __construct(GuestService $guestService)
    {
        $this->guestService = $guestService;
    }

    public function index(Request $request)
    {
        $guests = $this->guestService->getAllGuests();

        if ($guests) {
            return new JsonResponse(['success' => true, 'data' => (new GuestCollection($guests))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function store(CreateGuestRequest $request)
    {
        $guest = $this->guestService->createGuest($request->validated());

        if ($guest) {
            return new JsonResponse(['success' => true, 'data' => (new GuestResource($guest))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function show(Request $request, $id)
    {
        $guest = $this->guestService->getGuest($id);

        if ($guest) {
            return new JsonResponse(['success' => true, 'data' => (new GuestResource($guest))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function update(UpdateGuestRequest $request, $id)
    {
        $guest = $this->guestService->updateGuest($id, $request->validated());

        if ($guest) {
            return new JsonResponse(['success' => true, 'data' => (new GuestResource($guest))->toArray($request)], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }

    public function destroy(Request $request, $id)
    {
        $deleted = $this->guestService->deleteGuest($id);

        if ($deleted) {
            return new JsonResponse(['success' => true], 200);
        }

        return new JsonResponse(['success' => false], 400);
    }
}
