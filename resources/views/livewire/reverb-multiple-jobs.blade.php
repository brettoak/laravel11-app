<div class="max-w-full mx-auto" id="reverb-multiple-jobs-component">
    <!-- Main Control Panel -->
    <div class="relative overflow-hidden rounded-2xl shadow-2xl backdrop-blur-xl bg-gradient-to-br from-white/95 to-gray-50/95 dark:from-gray-800/95 dark:to-gray-900/95 border border-gray-200/50 dark:border-gray-700/50 p-8">
        <!-- Decorative gradient overlay -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-400/10 to-purple-400/10 dark:from-blue-500/20 dark:to-purple-500/20 rounded-full blur-3xl -z-10"></div>

        <!-- Header -->
        <div class="mb-8">
            <p class="text-gray-600 dark:text-gray-400">Run multiple tasks concurrently and monitor progress in real-time</p>
        </div>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="p-6 rounded-xl bg-gradient-to-br from-blue-50/50 to-blue-100/50 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-700/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-blue-600 dark:text-blue-400 mb-1">Total Jobs</p>
                        <p class="text-3xl font-bold text-blue-700 dark:text-blue-300">{{ count($jobs) }}</p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-blue-500/20 flex items-center justify-center">
                        <svg class="w-8 h-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-xl bg-gradient-to-br from-green-50/50 to-green-100/50 dark:from-green-900/20 dark:to-green-800/20 border border-green-200 dark:border-green-700/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-green-600 dark:text-green-400 mb-1">Running</p>
                        <p class="text-3xl font-bold text-green-700 dark:text-green-300">
                            {{ collect($jobs)->where('isRunning', true)->count() }}
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-green-500/20 flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="p-6 rounded-xl bg-gradient-to-br from-purple-50/50 to-purple-100/50 dark:from-purple-900/20 dark:to-purple-800/20 border border-purple-200 dark:border-purple-700/30">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-purple-600 dark:text-purple-400 mb-1">Completed</p>
                        <p class="text-3xl font-bold text-purple-700 dark:text-purple-300">
                            {{ collect($jobs)->where('progress', '>=', 100)->count() }}
                        </p>
                    </div>
                    <div class="w-14 h-14 rounded-full bg-purple-500/20 flex items-center justify-center">
                        <svg class="w-8 h-8 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Control Buttons -->
        <div class="flex flex-wrap gap-4">
            <button
                wire:click="startTask"
                class="group relative px-8 py-3.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl font-bold shadow-lg shadow-green-500/50 hover:shadow-xl hover:shadow-green-500/60 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-500/50"
            >
                <span class="flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    New Task
                </span>
            </button>

            <!-- Batch Create Dropdown -->
            <div class="relative" x-data="{ open: false }">
                <button
                    @click="open = !open"
                    class="px-8 py-3.5 bg-gradient-to-r from-purple-500 to-pink-600 hover:from-purple-600 hover:to-pink-700 text-white rounded-xl font-bold shadow-lg shadow-purple-500/50 hover:shadow-xl hover:shadow-purple-500/60 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-purple-500/50"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 14v6m-3-3h6M6 10h2a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2zm10 0h2a2 2 0 002-2V6a2 2 0 00-2-2h-2a2 2 0 00-2 2v2a2 2 0 002 2zM6 20h2a2 2 0 002-2v-2a2 2 0 00-2-2H6a2 2 0 00-2 2v2a2 2 0 002 2z"></path>
                        </svg>
                        Batch Create
                        <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </span>
                </button>

                <!-- Dropdown Menu -->
                <div
                    x-show="open"
                    @click.away="open = false"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 transform scale-100"
                    x-transition:leave-end="opacity-0 transform scale-95"
                    class="absolute left-0 mt-2 w-48 rounded-xl shadow-2xl bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 overflow-hidden z-10"
                    style="display: none;"
                >
                    <div class="py-2">
                        <button
                            wire:click="startMultipleTasks(3)"
                            @click="open = false"
                            class="w-full px-4 py-2.5 text-left hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-colors flex items-center gap-3"
                        >
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 font-bold">3</span>
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">3 Tasks</span>
                        </button>
                        <button
                            wire:click="startMultipleTasks(5)"
                            @click="open = false"
                            class="w-full px-4 py-2.5 text-left hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-colors flex items-center gap-3"
                        >
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 font-bold">5</span>
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">5 Tasks</span>
                        </button>
                        <button
                            wire:click="startMultipleTasks(10)"
                            @click="open = false"
                            class="w-full px-4 py-2.5 text-left hover:bg-purple-50 dark:hover:bg-purple-900/30 transition-colors flex items-center gap-3"
                        >
                            <span class="flex items-center justify-center w-8 h-8 rounded-lg bg-purple-100 dark:bg-purple-900/50 text-purple-600 dark:text-purple-400 font-bold">10</span>
                            <span class="text-gray-700 dark:text-gray-300 font-semibold">10 Tasks</span>
                        </button>
                    </div>
                </div>
            </div>

            @if(count($jobs) > 0)
                <button
                    wire:click="clearCompleted"
                    class="px-8 py-3.5 bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white rounded-xl font-bold shadow-lg shadow-blue-500/50 hover:shadow-xl hover:shadow-blue-500/60 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-blue-500/50"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Clear Completed
                    </span>
                </button>

                <button
                    wire:click="clearAll"
                    class="px-8 py-3.5 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white rounded-xl font-bold shadow-lg shadow-red-500/50 hover:shadow-xl hover:shadow-red-500/60 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-red-500/50"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Clear All
                    </span>
                </button>
            @endif
        </div>

        <!-- Empty State -->
        @if(count($jobs) === 0)
            <div class="mt-12 text-center py-16">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 mb-6">
                    <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-700 dark:text-gray-300 mb-2">No active tasks</h3>
                <p class="text-gray-500 dark:text-gray-400">Click "New Task" to get started</p>
            </div>
        @endif
    </div>

    <!-- Floating Progress Window (Bottom Right) -->
    @if(count($jobs) > 0)
        <div
            class="fixed bottom-6 right-6 w-96 max-h-[600px] overflow-hidden rounded-2xl shadow-2xl backdrop-blur-xl bg-white/95 dark:bg-gray-800/95 border border-gray-200/50 dark:border-gray-700/50 z-50 transition-all duration-300"
            x-data="{ expanded: true }"
        >
            <!-- Header -->
            <div class="p-4 bg-gradient-to-r from-blue-500 to-purple-600 text-white flex items-center justify-between cursor-pointer" @click="expanded = !expanded">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-white/20 flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-bold text-lg">Active Tasks</h3>
                        <p class="text-xs text-white/80">{{ count($jobs) }} tasks running</p>
                    </div>
                </div>
                <button class="p-2 hover:bg-white/10 rounded-lg transition-colors">
                    <svg
                        class="w-5 h-5 transition-transform duration-300"
                        :class="expanded ? 'rotate-180' : ''"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <!-- Debug Indicator -->
                <div class="hidden">Debug: {{ count($jobs) }} jobs</div>
            </div>

            <!-- Jobs List -->
            <div
                class="overflow-y-auto max-h-[500px] custom-scrollbar"
                x-show="expanded"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform translate-y-0"
                x-transition:leave-end="opacity-0 transform -translate-y-2"
            >
                <div class="p-4 space-y-3">
                    @foreach($jobs as $taskId => $job)
                        <div
                            wire:key="{{ $taskId }}"
                            class="group p-4 rounded-xl transition-all duration-300 {{ $job['isRunning'] ? 'bg-gradient-to-br from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 border-2 border-amber-300 dark:border-amber-700' : ($job['progress'] >= 100 ? 'bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border-2 border-green-300 dark:border-green-700' : 'bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600') }}"
                            data-task-id="{{ $taskId }}"
                        >
                            <!-- Job Header -->
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        @if($job['isRunning'])
                                            <span class="flex h-2.5 w-2.5">
                                                <span class="animate-ping absolute inline-flex h-2.5 w-2.5 rounded-full bg-amber-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-amber-500"></span>
                                            </span>
                                        @elseif($job['progress'] >= 100)
                                            <span class="flex h-2.5 w-2.5 bg-green-500 rounded-full"></span>
                                        @else
                                            <span class="flex h-2.5 w-2.5 bg-gray-400 rounded-full"></span>
                                        @endif
                                        <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">
                                            Task #{{ substr($taskId, 0, 8) }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Created at {{ $job['createdAt'] }}</p>
                                </div>
                                <button
                                    wire:click="removeJob('{{ $taskId }}')"
                                    class="p-1.5 hover:bg-red-100 dark:hover:bg-red-900/30 rounded-lg transition-colors group"
                                    title="Remove task"
                                >
                                    <svg class="w-4 h-4 text-gray-400 group-hover:text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>

                            <!-- Progress Bar -->
                            <div class="mb-2">
                                <div class="flex justify-between items-center mb-1.5">
                                    <span class="text-xs font-semibold text-gray-600 dark:text-gray-300">Progress</span>
                                    <span class="text-sm font-bold {{ $job['progress'] >= 100 ? 'text-green-600 dark:text-green-400' : 'text-amber-600 dark:text-amber-400' }}">
                                        {{ number_format($job['progress'], 1) }}%
                                    </span>
                                </div>
                                <div class="relative w-full bg-gray-200/50 dark:bg-gray-600/50 rounded-full h-2 overflow-hidden">
                                    <div
                                        class="h-full transition-all duration-700 ease-out rounded-full {{ $job['progress'] >= 100 ? 'bg-gradient-to-r from-green-500 to-emerald-500' : 'bg-gradient-to-r from-amber-500 to-orange-500' }}"
                                        style="width: {{ $job['progress'] }}%"
                                    >
                                        @if($job['isRunning'])
                                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer"></div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Status Message -->
                            <div class="flex items-center gap-2">
                                @if($job['isRunning'])
                                    <svg class="w-3.5 h-3.5 text-amber-500 animate-spin flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                @elseif($job['progress'] >= 100)
                                    <svg class="w-3.5 h-3.5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @endif
                                <p class="text-xs {{ $job['isRunning'] ? 'text-amber-700 dark:text-amber-300' : ($job['progress'] >= 100 ? 'text-green-700 dark:text-green-300' : 'text-gray-600 dark:text-gray-400') }} truncate">
                                    {{ $job['message'] }}
                                </p>
                            </div>

                            <!-- Step Counter -->
                            <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                Step: <span class="font-semibold">{{ $job['currentStep'] }}</span> / {{ $totalSteps }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>

@push('styles')
    <style>
        @keyframes shimmer {
            0% {
                transform: translateX(-100%);
            }
            100% {
                transform: translateX(100%);
            }
        }

        .animate-shimmer {
            animation: shimmer 2s infinite;
        }

        /* Custom Scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.2);
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.3);
        }

        .dark .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
@endpush

@push('scripts')
    <script>
        // Initialize when Livewire is ready
        document.addEventListener('livewire:init', () => {
            console.log('✓ Multiple Jobs Component - Livewire initialized');

            // Ensure Echo is available
            if (typeof Echo === 'undefined') {
                console.error('✗ Echo is not defined. Please ensure Laravel Echo is loaded.');
                return;
            }

            console.log('✓ Echo is available');

            // Store active channels
            const activeChannels = new Map();

            // Listen to task-started event
            Livewire.on('task-started', (event) => {
                const taskId = event[0] || event.taskId;
                console.log('📢 New task started:', taskId);

                // Get component ID
                const componentElement = document.getElementById('reverb-multiple-jobs-component');
                const componentId = componentElement ? componentElement.getAttribute('wire:id') : null;

                if (!componentId) {
                    console.error('✗ Component ID not found');
                    return;
                }

                // Subscribe to task progress channel
                const channelName = `task-progress.${taskId}`;
                console.log('🔗 Subscribing to channel:', channelName);

                const channel = Echo.private(channelName);

                // Store channel reference
                activeChannels.set(taskId, channel);

                // Subscription callbacks
                channel.subscribed(() => {
                    console.log('✅ Subscribed to:', channelName);
                });

                channel.error((error) => {
                    console.error('❌ Subscription error:', error);
                });

                // Listen for progress updates
                channel.listen('.App.Events.TaskProgressUpdated', (data) => {
                    console.log('📨 Progress update for task:', taskId, data);
                    updateJobProgress(taskId, data, componentId);
                });

                // Fallback listeners
                channel.listen('TaskProgressUpdated', (data) => {
                    updateJobProgress(taskId, data, componentId);
                });

                channel.listen('App.Events.TaskProgressUpdated', (data) => {
                    updateJobProgress(taskId, data, componentId);
                });

                // Listen to all events (debug)
                channel.listenToAll((eventName, data) => {
                    console.log('🔔 Event on channel:', channelName, 'Event:', eventName);
                    if (eventName.includes('TaskProgressUpdated')) {
                        updateJobProgress(taskId, data, componentId);
                    }
                });
            });

            // Listen to task-removed event
            Livewire.on('task-removed', (event) => {
                const taskId = event[0] || event.taskId;
                console.log('🗑️ Task removed:', taskId);

                // Disconnect from channel
                if (activeChannels.has(taskId)) {
                    const channel = activeChannels.get(taskId);
                    Echo.leave(channel.name);
                    activeChannels.delete(taskId);
                    console.log('✅ Disconnected from channel for task:', taskId);
                }
            });

            // Listen to notifications
            Livewire.on('notification', (data) => {
                const notification = data[0] || data;
                console.log('🔔 Notification:', notification);
                // Simple alert for now, can be replaced with a toast library
                alert(`${notification.type.toUpperCase()}: ${notification.message}`);
            });

            // Helper function to update job progress
            function updateJobProgress(taskId, data, componentId) {
                console.log('🔄 Updating job progress:', taskId, data);

                const component = Livewire.find(componentId);
                if (!component) {
                    console.error('❌ Component not found:', componentId);
                    return;
                }

                // Get current jobs
                const jobs = component.get('jobs');

                if (jobs && jobs[taskId]) {
                    // Update job data
                    jobs[taskId].currentStep = data.currentStep;
                    jobs[taskId].progress = data.progress;
                    jobs[taskId].message = data.message;

                    // Set running status
                    if (data.progress >= 100) {
                        jobs[taskId].isRunning = false;
                    }

                    // Update component
                    component.set('jobs', jobs);

                    console.log('✅ Job updated:', taskId, {
                        currentStep: data.currentStep,
                        progress: data.progress,
                        message: data.message
                    });
                }
            }

            console.log('✅ Multiple Jobs event listeners registered');
        });

        // WebSocket connection status logging
        if (typeof Echo !== 'undefined' && Echo.connector) {
            Echo.connector.pusher.connection.bind('state_change', (states) => {
                console.log('🔌 WebSocket state:', states.previous, '→', states.current);
            });

            Echo.connector.pusher.connection.bind('connected', () => {
                console.log('✅ WebSocket connected');
            });

            Echo.connector.pusher.connection.bind('disconnected', () => {
                console.warn('⚠️ WebSocket disconnected');
            });

            Echo.connector.pusher.connection.bind('error', (error) => {
                console.error('❌ WebSocket error:', error);
            });
        }
    </script>
@endpush
