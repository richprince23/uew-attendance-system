<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Schedules;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SessionController extends Controller
{
    private $course_name, $course_id, $venue, $schedules_id;
    public function __construct()
    {
        $this->course_name = "Hello";
        $this->course_id = "";
        $this->venue = "";
        $this->schedules_id = "";

    }

    public function start_session(Request $request)
    {
        $start_time = Carbon::now("UTC");
        $course_name = session('course_name');
        $course_id = session('course_id');
        $venue = session('venue');
        $duration = session('duration');
        $schedules_id = session('schedules_id');
        $end_time = Carbon::now("UTC")->addMinutes($duration);

        //logout lecturer after session start
        auth()->logout();

        return view('take-attendance', compact(['course_name', 'venue', 'end_time', 'duration', 'schedules_id', 'course_id']));
    }


    public function configSession(Request $request)
    {
        $request->validate([
            'venue' => 'required|string|max:255',
            'duration' => 'required|integer|min:10',
            'schedules_id' => 'required|exists:schedules,id',
        ]);

        $schedule = Schedules::where('schedules.id', $request['schedules_id'])
            ->join('courses', 'schedules.course_id', 'courses.id')
            ->first();

        if (!$schedule) {
            return response()->json(['message' => 'Schedule not found.'], 404);
        }

        $course_name = $schedule->course_name;
        $venue = $request['venue'];
        $duration = (int) $request['duration'];  // Cast to integer
        $scheduleId = $request['schedules_id'];
        $courseId = $schedule->course_id;

        session(['course_name' => $course_name, 'venue' => $venue, 'duration' => $duration, 'schedules_id' => $scheduleId, 'course_id' => $courseId]);

        // $start_time = Carbon::now("UTC");
        // $end_time = Carbon::now("UTC")->addMinutes($duration);

        return response()->json([
            'course_name' => $course_name,
            'venue' => $venue,
            'duration' => $duration,
            'schedules_id' => $scheduleId,
            'success' => true,
            'message' => 'Session started successfully'
        ], 200);
    }

    /**
     * Clear session data
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function clearSession(Request $request)
    {
        $scheduleId = $request->input('schedule_id');

        // Clear the session data related to attendance for the specific schedule
        session()->forget(['course_name', 'venue', 'duration', 'schedules_id', 'course_id']);

        return response()->json([
            'message' => 'Attendance session ended',
            'schedule_id' => $scheduleId
        ], 200);
    }


    /**
     * Recognize face from a captured image by processing it at Flask backedn
     * @param \Illuminate\Http\Request $request
     * @throws \Exception
     * @return mixed|\Illuminate\Http\JsonResponse
     */
    public function recognize(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|max:10240', // Max 10MB
            ]);

            $sid = $request->student_id;
            // Save the image temporarily
            $imagePath = $request->file('image')->store('temp');
            // Get schedule id
            $schedules_id = session('schedules_id');
            // Get course id
            $courseId = session('course_id');

            Log::info("Schedule Id : " . $schedules_id);
            Log::info("Course Id : " . $courseId);

            // Call the Flask backend to process the image
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

                // Get the student details
                $student_id = $data['student_id'];
                $student = Student::find($student_id);

                Log::info($student_id);

                // Check if there's an attendance record for today
                $attendanceToday = Attendance::where('student_id', $student_id)
                    ->whereDate('date', now()->toDateString())
                    ->first();

                if ($attendanceToday) {
                    // Check if the attendance is for the correct schedule
                    if ($attendanceToday->schedules_id == $schedules_id) {
                        return response()->json([
                            'status' => 'success',
                            'message' => 'Attendance already taken',
                            'student' => $student,
                        ]);
                    } else {
                        // Attendance does not exist for the correct schedule
                        // Mark attendance here
                        $attendance = new Attendance();
                        $attendance->student_id = $student_id;
                        $attendance->course_id = $courseId;
                        $attendance->schedules_id = $schedules_id;
                        $attendance->status = "present";
                        $attendance->date = now()->toDateString();
                        $attendance->time_in = Carbon::now('UTC');
                        $attendance->save();

                        return response()->json([
                            'status' => 'success',
                            'message' => 'Attendance recorded',
                            'student' => $student,
                        ]);
                    }
                } else {
                    // No attendance record for today, so create one
                    $attendance = new Attendance();
                    $attendance->student_id = $student_id;
                    $attendance->course_id = $courseId;
                    $attendance->schedules_id = $schedules_id;
                    $attendance->status = "present";
                    $attendance->date = now()->toDateString();
                    $attendance->time_in = Carbon::now('UTC');
                    $attendance->save();

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Attendance recorded',
                        'student' => $student,
                    ]);
                }
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
