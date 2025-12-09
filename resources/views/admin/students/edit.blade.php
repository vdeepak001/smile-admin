<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Edit Student') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('students.update', $student) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- College Selection -->
                        <div>
                            <x-input-label for="college_id" :value="__('Select College')" />
                            <select id="college_id" name="college_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select College</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->college_id }}" {{ old('college_id', $student->user->college_id ?? '') == $college->college_id ? 'selected' : '' }}>
                                        {{ $college->college_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('college_id')" class="mt-2" />
                        </div>

                        <!-- Degree Selection -->
                        <div>
                            <x-input-label for="degree_id" :value="__('Select Degree')" />
                            <select id="degree_id" name="degree_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">Select Degree (Optional)</option>
                                @foreach($degrees as $degree)
                                    <option value="{{ $degree->id }}" {{ old('degree_id', $student->degree_id ?? '') == $degree->id ? 'selected' : '' }}>
                                        {{ $degree->name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('degree_id')" class="mt-2" />
                        </div>

                        <!-- Specialization -->
                        <div>
                            <x-input-label for="specialization" :value="__('Specialization')" />
                            <x-text-input id="specialization" name="specialization" type="text" class="mt-1 block w-full" 
                                          :value="old('specialization', $student->specialization)" 
                                          placeholder="e.g., Computer Science, Information Technology" />
                            <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
                        </div>

                        <!-- Year of Study -->
                        <div>
                            <x-input-label for="year_of_study" :value="__('Year of Study')" />
                            <input type="number" id="year_of_study" name="year_of_study" 
                                   value="{{ old('year_of_study', $student->year_of_study) }}" 
                                   min="1" max="10"
                                   class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" 
                                   placeholder="e.g., 1, 2, 3">
                            <x-input-error :messages="$errors->get('year_of_study')" class="mt-2" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- User Details -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">User Details</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="first_name" :value="__('First Name')" />
                                        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $student->user->first_name)" required />
                                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="last_name" :value="__('Last Name')" />
                                        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $student->user->last_name)" required />
                                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="email" :value="__('Email')" />
                                        <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $student->user->email)" required />
                                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                    </div>

                                    <div>
                                        <x-input-label for="phone_number" :value="__('Phone Number')" />
                                        <x-text-input id="phone_number" name="phone_number" type="text" class="mt-1 block w-full" :value="old('phone_number', $student->user->phone_number)" />
                                        <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
                                    </div>


                                </div>
                            </div>

                            <!-- Student Details -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-4 border-b border-gray-200 pb-2">Student Details</h3>
                                
                                <div class="space-y-4">
                                    <div>
                                        <x-input-label for="enrollment_no" :value="__('Enrollment No')" />
                                        <x-text-input id="enrollment_no" name="enrollment_no" type="text" class="mt-1 block w-full bg-gray-100 cursor-not-allowed" :value="old('enrollment_no', $student->enrollment_no)" readonly disabled />
                                        <x-input-error :messages="$errors->get('enrollment_no')" class="mt-2" />
                                    </div>



                                    <div>
                                        <x-input-label for="date_of_birth" :value="__('Date of Birth')" />
                                        <x-text-input id="date_of_birth" name="date_of_birth" type="date" class="mt-1 block w-full" :value="old('date_of_birth', $student->date_of_birth?->format('Y-m-d'))" />
                                        <x-input-error :messages="$errors->get('date_of_birth')" class="mt-2" />
                                    </div>

                                    <div>
                                        <label for="course_ids" class="block text-sm font-medium text-gray-700 mb-2">
                                            {{ __('Assign Courses') }}
                                        </label>
                                        <select 
                                            id="course_ids" 
                                            name="course_ids[]" 
                                            multiple 
                                            size="5"
                                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent @error('course_ids') border-red-500 @enderror"
                                        >
                                            @foreach($courses as $course)
                                                <option value="{{ $course->course_id }}" 
                                                    {{ in_array($course->course_id, old('course_ids', $student->courses->pluck('course_id')->toArray())) ? 'selected' : '' }}
                                                >
                                                    {{ $course->course_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <p class="mt-1 text-sm text-gray-500">Hold Ctrl (Cmd on Mac) to select multiple courses</p>
                                        @error('course_ids')
                                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>


                                    <div class="flex items-center space-x-2 mt-6">
                                        <input type="checkbox" id="active_status" name="active_status" value="1" {{ old('active_status', $student->active_status) ? 'checked' : '' }} class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <label for="active_status" class="text-sm font-medium text-gray-700">Active Status</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-4 mt-6">
                            <a href="{{ route('students.index') }}" class="text-gray-500 hover:text-gray-700 transition-colors">Cancel</a>
                            <x-primary-button>
                                {{ __('Update Student') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
