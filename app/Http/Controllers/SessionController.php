<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    private $course_name, $course_code, $venue;
    public function __construct()
    {
        $this->course_name = "Hello";
        $this->course_code = "";
        $this->venue = "";
    }

    public function start_session(Request $request)
    {
        // $lecturer_id = Auth::user()->id;
        // $lecturer_name = Auth::user()->name;
        // $lecturer_email = Auth::user()->email;

        // set parameters from session form
        $course_name = "Hello";
        $course_code = "";
        $venue = "";
        $schedule_id = 1;
        $start_time = Carbon::now("UTC");
        $end_time = Carbon::now("UTC")->addMinutes(30);


        return view('take-attendance', compact(['course_name', 'venue', 'course_code', 'end_time']));
    }

    public function recognize(Request $request)
    {
        try {

            $request->validate([
                'image' => 'required|image|max:10240', // Max 10MB
            ]);

            $sid = $request->student_id;
            // Save the image temporarily
            $imagePath = $request->file('image')->store('temp');

            // Send the image to your Python API
            $response = Http::timeout(30)->attach(
                'image',
                file_get_contents(storage_path('app/' . $imagePath)),
                'image.png'
            )->post('http://127.0.0.1:3000/recognize');

            \Log::info('Python API response: ' . $response->body());

            // Delete the temporary image
            unlink(storage_path('app/' . $imagePath));

            if ($response->successful()) {
                $data = $response->json();

                if (!isset($data['student_id']) && $data['status'] != "success") {
                    throw new \Exception($data['message']);
                }

                // get the student details
                $student_id = $data['student_id'];
                $student = Student::find($student_id);

                Log::info($student_id);

                $attendanceToday = Attendance::where('student_id', $student_id)
                    ->whereDate('date', now())
                    ->first();

                if ($attendanceToday->schedules_id == 1) {

                    return response()->json([
                    'status' => 'success',
                    'message' => 'Attendance already taken',
                    'student' => $student,
                ]);

                } else {
                    // Attendance does not exist for today
                    //    mark attendance here
                    $attendance = new Attendance();
                    $attendance->student_id = $student_id;
                    $attendance->course_id = 1;
                    $attendance->schedules_id = 1;
                    $attendance->status = "present";
                    $attendance->date = now()->toDate();
                    $attendance->time_in = Carbon::now('UTC');
                    $attendance->save();
                }

                //TODO: implement attendance logiv here



                return response()->json([
                    'status' => 'success',
                    'message' => 'Attendance recorded',
                    'student' => $student,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => $response->body(),
                ], 500);
            }
        } catch (\Exception $e) {
            \Log::error('Error in getEncodings: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }
}
