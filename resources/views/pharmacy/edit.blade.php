@extends('layouts.app')
@section('title','Edit Drug')
@section('page-title','Edit Drug')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('pharmacy.index') }}">Pharmacy</a><span>/</span><span>Edit</span></div>
    <h1 class="page-title">Edit — {{ $drug->name }}</h1>
  </div>
  <a href="{{ route('pharmacy.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>
<div style="max-width:800px;">
<form method="POST" action="{{ route('pharmacy.update',$drug) }}">
@csrf @method('PUT')
<div class="card">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-pills" style="color:var(--primary);margin-right:8px;"></i>Drug Details</h3></div>
  <div class="card-body">
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Brand Name <span>*</span></label><input type="text" name="name" class="form-control" value="{{ old('name',$drug->name) }}" required></div>
      <div class="form-group"><label class="form-label">Generic Name</label><input type="text" name="generic_name" class="form-control" value="{{ old('generic_name',$drug->generic_name) }}"></div>
    </div>
    <div class="form-row cols-4" style="grid-template-columns:repeat(4,1fr);">
      <div class="form-group"><label class="form-label">Purchase Price <span>*</span></label><input type="number" name="purchase_price" class="form-control" step="0.01" value="{{ old('purchase_price',$drug->purchase_price) }}" required></div>
      <div class="form-group"><label class="form-label">Selling Price <span>*</span></label><input type="number" name="selling_price" class="form-control" step="0.01" value="{{ old('selling_price',$drug->selling_price) }}" required></div>
      <div class="form-group"><label class="form-label">Stock Quantity <span>*</span></label><input type="number" name="stock_quantity" class="form-control" value="{{ old('stock_quantity',$drug->stock_quantity) }}" required></div>
      <div class="form-group"><label class="form-label">Minimum Stock <span>*</span></label><input type="number" name="minimum_stock" class="form-control" value="{{ old('minimum_stock',$drug->minimum_stock) }}" required></div>
    </div>
    <div class="form-row cols-2">
      <div class="form-group"><label class="form-label">Expiry Date</label><input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date',$drug->expiry_date?$drug->expiry_date->format('Y-m-d'):null) }}"></div>
      <div class="form-group"><label class="form-label">Batch Number</label><input type="text" name="batch_number" class="form-control" value="{{ old('batch_number',$drug->batch_number) }}"></div>
    </div>
    <div class="flex gap-3 justify-end mt-2">
      <a href="{{ route('pharmacy.index') }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Save Changes</button>
    </div>
  </div>
</div>
</form>
</div>
@endsection
