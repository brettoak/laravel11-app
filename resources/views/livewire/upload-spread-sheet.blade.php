<div class="max-w-7xl mx-auto p-6">
    <!-- Main Control Panel -->
    <div class="relative rounded-2xl shadow-2xl backdrop-blur-xl bg-gradient-to-br from-white/95 to-gray-50/95 dark:from-gray-800/95 dark:to-gray-900/95 border border-gray-200/50 dark:border-gray-700/50 p-8">
        <!-- Decorative gradient overlay (contained) -->
        <div class="absolute inset-0 overflow-hidden rounded-2xl pointer-events-none -z-10">
            <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-400/10 to-purple-400/10 dark:from-blue-500/20 dark:to-purple-500/20 rounded-full blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-emerald-400/10 to-teal-400/10 dark:from-emerald-500/20 dark:to-teal-500/20 rounded-full blur-3xl"></div>
        </div>

        <!-- Header -->
        <div class="mb-8 flex justify-between items-start">
            <div>
                <h2 class="text-3xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-800 to-gray-600 dark:from-white dark:to-gray-300">
                    Upload Spreadsheet
                </h2>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Import CSV or Excel files to preview and process data.</p>
            </div>
            
            @if(!empty($headers))
                <button
                    wire:click="clear"
                    class="px-6 py-2.5 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white rounded-xl font-bold shadow-lg shadow-red-500/30 hover:shadow-red-500/40 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-red-500/30 flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Clear Data
                </button>
            @endif
        </div>

        <!-- content -->
        <div class="grid grid-cols-1 gap-8">
            
            @if(empty($headers))
                <!-- Upload Area -->
                <div 
                    x-data="{ dragging: false }"
                    @dragover.prevent="dragging = true"
                    @dragleave.prevent="dragging = false"
                    @drop.prevent="dragging = false"
                    class="relative"
                >
                    <label 
                        for="file-upload" 
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-2xl cursor-pointer transition-all duration-300 group"
                        :class="dragging ? 'border-blue-500 bg-blue-50/50 dark:bg-blue-900/20' : 'border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-gray-50 dark:hover:bg-gray-800/50'"
                    >
                        <div class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                            
                            <!-- Default State -->
                            <div wire:loading.remove wire:target="file">
                                <div class="w-16 h-16 mb-4 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-8 h-8 text-blue-500 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                </div>
                                <p class="mb-2 text-lg text-gray-700 dark:text-gray-300"><span class="font-semibold text-blue-600 dark:text-blue-400">Click to upload</span> or drag and drop</p>
                                <p class="text-sm text-gray-500 dark:text-gray-400">CSV, XLSX, XLS (Max 10MB)</p>
                            </div>

                            <!-- Loading State -->
                            <div wire:loading wire:target="file" class="absolute inset-0 flex flex-col items-center justify-center bg-white/80 dark:bg-gray-900/80 rounded-2xl backdrop-blur-sm z-10">
                                <svg class="w-12 h-12 text-blue-500 animate-spin mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                <p class="text-blue-600 dark:text-blue-400 font-medium animate-pulse">Processing file...</p>
                            </div>

                        </div>
                        <input id="file-upload" type="file" wire:model="file" class="hidden" accept=".csv, .xlsx, .xls" />
                    </label>

                    @error('file') 
                        <div class="mt-3 p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-xl flex items-center gap-3 text-red-700 dark:text-red-400 animate-fadeIn">
                            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <span class="text-sm font-medium">{{ $message }}</span>
                        </div>
                    @enderror
                </div>
            @else
                <!-- Data Preview -->
                <div class="bg-white/50 dark:bg-gray-800/50 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden shadow-inner">
                    <div class="p-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-900/50 flex justify-between items-center">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-green-100 dark:bg-green-900/30 rounded-lg">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-800 dark:text-gray-200">Data Preview</h3>
                                <p class="text-xs text-gray-500 font-medium">Showing first 100 rows</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-xs font-bold border border-blue-200 dark:border-blue-800">
                            {{ count($rows) }} Rows
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-100/80 dark:bg-gray-700/80 dark:text-gray-300">
                                <tr>
                                    @foreach($headers as $header)
                                        <th scope="col" class="px-6 py-4 font-bold border-b dark:border-gray-700 whitespace-nowrap">
                                            {{ $header }}
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($rows as $row)
                                    <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                        @foreach($row as $cell)
                                            <td class="px-6 py-3 whitespace-nowrap text-gray-600 dark:text-gray-300">
                                                {{ $cell }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="{{ count($headers) }}" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400">
                                            No data rows found in this file.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
