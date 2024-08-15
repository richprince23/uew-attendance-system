@extends('layouts.main')
@section('headers')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title', "Session Ended!")

@section('content')
<div class="text-center">
    <h1 class="text-3xl font-bold tracking-tight md:text-3xl">Live Attendance Session</h1>
    <br>
    <h3 class="text-2xl font-bold tracking-tight md:text-3xl my-4 text-blue-500"> {{ $course_name }}</h1>
</div>

<div>
    <h3 class="text-red-500"> Attendance Session Ended!</h3>

    <i>If you are a student, you may contact your lecturer for manual attendance recording</i>
</div>
@endsection
