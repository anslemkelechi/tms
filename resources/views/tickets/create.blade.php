@extends('layouts.app')
@section('title', 'New Ticket')

@section('content')
<h2 class="mb-3">Create Ticket</h2>
<div class="card shadow-sm border-0">
    <div class="card-body">
        <form method="POST" action="{{ route('tickets.store') }}" id="ticketForm">
            @csrf
            @include('tickets._form')
            <button type="submit" class="btn btn-success" id="submitBtn">
                <span class="spinner-border spinner-border-sm d-none" id="spinner" role="status"></span>
                <span id="btnText">Create Ticket</span>
            </button>

            <a href="{{ route('tickets.index') }}" class="btn btn-link">Cancel</a>
        </form>
    </div>
</div>
@endsection
@section('scripts')
<script>
    function showToast(message, type) {
        $('#toast')
            .removeClass('alert-success alert-danger')
            .addClass(type === 'error' ? 'alert-danger' : 'alert-success')
            .text(message)
            .fadeIn();
        setTimeout(function() {
            $('#toast').fadeOut();
        }, 3000);
    }

    $(function() {
        const form = $('#ticketForm');
        const btn = $('#submitBtn');
        const spinner = $('#spinner');
        const btnText = $('#btnText');
        const isEdit = form.find('input[name=_method]').length > 0;

        form.on('submit', function(e) {
            e.preventDefault();

            if (btn.prop('disabled')) return; 
            // clear old validation errors
            form.find('.is-invalid').removeClass('is-invalid');
            form.find('.invalid-feedback').remove();

            // loading state -> blocks further submits
            btn.prop('disabled', true);
            spinner.removeClass('d-none');
            btnText.text(isEdit ? 'Updating...' : 'Creating...');

            $.ajax({
                url: form.attr('action'),
                method: 'POST', // _method=PUT (edit) handles the spoof
                data: form.serialize(),
                success: function(res) {
                    // redirect back to the tickets list after a successful create
                    window.location.href = "{{ route('tickets.index') }}";
                    return; // skip re-enabling the button; we're navigating away
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        $.each(xhr.responseJSON.errors, function(field, messages) {
                            const input = form.find('[name="' + field + '"]');
                            input.addClass('is-invalid');
                            input.after('<div class="invalid-feedback">' + messages[0] + '</div>');
                        });
                    } else {
                        showToast('Something went wrong (' + xhr.status + ').', 'error');
                    }
                },
                complete: function() {
                    // always restore the button, success or fail
                    btn.prop('disabled', false);
                    spinner.removeClass('d-none').addClass('d-none');
                    btnText.text(isEdit ? 'Update Ticket' : 'Create Ticket');
                }
            });
        });
    });
</script>
@endsection