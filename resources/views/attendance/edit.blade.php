@extends('layouts.app', ['page' => __('Edit Attendance'), 'pageSlug' => 'attendance'])

@section('content')
    <div class="container">
        <h2>Edit Attendance</h2>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('attendance.update', $attendance->id) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label>User Name:</label>
                <input type="text" class="form-control" value="{{ $attendance->user->name }}" disabled>
            </div>

            <div class="mb-3">
                <label>Date:</label>
                <input type="text" class="form-control" value="{{ $attendance->date }}" disabled>
            </div>

            <div class="mb-3">
                <label>Status:</label>
                <select name="status" class="form-control">
                    <option value="0" disabled>Select Status</option>
                    <option value="Present" {{ $attendance->check_in_status == 'Present' ? 'selected' : '' }}>Present
                    </option>
                    <option value="Absent" {{ $attendance->check_in_status == 'Absent' ? 'selected' : '' }}>Absent</option>
                    <option value="Leave" {{ $attendance->check_in_status == 'Leave' ? 'selected' : '' }}>Leave</option>
                    <option value="Half" {{ $attendance->check_in_status == 'Half' ? 'selected' : '' }}>Half</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Status</button>
            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Back</a>
        </form>
    </div>
@endsection
<script>
    $(document).ready(function() {
            $("#status").select2(); // Initialize Select2
        });
</script>