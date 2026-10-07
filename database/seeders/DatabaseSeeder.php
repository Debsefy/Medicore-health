<?php

namespace Database\Seeders;

use App\Models\{User, Doctor, Patient, Appointment, Drug, Invoice, InvoiceItem};
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ─────────────────────────────────────────
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@hospital.com',
            'phone'    => '+234 800 000 0001',
            'password' => Hash::make('password'),
            'role'     => 'admin',
            'is_active'=> true,
        ]);

        // ── Receptionist ──────────────────────────────────
        User::create([
            'name'     => 'Sarah Reception',
            'email'    => 'reception@hospital.com',
            'phone'    => '+234 800 000 0004',
            'password' => Hash::make('password'),
            'role'     => 'receptionist',
            'is_active'=> true,
        ]);

        // ── Nurse ─────────────────────────────────────────
        User::create([
            'name'     => 'Nurse Grace',
            'email'    => 'nurse@hospital.com',
            'phone'    => '+234 800 000 0003',
            'password' => Hash::make('password'),
            'role'     => 'nurse',
            'is_active'=> true,
        ]);

        // ── Doctors ───────────────────────────────────────
        $doctorData = [
            ['Dr. James Adeyemi', 'doctor@hospital.com',  'Cardiology',      'MBBS, FMCP',  12],
            ['Dr. Amina Hassan',  'amina@hospital.com',   'Pediatrics',      'MBBS, FMCPaed', 8],
            ['Dr. Chukwu Obi',   'obi@hospital.com',     'General Practice','MBBS',         5],
            ['Dr. Fatima Bello', 'fatima@hospital.com',  'Gynecology',      'MBBS, FMCOG', 10],
            ['Dr. Emmanuel Eze', 'emmanuel@hospital.com','Neurology',       'MBBS, FMCP',   7],
        ];

        $doctorModels = [];
        foreach ($doctorData as [$name, $email, $spec, $qual, $exp]) {
            $user = User::create([
                'name' => $name, 'email' => $email,
                'phone' => '+234 80' . rand(10000000, 99999999),
                'password' => Hash::make('password'),
                'role' => 'doctor', 'is_active' => true,
            ]);
            $doctorModels[] = Doctor::create([
                'user_id'          => $user->id,
                'specialization'   => $spec,
                'qualification'    => $qual,
                'experience_years' => $exp,
                'consultation_fee' => rand(3000, 15000),
                'available_days'   => ['Monday','Tuesday','Wednesday','Thursday','Friday'],
                'available_from'   => '08:00:00',
                'available_to'     => '17:00:00',
                'is_available'     => true,
            ]);
        }

        // ── Patients ──────────────────────────────────────
        $patientNames = [
            ['Olusegun','Adebayo'],['Ngozi','Okonkwo'],['Emeka','Nwosu'],['Aisha','Musa'],
            ['Tunde','Bakare'],['Chioma','Eze'],['Ibrahim','Sule'],['Blessing','Okeke'],
            ['Yakubu','Danladi'],['Grace','Adeleke'],['Biodun','Olatunde'],['Amara','Chukwu'],
        ];

        $patients = [];
        foreach ($patientNames as [$fn, $ln]) {
            $patients[] = Patient::create([
                'first_name'    => $fn,
                'last_name'     => $ln,
                'email'         => strtolower($fn.'.'.$ln.'@email.com'),
                'phone'         => '+234 80' . rand(10000000, 99999999),
                'date_of_birth' => now()->subYears(rand(18,70))->subDays(rand(0,365)),
                'gender'        => ['male','female'][rand(0,1)],
                'blood_type'    => ['A+','A-','B+','B-','AB+','O+','O-'][rand(0,6)],
                'address'       => rand(1,100).' Lagos Street, Nigeria',
                'status'        => 'active',
            ]);
        }

        // ── Appointments ──────────────────────────────────
        $statuses = ['pending','confirmed','completed','cancelled'];
        $types    = ['consultation','follow_up','emergency','routine'];
        foreach (range(1,20) as $i) {
            Appointment::create([
                'patient_id'       => $patients[array_rand($patients)]->id,
                'doctor_id'        => $doctorModels[array_rand($doctorModels)]->id,
                'appointment_date' => now()->addDays(rand(-10, 20)),
                'appointment_time' => sprintf('%02d:00:00', rand(8,17)),
                'type'             => $types[array_rand($types)],
                'status'           => $statuses[array_rand($statuses)],
                'reason'           => 'Routine medical consultation',
                'booked_by'        => 'Admin User',
            ]);
        }

        // ── Drugs ─────────────────────────────────────────
        $drugs = [
            ['Amoxil','Amoxicillin','Antibiotics','Tablet',150,300,200,20],
            ['Panadol','Paracetamol','Analgesics','Tablet',50,100,500,50],
            ['Metformin HCl','Metformin','Antidiabetics','Tablet',200,450,150,30],
            ['Amlodipine','Amlodipine Besylate','Antihypertensives','Tablet',180,380,100,20],
            ['Vitamin C 500mg','Ascorbic Acid','Vitamins','Tablet',80,180,300,40],
            ['Chloroquine','Chloroquine Phosphate','Antimalarials','Tablet',120,250,200,30],
            ['Flagyl','Metronidazole','Antibiotics','Tablet',100,220,180,25],
            ['Ibuprofen','Ibuprofen','Analgesics','Tablet',90,200,250,30],
            ['Folic Acid','Folic Acid','Vitamins','Tablet',60,150,400,50],
            ['Lisinopril','Lisinopril','Antihypertensives','Tablet',220,500,8,20],
        ];

        foreach ($drugs as [$n,$g,$c,$u,$pp,$sp,$qty,$min]) {
            Drug::create([
                'name'=>$n,'generic_name'=>$g,'category'=>$c,'unit'=>$u,
                'purchase_price'=>$pp,'selling_price'=>$sp,
                'stock_quantity'=>$qty,'minimum_stock'=>$min,
                'expiry_date'=>now()->addMonths(rand(6,24)),
                'manufacturer'=>'MedPharm Ltd','is_active'=>true,
            ]);
        }

        // ── Sample Invoice ────────────────────────────────
        $invoice = Invoice::create([
            'patient_id'    => $patients[0]->id,
            'subtotal'      => 15000,
            'tax'           => 750,
            'discount'      => 0,
            'total'         => 15750,
            'payment_method'=> 'cash',
            'status'        => 'paid',
            'paid_at'       => now(),
            'notes'         => 'Thank you for your payment.',
        ]);
        InvoiceItem::create(['invoice_id'=>$invoice->id,'description'=>'Consultation Fee','type'=>'consultation','quantity'=>1,'unit_price'=>10000,'total'=>10000]);
        InvoiceItem::create(['invoice_id'=>$invoice->id,'description'=>'Blood Tests','type'=>'lab','quantity'=>1,'unit_price'=>5000,'total'=>5000]);

        $this->command->info('✅  MediCore HMS seeded successfully!');
        $this->command->info('    Admin:       admin@hospital.com / password');
        $this->command->info('    Doctor:      doctor@hospital.com / password');
        $this->command->info('    Nurse:       nurse@hospital.com / password');
        $this->command->info('    Reception:   reception@hospital.com / password');
    }
}
