<div class="max-w-full mx-auto" id="reverb-test-component">
    <!-- Modern glassmorphism card with gradient background -->
    <div class="relative overflow-hidden rounded-2xl shadow-2xl backdrop-blur-xl bg-gradient-to-br from-white/95 to-gray-50/95 dark:from-gray-800/95 dark:to-gray-900/95 border border-gray-200/50 dark:border-gray-700/50 p-8">
        <!-- Decorative gradient overlay -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-blue-400/10 to-purple-400/10 dark:from-blue-500/20 dark:to-purple-500/20 rounded-full blur-3xl -z-10"></div>
        
        <h2 class="text-3xl font-bold mb-8 bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent">Job Progress Real-time Monitoring</h2>

        <!-- Task information card with modern styling -->
        <div class="mb-8 p-6 rounded-xl bg-gradient-to-br from-blue-50/50 to-purple-50/50 dark:from-blue-900/20 dark:to-purple-900/20 border border-blue-100 dark:border-blue-800/30 backdrop-blur-sm">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">Task ID</span>
                    <p class="text-sm font-mono mt-1 text-gray-700 dark:text-gray-200 bg-white/50 dark:bg-gray-800/50 px-3 py-1.5 rounded-lg">{{ $taskId ?? 'Not started' }}</p>
                </div>
                <div>
                    <span class="text-xs font-semibold uppercase tracking-wider text-blue-600 dark:text-blue-400">Status</span>
                    <div class="mt-1">
                        <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-semibold {{ $isRunning ? 'bg-gradient-to-r from-amber-400 to-orange-400 text-white shadow-lg shadow-amber-500/50' : 'bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 text-gray-700 dark:text-gray-200' }}">
                            @if($isRunning)
                                <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                            @endif
                            {{ $isRunning ? 'Running' : 'Idle' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Modern progress bar -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm font-bold text-gray-700 dark:text-gray-200">Progress</span>
                    <span class="text-lg font-bold bg-gradient-to-r from-blue-600 to-purple-600 dark:from-blue-400 dark:to-purple-400 bg-clip-text text-transparent">{{ number_format($progress, 1) }}%</span>
                </div>
                <div class="relative w-full bg-gray-200/50 dark:bg-gray-700/50 rounded-full h-6 overflow-hidden shadow-inner">
                    <div
                        class="h-full bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 transition-all duration-700 ease-out rounded-full flex items-center justify-center shadow-lg relative overflow-hidden"
                        style="width: {{ $progress }}%"
                    >
                        <!-- Animated shimmer effect -->
                        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent animate-shimmer"></div>
                        @if($progress > 0 && $progress < 100)
                            <span class="text-xs text-white font-bold z-10 drop-shadow-lg">{{ $currentStep }}/{{ $totalSteps }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status message with modern card -->
            <div class="p-4 bg-white/70 dark:bg-gray-800/70 rounded-xl border border-gray-200/50 dark:border-gray-600/50 backdrop-blur-sm">
                <span class="text-xs font-semibold uppercase tracking-wider text-gray-500 dark:text-gray-400">Current Status</span>
                <p class="text-base font-semibold text-gray-800 dark:text-gray-100 mt-2 flex items-center gap-2">
                    @if($isRunning)
                        <span class="flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-3 w-3 rounded-full bg-blue-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-blue-500"></span>
                        </span>
                    @endif
                    {{ $message }}
                </p>
            </div>
        </div>

        <!-- Modern control buttons -->
        <div class="flex gap-4 mt-8">
            @if(!$isRunning)
                <button
                    wire:click="startTask"
                    class="group relative px-8 py-3.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white rounded-xl font-bold shadow-lg shadow-green-500/50 hover:shadow-xl hover:shadow-green-500/60 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-green-500/50"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Start Task
                    </span>
                </button>
            @else
                <button
                    disabled
                    class="relative px-8 py-3.5 bg-gradient-to-r from-amber-400 to-orange-500 text-white rounded-xl font-bold shadow-lg shadow-amber-500/50 cursor-not-allowed overflow-hidden"
                >
                    <span class="flex items-center gap-3">
                        <svg class="w-5 h-5 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Task Running...
                    </span>
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/20 to-transparent animate-shimmer"></div>
                </button>
            @endif

            @if($taskId)
                <button
                    wire:click="resetTask"
                    class="px-8 py-3.5 bg-gradient-to-r from-red-500 to-pink-600 hover:from-red-600 hover:to-pink-700 text-white rounded-xl font-bold shadow-lg shadow-red-500/50 hover:shadow-xl hover:shadow-red-500/60 transition-all duration-300 transform hover:scale-105 focus:outline-none focus:ring-4 focus:ring-red-500/50"
                >
                    <span class="flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                        Reset
                    </span>
                </button>
            @endif
        </div>

        <!-- Modern steps list -->
        @if($taskId)
            <div class="mt-10">
                <h3 class="text-xl font-bold mb-6 text-gray-800 dark:text-gray-100 flex items-center gap-2">
                    <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    Execution Steps
                </h3>
                <div class="space-y-3">
                    @for($i = 1; $i <= $totalSteps; $i++)
                        <div
                            class="group flex items-center gap-4 p-4 rounded-xl transition-all duration-300 {{ $i <= $currentStep ? 'bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/30 dark:to-emerald-900/30 border-2 border-green-300 dark:border-green-700 shadow-md' : ($i == $currentStep + 1 && $isRunning ? 'bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-900/30 dark:to-orange-900/30 border-2 border-amber-300 dark:border-amber-700 shadow-lg animate-pulse' : 'bg-gray-50/50 dark:bg-gray-800/50 border border-gray-200 dark:border-gray-700') }}">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center font-bold text-sm shadow-lg transition-all duration-300 {{ $i < $currentStep ? 'bg-gradient-to-br from-green-400 to-emerald-600 text-white scale-110' : ($i == $currentStep ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white animate-bounce' : 'bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-600 dark:to-gray-700 text-gray-600 dark:text-gray-300') }}">
                                @if($i < $currentStep)
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                @elseif($i == $currentStep && $isRunning)
                                    <svg class="w-6 h-6 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                @else
                                    {{ $i }}
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    <span class="text-base font-bold {{ $i <= $currentStep ? 'text-green-700 dark:text-green-300' : ($i == $currentStep + 1 && $isRunning ? 'text-amber-700 dark:text-amber-300' : 'text-gray-600 dark:text-gray-400') }}">
                                        Step {{ $i }}
                                    </span>
                                    <span class="text-sm {{ $i <= $currentStep ? 'text-green-600 dark:text-green-400' : ($i == $currentStep + 1 && $isRunning ? 'text-amber-600 dark:text-amber-400' : 'text-gray-500 dark:text-gray-500') }}">
                                        {{ $i <= $currentStep ? '✓ Completed' : ($i == $currentStep + 1 && $isRunning ? '⚡ In Progress...' : '⏳ Waiting') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        // Initialize when Livewire is ready
        document.addEventListener('livewire:init', () => {
            console.log('✓ Livewire initialized, setting up Echo listeners');

            // Ensure Echo is available
            if (typeof Echo === 'undefined') {
                console.error('✗ Echo is not defined. Please ensure Laravel Echo is loaded.');
                return;
            }

            console.log('✓ Echo is available:', {
                connector: Echo.connector?.name || 'unknown',
                options: {
                    key: Echo.connector?.options?.key || 'not set',
                    wsHost: Echo.connector?.options?.wsHost || 'not set',
                    wsPort: Echo.connector?.options?.wsPort || 'not set',
                }
            });

            let channel = null;

            // Listen to Livewire events to start/stop listening
            Livewire.on('task-started', (event) => {
                const taskId = event[0] || event.taskId;
                console.log('📢 Received task-started event, task ID:', taskId);

                // Disconnect previous connection
                if (channel) {
                    console.log('🔌 Leaving previous channel:', channel.name);
                    Echo.leave(channel.name);
                    channel = null;
                }

                // Get component ID via DOM element
                const componentElement = document.getElementById('reverb-test-component');
                const componentId = componentElement ? componentElement.getAttribute('wire:id') : null;

                if (!componentId) {
                    console.error('✗ Component ID not found');
                    return;
                }

                console.log('✓ Component ID:', componentId);

                // Listen for progress updates of the new task
                const channelName = `task-progress.${taskId}`;
                console.log('🔗 Subscribing to private channel:', channelName);
                
                channel = Echo.private(channelName);

                // Add subscription success callback
                channel.subscribed(() => {
                    console.log('✅ Channel subscription successful:', channelName);
                    console.log('   Listening for event: .App.Events.TaskProgressUpdated');
                });

                // Add error callback
                channel.error((error) => {
                    console.error('❌ Channel subscription error:', error);
                    console.error('   Channel:', channelName);
                    console.error('   Error details:', JSON.stringify(error, null, 2));
                });

                // Listen for the TaskProgressUpdated event
                // Try multiple event name formats to ensure compatibility
                
                // Format 1: With namespace and dot prefix (Laravel Echo default)
                channel.listen('.App.Events.TaskProgressUpdated', (data) => {
                    console.log('📨 Received event (format 1): .App.Events.TaskProgressUpdated');
                    updateComponentState(data, componentId);
                });

                // Format 2: Just the class name
                channel.listen('TaskProgressUpdated', (data) => {
                    console.log('📨 Received event (format 2): TaskProgressUpdated');
                    updateComponentState(data, componentId);
                });

                // Format 3: With namespace but no dot
                channel.listen('App.Events.TaskProgressUpdated', (data) => {
                    console.log('📨 Received event (format 3): App.Events.TaskProgressUpdated');
                    updateComponentState(data, componentId);
                });

                // Helper function to update component state
                function updateComponentState(data, componentId) {
                    console.log('🔄 Updating Livewire component...');
                    console.log('   Data received:', JSON.stringify(data, null, 2));

                    const component = Livewire.find(componentId);
                    if (component) {
                        console.log('   Component ID:', componentId);
                        console.log('   Current state:', {
                            currentStep: component.get('currentStep'),
                            progress: component.get('progress'),
                            message: component.get('message')
                        });

                        // Update component state
                        component.set('currentStep', data.currentStep);
                        component.set('progress', data.progress);
                        component.set('message', data.message);

                        console.log('✅ Component state updated:', {
                            currentStep: data.currentStep,
                            progress: data.progress,
                            message: data.message
                        });

                        // If task is completed, set running status to false
                        if (data.progress >= 100) {
                            setTimeout(() => {
                                component.set('isRunning', false);
                                console.log('✅ Task completed, set isRunning to false');
                            }, 1000);
                        }
                    } else {
                        console.error('❌ Unable to find Livewire component');
                        console.error('   Component ID:', componentId);
                        console.error('   Available components:', Object.keys(Livewire.all()));
                    }
                }

                // 🔍 DEBUG: Listen to ALL events on this channel (fallback)
                channel.listenToAll((eventName, data) => {
                    console.log('🔔 Received ANY event on channel:', channelName);
                    console.log('   Event name:', eventName);
                    console.log('   Event data:', data);
                    
                    // Fallback: Update component if event name contains 'TaskProgressUpdated'
                    if (eventName.includes('TaskProgressUpdated')) {
                        console.log('🔄 Fallback: Updating component via listenToAll');
                        updateComponentState(data, componentId);
                    }
                });

                console.log('✅ Event listeners registered for TaskProgressUpdated');
                console.log('   Listening for multiple event name formats');
                console.log('   Waiting for messages on channel:', channelName);
            });

            // Listen to reset event
            Livewire.on('task-reset', () => {
                if (channel) {
                    console.log('🔌 Disconnecting from channel:', channel.name);
                    Echo.leave(channel.name);
                    channel = null;
                    console.log('✅ Channel disconnected');
                }
            });

            console.log('✅ Livewire event listeners registered');
        });

        // Add global error handler for debugging
        window.addEventListener('error', (event) => {
            console.error('🚨 Global error:', event.error);
        });

        // Log WebSocket connection status
        if (typeof Echo !== 'undefined' && Echo.connector) {
            Echo.connector.pusher.connection.bind('state_change', (states) => {
                console.log('🔌 WebSocket state change:', {
                    previous: states.previous,
                    current: states.current
                });
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
