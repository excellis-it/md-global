<?php

namespace Database\Seeders;

use App\Models\Qna;
use Illuminate\Database\Seeder;

class AddQnaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $array = [
            [
                'question' => 'What is an HSA?',
                'answer' => 'A Health Savings Account (HSA) is a purpose saving account that enables individuals to pay for qualifying health care expenses with pre-tax funds while participating in a High Deductible Health Plan. You can use this HSA to pay for current health expenses, save for future qualified medical and retiree health expenses, or invest in IRAs.',
            ],
            [
                'question' => 'How does an HSA work?',
                'answer' => 'Funding - you may contribute to your HSA on a pre-determined schedule throughout the year.

                Accessing funds - you can pay for your payment cards, payout of pocket, request reimbursement online, or use the mobile app. Always keep your receipts as you may need them for an IRS audit.
                
                Requesting reimbursement - it is quick and easy to submit requests for reimbursement and upload receipts online or using the mobile app.
                
                Reimbursement processing - promptly process your requests and reimburse by checking or direct depositing. You receive money sooner in direct deposits.
                
                Account management - you can check your balance, review claims activity, and access valuable tools just by logging in to your mobile account.
                
                ',
            ],
            [
                'question' => 'What are the benefits of establishing an HSA?',
                'answer' => 'Tax savings - HSA provides tax deductions when you contribute to your account and a tax-free income when your employer contributes to your account. It also provides tax-free earnings through investments and tax-free withdrawals for qualified medical expenses. Affordability - HSA carries higher deductible but lower monthly premiums. The savings from lower premiums can be put in the funding of the HSA. Flexibility - allows you to pay your current medical expenses or save money for future needs. The money saved can be invested, and your account can grow through tax-free investment earnings. Ownership and portability- accounts are entirely portable, which means that you can keep your HSA even if you change jobs, change your medical coverage or become unemployed.',
            ],
            [
                'question' => 'Can I withdraw money from my HSA account for other purposes?',
                'answer' => 'Yes, you can withdraw money from your HSA account at any time and for any purpose. However, suppose the money is used for an ineligible expense. In that case, the expenditure will be taxed, and the individuals who are not disabled or over age 65 are subject to a 20% tax penalty.
                ',
            ],
            [
                'question' => 'Can I change the amount I contribute to my HSA during the plan year?',
                'answer' => 'Yes, you can change the amount you contribute to your HSA at any time during the year. If you change the amount contributed via payroll on a pre-tax basis, check with your employer. You can also make non-payroll contributions changes using the contribution center in your online account. This allows you to make or change contributions regularly or on a one-time basis.
                ',
            ],
            [
                'question' => 'Can my employer contribute to my HSA?',
                'answer' => 'Yes, the contributions to HSAs can be made by you, your employer, or both. All the contributions are determined by whether you have contributed the maximum allowed or not. If your employer is contributing some of the money to your account, you can make up the difference. If your employer contributes to your HSA account, the contribution is not taxable to you, the employee.
                ',
            ],
            [
                'question' => 'What investment options can I get with my HSA?',
                'answer' => 'If you decide to buy into an HSA, then you have to make three basic choices: - Interest-bearing account - Money market account - Mutual funds account',
            ],
            [
                'question' => 'Can I use an HSA for my health insurance?',
                'answer' => 'Yes, the HSA is designed to cover the expenses not paid by your health plan, including deductibles, coinsurance, and copayments, as well as many expenses your health plan may not cover, such as acupuncture, eye surgery, and some over the counter medicines.',
            ],
            [
                'question' => 'What is a High Deductible Health Plan?',
                'answer' => 'A High Deductible Health Plan (HDHP) combines a Health Savings Account or a Health Reimbursement Arrangement with traditional medical coverage. It provides insurance coverage and a tax-advantaged way to help save future medical expenses. All these three give you greater flexibility and discretion over how you use your health care dollars because the funds can be used to cover qualified medical expenses that are not covered by your health plan.',
            ],
            [
                'question' => 'Does my HSA still in function after my death?',
                'answer' => "You can designate a beneficiary or beneficiaries to receive your remaining HSA funds after your death. For example, your spouse can be the designated beneficiary of your HSA, and it will be treated as your spouse's HSA after your death. If your spouse is not the designated beneficiary of your HSA or the beneficiary is your estate. The account stops being an HSA, and the fair market value becomes taxable to the beneficiary in which year you die. If you don't designate a beneficiary, then the funds will be distributed according to the rules of the Custodial Agreement.",
            ],
        ];

        foreach ($array as $key => $value) {
            Qna::create($value);
        }
    }
}
