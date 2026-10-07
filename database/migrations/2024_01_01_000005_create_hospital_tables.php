<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Medical Records
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->date('visit_date');
            $table->text('chief_complaint');
            $table->text('diagnosis');
            $table->text('treatment_plan')->nullable();
            $table->text('notes')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->integer('pulse_rate')->nullable();
            $table->timestamps();
        });

        // Prescriptions
        Schema::create('prescriptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->onDelete('cascade');
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->string('prescription_number')->unique();
            $table->json('medications'); // [{name, dosage, frequency, duration, instructions}]
            $table->text('notes')->nullable();
            $table->enum('status', ['pending', 'dispensed', 'cancelled'])->default('pending');
            $table->timestamps();
        });

        // Drugs / Pharmacy Inventory
        Schema::create('drugs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('generic_name')->nullable();
            $table->string('category');
            $table->string('manufacturer')->nullable();
            $table->string('unit'); // tablet, ml, capsule, etc.
            $table->decimal('purchase_price', 10, 2)->default(0);
            $table->decimal('selling_price', 10, 2)->default(0);
            $table->integer('stock_quantity')->default(0);
            $table->integer('minimum_stock')->default(10);
            $table->date('expiry_date')->nullable();
            $table->string('batch_number')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Lab Tests
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->string('test_number')->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('doctor_id')->constrained()->onDelete('cascade');
            $table->foreignId('medical_record_id')->nullable()->constrained()->onDelete('set null');
            $table->string('test_name');
            $table->string('test_type');
            $table->enum('status', ['requested', 'in_progress', 'completed', 'cancelled'])->default('requested');
            $table->text('instructions')->nullable();
            $table->text('result')->nullable();
            $table->string('report_file')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->decimal('price', 10, 2)->default(0);
            $table->timestamps();
        });

        // Invoices
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('tax', 10, 2)->default(0);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('payment_method', ['cash', 'card', 'paystack', 'stripe', 'insurance', 'pending'])->default('pending');
            $table->enum('status', ['draft', 'sent', 'paid', 'overdue', 'cancelled'])->default('draft');
            $table->date('due_date')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->string('transaction_ref')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Invoice Items
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained()->onDelete('cascade');
            $table->string('description');
            $table->string('type'); // consultation, lab, pharmacy, procedure
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->timestamps();
        });

        // Audit Logs
        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('action');
            $table->string('model_type')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
        });

        // Notifications
        Schema::create('system_notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('message');
            $table->string('type')->default('info'); // info, success, warning, danger
            $table->string('icon')->nullable();
            $table->boolean('is_read')->default(false);
            $table->string('action_url')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('system_notifications');
        Schema::dropIfExists('audit_logs');
        Schema::dropIfExists('invoice_items');
        Schema::dropIfExists('invoices');
        Schema::dropIfExists('lab_tests');
        Schema::dropIfExists('drugs');
        Schema::dropIfExists('prescriptions');
        Schema::dropIfExists('medical_records');
    }
};
