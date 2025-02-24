@extends('layouts.app', ['page' => __('Attendance List'), 'pageSlug' => 'users', 'section' => 'users'])


@section('content')
<div class="container">
    <h2>Manual Attendance Entry</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>User</label>
            <select name="user_id" class="form-control">
    <option value="0">Select Employee</option>
    @foreach(App\Models\User::where('login_status', 0)->where('employee_status', 1)->get() as $user)
        <option value="{{ $user->finger_print_id }}">{{ $user->name }}</option>
    @endforeach
</select>

        </div>
        <div class="mb-3">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="0">Select Status</option>
                <option value="Present">Present</option>
                <option value="Absent">Absent</option>
                <option value="Leave">Leave</option>
                <option value="Half">Half</option>
                <option value="Late">Late</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit Attendance</button>
    </form>

    <h3 class="mt-5">Attendance Records</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>User</th>
                <th>Date</th>
                <th>Check In</th>
                <th>Check In Status</th>
                <th>Break Out</th>
                <th>Break Out Status</th>
                <th>Break In</th>
                <th>Break In Status</th>
                <th>Check-out</th>
                <th>Check Out Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendances as $attendance)
                <tr>
                    <td>{{ $attendance->user->name }}</td>
                    <td>{{ $attendance->date }}</td>
                    <td>{{ $attendance->check_in }}</td>
                    <td>{{ $attendance->check_in_status }}</td>
                    <td>{{ $attendance->break_in_status }}</td>
                    <td>{{ $attendance->break_in }}</td>
                    <td>{{ $attendance->break_out }}</td>
                    <td>{{ $attendance->break_out_status }}</td>
                    <td>{{ $attendance->check_out }}</td>
                    <td>{{ $attendance->check_out_status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('attendance.sync') }}" class="btn btn-success">Sync with ZKTeco</a>
</div>
@endsection


