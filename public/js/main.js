// Import jQuery and DataTables
import jQuery from "jquery";
import DataTable from 'datatables.net-bs5';

// Import additional DataTables extensions
import 'datatables.net-autofill-bs5';
import 'datatables.net-buttons-bs5';
import 'datatables.net-buttons/js/buttons.colVis.mjs';

// Ensure jQuery is globally available (for plugins to work properly)
window.$ = window.jQuery = jQuery;

// Initialize DataTable when the DOM is ready
document.addEventListener("DOMContentLoaded", function () {
    $('#myTable').DataTable({
        autoFill: true,
        dom: 'Bfrtip', // Enables buttons (filter, pagination, etc.)
        buttons: [
            'colvis', // Column visibility button
            'copy', 'csv', 'excel', 'pdf', 'print' // Export buttons
        ]
    });
});