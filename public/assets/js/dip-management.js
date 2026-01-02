document.addEventListener('DOMContentLoaded', function(){
    const dipModalEl = document.getElementById('dipModal');
    const addRowBtn = document.getElementById('addDipRow');
    const dipTableBody = document.querySelector('#dipEntriesTable tbody');
    const tankSelect = document.getElementById('tankSelect');
    const dipReading = document.getElementById('dipReading');
    const dipValue = document.getElementById('dipValue');
    const currentQty = document.getElementById('currentQty');

    // No modal: inline form behavior only

    // Add a new entry to the dip table
    addRowBtn?.addEventListener('click', function(){
        const tank = tankSelect?.value || '';
        const reading = dipReading?.value || '';
        const value = dipValue?.value || '';

        if (!tank || !reading || !value) {
            alert('Please provide tank, reading and dip value');
            return;
        }

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${tank}</td>
            <td>${reading}</td>
            <td>${Number(value).toFixed(2)}</td>
            <td>${(Math.random()*10000).toFixed(2)}</td>
            <td><input class="form-control form-control-sm" placeholder="Note"></td>
            <td><button class="btn btn-sm btn-outline-danger remove-row">Remove</button></td>
        `;
        dipTableBody.appendChild(tr);

        // clear inputs
        dipReading.value = '';
        dipValue.value = '';
    });

    // Event delegation for remove
    dipTableBody?.addEventListener('click', function(e){
        if (e.target && e.target.matches('button.remove-row')){
            const row = e.target.closest('tr');
            row?.remove();
        }
    });

    // Simple search filter for dip list
    const searchEl = document.getElementById('searchDip');
    searchEl?.addEventListener('input', function(){
        const q = this.value.toLowerCase();
        // If DataTable is available, use its search API
        if (window.jQuery && $.fn.dataTable && $.fn.dataTable.isDataTable('#dipListTable')){
            $('#dipListTable').DataTable().search(q).draw();
        } else {
            document.querySelectorAll('#dipListTable tbody tr').forEach(tr=>{
                tr.style.display = tr.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        }
    });

    // Initialize DataTable for recent dip list if available
    if (window.jQuery && $.fn.dataTable) {
        $(document).ready(function(){
            const table = $('#dipListTable').DataTable({
                responsive: true,
                autoWidth: false,
                paging: true,
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: -1 }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search entries...",
                }
            });

            // expose table globally for other handlers
            window.dipListTable = table;

            // Move the search input to our custom input
            const dtSearch = $('#dipListTable_filter input');
            if (dtSearch.length && document.getElementById('searchDip')){
                dtSearch.attr('placeholder', '');
                $('#dipListTable_filter').hide();
                $('#searchDip').on('input', function(){
                    table.search(this.value).draw();
                });
            }
        });
    }

    // Save All: move entries from dipEntriesTable to dipListTable (client-side)
    document.getElementById('saveAllBtn')?.addEventListener('click', function(){
        const rows = Array.from(document.querySelectorAll('#dipEntriesTable tbody tr'));
        if (!rows.length) {
            alert('No entries to save. Add rows first.');
            return;
        }

        if (window.dipListTable) {
            rows.forEach(r => {
                const cols = Array.from(r.querySelectorAll('td'));
                const tank = cols[0]?.textContent.trim() || '';
                const reading = cols[1]?.textContent.trim() || '';
                const value = cols[2]?.textContent.trim() || '';
                const qty = cols[3]?.textContent.trim() || '';
                const note = cols[4]?.querySelector('input')?.value || '';
                // Add row to DataTable (keep date/location as placeholders)
                window.dipListTable.row.add([
                    window.dipListTable.rows().count() + 1,
                    new Date().toLocaleString(),
                    'S.H.M Jafris Lanka',
                    tank,
                    reading,
                    value,
                    note,
                    '<div class="btn-group"><button class="btn btn-sm btn-outline-primary">Edit</button><button class="btn btn-sm btn-outline-danger">Delete</button></div>'
                ]).draw(false);
            });
        } else {
            // fallback: append to tbody
            const listBody = document.querySelector('#dipListTable tbody');
            rows.forEach(r => {
                const cols = Array.from(r.querySelectorAll('td'));
                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${listBody.children.length + 1}</td>
                    <td>${new Date().toLocaleString()}</td>
                    <td>S.H.M Jafris Lanka</td>
                    <td>${cols[0]?.textContent.trim()||''}</td>
                    <td>${cols[1]?.textContent.trim()||''}</td>
                    <td>${cols[2]?.textContent.trim()||''}</td>
                    <td>${cols[4]?.querySelector('input')?.value||''}</td>
                    <td><div class="btn-group"><button class="btn btn-sm btn-outline-primary">Edit</button><button class="btn btn-sm btn-outline-danger">Delete</button></div></td>
                `;
                listBody.appendChild(tr);
            });
        }

        // Clear entries table
        document.querySelector('#dipEntriesTable tbody').innerHTML = '';
        // Optionally reset form inputs
        document.getElementById('dipForm')?.reset();
    });

    // Reset form button
    document.getElementById('resetFormBtn')?.addEventListener('click', function(){
        document.querySelector('#dipEntriesTable tbody').innerHTML = '';
        document.getElementById('dipForm')?.reset();
    });

    // Save button placeholder
    // Remove previous save button handler (we no longer show Save Dips in summary)
});
