@extends('layouts.app')
@section('title', 'All Tickets')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="m-0">Tickets</h2>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary">+ New Ticket</a>
</div>

<div class="card shadow-sm border-0">
    <div class="table-responsive">
        <table class="table table-hover align-middle m-0">
            <thead class="table-light">
                <tr>
                    <th>Ticket #</th>
                    <th>Title</th>
                    <th>Requester</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($tickets as $ticket)
                <tr>
                    <td><code>{{ $ticket->ticket_number }}</code></td>
                    <td>{{ $ticket->title }}</td>
                    <td>{{ $ticket->full_name }}</td>
                    <td class="status-cell">
                        @php
                        $colors = ['open' => 'success', 'in_progress' => 'warning', 'closed' => 'secondary'];
                        @endphp
                        <span class="badge bg-{{ $colors[$ticket->status] }}">
                            {{ $ticket->status === 'closed' ? 'Resolved' : str_replace('_', ' ', ucfirst($ticket->status)) }}
                        </span>
                    </td>
                    <td class="text-end">
                        @if ($ticket->status !== 'closed')
                        <button type="button" class="btn btn-sm btn-outline-success resolve-btn"
                            data-url="{{ route('tickets.resolve', $ticket) }}">
                            Mark Resolved
                        </button>
                        @endif
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-outline-info">View</a>
                        <a href="{{ route('tickets.edit', $ticket) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                        <form method="POST" action="{{ route('tickets.destroy', $ticket) }}" class="d-inline delete-form">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">No tickets yet.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Delete ticket via AJAX (no page refresh, removes the row)
    $('.delete-form').on('submit', function(e) {
        e.preventDefault();

        if (!confirm('Delete this ticket?')) return;

        const form = $(this);
        const row = form.closest('tr');

        $.ajax({
            url: form.attr('action'),
            method: 'POST',
            data: form.serialize(), // includes @csrf token + _method=DELETE spoof
            success: function(res) {
                row.fadeOut(200, function() {
                    $(this).remove();
                });
            },
            error: function(xhr) {
                alert('Could not delete ticket (' + xhr.status + ').');
            }
        });
    });

    // Mark ticket as Resolved via AJAX (no page refresh, persists to DB)
    $('.resolve-btn').on('click', function() {
        const btn = $(this);
        const row = btn.closest('tr');

        btn.prop('disabled', true).text('Resolving...');

        $.ajax({
            url: btn.data('url'),
            method: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(res) {
                // update the status badge in place
                row.find('.status-cell').html(
                    '<span class="badge bg-secondary">Resolved</span>'
                );
                btn.remove(); 
            },
            error: function(xhr) {
                btn.prop('disabled', false).text('Mark Resolved');
                alert('Could not resolve ticket (' + xhr.status + ').');
            }
        });
    });
</script>
@endsection