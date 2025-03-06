<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use maliklibs\Zkteco\Lib\ZKTeco;

class AttendanceController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:attendance-create', ['only' => ['index', 'show']]);
    }

    public function index(Request $request)
    {
        // Ensure user is authenticated
        if (!Auth::check()) {
            abort(403, 'Unauthorized action.');
        }

        $auth = Auth::user();
        $query = Attendance::where('company_id', $auth->company_id);

        // Filter by Employee
        if ($request->filled('employee')) {
            $query->where('user_id', $request->employee);
        }

        // Filter by Single Date or Date Range
        if ($request->filled('from_date')) {
            $fromDate = Carbon::parse($request->from_date);

            if ($request->filled('to_date')) {
                $toDate = Carbon::parse($request->to_date);
                $query->whereBetween('date', [$fromDate, $toDate]);
            } else {
                $query->whereDate('date', $fromDate);
            }
        }

        $attendances = $query->get();

        return view('attendance.index', compact('attendances'));
    }



    // Store Manual Attendance
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,finger_print_id',
            'date' => 'required|date',
            'status' => 'required|in:Present,Absent,Leave,Half,Late'
        ]);
        $auth = Auth::user();
        $attendance = new Attendance();
        $attendance->user_id = $request->user_id;
        $attendance->date = $request->date;
        $attendance->company_id = $auth->company_id;
        $attendance->check_in_status = $request->status;
        $attendance->save();

        return redirect()->back()->with('success', 'Attendance Recorded Successfully');
    }

    // Fetch Attendance from ZKTeco Device

    public function fetchAttendanceFromZKTeco()
    {
        $auth = Auth::user();
        $zk = new ZKTeco('192.168.110.200', 4370, 5);

        if ($zk->connect()) {
            $attendances = $zk->getAttendance();
            $presentUserIds = []; // Track users who have attendance

            foreach ($attendances as $att) {
                $user = User::where('finger_print_id', $att['id'])
                    ->where('type', 'Employee')
                    ->where('employee_status', 1)
                    ->where('company_id', $auth->company_id)
                    ->first();

                if ($user) {
                    $companyId = $user->company_id;
                    $presentUserIds[] = $user->finger_print_id; // Track present users

                    // Convert from Pakistan Time (Asia/Karachi) to America/Denver
                    $attendanceTime = Carbon::createFromFormat('Y-m-d H:i:s', $att['timestamp'], 'Asia/Karachi')
                        ->setTimezone('America/Denver');

                    $today = $attendanceTime->toDateString(); // Ensure correct date

                    // Fetch existing attendance record or create a new one
                    $attendance = Attendance::firstOrNew([
                        'user_id' => $user->finger_print_id,
                        'date' => $today,
                    ]);

                    $attendance->company_id = $companyId;

                    // Update fields based on work_code_label
                    if ($att['work_code_label'] == 'Check-in') {
                        $attendance->check_in = $attendanceTime->toTimeString();
                        $attendance->check_in_status = ($attendanceTime->format('H:i') >= '06:06') ? 'Late' : 'Present';
                    } elseif ($att['work_code_label'] == 'Break-in') {
                        $attendance->break_in = $attendanceTime->toTimeString();
                        $attendance->break_in_status = 'Break';
                    } elseif ($att['work_code_label'] == 'Break-out') {
                        $attendance->break_out = $attendanceTime->toTimeString();
                        $attendance->break_out_status = ($attendanceTime->format('H:i') <= '10:05') ? 'On time' : 'Break Late';
                    } elseif ($att['work_code_label'] == 'Check-out') {
                        $attendance->check_out = $attendanceTime->toTimeString();
                        $attendance->check_out_status = ($attendanceTime->format('H:i') >= '15:00') ? 'Check-out' : 'Check-out-quickly';
                    }

                    $attendance->save();
                }
            }

            // // Get all active employees
            // $allEmployees = User::where('type', 'Employee')
            //     ->where('employee_status', 1)
            //     ->where('company_id', $auth->company_id)
            //     ->pluck('finger_print_id');

            // // Get users who have already marked attendance today
            // $markedAttendanceUsers = Attendance::whereIn('user_id', $allEmployees)
            //     ->where('date', $today)
            //     ->pluck('user_id');

            // // Get users who didn't mark attendance today
            // $absentUsers = $allEmployees->diff($markedAttendanceUsers);

            // foreach ($absentUsers as $absentUserId) {
            //     $user = User::where('finger_print_id', $absentUserId)->first();

            //     if ($user) {
            //         $companyId = $user->company_id;

            //         // Ensure absence is recorded only once per day
            //         $attendance = Attendance::firstOrNew([
            //             'user_id' => $user->finger_print_id,
            //             'date' => $today,
            //         ]);

            //         if (!$attendance->exists) { // Only save if it doesn't exist
            //             $attendance->company_id = $companyId;
            //             $attendance->check_in_status = 'Absent';
            //             $attendance->check_in = null;
            //             $attendance->break_in = null;
            //             $attendance->break_out = null;
            //             $attendance->check_out = null;
            //             $attendance->save();
            //         }
            //     }
            // }

            return redirect()->back()->with('success', 'Attendance Synced Successfully');
        } else {
            return redirect()->back()->withErrors(['error' => 'Unable to connect to the device']);
        }
    }




    // Edit Attendance Record
    public function edit($encryptedId)
    {
        $id = decrypt($encryptedId);
        $attendance = Attendance::findOrFail($id);

        return view('attendance.edit', compact('attendance'));
    }
    // Update Attendance Status (Present/Absent)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Present,Absent'
        ]);

        $attendance = Attendance::findOrFail($id);
        $attendance->check_in_status = $request->status;
        $attendance->save();

        return redirect()->route('attendance.index')->with('success', 'Attendance status updated successfully!');
    }

    // Delete Attendance Record
    public function destroy($id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->delete();

        return redirect()->route('attendance.index')->with('success', 'Attendance record deleted successfully!');
    }
}
