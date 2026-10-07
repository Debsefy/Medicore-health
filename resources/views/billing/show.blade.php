@extends('layouts.app')
@section('title','Invoice')
@section('page-title','Invoice Detail')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('billing.index') }}">Billing</a><span>/</span><span>{{ $invoice->invoice_number }}</span></div>
    <h1 class="page-title">{{ $invoice->invoice_number }}</h1>
  </div>
  <div class="flex gap-2">
    @if($invoice->status !== 'paid')
    <button data-modal="payModal" class="btn btn-success"><i class="fas fa-check-circle"></i> Mark as Paid</button>
    @endif
    <a href="{{ route('billing.print', $invoice) }}" class="btn btn-outline" target="_blank"><i class="fas fa-print"></i> Print</a>
  </div>
</div>

<div class="grid grid-12">
  <div class="col-8">
    <div class="card">
      <div class="card-body" style="padding:32px;">

        <!-- Invoice Header -->
        <div class="invoice-header flex justify-between items-center">
          <div>
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:8px;">
              <div style="width:44px;height:44px;background:linear-gradient(135deg,var(--primary),var(--accent));border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;color:#fff;"><i class="fas fa-heartbeat"></i></div>
              <div>
                <div style="font-size:22px;font-weight:800;color:var(--gray-900);">MediCore HMS</div>
                <div style="font-size:12px;color:var(--gray-400);">Hospital Management System</div>
              </div>
            </div>
          </div>
          <div style="text-align:right;">
            <div style="font-size:28px;font-weight:800;color:var(--primary);">INVOICE</div>
            <div style="font-size:16px;font-weight:600;color:var(--gray-600);">{{ $invoice->invoice_number }}</div>
            <span class="badge badge-{{ $invoice->status_color }}" style="font-size:13px;padding:5px 12px;margin-top:6px;display:inline-block;">{{ ucfirst($invoice->status) }}</span>
          </div>
        </div>

        <!-- Meta -->
        <div class="invoice-meta-grid">
          <div class="invoice-meta-item"><label>Bill To</label><p>{{ $invoice->patient->full_name }}</p><p style="font-size:12px;color:var(--gray-500);">{{ $invoice->patient->patient_id }}</p><p style="font-size:12px;color:var(--gray-500);">{{ $invoice->patient->phone }}</p></div>
          <div class="invoice-meta-item"><label>Invoice Date</label><p>{{ $invoice->created_at->format('M d, Y') }}</p></div>
          <div class="invoice-meta-item"><label>Due Date</label><p>{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'On Receipt' }}</p></div>
        </div>

        <!-- Items Table -->
        <div class="table-wrapper" style="margin-bottom:24px;">
          <table class="table">
            <thead>
              <tr><th>#</th><th>Description</th><th>Type</th><th style="text-align:right;">Qty</th><th style="text-align:right;">Unit Price</th><th style="text-align:right;">Total</th></tr>
            </thead>
            <tbody>
              @foreach($invoice->items as $i => $item)
              <tr>
                <td style="color:var(--gray-400);">{{ $i+1 }}</td>
                <td style="font-weight:600;">{{ $item->description }}</td>
                <td><span style="background:var(--info-soft);color:var(--info);padding:2px 8px;border-radius:20px;font-size:11px;text-transform:capitalize;">{{ $item->type }}</span></td>
                <td style="text-align:right;">{{ $item->quantity }}</td>
                <td style="text-align:right;">₦{{ number_format($item->unit_price,2) }}</td>
                <td style="text-align:right;font-weight:700;">₦{{ number_format($item->total,2) }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>

        <!-- Totals -->
        <div class="invoice-totals">
          <div class="invoice-total-row"><span>Subtotal</span><span>₦{{ number_format($invoice->subtotal,2) }}</span></div>
          @if($invoice->tax > 0)<div class="invoice-total-row"><span>Tax</span><span>₦{{ number_format($invoice->tax,2) }}</span></div>@endif
          @if($invoice->discount > 0)<div class="invoice-total-row"><span style="color:var(--success);">Discount</span><span style="color:var(--success);">-₦{{ number_format($invoice->discount,2) }}</span></div>@endif
          <div class="invoice-total-row total-final"><span>TOTAL</span><span style="color:var(--primary);">₦{{ number_format($invoice->total,2) }}</span></div>
          @if($invoice->paid_at)
          <div style="margin-top:16px;text-align:center;background:var(--success-soft);padding:12px;border-radius:8px;">
            <div style="font-weight:700;color:var(--success);">PAID ON {{ $invoice->paid_at->format('M d, Y') }}</div>
            <div style="font-size:12px;color:var(--success);text-transform:capitalize;">Via {{ str_replace('_',' ',$invoice->payment_method) }}</div>
          </div>
          @endif
        </div>

        @if($invoice->notes)
        <div style="margin-top:24px;padding:14px;background:var(--gray-50);border-radius:8px;font-size:13px;color:var(--gray-600);">
          <strong>Notes:</strong> {{ $invoice->notes }}
        </div>
        @endif
      </div>
    </div>
  </div>

  <div class="col-4" style="display:flex;flex-direction:column;gap:16px;">
    <div class="card">
      <div class="card-header"><h3 class="card-title">Payment Status</h3></div>
      <div class="card-body" style="text-align:center;">
        <div style="font-size:40px;margin-bottom:12px;color:{{ $invoice->status==='paid' ? 'var(--success)' : ($invoice->status==='overdue' ? 'var(--danger)' : 'var(--warning)') }}">
          <i class="fas fa-{{ $invoice->status==='paid' ? 'check-circle' : ($invoice->status==='overdue' ? 'exclamation-circle' : 'clock') }}"></i>
        </div>
        <div style="font-size:20px;font-weight:800;margin-bottom:4px;">₦{{ number_format($invoice->total,2) }}</div>
        <span class="badge badge-{{ $invoice->status_color }}" style="font-size:13px;padding:5px 12px;">{{ ucfirst($invoice->status) }}</span>
        @if($invoice->transaction_ref)<div style="font-size:12px;color:var(--gray-400);margin-top:8px;">Ref: {{ $invoice->transaction_ref }}</div>@endif
      </div>
    </div>

    <div class="card">
      <div class="card-header"><h3 class="card-title">Patient</h3></div>
      <div class="card-body">
        <div class="flex items-center gap-3">
          <div class="avatar">{{ strtoupper(substr($invoice->patient->first_name,0,2)) }}</div>
          <div><div style="font-weight:700;">{{ $invoice->patient->full_name }}</div><div style="font-size:12px;color:var(--gray-400);">{{ $invoice->patient->phone }}</div></div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Pay Modal -->
<div class="modal-overlay" id="payModal">
  <div class="modal" style="max-width:440px;">
    <div class="modal-header">
      <h3 class="modal-title"><i class="fas fa-check-circle" style="color:var(--success);margin-right:8px;"></i>Record Payment</h3>
      <button class="modal-close">×</button>
    </div>
    <div class="modal-body">
      <form method="POST" action="{{ route('billing.markPaid', $invoice) }}">
        @csrf
        <div class="form-group">
          <label class="form-label">Payment Method <span>*</span></label>
          <select name="payment_method" class="form-select" required>
            <option value="cash">Cash</option>
            <option value="card">Card / POS</option>
            <option value="paystack">Paystack</option>
            <option value="stripe">Stripe</option>
            <option value="insurance">Insurance</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Transaction Reference</label>
          <input type="text" name="transaction_ref" class="form-control" placeholder="Optional reference number">
        </div>
        <div style="background:var(--success-soft);border-radius:8px;padding:14px;margin-bottom:16px;text-align:center;">
          <div style="font-size:13px;color:var(--success);">Amount to collect</div>
          <div style="font-size:26px;font-weight:800;color:var(--success);">₦{{ number_format($invoice->total,2) }}</div>
        </div>
        <button type="submit" class="btn btn-success btn-lg w-full" style="justify-content:center;"><i class="fas fa-check"></i> Confirm Payment</button>
      </form>
    </div>
  </div>
</div>
@endsection
