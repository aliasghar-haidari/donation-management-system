<?php

namespace App\Http\Services\Account;

use App\Models\Accounting\Account;

class AccountService
{
    private array $accountTypeConfig = [
        'asset' => ['base_code' => 1000, 'increment' => 100],
        'liability' => ['base_code' => 2000, 'increment' => 100],
        'equity' => ['base_code' => 3000, 'increment' => 100],
        'revenue' => ['base_code' => 4000, 'increment' => 100],
        'expense' => ['base_code' => 5000, 'increment' => 100],
    ];

    /**
     * Create default accounts scoped to a specific currency ID.
     */
    public function createDefaultAccountsByCurrencyId(int $currencyId): void
    {
        foreach ($this->accountTypeConfig as $type => $config) {
            // Get the last code for this currency and type
            $lastAccount = Account::where('currency_id', $currencyId)
                ->where('type', $type)
                ->orderBy('code', 'desc')
                ->first();

            $lastCode = $lastAccount
                ? (int) $lastAccount->code
                : ($config['base_code'] - $config['increment']);

            $this->createAccountsForCurrency($currencyId, $type, $lastCode);
        }
    }

    /**
     * Create accounts for a given currency and type, incrementing code correctly.
     */
    private function createAccountsForCurrency(int $currencyId, string $type, int $lastCode): void
    {
        $defaultAccounts = collect($this->getDefaultAccountList())
            ->where('type', $type)
            ->values();

        foreach ($defaultAccounts as $account) {
            $lastCode += $this->accountTypeConfig[$type]['increment'];
            // Concatenate currency_id with the code to ensure uniqueness
            $code = $currencyId . '-' . str_pad($lastCode, 4, '0', STR_PAD_LEFT);

            Account::create([
                'code' => $code,
                'name' => $account['name'],
                'type' => $type,
                'currency_id' => $currencyId,
            ]);
        }
    }

    /**
     * List of default accounts grouped by type.
     */
    private function getDefaultAccountList(): array
    {
        return [
            ['name' => 'Cash', 'type' => 'asset'],
            ['name' => 'Bank Account', 'type' => 'asset'],
            ['name' => 'Accounts Receivable', 'type' => 'asset'],
            ['name' => 'Fixed Assets', 'type' => 'asset'],

            ['name' => 'Accounts Payable', 'type' => 'liability'],

            ['name' => 'Equity', 'type' => 'equity'],

            ['name' => 'Donation Income - Unrestricted', 'type' => 'revenue'],
            ['name' => 'Donation Income - Temporarily Restricted', 'type' => 'revenue'],
            ['name' => 'Donation Income - Permanently Restricted', 'type' => 'revenue'],
            ['name' => 'Fundraising Income', 'type' => 'revenue'],
            ['name' => 'Investment Income', 'type' => 'revenue'],
            ['name' => 'Other Income', 'type' => 'revenue'],

            ['name' => 'Program Services Expense', 'type' => 'expense'],
            ['name' => 'Management and General Expense', 'type' => 'expense'],
            ['name' => 'Fundraising Expense', 'type' => 'expense'],
            ['name' => 'Salaries Expense', 'type' => 'expense'],
            ['name' => 'Office Supplies Expense', 'type' => 'expense'],
            ['name' => 'Rent Expense', 'type' => 'expense'],
            ['name' => 'Depreciation Expense', 'type' => 'expense'],
            ['name' => 'Marketing and Advertising Expense', 'type' => 'expense'],
            ['name' => 'Other Expense', 'type' => 'expense'],
        ];
    }
}