<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (auth()->user()->can('architect')) {
            $projects = \App\Project::where('user_id', auth()->user()->id)
                ->orderBy('id', 'desc')
                ->get();
        } else if (auth()->user()->can('admin')) {
            $projects = \App\Project::orderBy('id', 'desc')->get();
        }
        return view('projects/index')->with([
            'projects' => $projects
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'project_architect_price' => 'required',
            'area' => 'required',
            'images' => 'required',
            'images.*' => 'mimes:jpeg,png',
        ]);

        $data = $request->only('description', 'project_architect_price', 'area');
        $data['project_architect_price'] = str_replace('.', '', $data['project_architect_price']);
        $data['project_architect_price'] = str_replace(',', '.', $data['project_architect_price']);
        $data['project_engineer_price'] = 0;
        $data['project_final_price'] = $data['project_architect_price'];
        $data['construction_price'] = 0;
        $data['user_id'] = auth()->user()->id;

        $project = \App\Project::create($data);

        if ($request->hasfile('images')) {
            $i = 0;
            foreach ($request->file('images') as $file) {
                $name = strtolower($file->getClientOriginalName());
                $file->move(public_path() . '/files/', $name);  
                
                \App\ProjectImage::create([
                    'project_id' => $project->id,
                    'file' => $name,
                    'main' => ($i == 0) ? true : false
                ]);
                $i++;
            }

        }

        return back()->with('success', 'O projeto foi criado!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $project = \App\Project::find($id);
        return view('projects/show')->with([
            'project' => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $project = \App\Project::find($id);

        if (!auth()->user()->can('edit-project', $project)) {
            return back()->with('error', 'Você não tem permissão para editar esse projeto');
        }

        return view('projects/edit')->with([
            'project' => $project
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $project = \App\Project::find($id);

        if (!auth()->user()->can('edit-project', $project)) {
            return back()->with('error', 'Você não tem permissão para editar esse projeto');
        }
        
        if (auth()->user()->can('architect')) {
            $request->validate([
                'description' => 'required',
                'project_architect_price' => 'required',
                'area' => 'required',
                'images.*' => 'mimes:jpeg,png',
            ]);

            $data = $request->only('description', 'project_architect_price', 'area');
            $data['project_architect_price'] = str_replace('.', '', $data['project_architect_price']);
            $data['project_architect_price'] = str_replace(',', '.', $data['project_architect_price']);
            $data['project_engineer_price'] = 0;
            $data['project_final_price'] = $data['project_architect_price'];
            $data['construction_price'] = 0;
            $data['user_id'] = auth()->user()->id;

            $project->update($data);

            if ($request->hasfile('images')) {
                $i = 0;
                foreach ($request->file('images') as $file) {
                    $name = strtolower($file->getClientOriginalName());
                    $file->move(public_path() . '/files/', $name);  
                    
                    \App\ProjectImage::create([
                        'project_id' => $project->id,
                        'file' => $name,
                        'main' => false
                    ]);
                }
            }

            // Atualiza a imagem principal
            \App\ProjectImage::where('project_id', $id)->update([
                'main' => false
            ]);
            if ($request->main_image) {
                $mainImage = \App\ProjectImage::find($request->main_image);
                $mainImage->update([
                    'main' => true
                ]);
            }

            if (count($request->deleted_images)) {
                // Exclui as imagens
                foreach ($request->deleted_images as $imageId) {
                    $image = \App\ProjectImage::find($imageId);
                    unlink (public_path() . '/files/' . $image->file);
                    $image->delete();
                }
            }
        }

        if (auth()->user()->can('admin')) {
            $request->validate([
                'description' => 'required',
                'project_architect_price' => 'required',
                'project_engineer_price' => 'required',
                'construction_price' => 'required',
                'area' => 'required',
            ]);

            $data = $request->only('description', 'project_architect_price', 'area', 
                'project_engineer_price', 'construction_price', 'active');
            $data['project_architect_price'] = str_replace('.', '', $data['project_architect_price']);
            $data['project_architect_price'] = str_replace(',', '.', $data['project_architect_price']);
            $data['project_engineer_price'] = str_replace('.', '', $data['project_engineer_price']);
            $data['project_engineer_price'] = str_replace(',', '.', $data['project_engineer_price']);
            $data['construction_price'] = str_replace('.', '', $data['construction_price']);
            $data['construction_price'] = str_replace(',', '.', $data['construction_price']);
            $data['project_final_price'] = $data['project_architect_price'] + $data['project_engineer_price'];

            $project->update($data);
        }

        return back()->with('success', 'O projeto foi atualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
