@extends('layouts.app')
@section('title','Add Drug')
@section('page-title','Add Drug to Inventory')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('pharmacy.index') }}">Pharmacy</a><span>/</span><span>Add Drug</span></div>
    <h1 class="page-title">Add New Drug</h1>
  </div>
  <a href="{{ route('pharmacy.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<div style="max-width:860px;">
<form method="POST" action="{{ route('pharmacy.store') }}">
@csrf
<div class="card">
  <div class="card-header"><h3 class="card-title"><i class="fas fa-pills" style="color:var(--primary);margin-right:8px;"></i>Drug Information</h3></div>
  <div class="card-body">

    <div class="form-row cols-2">
      <div class="form-group">
        <label class="form-label">Brand Name <span>*</span></label>
        <input type="text" name="name" class="form-control" placeholder="e.g. Amoxil" value="{{ old('name') }}" required>
      </div>
      <div class="form-group">
        <label class="form-label">Generic Name</label>
        <input type="text" name="generic_name" class="form-control" placeholder="e.g. Amoxicillin" value="{{ old('generic_name') }}">
      </div>
    </div>

    <div class="form-row cols-3">
      <div class="form-group">
        <label class="form-label">Category <span>*</span></label>
        <input type="text" name="category" class="form-control" list="categories" placeholder="e.g. Antibiotics" value="{{ old('category') }}" required>
        <datalist id="categories">
          @foreach(['Antibiotics','Analgesics','Antihypertensives','Antidiabetics','Vitamins','Antihistamines','Antifungals','Antivirals','Cardiovascular','Gastrointestinal'] as $cat)
          <option value="{{ $cat }}">
          @endforeach
        </datalist>
      </div>
      <div class="form-group">
        <label class="form-label">Manufacturer</label>
        <input type="text" name="manufacturer" class="form-control" placeholder="e.g. GlaxoSmithKline" value="{{ old('manufacturer') }}">
      </div>
      <div class="form-group">
        <label class="form-label">Unit <span>*</span></label>
        <select name="unit" class="form-select" required>
          <option value="">Select unit</option>
          @foreach(['Tablet','Capsule','Syrup (ml)','Injection (ml)','Cream (g)','Drop','Patch','Inhaler','Suppository'] as $u)
          <option value="{{ $u }}" {{ old('unit')==$u ? 'selected':'' }}>{{ $u }}</option>
          @endforeach
        </select>
      </div>
    </div>

    <div class="form-row cols-4" style="grid-template-columns:repeat(4,1fr);">
      <div class="form-group">
        <label class="form-label">Purchase Price (₦) <span>*</span></label>
        <input type="number" name="purchase_price" class="form-control" step="0.01" placeholder="0.00" value="{{ old('purchase_price') }}" required>
      </div>
      <div class="form-group">
        <label class="form-label">Selling Price (₦) <span>*</span></label>
        <input type="number" name="selling_price" class="form-control" step="0.01" placeholder="0.00" value="{{ old('selling_price') }}" required>
      </div>
      <div class="form-group">
        <label class="form-label">Stock Quantity <span>*</span></label>
        <input type="number" name="stock_quantity" class="form-control" placeholder="0" value="{{ old('stock_quantity',0) }}" required>
      </div>
      <div class="form-group">
        <label class="form-label">Minimum Stock <span>*</span></label>
        <input type="number" name="minimum_stock" class="form-control" placeholder="10" value="{{ old('minimum_stock',10) }}" required>
      </div>
    </div>

    <div class="form-row cols-2">
      <div class="form-group">
        <label class="form-label">Expiry Date</label>
        <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
      </div>
      <div class="form-group">
        <label class="form-label">Batch Number</label>
        <input type="text" name="batch_number" class="form-control" placeholder="e.g. BT-2024-001" value="{{ old('batch_number') }}">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Description / Instructions</label>
      <textarea name="description" class="form-control" rows="3" placeholder="Usage instructions, contraindications, storage...">{{ old('description') }}</textarea>
    </div>

    <div class="flex gap-3 justify-end">
      <a href="{{ route('pharmacy.index') }}" class="btn btn-outline">Cancel</a>
      <button type="submit" class="btn btn-primary btn-lg"><i class="fas fa-save"></i> Add to Inventory</button>
    </div>
  </div>
</div>
</form>
</div>
@endsection
