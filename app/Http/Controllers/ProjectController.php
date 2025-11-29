<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectMedia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(){
        $projects = Project::with(['farmer', 'admin'])->latest()->paginate(5);
        return view('admin.project', compact('projects'));
    }

    public function create(){
        $farmers = User::where('role', 'farmer')->get();
        return view('admin.projectCreate', compact('farmers'));
    }

    public function store(Request $request){
        $validated = $request->validate([
            'farmer_id'        => 'required|exists:users,id',
            'admin_id'         => 'nullable|exists:users,id',
            'title'            => 'required|string|max:255',
            'description'      => 'nullable|string',
            'animal_type'      => 'required|string|max:100',
            'price_per_unit'   => 'required|numeric|min:0',
            'total_units'      => 'required|integer|min:1',
            'sold_units'       => 'nullable|integer|min:0',
            'duration_months'  => 'required|integer|min:1',
            'profit_percentage'=> 'required|numeric|min:0|max:100',
            'status'           => 'nullable|in:draft,active,full,finished',
            'media.*'          => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240'
        ]);

        $validated['admin_id'] = auth()->id();
        $validated['sold_units'] = $validated['sold_units'] ?? 0;

        $project = Project::create($validated);

        if($request->hasFile('media')){
            foreach($request->file('media') as $file){
                $path = $file->store('projects/media', 'public');
                ProjectMedia::create([
                    'project_id' => $project->id,
                    'type' => $this->detectMediaType($file->getClientMimeType()),
                    'url' => $path,
                ]);
            }
        }

        return redirect()->route('projects.index')->with('success', 'Project Berhasil Dibuat');
    }
    public function show(Project $project){
        $project->load(['farmer', 'admin', 'media', 'investments']);
        return view('admin.projectDetail', compact('project'));
    }

    public function edit(Project $project){
        $farmers = User::where('role', 'farmer')->get();
        return view('admin.projectEdit', compact('project', 'farmers'));
    }

    public function update(Request $request, Project $project){
         $validated = $request->validate([
            'farmer_id'        => 'sometimes|required|exists:users,id',
            'admin_id'         => 'sometimes|nullable|exists:users,id',
            'title'            => 'sometimes|required|string|max:255',
            'description'      => 'sometimes|nullable|string',
            'animal_type'      => 'sometimes|required|string|max:100',
            'price_per_unit'   => 'sometimes|required|numeric|min:0',
            'total_units'      => 'sometimes|required|integer|min:1',
            'sold_units'       => 'sometimes|nullable|integer|min:0',
            'duration_months'  => 'sometimes|required|integer|min:1',
            'profit_percentage'=> 'sometimes|required|numeric|min:0|max:100',
            'status'           => 'sometimes|in:draft,active,full,finished',
            'media.*'          => 'nullable|file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
        ]);

        // Upload tambahan media jika ada (menambah, bukan mengganti)
        if ($request->hasFile('media')) {
            foreach ($request->file('media') as $file) {
                $path = $file->store('projects/media', 'public');

                ProjectMedia::create([
                    'project_id' => $project->id,
                    'type' => $this->detectMediaType($file->getClientMimeType()),
                    'url' => $path,
                ]);
            }
        }

        // Hindari overwrite sold_units jika tidak dikirim
        if (!array_key_exists('sold_units', $validated)) {
            unset($validated['sold_units']);
        }

        $project->update($validated);

        return redirect()->route('projects.index')->with('success', 'Project berhasil diperbarui.');
    }

    public function destroy(Project $project){
        foreach($project->media as $m){
            if($m->url){
                Storage::disk('public')->delete($m->url);
            }
            $m->delete();
        }
        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project Berhasil DIhapus');
    }

     public function destroyMedia(Project $project, ProjectMedia $media)
    {
        // pastikan media milik project
        if ($media->project_id != $project->id) {
            abort(403);
        }

        if ($media->url) {
            Storage::disk('public')->delete($media->url);
        }
        $media->delete();

        return back()->with('success', 'Media berhasil dihapus.');
    }



    /**
     * Deteksi tipe media dari mime type
     */
    protected function detectMediaType($mime)
    {
        if (str_contains($mime, 'image')) return 'image';
        if (str_contains($mime, 'video')) return 'video';
        return 'image';
    }
}
