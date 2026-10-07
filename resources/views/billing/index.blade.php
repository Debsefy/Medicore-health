@extends('layouts.app')
@section('title','Billing')
@section('page-title','Billing & Payments')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Billing</span></div>
    <h1 class="page-title">Invoices</h1>
    <p class="page-subtitle">Manage billing and payments</p>
  </div>
  <a href="{{ route('billing.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Create Invoice</a>
</div>

<!-- Revenue Stats -->
<div class="grid grid-4 mb-6">
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:44px;height:44px;background:var(--success-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--success);"><i class="fas fa-check-circle"></i></div>
      <div><div style="font-size:22px;font-weight:800;">₦{{ number_format($stats['total_revenue'],0) }}</div><div style="font-size:12px;color:var(--gray-500);">Total Collected</div></div>
    </div>
  </div>
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:44px;height:44px;background:var(--primary-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--primary);"><i class="fas fa-clock"></i></div>
      <div><div style="font-size:22px;font-weight:800;">₦{{ number_format($stats['pending'],0) }}</div><div style="font-size:12px;color:var(--gray-500);">Pending</div></div>
    </div>
  </div>
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:44px;height:44px;background:var(--danger-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--danger);"><i class="fas fa-exclamation-circle"></i></div>
      <div><div style="font-size:24px;font-weight:800;">{{ $stats['overdue'] }}</div><div style="font-size:12px;color:var(--gray-500);">Overdue</div></div>
    </div>
  </div>
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:44px;height:44px;background:var(--accent-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--accent);"><i class="fas fa-calendar-check"></i></div>
      <div><div style="font-size:22px;font-weight:800;">₦{{ number_format($stats['this_month'],0) }}</div><div style="font-size:12px;color:var(--gray-500);">This Month</div></div>
    </div>
  </div>
</div>

<form method="GET" class="filter-bar">
  <div class="filter-search"><i class="fas fa-search"></i><input type="text" name="search" placeholder="Search invoice #, patient..." value="{{ request('search') }}"></div>
  <select name="status" class="filter-select" onchange="this.form.submit()">
    <option value="">All Status</option>
    @foreach(['draft','sent','paid','overdue','cancelled'] as $s)<option value="{{ $s }}" {{ request('status')==$s ? 'selected':'' }}>{{ ucfirst($s) }}</option>@endforeach
  </select>
  <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i></button>
  @if(request()->hasAny(['search','status']))<a href="{{ route('billing.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i></a>@endif
</form>

<div class="card">
  <div class="table-wrapper" style="border:none;border-radius:0;">
    <table class="table">
      <thead><tr><th>Invoice #</th><th>Patient</th><th>Date</th><th>Due Date</th><th>Total</th><th>Payment Method</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($invoices as $invoice)
        <tr>
          <td><code style="font-size:12px;background:var(--gray-100);padding:2px 6px;border-radius:4px;">{{ $invoice->invoice_number }}</code></td>
          <td>
            <div style="font-weight:600;font-size:13px;">{{ $invoice->patient->full_name }}</div>
            <div style="font-size:11px;color:var(--gray-400);">{{ $invoice->patient->patient_id }}</div>
          </td>
          <td style="font-size:13px;">{{ $invoice->created_at->format('M d, Y') }}</td>
          <td style="font-size:13px;">{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : '—' }}</td>
          <td style="font-weight:800;font-size:15px;color:var(--gray-900);">₦{{ number_format($invoice->total,2) }}</td>
          <td style="font-size:13px;text-transform:capitalize;">{{ str_replace('_',' ',$invoice->payment_method) }}</td>
          <td><span class="badge badge-{{ $invoice->status_color }}">{{ ucfirst($invoice->status) }}</span></td>
          <td><div class="table-actions">
            <a href="{{ route('billing.show', $invoice) }}" class="btn btn-outline btn-icon btn-sm"><i class="fas fa-eye"></i></a>
            <a href="{{ route('billing.print', $invoice) }}" class="btn btn-outline btn-icon btn-sm" target="_blank" title="Print"><i class="fas fa-print"></i></a>
          </div></td>
        </tr>
        @empty
        <tr><td colspan="8"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-file-invoice-dollar"></i></div><h3>No invoices yet</h3><a href="{{ route('billing.create') }}" class="btn btn-primary">Create Invoice</a></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $invoices->links() }}</div>
</div>
@endsection
