let table;

function initTable() {
    // Destroy previous instance safely
    if (table) {
        table.destroy();
    }

    table = new DataTable('#entryTable', {
        responsive: true,
        pageLength: 10,
        
    });
}
async function fetchEntries(filter = {}) {
    let url = '/settlement/entries';
    if (filter.status) url += `?status=${filter.status}`;

    const res = await fetch(url);
    const entries = await res.json();

    const tbody = document.querySelector('#entryTable tbody');
    tbody.innerHTML = ''; // clear table

    entries.forEach(entry => {
        const row = document.createElement('tr');
        row.innerHTML = `
                <td>${entry.code}</td>
                <td><strong>${entry.products}</strong></td>
                <td><span class="badge badge-outline-primary">${entry.pump}</span></td>
                <td>${entry.start_meter}</td>
                <td>${entry.close_meter}</td>
                <td>${entry.price}</td>
                <td>${entry.sold_qty}</td>
                <td class="font-weight-bold">${entry.total_price}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-gradient-success btn-icon view" data-id="${entry.id}"><i class="mdi mdi-eye-arrow-right-outline"></i></button>
                    <button class="btn btn-sm btn-gradient-info btn-icon edit" data-id="${entry.id}"><i class="mdi mdi-pencil"></i></button>
                    <button class="btn btn-sm btn-gradient-danger btn-icon delete" data-id="${entry.id}"><i class="mdi mdi-delete"></i></button>
                </td>
            `;
        tbody.appendChild(row);
    });
    initTable();
}

// Call it after page loads
document.addEventListener('DOMContentLoaded', () => {
    fetchEntries();
});