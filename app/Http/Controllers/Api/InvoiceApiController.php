<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceApiController extends Controller
{
    public function index(Request $request)
    {
        $invoices = Invoice::with('patient')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->paginate(20);

        return response()->json($invoices);
    }

    public function show(Invoice $invoice)
    {
        return response()->json($invoice->load('patient', 'items'));
    }
}
