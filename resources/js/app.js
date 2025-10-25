import './bootstrap';
import 'alpinejs'

import { Grid, ModuleRegistry, ClientSideRowModelModule } from 'ag-grid-community';
import 'ag-grid-community/styles/ag-grid.css';
import 'ag-grid-community/styles/ag-theme-alpine.css';

// 注册模块
ModuleRegistry.registerModules([ClientSideRowModelModule]);

window.agGrid = { Grid };

