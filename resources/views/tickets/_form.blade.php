@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0 ps-3">
        @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
    </ul>
</div>
@endif

<div class="mb-3">
    <label class="form-label">Full Name</label>
    <input type="text" name="full_name" class="form-control"
        value="{{ old('full_name', $tickets->full_name ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control"
        value="{{ old('email', $tickets->email ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Title</label>
    <input type="text" name="title" class="form-control"
        value="{{ old('title', $tickets->title ?? '') }}" required>
</div>
<div class="mb-3">
    <label class="form-label">Description</label>
    <textarea name="description" class="form-control" rows="4" required>{{ old('description', $tickets->description ?? '') }}</textarea>
</div>
<div class="mb-3">
    <label class="form-label">Status</label>
    <select name="status" class="form-select">
        @foreach (['open', 'in_progress', 'closed'] as $status)
        <option value="{{ $status }}"
            @selected(old('status', $tickets->status ?? 'open') === $status)>
            {{ str_replace('_', ' ', ucfirst($status)) }}
        </option>
        @endforeach
    </select>
</div>