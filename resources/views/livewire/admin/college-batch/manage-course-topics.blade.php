<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumb -->
            <div class="mb-6">
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('college-info.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                                Colleges
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <a href="{{ route('college-batches.index', $collegeId) }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2">
                                    {{ $college->college_name }} - Batches
                                </a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="ml-1 text-sm font-bold text-gray-900 md:ml-2">{{ $batch->batch_id }}</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

           
            <!-- Batch Information -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8 border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50 border-b border-gray-200">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Titles Enabled</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-900">{{ $batch->batch_id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $course->course_name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700">{{ $batch->start_date ? \Carbon\Carbon::parse($batch->start_date)->format('d M Y') : '-' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700">{{ $batch->end_date ? \Carbon\Carbon::parse($batch->end_date)->format('d M Y') : '-' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-700 text-center">Type {{ $batch->batch_type ?? '-' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-center font-semibold {{ $batch->active_status ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $batch->active_status ? 'Enabled' : 'Disabled' }}
                                    </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Topic Selection -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-100 mb-8">
                <div class="px-6 py-4 bg-white border-b border-gray-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-[#2B3674]">Select Topics</h3>
                    <button wire:click="toggleSelectAll" class="text-sm font-bold text-[#422AFB] hover:text-[#422AFB]/80 transition-colors">
                        {{ count($selected_topics) === count($availableTopics) ? 'Deselect All' : 'Select All Topics' }}
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse">
                        <thead class="bg-[#DFEDFF]">
                            <tr>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-[#5A6A85] uppercase tracking-wider border-r border-[#E5E9F2] w-16">#</th>
                                <th class="px-6 py-4 text-left text-sm font-semibold text-[#5A6A85] uppercase tracking-wider border-r border-[#E5E9F2]">Topic Name</th>
                                <th class="px-6 py-4 text-right text-sm font-semibold text-[#5A6A85] uppercase tracking-wider w-32">Selection</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @forelse($availableTopics as $index => $topic)
                                <tr class="{{ $index % 2 === 0 ? 'bg-[#F6FAFF]' : 'bg-white' }}">
                                    <td class="px-6 py-4 border-r border-[#E5E9F2] font-bold text-gray-800">{{ $index + 1 }}</td>
                                    <td class="px-6 py-4 border-r border-[#E5E9F2] text-gray-700 font-medium">{{ $topic->topic_name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <input type="checkbox" id="topic-{{ $topic->topic_id }}" value="{{ $topic->topic_id }}" 
                                            wire:click="toggleTopic({{ $topic->topic_id }})" 
                                            {{ in_array($topic->topic_id, $selected_topics) ? 'checked' : '' }} 
                                            class="w-5 h-5 text-[#422AFB] border-gray-300 rounded focus:ring-[#422AFB]">
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-12 text-center text-gray-500">
                                        No topics found for this course.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex justify-end space-x-4 mb-12">
                <a href="{{ route('college-batches.index', $collegeId) }}" 
                    class="px-6 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button wire:click="save" 
                    class="px-6 py-2 bg-gradient-to-r from-purple-600 to-blue-600 text-white font-semibold rounded-lg hover:from-purple-700 hover:to-blue-700 transition-all duration-200 shadow-md hover:shadow-lg">
                    Save Selection
                </button>
            </div>
        </div>
    </div>
</div>
