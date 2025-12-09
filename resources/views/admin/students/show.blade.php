<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Student Details') }}
            </h2>
            <div class="space-x-2">
                <a href="{{ route('students.edit', $student) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    Edit
                </a>
                <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-lg font-medium text-indigo-600 mb-4">User Information</h3>
                            <dl class="space-y-4">
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">Full Name</dt>
                                    <dd class="font-medium">{{ $student->user->name }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">Email</dt>
                                    <dd class="font-medium">{{ $student->user->email }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">Phone</dt>
                                    <dd class="font-medium">{{ $student->user->phone_number ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">College</dt>
                                    <dd class="font-medium">{{ $student->user->college->college_name ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">Account Status</dt>
                                    <dd>
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $student->user->active_status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $student->user->active_status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-indigo-600 mb-4">Student Information</h3>
                            <dl class="space-y-4">
                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">Enrollment No</dt>
                                    <dd class="font-medium">{{ $student->enrollment_no }}</dd>
                                </div>

                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">Degree</dt>
                                    <dd class="font-medium">{{ $student->degree->name ?? 'N/A' }}</dd>
                                </div>

                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">Specialization</dt>
                                    <dd class="font-medium">{{ $student->specialization ?? 'N/A' }}</dd>
                                </div>

                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">Year of Study</dt>
                                    <dd class="font-medium">{{ $student->year_of_study ?? 'N/A' }}</dd>
                                </div>

                                <div class="flex justify-between border-b border-gray-200 pb-2">
                                    <dt class="text-gray-500">Date of Birth</dt>
                                    <dd class="font-medium">{{ $student->date_of_birth ? $student->date_of_birth->format('M d, Y') : 'N/A' }}</dd>
                                </div>

                            </dl>
                        </div>
                    </div>

                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <h3 class="text-lg font-medium text-indigo-600 mb-4">Assigned Courses</h3>
                        @if($student->courses && $student->courses->count() > 0)
                            <div class="flex flex-wrap gap-2">
                                @foreach($student->courses as $course)
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        {{ $course->course_name }}
                                    </span>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 italic">No courses assigned yet.</p>
                        @endif
                    </div>

                    <div class="mt-8 border-t border-gray-200 pt-6">
                        <div class="text-sm text-gray-500 flex justify-between">
                            <div>
                                Created at: {{ $student->created_at->format('M d, Y H:i') }}
                                by {{ $student->createdBy->name ?? 'System' }}
                            </div>
                            <div>
                                Last updated: {{ $student->updated_at->format('M d, Y H:i') }}
                                @if($student->updated_by)
                                    by {{ $student->updatedBy->name ?? 'System' }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
