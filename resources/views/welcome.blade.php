<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="School Attendance System with Facial Recognition">
    <title>School Attendance System</title>
    @vite('resources/sass/app.scss')
    <!-- Tailwind CSS -->
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
</head>

<body class="font-sans antialiased bg-gray-100">
    @php
        $app = \App\Models\Settings::first() ?? null;
    @endphp
    <!-- Header -->
    <header class="bg-white shadow-lg py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-gray-800">{{optional($app)->app_name ?? 'Biometric Attendance System'}}</h1>
            <nav class="space-x-6">
                <a href="#features" class="text-gray-600 hover:text-gray-900">Features</a>
                <a href="#pricing" class="text-gray-600 hover:text-gray-900">Pricing</a>
                <a href="#about" class="text-gray-600 hover:text-gray-900">About</a>
                <a href="#contact" class="text-gray-600 hover:text-gray-900">Contact</a>
                <a href="/admin/login" class="text-gray-600 hover:text-gray-900 border-2 border-blue-600 px-4 py-3 rounded-lg">Login</a>
            </nav>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-blue-600 text-white py-20">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center px-4 sm:px-6 lg:px-8">

            <!-- Left Side: Text Content -->
            <div class="lg:w-1/2 text-center lg:text-left">
                <h2 class="text-4xl font-extrabold">Revolutionize School Attendance with Facial Recognition</h2>
                <p class="mt-4 text-lg">Our cutting-edge School Attendance System uses facial recognition technology to
                    automate attendance tracking, providing real-time insights and streamlining your school's
                    operations.</p>
                <div class="mt-8 space-x-4">
                    <a href="/lecturer/login" class="bg-white text-blue-600 px-6 py-3 rounded-lg font-semibold">For Lecturers</a>
                    <a href="/student/login"
                        class="bg-transparent border border-white px-6 py-3 rounded-lg font-semibold">For Students</a>
                </div>

            </div>

            <!-- Right Side: Image -->
            <div class="lg:w-1/2 mt-10 lg:mt-0">
                <img src="/images/banner.png" alt="Facial Recognition System"
                    class="rounded-lg shadow-lg mx-auto h-96 object-cover">
            </div>

        </div>
    </section>


    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-800">Key Features</h3>
            <p class="mt-4 text-lg text-gray-600">Streamline Your School's Attendance Tracking</p>
            <div class="mt-10 grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-gray-50 p-6 rounded-lg shadow">
                    <h4 class="text-xl font-semibold text-gray-800">Automated Attendance Tracking</h4>
                    <p class="mt-4 text-gray-600">Our facial recognition technology automatically records student
                        attendance, eliminating manual processes and ensuring accurate data.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow">
                    <h4 class="text-xl font-semibold text-gray-800">Real-Time Attendance Reports</h4>
                    <p class="mt-4 text-gray-600">Access real-time attendance data and generate detailed reports to
                        monitor student attendance and identify trends.</p>
                </div>
                <div class="bg-gray-50 p-6 rounded-lg shadow">
                    <h4 class="text-xl font-semibold text-gray-800">Easy Integration</h4>
                    <p class="mt-4 text-gray-600">Our system seamlessly integrates with your existing school management
                        software, ensuring a smooth transition and streamlined operations.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section -->
    <section id="pricing" class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-800">Affordable Pricing for Schools of All Sizes</h3>
            <p class="mt-4 text-lg text-gray-600">Our School Attendance System offers flexible pricing plans to fit the
                needs of your school, ensuring a cost-effective solution that delivers maximum value.</p>
            <div class="mt-8 space-x-4">
                <a href="#" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold">View Pricing</a>
                <a href="#"
                    class="bg-transparent border border-blue-600 px-6 py-3 rounded-lg font-semibold">Request Demo</a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-800">About Our School Attendance System</h3>
            <p class="mt-4 text-lg text-gray-600">Our School Attendance System is a cutting-edge solution designed to
                revolutionize the way schools track and manage student attendance. Leveraging the power of facial
                recognition technology, we provide a seamless and efficient way to automate attendance tracking,
                empowering schools to focus on their core mission of education.</p>
            <a href="#" class="mt-8 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold">Learn
                More</a>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="py-20 bg-gray-100">
        <div class="max-w-7xl mx-auto text-center px-4 sm:px-6 lg:px-8">
            <h3 class="text-3xl font-bold text-gray-800">Get in Touch</h3>
            <p class="mt-4 text-lg text-gray-600">Have questions or ready to schedule a demo? Our team is here to help.
                Contact us today to learn more about our School Attendance System and how it can benefit your school.
            </p>
            <a href="#"
                class="mt-8 inline-block bg-blue-600 text-white px-6 py-3 rounded-lg font-semibold">Contact Us</a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8 px-4 sm:px-6 lg:px-8">
            <div>
                <h4 class="font-semibold text-lg">Company</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="hover:underline">About Us</a></li>
                    <li><a href="#" class="hover:underline">Our Team</a></li>
                    <li><a href="#" class="hover:underline">Careers</a></li>
                    <li><a href="#" class="hover:underline">News</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-lg">Products</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="hover:underline">School Attendance System</a></li>
                    <li><a href="#" class="hover:underline">Visitor Management</a></li>
                    <li><a href="#" class="hover:underline">Reporting & Analytics</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-lg">Resources</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="hover:underline">Blog</a></li>
                    <li><a href="#" class="hover:underline">Documentation</a></li>
                    <li><a href="#" class="hover:underline">Support</a></li>
                    <li><a href="#" class="hover:underline">FAQs</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-semibold text-lg">Legal</h4>
                <ul class="mt-4 space-y-2">
                    <li><a href="#" class="hover:underline">Privacy Policy</a></li>
                    <li><a href="#" class="hover:underline">Terms of Service</a></li>
                    <li><a href="#" class="hover:underline">Cookie Policy</a></li>
                </ul>
            </div>
        </div>
    </footer>

</body>

</html>
