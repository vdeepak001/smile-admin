<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Student Details') }}
            </h2>
            <a href="{{ route('college.students.index') }}" class="text-white hover:text-gray-200 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Basic Information Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-2xl font-bold text-gray-900">Basic Information</h3>
                        @if ($student->active_status)
                            <span
                                class="inline-flex px-3 py-1 text-sm font-semibold leading-5 text-green-800 bg-green-100 rounded-full">
                                Active
                            </span>
                        @else
                            <span
                                class="inline-flex px-3 py-1 text-sm font-semibold leading-5 text-red-800 bg-red-100 rounded-full">
                                Inactive
                            </span>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Personal Information -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Personal
                                Details</h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Full Name</label>
                                <p class="mt-1 text-base text-gray-900">{{ $student->user->name }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Email Address</label>
                                <p class="mt-1 text-base text-gray-900">{{ $student->user->email }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Phone Number</label>
                                <p class="mt-1 text-base text-gray-900">{{ $student->user->phone_number ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Date of Birth</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ $student->date_of_birth ? $student->date_of_birth->format('F d, Y') : 'N/A' }}
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Gender</label>
                                <p class="mt-1 text-base text-gray-900 capitalize">{{ $student->user->gender ?? 'N/A' }}
                                </p>
                            </div>
                        </div>

                        <!-- Academic Information -->
                        <div class="space-y-4">
                            <h4 class="text-lg font-semibold text-gray-800 border-b border-gray-200 pb-2">Academic
                                Details</h4>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Enrollment Number</label>
                                <p class="mt-1 text-base text-gray-900 font-mono">{{ $student->enrollment_no }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Roll Number</label>
                                <p class="mt-1 text-base text-gray-900">{{ $student->roll_number ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Degree</label>
                                <p class="mt-1 text-base text-gray-900">{{ $student->degree->name ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Specialization</label>
                                <p class="mt-1 text-base text-gray-900">{{ $student->specialization ?? 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Year of Study</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ $student->year_of_study ? 'Year ' . $student->year_of_study : 'N/A' }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Academic Period</label>
                                <p class="mt-1 text-base text-gray-900">
                                    @if ($student->start_year && $student->end_year)
                                        {{ $student->start_year }} - {{ $student->end_year }}
                                    @elseif($student->start_year)
                                        {{ $student->start_year }} - Present
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Information -->
                    @if ($student->guardian_name || $student->user->address)
                        <div class="mt-6 pt-6 border-t border-gray-200">
                            <h4 class="text-lg font-semibold text-gray-800 mb-4">Additional Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @if ($student->guardian_name)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Guardian Name</label>
                                        <p class="mt-1 text-base text-gray-900">{{ $student->guardian_name }}</p>
                                    </div>
                                @endif

                                @if ($student->user->address)
                                    <div>
                                        <label class="block text-sm font-medium text-gray-500">Address</label>
                                        <p class="mt-1 text-base text-gray-900">{{ $student->user->address }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    <!-- Registration Information -->
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-lg font-semibold text-gray-800 mb-4">Registration Information</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-500">Registered On</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ $student->created_at->format('F d, Y h:i A') }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-500">Last Updated</label>
                                <p class="mt-1 text-base text-gray-900">
                                    {{ $student->updated_at->format('F d, Y h:i A') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Courses Card -->
          

            <!-- Back Button -->
            <div class="mt-6 flex justify-end">
                <a href="{{ route('college.students.index') }}"
                    class="inline-flex items-center px-6 py-3 bg-gray-600 text-white font-medium rounded-lg hover:bg-gray-700 transition-colors shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Students List
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
