<div>
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('gridComponent', (initialData,columnDefs) => ({
                gridApi: null,
                columnDefs: columnDefs,
                rowData: initialData,

                initGrid() {
                    const gridOptions = {
                        theme: window.themeQuartz, // Use the new theme API
                        columnDefs: this.columnDefs,
                        rowData: this.rowData,
                        defaultColDef: {
                            resizable: true,
                            sortable: true,
                            filter: true,
                        },
                        pagination: true,
                        paginationPageSize: 5,
                        paginationPageSizeSelector: [5, 10, 20, 50, 100],
                        onGridReady: (params) => {
                            this.gridApi = params.api;
                            // params.api.sizeColumnsToFit();
                        }
                    };

                    const gridDiv = document.querySelector('#myGrid');
                    window.createGrid(gridDiv, gridOptions);
                },

            }));
        });
    </script>


    <div class="mb-4">
        <h2 class="text-2xl font-bold">Data Display</h2>
        <div x-data="{ email: '', isValid: false, validate() { this.isValid = this.email.includes('@'); } }">
            <input
                type="email"
                x-model="email"
                @input="validate()"
                :class="{ 'border-red-500': !isValid && email.length > 0, 'border-green-500': isValid }"
                class="border-2 px-4 py-2">

            <p :class="{ 'text-red-500': !isValid, 'text-green-500': isValid }">
                <span x-show="!isValid && email.length > 0">❌ Invalid email format</span>
                <span x-show="isValid">✅ Valid email format</span>
            </p>
        </div>

    <div
        x-data="gridComponent(@js($tableData), @js($columnDefs))"
        x-init="initGrid()"
        class="w-9/12"
    >
        <div id="myGrid" style="height: {{ min(count($tableData) * 42 + 56, 800) }}px" class="ag-theme-alpine"></div>
    </div>
</div>
