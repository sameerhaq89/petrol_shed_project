<div class="d-flex justify-content-between align-items-center mb-3">
    {{-- <h5 class="mb-0">Recent Dip Entries</h5> --}}
    <div>
        <input class="form-control form-control-sm" id="searchDip" placeholder="Search..." style="min-width:180px;">
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover" id="dipListTable" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Date</th>
                <th>Location</th>
                <th>Tank</th>
                <th>Dip Reading</th>
                <th>Qty (L)</th>
                <th>Note</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            {{-- Example rows; in real app replace with loop --}}
            <tr>
                <td>127</td>
                <td>12/01/2025 17:23</td>
                <td>S.H.M Jafris Lanka</td>
                <td>LP92-1</td>
                <td>700.00</td>
                <td>4,199.00</td>
                <td>OK</td>
                <td>
                    <div class="btn-group">
                        <button class="btn btn-sm btn-outline-primary"><i class="mdi mdi-pencil"></i></button>
                        <button class="btn btn-sm btn-outline-danger"><i class="mdi mdi-delete"></i></button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>
