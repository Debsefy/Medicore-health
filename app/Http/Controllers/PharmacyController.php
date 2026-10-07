<?php

namespace App\Http\Controllers;

use App\Models\{Drug, AuditLog};
use Illuminate\Http\Request;

class PharmacyController extends Controller
{
    public function index(Request $request)
    {
        $query = Drug::query();
        if ($request->search) $query->where('name','like',"%{$request->search}%")->orWhere('generic_name','like',"%{$request->search}%");
        if ($request->category) $query->where('category', $request->category);
        if ($request->stock_status === 'low') $query->whereColumn('stock_quantity','<=','minimum_stock');
        if ($request->stock_status === 'out') $query->where('stock_quantity','<=',0);

        $drugs      = $query->paginate(15)->withQueryString();
        $categories = Drug::distinct('category')->pluck('category');
        $stats = [
            'total'      => Drug::count(),
            'low_stock'  => Drug::whereColumn('stock_quantity','<=','minimum_stock')->count(),
            'out_stock'  => Drug::where('stock_quantity','<=',0)->count(),
            'expiring'   => Drug::where('expiry_date','<=',now()->addDays(30))->where('expiry_date','>=',now())->count(),
        ];
        return view('pharmacy.index', compact('drugs','categories','stats'));
    }

    public function create() { return view('pharmacy.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string',
            'generic_name'   => 'nullable|string',
            'category'       => 'required|string',
            'manufacturer'   => 'nullable|string',
            'unit'           => 'required|string',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'expiry_date'    => 'nullable|date',
            'batch_number'   => 'nullable|string',
            'description'    => 'nullable|string',
        ]);

        $drug = Drug::create($data);
        AuditLog::record('Drug Added', $drug);
        return redirect()->route('pharmacy.index')->with('success', 'Drug added to inventory.');
    }

    public function edit(Drug $drug) { return view('pharmacy.edit', compact('drug')); }

    public function update(Request $request, Drug $drug)
    {
        $data = $request->validate([
            'name'           => 'required|string',
            'stock_quantity' => 'required|integer|min:0',
            'selling_price'  => 'required|numeric|min:0',
            'purchase_price' => 'required|numeric|min:0',
            'minimum_stock'  => 'required|integer|min:0',
            'expiry_date'    => 'nullable|date',
        ]);

        $drug->update($data);
        AuditLog::record('Drug Updated', $drug);
        return redirect()->route('pharmacy.index')->with('success', 'Drug updated.');
    }

    public function destroy(Drug $drug)
    {
        AuditLog::record('Drug Deleted', $drug);
        $drug->delete();
        return redirect()->route('pharmacy.index')->with('success', 'Drug removed.');
    }
}
