import './bootstrap';
import { createGrid, ModuleRegistry, AllCommunityModule, themeQuartz } from 'ag-grid-community';

// 注册所有社区版模块
ModuleRegistry.registerModules([AllCommunityModule]);

// 导出全局工具函数
window.createGrid = createGrid;
window.themeQuartz = themeQuartz; // 导出主题

// 注意：不在这里导入 Alpine.js
// Livewire 会自动加载并管理 Alpine.js
// 如果需要在其他地方使用 Alpine，可以通过 window.Alpine 访问（由 Livewire 设置）
