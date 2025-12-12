<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Bulk Import Students') }}
            </h2>
            <a href="{{ route('students.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition">
                Back to Students
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Success!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    @if(session('success_count'))
                        <p class="mt-2">Total students imported: <strong>{{ session('success_count') }}</strong></p>
                    @endif
                </div>
            @endif

            @if(session('errors_list') && count(session('errors_list')) > 0)
                <div class="mb-6 bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative">
                    <strong class="font-bold">Validation Errors:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach(session('errors_list') as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Instructions -->
                    <div class="mb-6 bg-blue-50 border-l-4 border-blue-500 p-4">
                        <h3 class="text-lg font-semibold text-blue-700 mb-2">Instructions</h3>
                        <ul class="list-disc list-inside text-sm text-blue-600 space-y-1">
                            <li>Upload a CSV file containing student data</li>
                            <li>First row must be the header with column names</li>
                            <li>Required columns: <code class="bg-blue-100 px-1">first_name</code>, <code class="bg-blue-100 px-1">last_name</code>, <code class="bg-blue-100 px-1">email</code>, <code class="bg-blue-100 px-1">college_id</code></li>
                            <li>Optional columns: <code class="bg-blue-100 px-1">phone_number</code>, <code class="bg-blue-100 px-1">degree_id</code>, <code class="bg-blue-100 px-1">specialization</code>, <code class="bg-blue-100 px-1">year_of_study</code>, <code class="bg-blue-100 px-1">start_year</code>, <code class="bg-blue-100 px-1">end_year</code>, <code class="bg-blue-100 px-1">date_of_birth</code> (YYYY-MM-DD), <code class="bg-blue-100 px-1">active_status</code> (1 or 0)</li>
                            <li>Passwords will be auto-generated and sent via email</li>
                        </ul>
                    </div>

                    <!-- CSV Template Download -->
                    <div class="mb-6">
                        <a href="data:text/csv;charset=utf-8,first_name,last_name,email,phone_number,college_id,degree_id,specialization,year_of_study,start_year,end_year,date_of_birth,active_status%0AJohn,Doe,john.doe@example.com,1234567890,1,1,Computer Science,2,2020,2024,2000-01-15,1" 
                           download="student_import_template.csv"
                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            Download CSV Template
                        </a>
                    </div>

                    <!-- Upload Form -->
                    <form action="{{ route('students.import') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div>
                            <label for="csv_file" class="block text-sm font-medium text-gray-700 mb-2">
                                CSV File <span class="text-red-500">*</span>
                            </label>
                            <input type="file" 
                                   id="csv_file" 
                                   name="csv_file" 
                                   accept=".csv,.txt"
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('csv_file') border-red-500 @enderror" 
                                   required>
                            @error('csv_file')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-sm text-gray-500">Maximum file size: 5MB</p>
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4">
                            <a href="{{ route('students.index') }}" class="px-6 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 font-medium transition-colors">
                                Cancel
                            </a>
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition-colors">
                                Import Students
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
