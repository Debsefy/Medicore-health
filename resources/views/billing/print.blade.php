<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><title>Invoice {{ $invoice->invoice_number }} — MediCore HMS</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box;margin:0;padding:0}
    body{font-family:'Plus Jakarta Sans',sans-serif;background:#fff;color:#1e293b;padding:40px;font-size:14px}
    .header{display:flex;justify-content:space-between;align-items:flex-start;border-bottom:3px solid #0f6fff;padding-bottom:24px;margin-bottom:24px}
    .logo{display:flex;align-items:center;gap:12px}
    .logo-icon{width:44px;height:44px;background:linear-gradient(135deg,#0f6fff,#06b6d4);border-radius:12px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:20px}
    .brand-name{font-size:22px;font-weight:800}
    .invoice-label{font-size:32px;font-weight:800;color:#0f6fff}
    .meta{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:24px}
    .meta-item label{font-size:10px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#94a3b8;display:block;margin-bottom:4px}
    .meta-item p{font-size:14px;font-weight:600}
    table{width:100%;border-collapse:collapse;margin-bottom:24px}
    th{background:#f8fafc;padding:10px 14px;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:#64748b;border-bottom:1px solid #e2e8f0;text-align:left}
    td{padding:12px 14px;border-bottom:1px solid #f1f5f9;font-size:13px}
    .totals{margin-left:auto;width:300px}
    .total-row{display:flex;justify-content:space-between;padding:8px 0;border-bottom:1px solid #f1f5f9}
    .total-final{font-size:18px;font-weight:800;border-top:2px solid #1e293b;padding-top:12px;margin-top:4px}
    .paid-stamp{text-align:center;padding:16px;background:#d1fae5;border-radius:8px;margin-top:20px;color:#065f46;font-weight:700;font-size:16px}
    .footer{margin-top:40px;text-align:center;font-size:12px;color:#94a3b8;border-top:1px solid #e2e8f0;padding-top:16px}
    @media print{body{padding:20px}}
  </style>
</head>
<body>
  <div class="header">
    <div class="logo">
      <div class="logo-icon">♥</div>
      <div><div class="brand-name">MediCore HMS</div><div style="font-size:12px;color:#64748b;">Hospital Management System</div></div>
    </div>
    <div style="text-align:right;">
      <div class="invoice-label">INVOICE</div>
      <div style="font-size:16px;font-weight:600;color:#475569">{{ $invoice->invoice_number }}</div>
      <div style="margin-top:8px;background:{{ $invoice->status==='paid' ? '#d1fae5' : '#fef3c7' }};color:{{ $invoice->status==='paid' ? '#065f46' : '#92400e' }};padding:3px 12px;border-radius:20px;font-size:12px;font-weight:700;display:inline-block;">{{ strtoupper($invoice->status) }}</div>
    </div>
  </div>

  <div class="meta">
    <div class="invoice-meta-item"><label>Bill To</label><p>{{ $invoice->patient->full_name }}</p><p style="font-size:12px;color:#64748b;">{{ $invoice->patient->patient_id }}</p><p style="font-size:12px;color:#64748b;">{{ $invoice->patient->phone }}</p></div>
    <div class="invoice-meta-item"><label>Invoice Date</label><p>{{ $invoice->created_at->format('M d, Y') }}</p></div>
    <div class="invoice-meta-item"><label>Due Date</label><p>{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'On Receipt' }}</p></div>
  </div>

  <table>
    <thead><tr><th>#</th><th>Description</th><th>Type</th><th style="text-align:right">Qty</th><th style="text-align:right">Unit Price</th><th style="text-align:right">Total</th></tr></thead>
    <tbody>
      @foreach($invoice->items as $i => $item)
      <tr>
        <td>{{ $i+1 }}</td>
        <td><strong>{{ $item->description }}</strong></td>
        <td style="text-transform:capitalize;">{{ $item->type }}</td>
        <td style="text-align:right;">{{ $item->quantity }}</td>
        <td style="text-align:right;">₦{{ number_format($item->unit_price,2) }}</td>
        <td style="text-align:right;font-weight:700;">₦{{ number_format($item->total,2) }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="totals">
    <div class="total-row"><span>Subtotal</span><span>₦{{ number_format($invoice->subtotal,2) }}</span></div>
    @if($invoice->tax > 0)<div class="total-row"><span>Tax</span><span>₦{{ number_format($invoice->tax,2) }}</span></div>@endif
    @if($invoice->discount > 0)<div class="total-row"><span style="color:#10b981">Discount</span><span style="color:#10b981">-₦{{ number_format($invoice->discount,2) }}</span></div>@endif
    <div class="total-row total-final"><span>TOTAL</span><span style="color:#0f6fff">₦{{ number_format($invoice->total,2) }}</span></div>
  </div>

  @if($invoice->status === 'paid')
  <div class="paid-stamp">✓ PAID — {{ $invoice->paid_at->format('M d, Y') }} via {{ ucfirst(str_replace('_',' ',$invoice->payment_method)) }}{{ $invoice->transaction_ref ? ' · Ref: '.$invoice->transaction_ref : '' }}</div>
  @endif

  @if($invoice->notes)<div style="margin-top:20px;padding:12px;background:#f8fafc;border-radius:6px;font-size:13px;color:#475569;"><strong>Notes:</strong> {{ $invoice->notes }}</div>@endif

  <div class="footer">MediCore Hospital Management System · Generated {{ now()->format('M d, Y h:i A') }}</div>

  <script>window.onload = () => window.print();</script>
</body>
</html>
