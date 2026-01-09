<div class="collapse" id="metaFilterBody">
    <div class="d-flex flex-wrap align-items-end gap-2 py-3">
        
        <div class="filter-field">
            <label class="text-muted small mb-1">ID</label>
            <input type="text" class="form-control form-control-sm bg-light py-1" id="filterId" 
                placeholder="ID..." style="width: 100px;">
        </div>

        <div class="filter-field">
            <label class="text-muted small mb-1">Pump Operator</label>
            <select class="form-control form-control-sm py-1" id="filterOperator" style="width: 150px;">
                <option value="">All Operators</option>
                <!-- Options will be populated dynamically -->
            </select>
        </div>

        <div class="filter-field">
            <label class="text-muted small mb-1">Location</label>
            <select class="form-control form-control-sm py-1" id="filterLocation" style="width: 150px;">
                <option value="">All Locations</option>
                <!-- Options will be populated dynamically -->
            </select>
        </div>

        <div class="filter-field">
            <label class="text-muted small mb-1">Commission Type</label>
            <select class="form-control form-control-sm py-1" id="filterCommissionType" style="width: 140px;">
                <option value="">All Types</option>
                <option value="Percentage">Percentage</option>
                <option value="Fixed">Fixed</option>
                <option value="Tiered">Tiered</option>
            </select>
        </div>

        <div class="filter-field">
            <label class="text-muted small mb-1">Sold Fuel Min</label>
            <input type="number" class="form-control form-control-sm py-1" id="filterFuelMin" 
                placeholder="Min Qty" style="width: 110px;" min="0">
        </div>

        <div class="filter-field">
            <label class="text-muted small mb-1">Sold Fuel Max</label>
            <input type="number" class="form-control form-control-sm py-1" id="filterFuelMax" 
                placeholder="Max Qty" style="width: 110px;" min="0">
        </div>

        <div class="filter-field">
            <label class="text-muted small mb-1">Sale Amount Min</label>
            <input type="number" class="form-control form-control-sm py-1" id="filterSaleMin" 
                placeholder="Min Amount" style="width: 120px;" min="0">
        </div>

        <div class="filter-field">
            <label class="text-muted small mb-1">Sale Amount Max</label>
            <input type="number" class="form-control form-control-sm py-1" id="filterSaleMax" 
                placeholder="Max Amount" style="width: 120px;" min="0">
        </div>

        <div class="filter-reset ms-auto">
            <div class="mb-1" style="height: 16px;"></div> <!-- Spacer to align with labels -->
            <button type="button" class="btn btn-sm btn-outline-secondary" id="resetFilterBtn" 
                data-bs-toggle="tooltip" data-bs-placement="top" >
                <i class="mdi mdi-refresh"></i>
            </button>
        </div>
    </div>
</div>

<style>
    /* Filter field styling */
    .filter-field {
        display: flex;
        flex-direction: column;
    }
    
    #metaFilterBody .form-control-sm {
        height: 32px;
        font-size: 0.875rem;
        min-width: 100px;
    }
    
    #metaFilterBody label {
        white-space: nowrap;
        font-size: 0.75rem;
        line-height: 1.2;
    }
    
    /* Reset button styling */
    .filter-reset {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
    }
    
    #resetFilterBtn {
        height: 32px;
        width: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
        border-radius: 4px;
    }
    
    #resetFilterBtn i {
        font-size: 18px;
        line-height: 1;
    }
    
    #resetFilterBtn:hover {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }
    
    /* Tooltip styling */
    .tooltip-inner {
        font-size: 0.75rem;
        padding: 4px 8px;
    }
    
    /* Responsive design */
    @media (max-width: 1600px) {
        #metaFilterBody .d-flex {
            gap: 10px;
        }
        
        .filter-field {
            flex: 1;
            min-width: 120px;
        }
        
        #metaFilterBody .form-control-sm {
            width: 100% !important;
        }
    }
    
    @media (max-width: 1400px) {
        #metaFilterBody .d-flex {
            gap: 8px;
        }
        
        .filter-field {
            min-width: 110px;
        }
    }
    
    @media (max-width: 1200px) {
        #metaFilterBody .d-flex {
            gap: 6px;
        }
        
        .filter-field {
            min-width: 100px;
        }
        
        #metaFilterBody .form-control-sm {
            font-size: 0.8rem;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Filter component loaded');
        
        // Initialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>