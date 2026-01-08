<style>
    @media (max-width: 768px) {
        #testingDetailsFilterDiv .d-flex.flex-nowrap {
            flex-wrap: wrap !important;
        }

        #testingDetailsFilterDiv .overflow-auto {
            overflow: visible !important;
        }

        #testingDetailsFilterDiv>.d-flex>div {
            width: 100% !important;
            max-width: 100% !important;
            min-width: 100% !important;
            margin-bottom: 0.5rem;
        }

        #testingDetailsFilterDiv>.d-flex>div:nth-child(5),
        #testingDetailsFilterDiv>.d-flex>div:nth-child(6) {
            width: calc(50% - 4px) !important;
            max-width: calc(50% - 4px) !important;
            min-width: calc(50% - 4px) !important;
        }

        #testingDetailsFilterDiv>.d-flex>div:nth-child(5) {
            margin-right: 8px;
        }
    }
</style>
<div class="collapse" id="testingDetailsFilterDiv">
    <div class="d-flex flex-nowrap align-items-end gap-2 py-1 overflow-auto">
        <div class="d-flex flex-column flex-grow-1" style="min-width: 180px; max-width: 210px;">
            <label class="text-muted small mb-1">Business Location</label>
            <select class="form-control form-control-sm py-1">
                <option>Main Station - Negombo</option>
                <option>City Branch - Colombo</option>
                <option>Highway Station - Gampaha</option>
            </select>
        </div>
        <div class="d-flex flex-column flex-grow-1" style="min-width: 180px; max-width: 210px;">
            <label class="text-muted small mb-1">Pump Operator</label>
            <select class="form-control form-control-sm py-1">
                <option>All Operators</option>
                <option>Isuru Perera</option>
                <option>Nimesh Silva</option>
                <option>Kasun Fernando</option>
            </select>
        </div>
        <div class="d-flex flex-column flex-shrink-0" style="width: 100px;">
            <label class="text-muted small mb-1">Settlement No</label>
            <select class="form-control form-control-sm py-1">
                <option>All</option>
                <option>STL-001</option>
                <option>STL-002</option>
                <option>STL-003</option>
            </select>
        </div>
        <div class="d-flex flex-column flex-grow-1" style="min-width: 180px; max-width: 210px;">
            <label class="text-muted small mb-1">Pumps</label>
            <select class="form-control form-control-sm py-1">
                <option>All Pumps</option>
                <option>Pump 1</option>
                <option>Pump 2</option>
                <option>Pump 3</option>
            </select>
        </div>
        <div class="d-flex flex-column flex-grow-1" style="min-width: 150px; max-width: 210px;">
            <label class="text-muted small mb-1">Products</label>
            <select class="form-control form-control-sm py-1">
                <option>All Products</option>
                <option>Diesel</option>
                <option>Petrol</option>
            </select>
        </div>
        <div class="d-flex flex-column flex-shrink-0" style="width: 130px;">
            <label class="text-muted small mb-1">Date Range</label>
            <input type="date" class="form-control form-control-sm py-1" value="2025-01-07">
        </div>
    </div>
</div>