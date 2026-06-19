<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CSRF token for jQuery AJAX POST requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>jQuery + Laravel Demo</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family: sans-serif; max-width: 640px; margin: 40px auto;">
    <h1>jQuery + Laravel sanity check</h1>

    <input type="text" id="name" placeholder="Your name" value="Tochi">
    <button id="ping-btn">Send AJAX ping</button>

    <pre id="output" style="background:#111;color:#0f0;padding:12px;margin-top:16px;">// response shows here</pre>

    <script>
        // Send the CSRF token with every jQuery AJAX request
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        $('#ping-btn').on('click', function () {
            $.ajax({
                url: '/api/ping',
                method: 'POST',
                data: { name: $('#name').val() },
                success: function (res) {
                    $('#output').text(JSON.stringify(res, null, 2));
                },
                error: function (xhr) {
                    $('#output').text('Error ' + xhr.status + ': ' + xhr.responseText);
                }
            });
        });
    </script>
</body>
</html>
