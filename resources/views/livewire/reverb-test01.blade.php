<div class="max-w-4xl mx-auto p-6" id="reverb-test-component">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Job 进度实时监控演示</h2>

        <!-- Task information card -->
        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <span class="text-sm text-gray-600">任务 ID:</span>
                    <p class="text-sm font-mono text-gray-800">{{ $taskId ?? '未开始' }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600">状态:</span>
                    <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold {{ $isRunning ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ $isRunning ? '运行中' : '空闲' }}
                    </span>
                </div>
            </div>

            <!-- Progress bar -->
            <div class="mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-semibold text-gray-700">进度</span>
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
                <span class="text-sm text-gray-600">当前状态:</span>
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
                    启动任务
                </button>
            @else
                <button
                    disabled
                    class="px-6 py-3 bg-amber-500 text-white rounded-lg font-semibold cursor-not-allowed shadow-md border-2 border-amber-600 opacity-90"
                >
                    ⏳ 任务运行中...
                </button>
            @endif

            @if($taskId)
                <button
                    wire:click="resetTask"
                    class="px-6 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition-colors shadow-md hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2"
                >
                    重置
                </button>
            @endif
        </div>

        <!-- Steps list -->
        @if($taskId)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-3 text-gray-800">执行步骤</h3>
                <div class="space-y-2">
                    @for($i = 1; $i <= $totalSteps; $i++)
                        <div class="flex items-center gap-3 p-2 rounded {{ $i <= $currentStep ? 'bg-green-50 border border-green-200' : ($i == $currentStep + 1 && $isRunning ? 'bg-yellow-50 border border-yellow-200' : 'bg-gray-50') }}">
                            <div class="flex-shrink-0 w-6 h-6 rounded-full flex items-center justify-center font-semibold text-xs {{ $i < $currentStep ? 'bg-green-500 text-white' : ($i == $currentStep ? 'bg-yellow-500 text-white animate-pulse' : 'bg-gray-300 text-gray-600') }}">
                                @if($i < $currentStep)
                                    ✓
                                @elseif($i == $currentStep && $isRunning)
                                    ⟳
                                @else
                                    {{ $i }}
                                @endif
                            </div>
                            <span class="text-sm {{ $i <= $currentStep ? 'text-green-800 font-semibold' : ($i == $currentStep + 1 && $isRunning ? 'text-yellow-800' : 'text-gray-600') }}">
                                步骤 {{ $i }}: {{ $i <= $currentStep ? '已完成' : ($i == $currentStep + 1 && $isRunning ? '执行中...' : '等待中') }}
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
    document.addEventListener('livewire:init', () => {
        // Ensure Echo is initialized
        if (typeof Echo !== 'undefined' && typeof Livewire !== 'undefined') {
            let channel = null;

            // Listen to Livewire events to start/stop listening
            window.Livewire.on('task-started', (event) => {
                const taskId = event[0] || event.taskId;
                console.log('Received task-started event, task ID:', taskId);

                // Disconnect previous connection
                if (channel) {
                    Echo.leave(channel.name);
                    channel = null;
                }

                // Get component ID via DOM element (get when event is triggered, ensure component is mounted)
                const componentElement = document.getElementById('reverb-test-component');
                const componentId = componentElement ? componentElement.getAttribute('wire:id') : null;
                
                console.log('Component ID:', componentId);

                // Listen for progress updates of the new task
                const channelName = 'task-progress.' + taskId;
                channel = Echo.private(channelName);
                
                // Helper function to update component (defined early, for use by listeners)
                function updateComponent(data, componentId) {
                    if (componentId) {
                        const component = Livewire.find(componentId);
                        if (component) {
                            console.log('Updating component state:', data);
                            component.set('currentStep', data.currentStep);
                            component.set('progress', data.progress);
                            component.set('message', data.message);

                            // If task is completed, set running status to false
                            if (data.progress >= 100) {
                                setTimeout(() => {
                                    component.set('isRunning', false);
                                }, 1000);
                            }
                        } else {
                            console.error('Unable to find Livewire component, ID:', componentId);
                        }
                    } else {
                        console.error('Component ID is empty');
                    }
                }
                
                // Add subscription success and error callbacks
                channel.subscribed(() => {
                    console.log('Channel subscription successful: ' + channelName);
                    
                    // Set up listeners immediately after subscription success
                    // Try multiple event name formats
                    const eventListeners = [
                        '.App.Events.TaskProgressUpdated',
                        'App.Events.TaskProgressUpdated',
                        '.App\\Events\\TaskProgressUpdated',
                        'App\\Events\\TaskProgressUpdated'
                    ];
                    
                    eventListeners.forEach(eventName => {
                        channel.listen(eventName, (data) => {
                            console.log('Received progress update event (' + eventName + '):', data);
                            updateComponent(data, componentId);
                        });
                    });
                    
                    console.log('Event listeners set up, listening to events:', eventListeners);
                });
                
                channel.error((error) => {
                    console.error('Channel subscription error:', error);
                    if (error && error.message) {
                        console.error('Error message:', error.message);
                    }
                });

                console.log('Connected to task progress channel: ' + channelName);
            });

            // Listen to reset event
            window.Livewire.on('task-reset', () => {
                if (channel) {
                    Echo.leave(channel.name);
                    channel = null;
                    console.log('Disconnected from task progress channel');
                }
            });
        } else {
            console.error('Echo or Livewire not initialized, please ensure WebSocket connection is properly configured');
        }
    });
</script>
@endpush
