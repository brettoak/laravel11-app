import './bootstrap';
import { createGrid, ModuleRegistry, AllCommunityModule, themeQuartz } from 'ag-grid-community';

// Register all community modules
ModuleRegistry.registerModules([AllCommunityModule]);

// Export global utility functions
window.createGrid = createGrid;
window.themeQuartz = themeQuartz; // Export theme

// Note: Do not import Alpine.js here
// Livewire will automatically load and manage Alpine.js
// If you need to use Alpine elsewhere, you can access it via window.Alpine (set by Livewire)
