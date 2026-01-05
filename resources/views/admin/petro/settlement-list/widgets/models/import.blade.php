<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title" id="importModalLabel">
                    <i class="mdi mdi-upload"></i> Import Settlement Data
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="importForm" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="importFile" class="form-label">Select File (CSV or Excel)</label>
                        <input class="form-control form-control-lg" type="file" id="importFile" 
                            accept=".csv,.xlsx,.xls" required>
                        <small class="text-muted">Supported formats: CSV, Excel</small>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="importSettlementData()">
                    <i class="mdi mdi-upload"></i> Import
                </button>
            </div>
        </div>
    </div>
</div>