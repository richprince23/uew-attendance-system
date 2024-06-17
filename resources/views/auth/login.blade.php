@extends('layouts.auth')

@section('title', 'Login')
@section('content')

    <div class="">
        <h2 class="text-3xl md:text-6xl text-center text-white">UEW Attendance System</h2>
        <img src="/images/logo.png" alt="" class="w-32 my-12 mx-auto">
        <div class="flex justify-center">
            <section class=" w-full md:w-3/5 border-white rounded-lg border-2 px-8 py-6 md:px-32 md:py-16">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <h2 class="text-2xl md:text-4xl text-center text-white">Login</h2>
                    <div class="form-group">
                        <label for="email" class="text-white">Email</label>
                        <input type="email" name="email" id="email" class="form-control @error('email') border-red-500 border-2 @enderror" name="email" value="{{ old('email') }}" placeholder="Email" required>
                        @error('email')
                            <span class="text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-white">Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') border-red-500 border-2 @enderror"  placeholder="Password" required>
                        @error('password')
                            <span class="text-red-500 text-sm" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn-primary">Login</button>
                    </div>

                </form>
            </section>
        </div>
        <footer class="mt-8">
            <p class="text-center text-white">UEW Attendance System &copy; @php
                echo date('Y');
            @endphp
                ARK Softwarez. All rights reserved.
            </p>
        </footer>
    </div>
@endsection
