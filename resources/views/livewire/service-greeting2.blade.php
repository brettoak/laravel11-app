<div x-data="userTable()" x-init="initGrid()">
    <div id="myGrid" class="ag-theme-alpine" style="height: 400px;"></div>

    <script>
        function userTable() {
            return {
                gridOptions: {
                    columnDefs: [
                        { headerName: "ID", field: "id" },
                        { headerName: "Name", field: "name" },
                        { headerName: "Email", field: "email" },
                    ],
                    rowData: @entangle('users'),
                },
                initGrid() {
                    const gridDiv = document.querySelector('#myGrid');
                    new agGrid.Grid(gridDiv, this.gridOptions);
                }
            }
        }
    </script>
</div>
