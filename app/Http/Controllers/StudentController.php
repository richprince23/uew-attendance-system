<?php

namespace App\Http\Controllers;

use App\Models\Recognitions;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{

    public function getEncodings(Request $request)
{
    try {
        $request->validate([
            'image' => 'required|image|max:10240', // Max 10MB
            'student_id' => 'required|exists:students,id',
        ]);

        $sid = $request->student_id;
        // Save the image temporarily
        $imagePath = $request->file('image')->store('temp');

        \Log::info('Image saved at: ' . $imagePath);
        \Log::info('Image mime type: ' . $request->file('image')->getMimeType());
        \Log::info('Image size: ' . filesize(storage_path('app/' . $imagePath)) . ' bytes');

        // Send the image to your Python API
        $response = Http::timeout(30)->attach(
            'image', file_get_contents(storage_path('app/' . $imagePath)), 'image.png'
        )->post('http://127.0.0.1:3000/register', ['student_id' => $sid]);

        \Log::info('Python API response: ' . $response->body());

        // Delete the temporary image
        unlink(storage_path('app/' . $imagePath));

        if ($response->successful()) {
            $data = $response->json();

            if (!isset($data['encodings'])) {
                throw new \Exception($data['message']);
            }

            $encodings = $data['encodings'];
            // remove all \n from encodings
            $encodings = str_replace( "\n", "", $encodings);
            // dd($encodings);
            // json_encode($data['encodings']);
            // Save the results to the database
            $recognition = new Recognitions();
            $recognition->student_id = $sid;
            $recognition->face_encoding = $encodings;
            $recognition->save();

            return response()->json([
                'success' => true,
                'message' => 'Facial recognition data saved successfully.',
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
