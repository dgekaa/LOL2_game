<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LastEvent extends Model
{
    public $timestamps = false;

    protected $fillable = ['eventId', 'transactionId'];

    public function getEventId() {
        $row = $this::query()->first();

        $eventId = null;
        if($row) {
            $eventId = $row->eventId;
            $eventId += 1;
            $row->eventId = $eventId;
            $row->save();
        } else {
            $eventId = 1;
            LastEvent::create(['eventId' => $eventId, 'transactionId' => 0]);
        }

        return $eventId;
    }

    public function getTransactionId() {
        $row = $this::query()->first();

        $transactionId = null;
        if($row) {
            $transactionId = $row->transactionId;
            $transactionId += 1;
            $row->transactionId = $transactionId;
            $row->save();
        } else {
            $transactionId = 1;
            LastEvent::create(['eventId' => 0, 'transactionId' => $transactionId]);
        }

        return $transactionId;
    }
}
