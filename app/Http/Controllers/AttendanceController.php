<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use maliklibs\Zkteco\Lib\ZKTeco;

class AttendanceController extends Controller
{
    // Fetch Attendance View
    public function index()
    {
        $attendances = Attendance::with('user')->get();
        return view('attendance.index', compact('attendances'));
    }

    // Store Manual Attendance
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:Present,Absent,Late'
        ]);

        Attendance::create([
            'user_id' => $request->user_id,
            'date' => $request->date,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Attendance Recorded Successfully');
    }

    // Fetch Attendance from ZKTeco Device
    public function fetchAttendanceFromZKTeco()
{
    $zk = new ZKTeco('192.168.110.200', 4370, 5);

    if ($zk->connect()) {
        $attendances = $zk->getAttendance();
        dd($attendances);

        foreach ($attendances as $att) {
            $user = User::where('id', $att['id'])->first();

            if ($user) {
                $attendanceTime = Carbon::parse($att['timestamp'])->setTimezone('Asia/Karachi');

                // Fetch existing attendance record or create a new one
                $attendance = Attendance::firstOrNew([
                    'user_id' => $user->id,
                    'date' => Carbon::now()->toDateString(),
                ]);

                // Update only the relevant field
                if ($att['work_code_label'] == 'Check-in') {
                    $attendance->check_in = $attendanceTime->toTimeString();
                    $attendance->check_in_status = ($attendanceTime->format('H:i') >= '06:06') ? 'Late' : 'Present';
                } elseif ($att['work_code_label'] == 'Break-in') {
                    $attendance->break_in_status = 'Break';
                } elseif ($att['work_code_label'] == 'Break-out') {
                    $attendance->break_out_status = ($attendanceTime->format('H:i') <= '10:00') ? 'On time' : 'Break Late';
                } elseif ($att['work_code_label'] == 'Check-out') {
                    $attendance->check_out_status = ($attendanceTime->format('H:i') >= '15:00') ? 'Check-out' : null;
                }

                $attendance->save(); // Save only the updated field
            }
        }

        return redirect()->back()->with('success', 'Attendance Synced Successfully');
    } else {
        return redirect()->back()->withErrors(['success' => 'Unable to connect to the device']);
    }
}


}

