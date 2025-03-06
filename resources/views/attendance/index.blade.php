@extends('layouts.app', ['page' => __('Attendance List'), 'pageSlug' => 'users', 'section' => 'users'])


@section('content')
    <!--**********************************
                                    Content body start
                                ***********************************-->
    <div class="content-body" style="margin-top: 30px;min-height: 89vh!important;">
        <div class="container-fluid">
            {{--            <div class="row page-titles mx-0" style="margin-top: -55px;margin-bottom: -4px"> --}}
            {{--                <div class="col-lg-12 p-md-0"> --}}
            {{--                    <div class="welcome-text" style="text-align: center"> --}}
            {{--                        <h1>Employee Registration</h1> --}}

            {{--                    </div> --}}
            {{--                </div> --}}

            {{--            </div> --}}
            @include('inc._message')
            <!-- row -->

            <div class="alert alert-danger " style="display: none" id="alert">
                <a href="#" class="close" aria-label="close"
                    onclick="document.getElementById('alert').style.display = 'none';">&times;</a>
                <p style="margin: auto;width: 50%;"><strong>Danger!</strong> Password not match.</p>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">

                        <div class="card-body">
                            <div class="form-validation">
                                <form class="form-valide" id="form" action="{{ route('attendance.store') }}"
                                    method="post" onsubmit="return maincheckForm()">
                                    @csrf
                                    <div class="container">
                                        <h2>Manual Attendance Entry</h2>

                                        @if (session('success'))
                                            <div class="alert alert-success">{{ session('success') }}</div>
                                        @endif

                                        <form action="{{ route('attendance.store') }}" method="POST">
                                            @csrf
                                            <div class="mb-3">
                                                <label>User</label>
                                                @php
                                                    use Illuminate\Support\Facades\Auth;
                                                    use App\Models\User;

                                                    $companyId = Auth::user()->company_id; // Get the authenticated user's company_id
                                                    $employees = User::where('type', 'Employee')
                                                        ->where('employee_status', 1)
                                                        ->where('company_id', $companyId) // Filter by company_id
                                                        ->get();
                                                @endphp

                                                <select name="user_id" class="form-control" id="user_id">
                                                    <option value="0">Select Employee</option>
                                                    @foreach ($employees as $user)
                                                        <option value="{{ $user->finger_print_id }}">{{ $user->name }}
                                                        </option>
                                                    @endforeach
                                                </select>


                                            </div>
                                            <div class="mb-3">
                                                <label>Date</label>
                                                <input type="date" name="date" class="form-control" id="date">
                                            </div>
                                            <div class="mb-3">
                                                <label>Status</label>
                                                <select name="status" class="form-control" id="status">
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
                                        <form action="{{ route('attendance.index') }}" method="GET">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="from_date">From Date</label>
                                                    <input type="text" name="from_date" id="from_date"
                                                        class="form-control" value="{{ request('from_date') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="to_date">To Date</label>
                                                    <input type="text" name="to_date" id="to_date" class="form-control"
                                                        value="{{ request('to_date') }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="employee">Employee</label>
                                                    @php
                                                        $companyId = Auth::user()->company_id; // Get logged-in user's company_id
                                                        $employees = User::where('type', 'Employee')
                                                            ->where('employee_status', 1)
                                                            ->where('company_id', $companyId) // Filter by company_id
                                                            ->get();
                                                    @endphp

                                                    <select name="employee" id="employee" class="form-control">
                                                        <option value="">Select Employee</option>
                                                        @foreach ($employees as $user)
                                                            <option value="{{ $user->finger_print_id }}"
                                                                {{ request('employee') == $user->finger_print_id ? 'selected' : '' }}>
                                                                {{ $user->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                </div>
                                            </div>
                                            <button type="submit" class="btn btn-primary mt-2">Filter</button>
                                            <a href="{{ route('attendance.index') }}" class="btn btn-secondary">Reset</a>
                                        </form>
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
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($attendances as $attendance)
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
                                                        <td>
                                                            <a href="{{ route('attendance.edit', encrypt($attendance->id)) }}"
                                                                class="btn btn-sm btn-info"><i class="fas fa-edit"></i></a>
                                                            <form
                                                                action="{{ route('attendance.destroy', $attendance->id) }}"
                                                                method="POST" style="display:block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Are you sure?')"><i
                                                                        class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <a href="{{ route('attendance.sync') }}" class="btn btn-success">Sync with
                                            ZKTeco</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!--**********************************
                                    Content body end
                                ***********************************-->
@endsection
@section('script')

    <script>
        function maincheckForm() {
            let user_id = document.getElementById("user_id"),
                date = document.getElementById("date"),
                status = document.getElementById("status");

            let validateInputIdArray = [user_id, date, status];

            let isValid = validateInventoryInputs(validateInputIdArray);

            return isValid;
        }

        function validateInventoryInputs(inputElements) {
            let isValid = true;

            inputElements.forEach(input => {
                // Reset previous validation styles
                $(input).removeClass('bg-danger');
                $(input).next(".select2").find('.select2-selection').removeClass('border-danger'); // For Select2

                if (input.value.trim() === "" || input.value == "0") {
                    if ($(input).hasClass("select2-hidden-accessible")) {
                        // If it's a Select2 element
                        $(input).next(".select2").find('.select2-selection').addClass('border-danger');
                    } else {
                        $(input).addClass('bg-danger'); // For normal inputs like date
                    }
                    isValid = false;
                }
            });

            return isValid;
        }

        $(document).ready(function() {
            $("#user_id, #status, #employee").select2(); // Initialize Select2
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function(event) {
                    if (!confirm('Are you sure you want to delete this record?')) {
                        event.preventDefault();
                    }
                });
            });
        });
    </script>

@stop
