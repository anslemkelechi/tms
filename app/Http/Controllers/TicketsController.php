<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Str;


class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = Tickets::all();
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tickets.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Response $response)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $data['ticket_number'] = 'TXT' . strtoupper(Str::random(8));
        Tickets::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Ticket created successfully.',
            'data' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Tickets $tickets)
    {
        return view('tickets.show', compact('tickets'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tickets $tickets)
    {
        return view('tickets.edit', compact('tickets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tickets $tickets)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:open,in_progress,closed',
        ]);

        $tickets->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Ticket edited successfully.',
            'data' => $data
        ]);
    }

    /**
     * Mark a ticket as resolved (status = closed) via AJAX.
     */
    public function resolve(Tickets $tickets)
    {
        $tickets->update(['status' => 'closed']);

        return response()->json([
            'success' => true,
            'message' => 'Ticket marked as resolved.',
            'status'  => $tickets->status,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tickets $tickets)
    {
        $tickets->delete();

        return response()->json([
            'success' => true,
            'message' => 'Ticket deleted successfully.'
        ]);
    }
}
