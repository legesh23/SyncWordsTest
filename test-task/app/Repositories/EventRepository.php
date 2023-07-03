<?php

namespace App\Repositories;

use App\Models\Event;

class EventRepository
{
    public function getByID($id): ?Event
    {
        return Event::findOrFail($id);
        // was not specified if user can get info about events belongs to another users.
        // If not - this return need change to this:
        // return Event::whereId($id)->whereOrganizationId(request()->user()->id)->first();
    }

    public function delete($id): ?Event
    {
        return Event::where($id)->delete();
    }

    public function updateRows(Event $event, array $params): bool
    {
        return $event->update([
            $params
        ]);
    }

    public function update(Event $event, array $params): bool
    {
        return $event->update([
            'event_title' => $params['event_title'],
            'event_start_date' => $params['event_start_date'],
            'event_end_date' => $params['event_end_date']
        ]);
    }
}
