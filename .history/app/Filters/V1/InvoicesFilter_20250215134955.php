<?php

namespace App\Filters\V1;

use Illuminate\Http\Request;
use App\Filters\ApiFilter;

class InvoicesFilter extends ApiFilter
{
    $table->integer('customer_id');
            $table->integer('amount');
            $table->string('status'); //billed, paid,void
            $table->dateTime('billed_date');
            $table->dateTime('paid_date')->nullable();
    protected $safeParms = [
        'customerId' => ['eq'],
        'amount' => ['eq', 'lt', 'gt', 'gte', 'lte'],
        'status' => ['eq','ne'],
        'billedDate' => ['eq', 'lt', 'gt', 'gte', 'lte'],
        'paidDate' => ['eq', 'lt', 'gt', 'gte', 'lte']
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operatorMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>=',
        'ne' => '!='
    ];

    public function Transform(Request $request)
    {
        $eloQuery = [];
        foreach ($this->safeParms as $parm => $operators) {
            $query = $request->query($parm);
            if (!isset($query)) {
                continue;
            }
            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operators as $operator) {
                if (isset($query[$operator])) {
                    $eloQuery[] = [$column, $this->operatorMap[$operator], $query[$operator]];
                }
            }
        }
        return $eloQuery;
    }
}
