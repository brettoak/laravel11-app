<div class="max-w-4xl mx-auto p-6" id="reverb-test-component">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Job 进度实时监控演示</h2>

        <!-- 任务信息卡片 -->
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

            <!-- 进度条 -->
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

            <!-- 状态消息 -->
            <div class="p-3 bg-white rounded border border-gray-200">
                <span class="text-sm text-gray-600">当前状态:</span>
                <p class="text-sm font-semibold text-gray-800 mt-1">{{ $message }}</p>
            </div>
        </div>

        <!-- 控制按钮 -->
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

        <!-- 步骤列表 -->
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
        // 确保 Echo 已初始化
        if (typeof Echo !== 'undefined' && typeof Livewire !== 'undefined') {
            let channel = null;
            
            // 全局监听 Echo 连接的所有事件（用于调试）
            if (Echo.connector && Echo.connector.pusher) {
                Echo.connector.pusher.connection.bind('message', (data) => {
                    // 检查是否是任务进度频道的事件
                    if (data && data.channel && data.channel.includes('task-progress')) {
                        console.log('检测到任务进度频道的消息:', {
                            event: data.event,
                            channel: data.channel,
                            data: data.data
                        });
                        
                        // 如果事件名称包含 TaskProgressUpdated，尝试解析数据
                        if (data.event && (data.event.includes('TaskProgressUpdated') || data.event.includes('progress'))) {
                            try {
                                const eventData = typeof data.data === 'string' ? JSON.parse(data.data) : data.data;
                                console.log('解析出的事件数据:', eventData);
                                
                                // 尝试更新组件
                                const componentElement = document.getElementById('reverb-test-component');
                                const componentId = componentElement ? componentElement.getAttribute('wire:id') : null;
                                if (componentId) {
                                    const component = Livewire.find(componentId);
                                    if (component && eventData) {
                                        console.log('从原始消息更新组件:', eventData);
                                        component.set('currentStep', eventData.currentStep);
                                        component.set('progress', eventData.progress);
                                        component.set('message', eventData.message);
                                    }
                                }
                            } catch (e) {
                                console.error('解析事件数据失败:', e);
                            }
                        }
                    }
                });
                Echo.connector.pusher.connection.bind('pusher:error', (error) => {
                    console.error('Pusher 连接错误:', error);
                });
            }

            // 监听 Livewire 事件来启动/停止监听
            window.Livewire.on('task-started', (event) => {
                const taskId = event[0] || event.taskId;
                console.log('收到 task-started 事件，任务ID:', taskId);

                // 断开之前的连接
                if (channel) {
                    Echo.leave(channel.name);
                    channel = null;
                }

                // 通过 DOM 元素获取组件 ID（在事件触发时获取，确保组件已挂载）
                const componentElement = document.getElementById('reverb-test-component');
                const componentId = componentElement ? componentElement.getAttribute('wire:id') : null;
                
                console.log('组件 ID:', componentId);

                // 监听新任务的进度更新
                const channelName = 'task-progress.' + taskId;
                channel = Echo.private(channelName);
                
                // 更新组件的辅助函数（提前定义，供监听器使用）
                function updateComponent(data, componentId) {
                    if (componentId) {
                        const component = Livewire.find(componentId);
                        if (component) {
                            console.log('更新组件状态:', data);
                            component.set('currentStep', data.currentStep);
                            component.set('progress', data.progress);
                            component.set('message', data.message);

                            // 如果任务完成，设置运行状态为 false
                            if (data.progress >= 100) {
                                setTimeout(() => {
                                    component.set('isRunning', false);
                                }, 1000);
                            }
                        } else {
                            console.error('无法找到 Livewire 组件，ID:', componentId);
                        }
                    } else {
                        console.error('组件 ID 为空');
                    }
                }
                
                // 添加订阅成功和错误回调
                channel.subscribed(() => {
                    console.log('频道订阅成功: ' + channelName);
                    
                    // 在订阅成功后立即设置监听器
                    // 尝试多种事件名称格式
                    const eventListeners = [
                        '.App.Events.TaskProgressUpdated',
                        'App.Events.TaskProgressUpdated',
                        '.App\\Events\\TaskProgressUpdated',
                        'App\\Events\\TaskProgressUpdated'
                    ];
                    
                    eventListeners.forEach(eventName => {
                        channel.listen(eventName, (data) => {
                            console.log('收到进度更新事件 (' + eventName + '):', data);
                            updateComponent(data, componentId);
                        });
                    });
                    
                    console.log('已设置事件监听器，监听的事件:', eventListeners);
                });
                
                channel.error((error) => {
                    console.error('频道订阅错误:', error);
                    if (error && error.message) {
                        console.error('错误消息:', error.message);
                    }
                });
                
                // 也在订阅前设置监听器（以防订阅回调延迟）
                channel.listen('.App.Events.TaskProgressUpdated', (data) => {
                    console.log('收到进度更新事件 (预监听器):', data);
                    updateComponent(data, componentId);
                });
                
                // 尝试直接监听 Pusher 频道的所有事件
                if (channel.pusher && channel.pusher.channel) {
                    const pusherChannel = channel.pusher.channel;
                    console.log('Pusher 频道对象:', pusherChannel);
                    
                    // 尝试监听所有事件（使用 Pusher 的 bind_all 或者直接监听）
                    // 注意：Pusher 可能没有 bind_global，让我们尝试其他方法
                    if (pusherChannel.bind) {
                        // 监听所有可能的事件名称格式
                        const possibleEventNames = [
                            'App\\Events\\TaskProgressUpdated',
                            'App.Events.TaskProgressUpdated',
                            '.App\\Events\\TaskProgressUpdated',
                            '.App.Events.TaskProgressUpdated'
                        ];
                        
                        possibleEventNames.forEach(eventName => {
                            pusherChannel.bind(eventName, (data) => {
                                console.log('Pusher 频道直接收到事件 (' + eventName + '):', data);
                                updateComponent(data, componentId);
                            });
                        });
                    }
                }

                console.log('已连接到任务进度频道: ' + channelName);
            });

            // 监听重置事件
            window.Livewire.on('task-reset', () => {
                if (channel) {
                    Echo.leave(channel.name);
                    channel = null;
                    console.log('已断开任务进度频道连接');
                }
            });
        } else {
            console.error('Echo 或 Livewire 未初始化，请确保已正确配置 WebSocket 连接');
        }
    });
</script>
@endpush
