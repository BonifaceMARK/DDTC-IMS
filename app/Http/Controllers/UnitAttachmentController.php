<?php

namespace App\Http\Controllers;

use App\Models\UnitAttach;
use App\Models\User;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UnitAttachmentController extends Controller
{
    public function index()
    {
        $unitAttaches = UnitAttach::with('user', 'unit')->latest()->paginate(10);
        return view('unit-attach.index', compact('unitAttaches'));
    }

    public function create()
    {
        $users = User::all();
        $units = Unit::all();
        return view('unit-attach.create', compact('users', 'units'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'unit_id' => 'required',
            'att_type' => 'required|string|max:15',
            'att_file' => 'required|file',
            'stat' => 'nullable',
            'remarks' => 'nullable|string|max:100',
        ]);

        $data = $request->only(['user_id', 'unit_id', 'att_type', 'stat', 'remarks']);

        if ($request->hasFile('att_file')) {
            $file = $request->file('att_file');
            $data['att_file'] = file_get_contents($file->getRealPath());
            $data['att_dir'] = $file->store('attachments', 'public');
        }

        UnitAttach::create($data);

        return redirect()->route('unit-attach.index')->with('success', 'Attachment added successfully!');
    }

    public function edit(UnitAttach $unitAttach)
    {
        $users = User::all();
        $units = Unit::all();
        return view('unit-attach.edit', compact('unitAttach', 'users', 'units'));
    }

    public function update(Request $request, UnitAttach $unitAttach)
    {
        $request->validate([
            'user_id' => 'required',
            'unit_id' => 'required',
            'att_type' => 'required|string|max:15',
            'att_file' => 'nullable|file',
            'stat' => 'nullable',
            'remarks' => 'nullable|string|max:100',
        ]);

        $data = $request->only(['user_id', 'unit_id', 'att_type', 'stat', 'remarks']);

        if ($request->hasFile('att_file')) {
            $file = $request->file('att_file');
            $data['att_file'] = file_get_contents($file->getRealPath());
            $data['att_dir'] = $file->store('attachments', 'public');
        }

        $unitAttach->update($data);

        return redirect()->route('unit-attach.index')->with('success', 'Attachment updated successfully!');
    }
}
