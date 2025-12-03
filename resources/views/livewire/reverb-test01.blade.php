<div class="max-w-full mx-auto p-6" id="reverb-test-component">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Job Progress Real-time Monitoring Demo</h2>

        <!-- Task information card -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <span class="text-sm text-gray-600">Task ID:</span>
                    <p class="text-sm font-mono text-gray-800">{{ $taskId ?? 'Not started' }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Status:</span>
                    <span
                        class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $isRunning ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $isRunning ? 'Running' : 'Idle' }}
                    </span>
                </div>
            </div>

            <!-- Progress bar -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-700">Progress</span>
                    <span class="text-sm font-semibold text-gray-700">{{ number_format($progress, 1) }}%</span>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">
                    <div
                        class="h-full bg-gradient-to-r from-blue-500 to-green-500 transition-all duration-500 ease-out rounded-full flex items-center justify-center"
                        style="width: {{ $progress }}%"
                    >
                        @if($progress > 0 && $progress < 100)
                            <span class="text-xs text-white font-bold">{{ $currentStep }}/{{ $totalSteps }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status message -->
            <div class="p-3 bg-white rounded border border-gray-200">
                <span class="text-sm text-gray-600">Current Status:</span>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $message }}</p>
            </div>
        </div>

        <!-- Control buttons -->
        <div class="flex gap-4">
            @if(!$isRunning)
                <button
                    wire:click="startTask"
                    class="px-6 py-3 bg-green-600 rounded-lg font-semibold hover:bg-green-700 transition-colors shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                >
                    Start Task
                </button>
            @else
                <button
                    disabled
                    class="px-6 py-3 bg-amber-500 text-white rounded-lg font-semibold cursor-not-allowed shadow-md border-2 border-amber-600 opacity-90"
                >
                    ⏳ Task Running...
                </button>
            @endif

            @if($taskId)
                <button
                    wire:click="resetTask"
                    class="px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    Reset
                </button>
            @endif
        </div>

        <!-- Steps list -->
        @if($taskId)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-3 text-gray-800">Execution Steps</h3>
                <div class="space-y-2">
                    @for($i = 1; $i <= $totalSteps; $i++)
                        <div
                            class="flex items-center gap-3 p-2 rounded {{ $i <= $currentStep ? 'bg-green-50 border border-green-200' : ($i == $currentStep + 1 && $isRunning ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50') }}">
                            <div
                                class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center font-semibold text-xs {{ $i < $currentStep ? 'bg-green-500 text-white' : ($i == $currentStep ? 'bg-yellow-500 text-white animate-pulse' : 'bg-gray-300 text-gray-600') }}">
                                @if($i < $currentStep)
                                    ✓
                                @elseif($i == $currentStep && $isRunning)
                                    ⟳
                                @else
                                    {{ $i }}
                                @endif
                            </div>
                            <span
                                class="text-sm {{ $i <= $currentStep ? 'text-green-800 font-semibold' : ($i == $currentStep + 1 && $isRunning ? 'text-yellow-800' : 'text-gray-600') }}">
                                Step {{ $i }}: {{ $i <= $currentStep ? 'Completed' : ($i == $currentStep + 1 && $isRunning ? 'In Progress...' : 'Waiting') }}
                            </span>
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
                // Laravel Echo automatically prepends a dot for namespaced events
                channel.listen('.App.Events.TaskProgressUpdated', (data) => {
                    console.log('📨 Received progress update event');
                    console.log('   Channel:', channelName);
                    console.log('   Data received:', JSON.stringify(data, null, 2));

                    const component = Livewire.find(componentId);
                    if (component) {
                        console.log('🔄 Updating Livewire component...');
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
                });

                console.log('✅ Event listener registered for TaskProgressUpdated');
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
