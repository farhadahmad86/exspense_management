@extends('layouts.app', ['page' => __('Add Attendance'), 'pageSlug' => 'users', 'section' => 'users'])


@section('content')
<div class="container">
    <h2>Manual Attendance Entry</h2>
    <form action="{{ route('attendance.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="user_id">Employee:</label>
            <select name="user_id" class="form-control">
                @foreach(\App\Models\User::where('type', 'Employee')->get() as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" name="date" class="form-control">
        </div>

        <div class="form-group">
            <label for="check_in">Check In Time:</label>
            <input type="time" name="check_in" class="form-control">
        </div>

        <div class="form-group">
            <label for="check_out">Check Out Time:</label>
            <input type="time" name="check_out" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
    </form>
</div>
@endsection

