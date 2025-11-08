<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Popular; // <-- You'll create this model later
use Validator;
use App\Services\FileService;
use App\Http\Resources\Dropdown\BlockResource as DDBlockResource;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CustomersExport;

class PopularController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');

        if ($keyword) {
            $results = Popular::where('name', 'like', "%{$keyword}%")
                ->paginate($request->input('pageLength', 10));
        } else {
            $results = Popular::paginate($request->input('pageLength', 10));
        }

        return view('admin.masters.popular.list', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statuses = _getGlobalStatus();
        return view('admin.masters.popular.create', compact('statuses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:2|max:99',
        ]);

        Popular::create([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return redirect()->route('popular.index')->with('success', 'Popular item created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $result = Popular::findOrFail($id);
        return view('admin.masters.popular.show', compact('result'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $result = Popular::findOrFail($id);
        $statuses = _getGlobalStatus();

        return view('admin.masters.popular.edit', compact('result', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|min:2|max:99',
        ]);

        $result = Popular::findOrFail($id);

        $result->update([
            'name' => $request->name,
            'status' => $request->status ?? 1,
        ]);

        return redirect()->route('popular.index')->with('success', 'Popular item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $result = Popular::findOrFail($id);
        $result->delete();

        return redirect()->route('popular.index')->with('success', 'Popular item deleted successfully!');
    }

    /**
     * Validation rules for Popular model.
     */
    public function rules($id = "")
    {
        $rules = [];

        if ($id) {
            $rules['name'] = "required|unique:populars,name,{$id},id|min:2|max:99";
        } else {
            $rules['name'] = "required|unique:populars,name,null,id|min:2|max:99";
        }

        return $rules;
    }

    public function messages()
    {
        return [];
    }

    public function attributes()
    {
        return [];
    }

    /**
     * Export Popular items to Excel.
     */
    public function export(Request $request)
    {
        $filename = 'popular_' . date('d-m-Y') . '.xlsx';
        return Excel::download(new CustomersExport, $filename);
    }
}
