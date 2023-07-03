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

    public function delete($id): bool
    {
        return Event::whereId($id)->delete();
    }

    public function updateRows(Event $event, array $params): bool
    {
        foreach($params as $key => $value) {
            $event[$key] = $value;
        }
        return $event->save();
    }

    public function update(Event $event, array $params): bool
    {
        $event->event_title = $params['event_title'];
        $event->event_start_date = $params['event_start_date'];
        $event->event_end_date = $params['event_end_date'];
        return $event->save();
    }
}
