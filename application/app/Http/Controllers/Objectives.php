<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Objective;
use Illuminate\Http\Request;

class Objectives extends Controller
{
    public function index()
    {
        $objectives = Objective::all();
        return view('pages.objectives.wrapper', compact('objectives'));
    }



    public function create()
    {
    return view('objectives.create');
    }



    public function store(Request $request)
    {
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'module' => 'required|in:leads,invoices,payments,clients,expenses',
        'target_value' => 'required|integer',
        // ... otros campos ...
    ]);

    $objective = Objective::create($validatedData);
    return redirect()->route('objectives.index')->with('success', 'Objective created successfully.');
    }



    public function show(Objective $objective)
    {
    return view('objectives.show', compact('objective'));
    }



    public function update(Request $request, Objective $objective)
    {
    $validatedData = $request->validate([
        'name' => 'required|max:255',
        'module' => 'required|in:leads,invoices,payments,clients,expenses',
        'target_value' => 'required|integer',
        // ... otros campos ...
    ]);

    $objective->update($validatedData);
    return redirect()->route('objectives.index')->with('success', 'Objective updated successfully.');
    }



    public function destroy(Objective $objective)
    {
    $objective->delete();
    return redirect()->route('objectives.index')->with('success', 'Objective deleted successfully.');
    }





    
}
