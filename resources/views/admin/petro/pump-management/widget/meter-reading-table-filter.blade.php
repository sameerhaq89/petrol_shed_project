<style>
    .filter-location,
    .filter-operator,
    .filter-pumps,
    .filter-products {
        min-width: 180px;
        max-width: 220px;
        flex: 1 1 180px;
    }

    .filter-settlement {
        width: 110px;
        flex-shrink: 0;
    }

    .filter-date {
        width: 130px;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        #meterReadingsFilterDiv .d-flex.flex-nowrap {
            flex-wrap: wrap !important;
        }

        #meterReadingsFilterDiv .overflow-auto {
            overflow: visible !important;
        }

        .filter-location,
        .filter-operator,
        .filter-settlement,
        .filter-pumps,
        .filter-products,
        .filter-date {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
            margin-bottom: 0.5rem;
        }

        .filter-products,
        .filter-date {
            width: calc(50% - 4px) !important;
            max-width: calc(50% - 4px) !important;
            min-width: calc(50% - 4px) !important;
        }

        .filter-products {
            margin-right: 8px;
        }
    }
</style>
<div class="collapse" id="meterReadingsFilterDiv">
    <div class="d-flex flex-nowrap align-items-end gap-2 py-1">
        <div class="d-flex flex-column filter-location">
            <label class="text-muted small mb-1">Business Location</label>
            <select class="form-control form-control-sm py-1">
                <option>Main Station - Negombo</option>
                <option>City Branch - Colombo</option>
                <option>Highway Station - Gampaha</option>
            </select>
        </div>
        <div class="d-flex flex-column filter-operator">
            <label class="text-muted small mb-1">Pump Operator</label>
            <select class="form-control form-control-sm py-1">
                <option>All Operators</option>
                <option>Isuru Perera</option>
                <option>Nimesh Silva</option>
                <option>Kasun Fernando</option>
            </select>
        </div>
        <div class="d-flex flex-column filter-settlement">
            <label class="text-muted small mb-1">Settlement No</label>
            <select class="form-control form-control-sm py-1">
                <option>All</option>
                <option>STL-001</option>
                <option>STL-002</option>
                <option>STL-003</option>
            </select>
        </div>
        <div class="d-flex flex-column filter-pumps">
            <label class="text-muted small mb-1">Pumps</label>
            <select class="form-control form-control-sm py-1">
                <option>All Pumps</option>
                <option>Pump 1 - Diesel</option>
                <option>Pump 2 - Petrol 92</option>
                <option>Pump 3 - Petrol 95</option>
            </select>
        </div>
        <div class="d-flex flex-column filter-products">
            <label class="text-muted small mb-1">Products</label>
            <select class="form-control form-control-sm py-1">
                <option>All Products</option>
                <option>Diesel</option>
                <option>Petrol 92 Octane</option>
                <option>Petrol 95 Octane</option>
            </select>
        </div>
        <div class="d-flex flex-column filter-date">
            <label class="text-muted small mb-1">Date Range</label>
            <input type="date" class="form-control form-control-sm py-1" value="2025-01-07">
        </div>
    </div>
</div>