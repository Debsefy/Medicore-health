<?php

namespace App\Http\Controllers;

use App\Models\{Invoice, InvoiceItem, Patient, Appointment, AuditLog};
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('patient');
        if ($request->search) {
            $query->where('invoice_number','like',"%{$request->search}%")
                  ->orWhereHas('patient', fn($q) => $q->where('first_name','like',"%{$request->search}%")->orWhere('last_name','like',"%{$request->search}%"));
        }
        if ($request->status) $query->where('status', $request->status);
        $invoices = $query->latest()->paginate(15)->withQueryString();
        $stats = [
            'total_revenue'  => Invoice::where('status','paid')->sum('total'),
            'pending'        => Invoice::whereIn('status',['sent','draft'])->sum('total'),
            'overdue'        => Invoice::where('status','overdue')->count(),
            'this_month'     => Invoice::where('status','paid')->whereMonth('paid_at', now()->month)->sum('total'),
        ];
        return view('billing.index', compact('invoices','stats'));
    }

    public function create()
    {
        $patients     = Patient::where('status','active')->get();
        $appointments = Appointment::with('patient')->where('status','completed')->doesntHave('invoice')->get();
        return view('billing.create', compact('patients','appointments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'due_date'       => 'nullable|date',
            'items'          => 'required|array|min:1',
            'items.*.desc'   => 'required|string',
            'items.*.type'   => 'required|string',
            'items.*.qty'    => 'required|integer|min:1',
            'items.*.price'  => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['qty'] * $item['price'];
        }
        $tax      = $subtotal * ($request->tax_percent / 100);
        $discount = $request->discount ?? 0;
        $total    = $subtotal + $tax - $discount;

        $invoice = Invoice::create([
            'patient_id'      => $request->patient_id,
            'appointment_id'  => $request->appointment_id,
            'subtotal'        => $subtotal,
            'tax'             => $tax,
            'discount'        => $discount,
            'total'           => $total,
            'payment_method'  => 'pending',
            'status'          => 'draft',
            'due_date'        => $request->due_date,
            'notes'           => $request->notes,
        ]);

        foreach ($request->items as $item) {
            InvoiceItem::create([
                'invoice_id'  => $invoice->id,
                'description' => $item['desc'],
                'type'        => $item['type'],
                'quantity'    => $item['qty'],
                'unit_price'  => $item['price'],
                'total'       => $item['qty'] * $item['price'],
            ]);
        }

        AuditLog::record('Invoice Created', $invoice);
        return redirect()->route('billing.show', $invoice)->with('success', 'Invoice created.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load(['patient','appointment','items']);
        return view('billing.show', compact('invoice'));
    }

    public function markPaid(Request $request, Invoice $invoice)
    {
        $request->validate(['payment_method' => 'required|in:cash,card,paystack,stripe,insurance']);
        $invoice->update([
            'status'          => 'paid',
            'payment_method'  => $request->payment_method,
            'paid_at'         => now(),
            'transaction_ref' => $request->transaction_ref,
        ]);
        AuditLog::record('Invoice Paid', $invoice);
        return redirect()->route('billing.show', $invoice)->with('success', 'Payment recorded.');
    }

    public function print(Invoice $invoice)
    {
        $invoice->load(['patient','appointment','items']);
        return view('billing.print', compact('invoice'));
    }
}
