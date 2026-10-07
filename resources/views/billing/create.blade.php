@extends('layouts.app')
@section('title','Create Invoice')
@section('page-title','Create Invoice')

@section('content')
<div class="page-header">
  <div class="page-header-left">
    <div class="breadcrumb"><a href="{{ route('dashboard') }}">Home</a><span>/</span><a href="{{ route('billing.index') }}">Billing</a><span>/</span><span>Create</span></div>
    <h1 class="page-title">Create Invoice</h1>
  </div>
  <a href="{{ route('billing.index') }}" class="btn btn-outline"><i class="fas fa-arrow-left"></i> Back</a>
</div>

<form method="POST" action="{{ route('billing.store') }}">
@csrf
<div class="grid grid-12">

  <div class="col-8" style="display:flex;flex-direction:column;gap:18px;">

    <!-- Patient & Appointment -->
    <div class="card">
      <div class="card-header"><h3 class="card-title"><i class="fas fa-user" style="color:var(--primary);margin-right:8px;"></i>Patient Details</h3></div>
      <div class="card-body">
        <div class="form-row cols-2">
          <div class="form-group">
            <label class="form-label">Patient <span>*</span></label>
            <select name="patient_id" class="form-select" required>
              <option value="">— Select patient —</option>
              @foreach($patients as $p)<option value="{{ $p->id }}" {{ old('patient_id')==$p->id ? 'selected':'' }}>{{ $p->full_name }} ({{ $p->patient_id }})</option>@endforeach
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Link to Appointment</label>
            <select name="appointment_id" class="form-select">
              <option value="">None</option>
              @foreach($appointments as $apt)<option value="{{ $apt->id }}" {{ old('appointment_id')==$apt->id ? 'selected':'' }}>{{ $apt->appointment_number }} — {{ $apt->patient->full_name }}</option>@endforeach
            </select>
          </div>
        </div>
        <div class="form-row cols-2">
          <div class="form-group">
            <label class="form-label">Due Date</label>
            <input type="date" name="due_date" class="form-control" value="{{ old('due_date', date('Y-m-d', strtotime('+7 days'))) }}">
          </div>
        </div>
      </div>
    </div>

    <!-- Invoice Items -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-list" style="color:var(--success);margin-right:8px;"></i>Invoice Items</h3>
        <button type="button" id="addInvoiceItem" class="btn btn-outline btn-sm"><i class="fas fa-plus"></i> Add Item</button>
      </div>
      <div class="card-body" style="padding:0;">
        <div class="table-wrapper" style="border:none;border-radius:0;">
          <table class="table">
            <thead>
              <tr>
                <th style="width:35%;">Description</th>
                <th style="width:18%;">Type</th>
                <th style="width:10%;">Qty</th>
                <th style="width:15%;">Unit Price (₦)</th>
                <th style="width:12%;">Total (₦)</th>
                <th style="width:10%;"></th>
              </tr>
            </thead>
            <tbody id="invoiceItemsBody">
              <tr class="invoice-item-row">
                <td><input type="text" name="items[0][desc]" class="form-control" placeholder="e.g. Consultation fee" required></td>
                <td>
                  <select name="items[0][type]" class="form-select">
                    <option value="consultation">Consultation</option>
                    <option value="lab">Lab Test</option>
                    <option value="pharmacy">Pharmacy</option>
                    <option value="procedure">Procedure</option>
                    <option value="other">Other</option>
                  </select>
                </td>
                <td><input type="number" name="items[0][qty]" class="form-control item-qty" value="1" min="1"></td>
                <td><input type="number" name="items[0][price]" class="form-control item-price" value="0" step="0.01"></td>
                <td class="item-total" style="font-weight:700;">0.00</td>
                <td><button type="button" class="btn btn-danger btn-icon btn-sm remove-item"><i class="fas fa-times"></i></button></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

  </div>

  <!-- Totals Sidebar -->
  <div class="col-4">
    <div class="card sticky" style="position:sticky;top:80px;">
      <div class="card-header"><h3 class="card-title">Summary</h3></div>
      <div class="card-body" style="display:flex;flex-direction:column;gap:14px;">

        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--gray-100);">
          <span style="font-size:14px;color:var(--gray-600);">Subtotal</span>
          <span style="font-size:15px;font-weight:700;">₦<span id="subtotalDisplay">0.00</span></span>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;">
          <label style="font-size:14px;color:var(--gray-600);">Tax (%)</label>
          <input type="number" id="taxPercent" name="tax_percent" class="form-control" style="width:80px;text-align:right;" value="0" min="0" max="100">
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;padding:8px 0;border-bottom:1px solid var(--gray-100);">
          <span style="font-size:14px;color:var(--gray-600);">Tax Amount</span>
          <span style="font-size:14px;color:var(--gray-600);">₦<span id="taxDisplay">0.00</span></span>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;">
          <label style="font-size:14px;color:var(--gray-600);">Discount (₦)</label>
          <input type="number" id="discountVal" name="discount" class="form-control" style="width:100px;text-align:right;" value="0" min="0">
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;padding:10px 0;border-bottom:1px solid var(--gray-100);">
          <span style="font-size:14px;color:var(--gray-600);">Discount</span>
          <span style="font-size:14px;color:var(--success);">-₦<span id="discountDisplay">0.00</span></span>
        </div>

        <div style="display:flex;justify-content:space-between;align-items:center;padding:14px;background:var(--primary-light);border-radius:8px;">
          <span style="font-size:16px;font-weight:700;">TOTAL</span>
          <span style="font-size:20px;font-weight:800;color:var(--primary);">₦<span id="totalDisplay">0.00</span></span>
        </div>

        <div class="form-group">
          <label class="form-label">Notes</label>
          <textarea name="notes" class="form-control" rows="3" placeholder="Payment terms, special notes..."></textarea>
        </div>

        <button type="submit" class="btn btn-primary btn-lg w-full" style="justify-content:center;"><i class="fas fa-file-invoice-dollar"></i> Create Invoice</button>
        <a href="{{ route('billing.index') }}" class="btn btn-outline w-full" style="justify-content:center;">Cancel</a>
      </div>
    </div>
  </div>

</div>
</form>
@endsection
