# Code Escrow API – Full Documentation

## Overview

A Laravel-based escrow system that manages gigs, freelancers, and transactions. It supports job queues, email notifications, and clean API architecture.

---

# 🚀 FULL SETUP GUIDE (FROM SCRATCH)

## 1. Install Laravel Project

```bash
composer create-project laravel/laravel code-escrow
cd code-escrow
```

## 2. Environment Setup

```bash
cp .env.example .env
php artisan key:generate
```

Update `.env`:

```env
DB_CONNECTION=mysql
DB_DATABASE=code_escrow
DB_USERNAME=root
DB_PASSWORD=

QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="transaction@yourecapp.com"
MAIL_FROM_NAME="Code Escrow"
```

---

# 🧱 DATABASE SETUP

## Create Database Tables

```bash
php artisan make:model Gig -m
php artisan make:model Freelancer -m
php artisan make:model Transaction -m
```

## Example Migration (Transaction)

```php
Schema::create('transactions', function (Blueprint $table) {
    $table->id();
    $table->foreignId('gig_id')->constrained()->cascadeOnDelete();
    $table->decimal('amount_usd', 10, 2);
    $table->string('status');
    $table->timestamps();
});
```

## Run Migrations

```bash
php artisan migrate
```

---

# ⚙️ QUEUE SETUP (IMPORTANT)

## Create Queue Tables

```bash
php artisan queue:table
php artisan migrate
```

## Run Worker

```bash
php artisan queue:work
```

---

# 📂 PROJECT ARCHITECTURE (WITH FILES)

## 1. Routes (Switchboard)

📄 `routes/api.php`

```php
Route::get('/gigs', [GigController::class, 'index']);
Route::post('/gigs', [GigController::class, 'store']);

Route::get('/freelancer', [FreelancerController::class, 'index']);
Route::post('/freelancer', [FreelancerController::class, 'store']);

Route::get('/transaction', [TransactionController::class, 'index']);
Route::patch('/freelancers/refresh-trust', [FreelancerController::class, 'refreshTrust']);
```

---

## 2. Bootstrap (Ignition Core)

📄 `bootstrap/app.php`

* Loads routes
* Registers middleware
* Handles exceptions

(No modification usually needed)

---

## 3. Requests (Firewall)

```bash
php artisan make:request StoreGigRequest
```

📄 `app/Http/Requests/StoreGigRequest.php`

```php
public function rules()
{
    return [
        'title' => 'required|string',
        'price' => 'required|numeric'
    ];
}
```

---

## 4. Controllers (Traffic Cop)

```bash
php artisan make:controller GigController
```

📄 `app/Http/Controllers/GigController.php`

```php
public function store(StoreGigRequest $request)
{
    return $this->gigService->create($request->validated());
}
```

---

## 5. Services (Engine)

📄 `app/Services/GigService.php`

```php
class GigService
{
    public function create(array $data)
    {
        return Gig::create($data);
    }
}
```

---

## 6. Models (ORM)

📄 `app/Models/Transaction.php`

```php
class Transaction extends Model
{
    protected $fillable = ['gig_id', 'amount_usd', 'status'];

    public function gig()
    {
        return $this->belongsTo(Gig::class);
    }
}
```

---

## 7. Migrations (DB Version Control)

```bash
php artisan make:migration create_transactions_table
```

---

## 8. Enums (Type Safety)

```bash
php artisan make:enum TransactionStatus
```

📄 `app/Enums/TransactionStatus.php`

```php
enum TransactionStatus: string
{
    case PENDING = 'pending';
    case RELEASED = 'released';
}
```

---

## 9. Factories (Fake Data)

```bash
php artisan make:factory TransactionFactory
```

📄 `database/factories/TransactionFactory.php`

```php
return [
    'amount_usd' => fake()->randomFloat(2, 10, 500),
    'status' => 'pending'
];
```

---

## 10. Seeders (Data Injector)

```bash
php artisan make:seeder DatabaseSeeder
```

📄 `database/seeders/DatabaseSeeder.php`

```php
Transaction::factory(10)->create();
```

Run:

```bash
php artisan db:seed
```

---

## 11. Resources (Serialization)

```bash
php artisan make:resource TransactionResource
```

📄 `app/Http/Resources/TransactionResource.php`

```php
public function toArray($request)
{
    return [
        'amount' => $this->amount_usd,
        'status' => $this->status,
        'gig' => new GigSummaryResource($this->whenLoaded('gig'))
    ];
}
```

---

## 12. Jobs (Background Tasks)

```bash
php artisan make:job SendPayoutEmailJob
```

📄 `app/Jobs/SendPayoutEmailJob.php`

```php
public function handle()
{
    Mail::to($this->email)->send(new PayoutMail($this->transaction));
}
```

---

## 13. Blade View (Email UI)

📄 `resources/views/emails/payout.blade.php`

```blade
<h1>Payment Released</h1>
<p>Amount: {{ $transaction->amount_usd }}</p>
```

---

## 14. Mailer (Courier)

```bash
php artisan make:mail PayoutMail
```

📄 `app/Mail/PayoutMail.php`

```php
public function build()
{
    return $this->view('emails.payout')
                ->with(['transaction' => $this->transaction]);
}
```

---

# 🔄 FULL FLOW (IMPORTANT)

1. Request hits `api.php`
2. Goes to Controller
3. Request validated
4. Service executes logic
5. DB transaction happens
6. Job dispatched
7. Queue processes job
8. Mail sent
9. Resource formats response

---

# 🧪 TEST JSON PAYLOADS

## Create Gig

```json
{
  "title": "Build Laravel API",
  "price": 150
}
```

## Create Freelancer

```json
{
  "name": "John Doe",
  "email": "john@example.com"
}
```

## Refresh Trust

```json
{}
```

---

# 🧠 FINAL NOTES

* Always run queue worker for jobs
* Use `with('gig')` to avoid resource errors
* Never put logic inside controllers
* Services = core brain of your app

---

This README now fully represents your project structure, setup, and execution pipeline.
