@extends('layouts.app')
@section('title', 'Ticket Details')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-body">
        <h3>{{ $tickets->title }}</h3>
        <p class="text-muted">Ticket #: <code>{{ $tickets->ticket_number }}</code></p>
        <p><strong>Requester:</strong> {{ $tickets->full_name }} ({{ $tickets->email }})</p>
        <p><strong>Status:</strong> {{ str_replace('_', ' ', ucfirst($tickets->status)) }}</p>
        <p><strong>Description:</strong><br>{{ $tickets->description }}</p>
        <a href="{{ route('tickets.edit', $tickets) }}" class="btn btn-primary">Edit</a>
        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection