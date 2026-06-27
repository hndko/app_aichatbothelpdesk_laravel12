<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('ticket.{id}', function ($user, $id) {
    $ticket = \App\Models\Ticket::find($id);
    if (!$ticket) {
        return false;
    }
    if ($user->isUser()) {
        return (int) $ticket->user_id === (int) $user->id;
    }
    if ($user->isHelpdesk()) {
        return (int) $ticket->assigned_admin_id === (int) $user->id;
    }
    return $user->isAdmin() || $user->isServiceDesk();
});
