## ساختار اصلی پروژه

```
FMT laravel/
├── app/
│   ├── Console/
│   │   └── Kernel.php
│   ├── Exceptions/
│   │   └── Handler.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AdminController.php
│   │   │   ├── AuthController.php
│   │   │   ├── BankAccountController.php
│   │   │   ├── BonityController.php
│   │   │   ├── ForexController.php
│   │   │   ├── IBController.php
│   │   │   ├── KycDocumentController.php
│   │   │   ├── PersonalCabinController.php
│   │   │   ├── ProfileController.php
│   │   │   ├── TradeController.php
│   │   │   ├── TradingAccountController.php
│   │   │   ├── TransactionController.php
│   │   │   ├── UserController.php
│   │   │   └── WalletController.php
│   │   ├── Kernel.php
│   │   └── Middleware/
│   │       ├── Authenticate.php
│   │       ├── EncryptCookies.php
│   │       ├── PreventRequestsDuringMaintenance.php
│   │       ├── RedirectIfAuthenticated.php
│   │       ├── TrimStrings.php
│   │       ├── TrustHosts.php
│   │       ├── TrustProxies.php
│   │       ├── ValidateSignature.php
│   │       └── VerifyCsrfToken.php
│   ├── Models/
│   │   ├── BankAccount.php
│   │   ├── BaseModel.php
│   │   ├── CommissionLog.php
│   │   ├── ComplianceLog.php
│   │   ├── CopyTrade.php
│   │   ├── DemoAccount.php
│   │   ├── ForexPair.php
│   │   ├── IB.php
│   │   ├── KycDocument.php
│   │   ├── MarketData.php
│   │   ├── Notification.php
│   │   ├── Order.php
│   │   ├── PersonalCabin.php
│   │   ├── RiskLog.php
│   │   ├── Trade.php
│   │   ├── TradingAccount.php
│   │   ├── Transaction.php
│   │   ├── User.php
│   │   └── Wallet.php
│   ├── Providers/
│   │   ├── AppServiceProvider.php
│   │   ├── AuthServiceProvider.php
│   │   ├── BroadcastServiceProvider.php
│   │   ├── EventServiceProvider.php
│   │   └── RouteServiceProvider.php
│   └── Services/
│       └── TradeEngine.php
├── database/
│   ├── .gitignore
│   ├── factories/
│   │   └── UserFactory.php
│   ├── migrations/
│   │   ├── 2025_04_19_134955_create_bank_accounts_table.php
│   │   ├── 2025_04_19_134955_create_compliance_logs_table.php
│   │   ├── 2025_04_19_134955_create_copy_trades_table.php
│   │   ├── 2025_04_19_134955_create_demo_accounts_table.php
│   │   ├── 2025_04_19_134955_create_kyc_documents_table.php
│   │   ├── 2025_04_19_134955_create_market_data_table.php
│   │   ├── 2025_04_19_134955_create_notifications_table.php
│   │   ├── 2025_04_19_134955_create_orders_table.php
│   │   ├── 2025_04_19_134955_create_personal_cabins_table.php
│   │   ├── 2025_04_19_134955_create_risk_logs_table.php
│   │   ├── 2025_04_19_134955_create_trading_accounts_table.php
│   │   ├── 2025_04_19_134958_create_ibs_table.php
│   │   ├── 2025_04_19_134958_create_trades_table.php
│   │   ├── 2025_04_19_134959_create_forex_pairs_table.php
│   │   ├── 2025_04_19_134959_create_transactions_table.php
│   │   ├── 2025_04_19_134959_create_wallets_table.php
│   │   └── 2025_04_19_135607_create_users_table.php
│   ├── schema/
│   └── seeders/
│       └── DatabaseSeeder.php
├── mapbuilder.py
└── routes/
    ├── api.php
    ├── api_Log.txt
    ├── channels.php
    ├── console.php
    └── web.php
```

### توضیح اجزای پروژه

* **app/**: شامل هستهٔ منطق برنامه است:

  * **Console/Kernel.php**: تعریف فرمان‌های سفارشی و زمان‌بندی دستورات کنسول.
  * **Exceptions/Handler.php**: مدیریت استثناها و نحوهٔ پاسخ‌دهی به خطا.
  * **Http/Controllers/**: کنترلرها برای پردازش درخواست‌های کاربر:

    * هر فایل کنترلری (مثلاً `AuthController.php`) مسئول عملیات مربوطه است.
  * **Http/Middleware/**: میان‌افزارها برای کنترل دسترسی، رمزنگاری کوکی‌ها، محافظت در برابر CSRF و غیره.
  * **Models/**: مدل‌های Eloquent برای ارتباط با جداول دیتابیس.
  * **Providers/**: ارائه‌دهنده‌های خدمات لاراول مثل ثبت رخدادها، روتر و احراز هویت.
  * **Services/TradeEngine.php**: منطق اختصاصی موتور معامله.

* **database/**: تنظیمات مرتبط با دیتابیس:

  * **factories/**: تولید داده‌های آزمایشی (فکتوری‌ها).
  * **migrations/**: اسکریپت‌های مهاجرت برای ساخت و تغییر جداول.
  * **seeders/**: تولید داده‌های اولیه با `DatabaseSeeder.php`.

* **mapbuilder.py**: اسکریپتی برای ساخت نقشه یا گزارش ساختار دیتابیس یا روابط.

* **routes/**: تعریف مسیرهای API و وب:

  * **api.php**, **web.php**: ثبت روت‌های REST و وب.
  * **channels.php**, **console.php**: روت‌های مربوط به broadcasting و کنسول.
  * **api\_Log.txt**: لاگ درخواست‌های API.

### روت‌های تست‌شده

* **POST** `http://193.163.201.115/api/auth/register`
* **POST** `http://193.163.201.115:8000/api/auth/login`
* **GET** `http://193.163.201.115:8000/api/users/2`
* **GET** `http://193.163.201.115:8000/api/admin/users`

تمام روت‌ها در حال حاضر روی سرور تست شده‌اند. بخش‌های مختلف کاربری (ثبت‌نام، ورود، مشاهدهٔ کاربر، مدیریت کاربران) به سرعت در حال تکمیل هستند.
