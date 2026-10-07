@extends('layouts.app')
@section('title','Pharmacy')
@section('page-title','Pharmacy & Inventory')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><span>Pharmacy</span></div>
    <h1 class="page-title">Drug Inventory</h1>
    <p class="page-subtitle">Manage medications and stock levels</p>
  </div>
  <a href="{{ route('pharmacy.create') }}" class="btn btn-primary"><i class="fas fa-plus"></i> Add Drug</a>
</div>

<!-- Pharmacy Stats -->
<div class="grid grid-4 mb-6">
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:44px;height:44px;background:var(--primary-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--primary);"><i class="fas fa-pills"></i></div>
      <div><div style="font-size:24px;font-weight:800;">{{ $stats['total'] }}</div><div style="font-size:12px;color:var(--gray-500);">Total Drugs</div></div>
    </div>
  </div>
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:44px;height:44px;background:var(--warning-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--warning);"><i class="fas fa-exclamation-triangle"></i></div>
      <div><div style="font-size:24px;font-weight:800;">{{ $stats['low_stock'] }}</div><div style="font-size:12px;color:var(--gray-500);">Low Stock</div></div>
    </div>
  </div>
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:44px;height:44px;background:var(--danger-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--danger);"><i class="fas fa-times-circle"></i></div>
      <div><div style="font-size:24px;font-weight:800;">{{ $stats['out_stock'] }}</div><div style="font-size:12px;color:var(--gray-500);">Out of Stock</div></div>
    </div>
  </div>
  <div class="card" style="padding:18px;">
    <div class="flex items-center gap-3">
      <div style="width:44px;height:44px;background:var(--info-soft);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:20px;color:var(--info);"><i class="fas fa-calendar-times"></i></div>
      <div><div style="font-size:24px;font-weight:800;">{{ $stats['expiring'] }}</div><div style="font-size:12px;color:var(--gray-500);">Expiring Soon</div></div>
    </div>
  </div>
</div>

<form method="GET" class="filter-bar">
  <div class="filter-search">
    <i class="fas fa-search"></i>
    <input type="text" name="search" placeholder="Search drug name, generic name..." value="{{ request('search') }}">
  </div>
  <select name="category" class="filter-select" onchange="this.form.submit()">
    <option value="">All Categories</option>
    @foreach($categories as $cat)<option value="{{ $cat }}" {{ request('category')==$cat ? 'selected':'' }}>{{ $cat }}</option>@endforeach
  </select>
  <select name="stock_status" class="filter-select" onchange="this.form.submit()">
    <option value="">All Stock</option>
    <option value="low" {{ request('stock_status')=='low' ? 'selected':'' }}>Low Stock</option>
    <option value="out" {{ request('stock_status')=='out' ? 'selected':'' }}>Out of Stock</option>
  </select>
  <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-filter"></i></button>
  @if(request()->hasAny(['search','category','stock_status']))<a href="{{ route('pharmacy.index') }}" class="btn btn-outline btn-sm"><i class="fas fa-times"></i></a>@endif
</form>

<div class="card">
  <div class="table-wrapper" style="border:none;border-radius:0;">
    <table class="table">
      <thead>
        <tr><th>Drug Name</th><th>Category</th><th>Unit</th><th>Stock</th><th>Selling Price</th><th>Expiry</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        @forelse($drugs as $drug)
        <tr>
          <td>
            <div style="font-weight:700;font-size:13.5px;">{{ $drug->name }}</div>
            @if($drug->generic_name)<div style="font-size:11px;color:var(--gray-400);">{{ $drug->generic_name }}</div>@endif
          </td>
          <td><span style="background:var(--info-soft);color:var(--info);padding:3px 8px;border-radius:20px;font-size:12px;font-weight:600;">{{ $drug->category }}</span></td>
          <td style="font-size:13px;">{{ $drug->unit }}</td>
          <td>
            <div style="font-weight:700;font-size:14px;color:{{ $drug->stock_quantity <= 0 ? 'var(--danger)' : ($drug->isLowStock() ? 'var(--warning)' : 'var(--success)') }}">{{ number_format($drug->stock_quantity) }}</div>
            <div style="font-size:11px;color:var(--gray-400);">Min: {{ $drug->minimum_stock }}</div>
            <div class="drug-stock-bar" style="width:80px;">
              @php $pct = $drug->minimum_stock > 0 ? min(100, ($drug->stock_quantity / ($drug->minimum_stock * 3)) * 100) : 0; @endphp
              <div class="drug-stock-bar-fill {{ $drug->stock_quantity <= 0 ? 'danger' : ($drug->isLowStock() ? 'low' : 'good') }}" style="width:{{ $pct }}%;"></div>
            </div>
          </td>
          <td style="font-weight:600;font-size:14px;">₦{{ number_format($drug->selling_price, 2) }}</td>
          <td style="font-size:13px;">
            @if($drug->expiry_date)
              <span style="color:{{ $drug->isExpired() ? 'var(--danger)' : ($drug->isExpiringSoon() ? 'var(--warning)' : 'var(--gray-600)') }};">
                {{ $drug->expiry_date->format('M d, Y') }}
                @if($drug->isExpired()) <i class="fas fa-exclamation-circle"></i>@endif
              </span>
            @else — @endif
          </td>
          <td>
            <span class="badge badge-{{ $drug->stock_status_color }}">
              {{ ucfirst(str_replace('_',' ',$drug->stock_status)) }}
            </span>
          </td>
          <td><div class="table-actions">
            <a href="{{ route('pharmacy.edit', $drug) }}" class="btn btn-outline btn-icon btn-sm"><i class="fas fa-edit"></i></a>
            <form method="POST" action="{{ route('pharmacy.destroy', $drug) }}" style="display:inline;">
              @csrf @method('DELETE')
              <button class="btn btn-danger btn-icon btn-sm" data-confirm="Remove {{ $drug->name }}?"><i class="fas fa-trash"></i></button>
            </form>
          </div></td>
        </tr>
        @empty
        <tr><td colspan="8"><div class="empty-state"><div class="empty-state-icon"><i class="fas fa-pills"></i></div><h3>No drugs in inventory</h3><a href="{{ route('pharmacy.create') }}" class="btn btn-primary">Add Drug</a></div></td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="card-footer">{{ $drugs->links() }}</div>
</div>
@endsection
