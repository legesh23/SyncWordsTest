<?php

namespace App\Http\Controllers;

use App\Http\Requests\EventPatchUpdateRequest;
use App\Http\Requests\EventUpdateRequest;
use App\Http\Resources\EventResource;
use App\Repositories\EventRepository;
use Symfony\Component\HttpFoundation\Response;

class EventsController extends Controller
{
    public function __construct(private readonly EventRepository $repository)
    {
    }

    public function list(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        return EventResource::collection(request()->user()->events);
    }

    public function show(string $eventID): \Illuminate\Http\JsonResponse|EventResource
    {
        $event = $this->repository->getByID($eventID);
        if (!$event) {
            return response()->json([
                'code' => Response::HTTP_NOT_FOUND,
                'status' => 'not found',
            ]);
        }
        return new EventResource($event);
    }

    public function updateAll(EventUpdateRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $event = $this->repository->getByID($id);
        $this->repository->update(
            $event,
            $request->only([
                'event_title',
                'event_start_date',
                'event_end_date'
            ])
        );
        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => 'success',
        ]);
    }

    public function update(EventPatchUpdateRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        $event = $this->repository->getByID($id);
        $this->repository->updateRows(
            $event,
            $request->only([
                'event_title',
                'event_start_date',
                'event_end_date'
            ])
        );
        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => 'success',
        ]);
    }

    public function delete(string $id): \Illuminate\Http\JsonResponse
    {
        $this->repository->delete($id);
        return response()->json([
            'code' => Response::HTTP_OK,
            'status' => 'success',
        ]);
    }
}
