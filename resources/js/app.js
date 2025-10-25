import './bootstrap';
import Alpine from 'alpinejs';
import { createGrid, ModuleRegistry, AllCommunityModule, themeQuartz } from 'ag-grid-community';

// 注册所有社区版模块
ModuleRegistry.registerModules([AllCommunityModule]);

window.Alpine = Alpine;
window.createGrid = createGrid;
window.themeQuartz = themeQuartz; // 导出主题



Alpine.start();
