<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Type;



class ProjectsController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $valData = $request->validated();

        $valData['slug'] = Str::slug($request->title, '-');

        if ($request->has('thumb')) {
            $file_path = Storage::put('thumbs', $request->thumb);
            $valData['thumb'] = $file_path;
        }

        //dd($valData);
        $newProject = Project::create($valData);

        return to_route('admin.projects.index')->with('status', 'Well Done, New Entry Added Succeffully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $types = Type::all();
        return view('admin.projects.edit', compact('project', 'types'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $valData = $request->validated();

        $valData['slug'] = Str::slug($request->title, '-');
        //dd($valData);

        if ($request->has('thumb')) {


            $newThumb = $request->thumb;
            $path = Storage::put('thumbs', $newThumb);

            if (!is_Null($project->thumb) && Storage::fileExists($project->thumb)) {
                Storage::delete($project->thumb);
            }

            $valData['thumb'] = $path;
        }

        $project->update($valData);
        return to_route('admin.projects.show', $project->id)->with('status', 'Well Done, Element Edited Succeffully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return to_route('admin.projects.index')->with('status', 'Well Done, Element Moved to the Recycle Bin Succeffully');
    }

    public function recycle()
    {


        // PAGINATION
        $trashed_projects = Project::onlyTrashed()->paginate(4);

        return view('admin.projects.recycle', compact('trashed_projects'));
    }

    public function restore($id)
    {

        $project = Project::onlyTrashed()->find($id);
        $project->restore();

        return to_route('admin.projects.recycle')->with('status', 'Well Done, Element Restored Succeffully');
    }

    public function forceDelete($id)
    {

        $project = Project::onlyTrashed()->find($id);

        if (!is_Null($project->thumb)) {
            Storage::delete($project->thumb);
        }

        /* if ($project->thumb != null && $project->thumb != '') {
            // dd($project->thumb);
            Storage::delete($project->thumb);
        } */

        $project->forceDelete();

        return to_route('admin.projects.recycle')->with('status', 'Well Done, Element Deleted Succeffully');
    }

    public function showTrashed($id)
    {
        $project = Project::onlyTrashed()->find($id);
        dd($project);
        return view('admin.projects.showTrashed', compact('project'));
    }
}
