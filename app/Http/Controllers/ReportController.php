<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Shift;
use App\Models\StockMovement;
use App\Models\CashDrop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        $stationId = Auth::user()->station_id;
        $users = User::where('station_id', $stationId)->get();
        return view('admin.reports.index', compact('users'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'report_type' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'nullable|exists:users,id',
            'shift_number' => 'nullable|string',
        ]);

        $stationId = Auth::user()->station_id;

        if (!$stationId) {
            return redirect()->back()->with('error', 'You are not assigned to a station.');
        }

        $reportType = $request->report_type;

        // If no report type selected, get all reports
        if (empty($reportType)) {
            $allReportsData = [
                'sales' => $this->getReportData('sales', $request->start_date, $request->end_date, $stationId, $request->user_id, $request->shift_number),
                'settlements' => $this->getReportData('settlements', $request->start_date, $request->end_date, $stationId, $request->user_id, $request->shift_number),
                'stock' => $this->getReportData('stock', $request->start_date, $request->end_date, $stationId, $request->user_id, $request->shift_number),
                'cash_drops' => $this->getReportData('cash_drops', $request->start_date, $request->end_date, $stationId, $request->user_id, $request->shift_number),
            ];

            // Process settlements data
            if ($allReportsData['settlements']) {
                $allReportsData['settlements']->transform(function ($shift) {
                    if ($shift->status === 'open') {
                        $shift->total_sales = $shift->sales->sum('amount');
                        $shift->cash_sales = $shift->sales->where('payment_mode', 'cash')->sum('amount');
                        $shift->cash_variance = 0;
                    }
                    return $shift;
                });
            }

            // Calculate totals for all report types
            $totals = [
                'sales' => [
                    'total_amount' => $allReportsData['sales']->sum('amount'),
                    'total_quantity' => $allReportsData['sales']->sum('quantity'),
                ],
                'settlements' => [
                    'total_sales' => $allReportsData['settlements']->sum('total_sales'),
                    'cash_sales' => $allReportsData['settlements']->sum('cash_sales'),
                    'total_variance' => $allReportsData['settlements']->sum('cash_variance'),
                ],
                'cash_drops' => [
                    'total_amount' => $allReportsData['cash_drops']->sum('amount'),
                ],
                'stock' => [
                    'total_quantity' => $allReportsData['stock']->sum('quantity'),
                ],
            ];

            $filters = $request->only(['report_type', 'start_date', 'end_date', 'user_id', 'shift_number']);
            $users = User::where('station_id', $stationId)->get();

            return view('admin.reports.index', compact('allReportsData', 'reportType', 'filters', 'users', 'totals'));
        }

        $data = $this->getReportData(
            $request->report_type,
            $request->start_date,
            $request->end_date,
            $stationId,
            $request->user_id,
            $request->shift_number
        );

        $reportData = $data;
        $filters = $request->only(['report_type', 'start_date', 'end_date', 'user_id', 'shift_number']);
        $users = User::where('station_id', $stationId)->get();

        if ($reportType === 'settlements') {
            $data->transform(function ($shift) {
                if ($shift->status === 'open') {
                    $shift->total_sales = $shift->sales->sum('amount');
                    $shift->cash_sales = $shift->sales->where('payment_mode', 'cash')->sum('amount');
                    // For open shifts, expected cash is opening + sales
                    // Variance is 0 or undefined until closing cash is entered
                    $shift->cash_variance = 0;
                }
                return $shift;
            });
        }

        // Calculate Totals
        $totals = [];
        if ($reportType === 'sales') {
            $totals['total_amount'] = $data->sum('amount');
            $totals['total_quantity'] = $data->sum('quantity');
        } elseif ($reportType === 'settlements') {
            $totals['total_sales'] = $data->sum('total_sales');
            $totals['cash_sales'] = $data->sum('cash_sales'); // Assuming this column exists or relevant
            $totals['total_variance'] = $data->sum('cash_variance');
        } elseif ($reportType === 'cash_drops') {
            $totals['total_amount'] = $data->sum('amount');
        } elseif ($reportType === 'stock') {
            $totals['total_quantity'] = $data->sum('quantity');
        }

        return view('admin.reports.index', compact('reportData', 'reportType', 'filters', 'users', 'totals'));
    }

    public function export(Request $request)
    {
        $request->validate([
            'report_type' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'user_id' => 'nullable|exists:users,id',
            'shift_number' => 'nullable|string',
        ]);

        $stationId = Auth::user()->station_id;

        if (!$stationId) {
            return redirect()->back()->with('error', 'You are not assigned to a station.');
        }

        $data = $this->getReportData(
            $request->report_type,
            $request->start_date,
            $request->end_date,
            $stationId,
            $request->user_id,
            $request->shift_number
        );

        $filename = $request->report_type . '_report_' . Carbon::now()->format('Y-m-d_H-i-s') . '.csv';

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function () use ($data, $request) {
            $file = fopen('php://output', 'w');

            // Add Header Row based on report type
            $columns = $this->getColumnsForReport($request->report_type);
            fputcsv($file, $columns);

            // Add Data Rows
            foreach ($data as $row) {
                $formattedRow = $this->formatRowForExport($row, $request->report_type);
                fputcsv($file, $formattedRow);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    private function getReportData($type, $start, $end, $stationId, $userId = null, $shiftNumber = null)
    {
        $startDate = Carbon::parse($start)->startOfDay();
        $endDate = Carbon::parse($end)->endOfDay();

        switch ($type) {
            case 'sales':
                $query = Sale::with(['fuelType', 'pump', 'creator'])
                    ->where('station_id', $stationId)
                    ->whereBetween('sale_datetime', [$startDate, $endDate]);

                if ($userId) {
                    $query->where('created_by', $userId);
                }
                // Sales don't strictly have shift_number column, but belongs to a shift
                if ($shiftNumber) {
                    $query->whereHas('shift', function ($q) use ($shiftNumber) {
                        $q->where('shift_number', $shiftNumber);
                    });
                }

                return $query->orderBy('sale_datetime', 'desc')->get();

            case 'settlements': // Shifts
                $query = Shift::with(['user'])
                    ->where('station_id', $stationId)
                    ->whereBetween('start_time', [$startDate, $endDate]);

                if ($userId) {
                    $query->where('user_id', $userId);
                }
                if ($shiftNumber) {
                    $query->where('shift_number', $shiftNumber);
                }

                return $query->orderBy('start_time', 'desc')->get();

            case 'stock':
                // Stock Movements typically don't have user_id or shift directly easily filterable for general report
                // But if they did, we would add here. For now, ignoring user/shift for stock or checking if your model supports it.
                // StockMovement typically auto-generated or by user? Schema didn't show user_id.
                return StockMovement::with(['tank'])
                    ->whereHas('tank', function ($q) use ($stationId) {
                        $q->where('station_id', $stationId);
                    })
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->orderBy('created_at', 'desc')
                    ->get();

            case 'cash_drops':
                $query = CashDrop::with(['shift', 'user'])
                    ->whereHas('shift', function ($q) use ($stationId) {
                        $q->where('station_id', $stationId);
                    })
                    ->whereBetween('dropped_at', [$startDate, $endDate]);

                if ($userId) {
                    $query->where('user_id', $userId);
                }
                if ($shiftNumber) {
                    $query->whereHas('shift', function ($q) use ($shiftNumber) {
                        $q->where('shift_number', $shiftNumber);
                    });
                }

                return $query->orderBy('dropped_at', 'desc')->get();

            default:
                return [];
        }
    }

    private function getColumnsForReport($type)
    {
        switch ($type) {
            case 'sales':
                return ['Date', 'Fuel Type', 'Quantity', 'Amount', 'Pump', 'Payment Method', 'Created By'];
            case 'settlements': // Shifts
                return ['Date', 'Shift #', 'User', 'Total Sales', 'Cash Sales', 'Variance', 'Status'];
            case 'stock':
                return ['Date', 'Tank', 'Type', 'Quantity', 'Reference'];
            case 'cash_drops':
                return ['Date', 'User', 'Shift #', 'Amount', 'Notes'];
            default:
                return [];
        }
    }

    private function formatRowForExport($row, $type)
    {
        switch ($type) {
            case 'sales':
                return [
                    $row->sale_datetime->format('Y-m-d H:i'),
                    $row->fuelType->name ?? 'N/A',
                    $row->quantity,
                    $row->amount,
                    $row->pump->pump_name ?? 'N/A',
                    $row->payment_method,
                    $row->creator->name ?? 'N/A'
                ];
            case 'settlements':
                return [
                    $row->shift_date,
                    $row->shift_number,
                    $row->user->name ?? 'N/A',
                    $row->total_sales,
                    $row->cash_sales,
                    $row->cash_variance,
                    $row->status
                ];
            case 'stock':
                return [
                    $row->created_at->format('Y-m-d H:i'),
                    $row->tank->tank_name ?? 'N/A',
                    $row->type,
                    $row->quantity,
                    $row->reference_number ?? ''
                ];
            case 'cash_drops':
                return [
                    Carbon::parse($row->dropped_at)->format('Y-m-d H:i'),
                    $row->user->name ?? 'N/A',
                    $row->shift->shift_number ?? 'N/A',
                    $row->amount,
                    $row->notes
                ];
            default:
                return [];
        }
    }
}
