@extends('admin.layouts.app')
<style>
    .dropdown-item:hover,
    .dropdown-item {
        color: gray !important;
    }
</style>
@section('content')
<div class="content-wrapper" style="padding: 1.1rem 2.25rem !important;">

    @include('admin.command.widgets.page-header', $pageHeader)

    <div class="row">
        <div class="col-12 mb-4 stretch-card">
            <div class=" card border-primary shadow-sm" style="border-top: 3px solid;">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3 flex-wrap">
                        <h4 class="card-title text-muted mb-0">
                            <i class="mdi mdi-format-list-bulleted text-primary"></i> Summary Table
                        </h4>

                        <!-- Right side buttons -->
                        <div class="d-flex align-items-center gap-2 ms-auto">

                            <div class="dropdown">
                                <button type="button" class="btn btn-sm btn-gradient-primary dropdown-toggle"
                                    data-bs-toggle="dropdown" aria-expanded="false" title="Export Options">
                                    <i class="fa fa-download"></i> Export
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="exportTableToCSV('settlement_data.csv'); return false;">
                                            <i class="fa fa-file-text-o  me-2"></i> CSV
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#"
                                            onclick="exportTableToExcel('settlement_data.xlsx'); return false;">
                                            <i class="fa fa-file-excel-o text me-2"></i> Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="exportTableToPDF(); return false;">
                                            <i class="fa fa-file-pdf-o me-2"></i> PDF
                                        </a>
                                    </li>
                                    {{-- <li>
                                        <hr class="dropdown-divider">
                                    </li> --}}
                                    <li>
                                        <a class="dropdown-item" href="#" onclick="printTable(); return false;">
                                            <i class="fa fa-print me-2"></i> Print
                                        </a>
                                    </li>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-sm btn-gradient-primary" data-bs-toggle="modal"
                                data-bs-target="#importModal" title="Import">
                                <i class="fa fa-upload"></i> Import
                            </button>
                            {{--
                            <!-- Add Button -->
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createModal">
                                <i class="mdi mdi-plus-circle"></i> Add
                            </button> --}}
                            <button id="tableFilterBtn" class="btn btn-sm btn-outline-secondary" type="button"
                                data-bs-toggle="collapse" data-bs-target="#metaFilterBody">
                                <i class="mdi mdi-filter"></i>
                                <span id="tableFilterBtnText">Show Filter</span>
                            </button>
                        </div>
                    </div>
                    @include('admin.petro.settlement-list.widgets.filter')
                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="data-table table table-hover table-bordered w-100">
                            <thead class="bg-light">
                                <tr>
                                    <th>Settlement ID</th>
                                    <th>Settlement Date</th>
                                    <th>Pump Operator</th>
                                    <th>Pumps</th>
                                    <th>Location</th>
                                    <th>Shift</th>
                                    <th>Total Amount</th>
                                    <th>Added User</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View Details Modal -->
@include('admin.petro.settlement-list.widgets.models.view-details')
@include('admin.petro.settlement-list.widgets.models.import')
@endsection

<script src="{{ asset('assets/js/settlementList.js') }}"></script>

<!-- Export/Import Functions -->
<script>
    function exportTableToCSV(filename) {
        const csv = [];
        const rows = document.querySelectorAll("#entryTable tr");

        rows.forEach(row => {
            const cols = row.querySelectorAll("td, th");
            const csvRow = [];
            cols.forEach(col => {
                csvRow.push('"' + col.innerText.replace(/"/g, '""') + '"');
            });
            csv.push(csvRow.join(","));
        });

        downloadCSV(csv.join("\n"), filename);
    }

    function downloadCSV(csv, filename) {
        const csvFile = new Blob([csv], {
            type: "text/csv"
        });
        const downloadLink = document.createElement("a");
        downloadLink.href = URL.createObjectURL(csvFile);
        downloadLink.download = filename;
        document.body.appendChild(downloadLink);
        downloadLink.click();
        document.body.removeChild(downloadLink);
    }

    function exportTableToExcel(filename) {
        const table = document.getElementById('entryTable');
        const html = table.outerHTML;
        const uri = 'data:application/vnd.ms-excel;base64,' + btoa(unescape(encodeURIComponent(html)));
        const link = document.createElement("a");
        link.href = uri;
        link.download = filename;
        link.click();
    }

    function exportTableToPDF() {
        alert('PDF export requires a library like jsPDF. Install it for full functionality.');
    }

    function printTable() {
        const printWindow = window.open('', '', 'height=600,width=800');
        const table = document.getElementById('entryTable').outerHTML;
        printWindow.document.write('<html><head><title>Settlement Report</title>');
        printWindow.document.write('<link rel="stylesheet" href="{{ asset('assets/css/data-table.css') }}">');
        printWindow.document.write('</head><body>');
        printWindow.document.write('<h2>Settlement List Report</h2>');
        printWindow.document.write(table);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.print();
    }

    function importSettlementData() {
        const fileInput = document.getElementById('importFile');
        const file = fileInput.files[0];

        if (!file) {
            alert('Please select a file');
            return;
        }

        const formData = new FormData();
        formData.append('file', file);

        fetch('/settlement-list/import', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Data imported successfully');
                    fetchSettlements();
                    bootstrap.Modal.getInstance(document.getElementById('importModal')).hide();
                } else {
                    alert('Error importing data: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error importing data');
            });
    }

    function createSettlement() {
        const formData = {
            settlement_date: document.getElementById('settlementDate').value,
            pump_operator_name: document.getElementById('pumpOperator').value,
            location: document.getElementById('location').value,
            shift: document.getElementById('shift').value,
            total_amount: document.getElementById('totalAmount').value,
            status: document.getElementById('status').value,
            note: document.getElementById('note').value
        };

        fetch('/settlement-list', {
                method: 'POST',
                body: JSON.stringify(formData),
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Settlement created successfully');
                    fetchSettlements();
                    bootstrap.Modal.getInstance(document.getElementById('createModal')).hide();
                    document.getElementById('createSettlementForm').reset();
                } else {
                    alert('Error creating settlement: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error creating settlement');
            });
    }
</script>