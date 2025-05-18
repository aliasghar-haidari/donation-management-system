<?php

namespace App\Http\Services\Account;

use App\Models\Accounting\Account;
use App\Models\Company\Company;
use InvalidArgumentException;

class AccountService
{
    /**
     * Account type configuration for code generation.
     */
    private array $accountTypeConfig = [
        'asset' => ['base_code' => 1000, 'increment' => 100],
        'liability' => ['base_code' => 2000, 'increment' => 100],
        'equity' => ['base_code' => 3000, 'increment' => 100],
        'revenue' => ['base_code' => 4000, 'increment' => 100],
        'expense' => ['base_code' => 5000, 'increment' => 100],
    ];

    /**
     * Create a set of default accounts for the given company.
     */
    public function createDefaultAccounts(Company $company): void
    {
        $defaultAccounts = $this->getDefaultAccountList();

        $lastCodes = [];

        foreach ($defaultAccounts as $account) {
            $type = $account['type'];

            if (!isset($this->accountTypeConfig[$type])) {
                throw new InvalidArgumentException("Invalid account type: {$type}");
            }

            $lastCodes[$type] = ($lastCodes[$type] ?? $this->accountTypeConfig[$type]['base_code'] - $this->accountTypeConfig[$type]['increment']) + $this->accountTypeConfig[$type]['increment'];

            $code = str_pad($lastCodes[$type], 4, '0', STR_PAD_LEFT);

            Account::create([
                'company_id' => $company->id,
                'code' => $code,
                'name' => $account['name'],
                'type' => $type,
                'currency_id' => $company->currency_id,
            ]);
        }
    }

    /**
     * Generate a new account code for the given type.
     */
    public function generateAccountCode(Company $company, string $type, ?string $parentCode = null): string
    {
        if (!isset($this->accountTypeConfig[$type])) {
            throw new InvalidArgumentException("Invalid account type: {$type}");
        }

        if ($parentCode) {
            // Handle child account code generation
            $lastChild = Account::where('company_id', $company->id)
                ->where('code', 'like', "$parentCode-%")
                ->orderBy('code', 'desc')
                ->first();

            $nextNumber = $lastChild ? ((int) substr($lastChild->code, -2)) + 1 : 1;
            return "{$parentCode}-" . str_pad($nextNumber, 2, '0', STR_PAD_LEFT);
        }

        // Handle top-level account code generation
        $baseCode = $this->accountTypeConfig[$type]['base_code'];
        $increment = $this->accountTypeConfig[$type]['increment'];

        $lastAccount = Account::where('company_id', $company->id)
            ->where('type', $type)
            ->where('code', 'not like', '%-%')
            ->orderBy('code', 'desc')
            ->first();

        return $lastAccount
            ? str_pad(((int) $lastAccount->code) + $increment, 4, '0', STR_PAD_LEFT)
            : str_pad($baseCode, 4, '0', STR_PAD_LEFT);
    }

    /**
     * Get the list of default accounts.
     */
    private function getDefaultAccountList(): array
    {
        return [
            // Assets
            ['name' => 'Cash', 'type' => 'asset'],
            ['name' => 'Cash on Hand', 'type' => 'asset'],
            ['name' => 'Bank Account', 'type' => 'asset'],
            ['name' => 'Accounts Receivable', 'type' => 'asset'],
            ['name' => 'Pledges Receivable', 'type' => 'asset'],
            ['name' => 'Prepaid Expenses', 'type' => 'asset'],
            ['name' => 'Fixed Assets', 'type' => 'asset'],
            ['name' => 'Accumulated Depreciation', 'type' => 'asset'],

            // Liabilities
            ['name' => 'Accounts Payable', 'type' => 'liability'],
            ['name' => 'Deferred Revenue', 'type' => 'liability'],
            ['name' => 'Grants Payable', 'type' => 'liability'],
            ['name' => 'Accrued Expenses', 'type' => 'liability'],

            // Equity
            ['name' => 'Net Assets / Fund Balances', 'type' => 'equity'],
            ['name' => 'Unrestricted Net Assets', 'type' => 'equity'],
            ['name' => 'Temporarily Restricted Net Assets', 'type' => 'equity'],
            ['name' => 'Permanently Restricted Net Assets', 'type' => 'equity'],

            // Revenue
            ['name' => 'Donation Income - Unrestricted', 'type' => 'revenue'],
            ['name' => 'Donation Income - Temporarily Restricted', 'type' => 'revenue'],
            ['name' => 'Donation Income - Permanently Restricted', 'type' => 'revenue'],
            ['name' => 'Grants Income', 'type' => 'revenue'],
            ['name' => 'Fundraising Income', 'type' => 'revenue'],
            ['name' => 'Investment Income', 'type' => 'revenue'],
            ['name' => 'Other Income', 'type' => 'revenue'],

            // Expenses
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
