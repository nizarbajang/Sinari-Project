<?php

namespace App\Http\Controllers;

use App\Models\FarmerReport;
use App\Models\Project;
use App\Models\ReportMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FarmerReportController extends Controller
{
    public function index()
    {
        $reports = FarmerReport::where('farmer_id', Auth::id())->with('project')->latest()->paginate(8);
        return view('farmer.index', compact('reports'));
    }
    public function create()
    {
        $projects = Project::where('farmer_id', Auth::id())->get();
        return view('farmer.createReport', compact('projects'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'weight'        => 'nullable|numeric',
            'health_status' => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
            'media.*'       => 'nullable|mimes:jpg,jpeg,png,mp4|max:50000',
        ]);
        $report = FarmerReport::create([
            'project_id' => $request->project_id,
            'farmer_id' => Auth::id(),
            'weight' => $request->weight,
            'health_status' => $request->health_status,
            'notes' => $request->notes
        ]);
        if($request->hasFile('media')){
            foreach($request->media as $file){
                $path = $file->store('report_media', 'public');

                ReportMedia::create([
                    'report_id' => $report->id,
                    'url' => $path,
                    'type' => $file->getClientOriginalExtension() === 'mp4' ? 'video' : 'image'
                ]);
            }
        }
        return redirect()->route('reports.index')->with('success', 'Laporan Berhasil Ditambahkan');
    }
    public function show(string $id)
    {
        $report = FarmerReport::with(['project', 'media'])
                ->where('farmer_id', Auth::id())
                ->findOrFail($id);

        return view('farmer.showReport', compact('report'));
    }
    public function edit(string $id)
    {
        $report = FarmerReport::findOrFail($id);
        $projects = Project::where('farmer_id', Auth::id())->get();

        return view('farmer.editReport', compact('report', 'projects'));
    }
    public function update(Request $request, string $id)
    {
         $report = FarmerReport::findOrFail($id);

        $request->validate([
            'project_id'    => 'required|exists:projects,id',
            'weight'        => 'nullable|numeric',
            'health_status' => 'nullable|string|max:255',
            'notes'         => 'nullable|string',
            'media.*'       => 'nullable|mimes:jpg,jpeg,png,mp4|max:50000',
        ]);

        $report->update([
            'project_id'    => $request->project_id,
            'weight'        => $request->weight,
            'health_status' => $request->health_status,
            'notes'         => $request->notes,
        ]);

        if ($request->hasFile('media')) {
            foreach ($request->media as $file) {
                $path = $file->store('report_media', 'public');

                ReportMedia::create([
                    'report_id' => $report->id,
                    'url'       => $path,
                    'type'      => $file->getClientOriginalExtension() === 'mp4' ? 'video' : 'image'
                ]);
            }
        }

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil diperbarui.');
    }
    public function destroy(string $id)
    {
        FarmerReport::findOrFail($id)->delete();

        return redirect()->route('reports.index')->with('success', 'Laporan berhasil dihapus.');
    }
}
