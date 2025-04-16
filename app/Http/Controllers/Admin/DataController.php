<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;
use App\Models\Sensor;

class DataController extends Controller
{
    public function index(Request $request)
    {
        $records = DB::table('sensors')
            ->select('sensor_id', 'location', 'simulated_aqi as aqi', 'status', 'last_updated as recorded_at')
            ->orderByDesc('last_updated')
            ->take(100)
            ->get();

        $locations = Sensor::distinct()->pluck('location')->toArray();

        $total = $records->count();
        $average = round($records->avg('aqi'), 2);
        $activeCount = Sensor::where('status', 'Active')->count();
        $inactiveCount = Sensor::where('status', 'Inactive')->count();

        // Chart data: last 5 records (example)
        $chartLabels = $records->take(5)->pluck('recorded_at')->reverse()->values();
        $chartValues = $records->take(5)->pluck('aqi')->reverse()->values();

        return view('pages.admin.data-management', compact(
            'records', 'total', 'average', 'activeCount', 'inactiveCount',
            'chartLabels', 'chartValues', 'locations'
        ));
    }
    public function filter(Request $request)
    {
        $query = DB::table('sensors')->whereNotNull('simulated_aqi');

        if ($request->filled('location') && $request->location != 'All') {
            $query->where('location', $request->location);
        }

        if ($request->filled('from')) {
            $query->where('last_updated', '>=', Carbon::parse($request->from));
        }

        if ($request->filled('to')) {
            $query->where('last_updated', '<=', Carbon::parse($request->to));
        }

        $filteredData = $query->orderBy('last_updated', 'desc')->get();

        return response()->json($filteredData);
    }

    public function exportCsv(Request $request)
    {
        $query = DB::table('sensors')->whereNotNull('simulated_aqi');

        if ($request->filled('location') && $request->location != 'All') {
            $query->where('location', $request->location);
        }

        if ($request->filled('from')) {
            $query->where('last_updated', '>=', Carbon::parse($request->from));
        }

        if ($request->filled('to')) {
            $query->where('last_updated', '<=', Carbon::parse($request->to));
        }

        $data = $query->orderBy('last_updated', 'desc')->get();

        $csvFileName = 'aqi_export_' . now()->format('Ymd_His') . '.csv';
        $csvPath = storage_path('app/public/' . $csvFileName);

        $file = fopen($csvPath, 'w');
        fputcsv($file, ['Sensor ID', 'Location', 'AQI', 'Status', 'Last Updated']);

        foreach ($data as $row) {
            fputcsv($file, [
                $row->sensor_id ?? '-',
                $row->location,
                $row->simulated_aqi,
                $row->status,
                $row->last_updated
            ]);
        }

        fclose($file);

        return response()->download($csvPath)->deleteFileAfterSend();
    }
}
