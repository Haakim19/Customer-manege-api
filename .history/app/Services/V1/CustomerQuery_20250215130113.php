<?php

namespace App\Sevices\V1;

use Illuminate\Http\Request;

class CustomerQuery
{
    protected $safeParms = [
        'name' => ['eq'],
        'type' => ['eq'],
        'email' => ['eq'],
        'address' => ['eq'],
        'city' => ['eq'],
        'state' => ['eq'],
        'postalCode' => ['eq', 'gt', 'lt'],
    ];

    protected $columnMap = [
        'postalCode' => 'postal_code'
    ];

    protected $operaterMap = [
        'eq' => '=',
        'lt' => '<',
        'gt' => '>',
        'lte' => '<=',
        'gte' => '>='
    ];

    public function Transform(Request $request)
    {
        $eloQuery = [];
        foreach ($this->safeParms as $parm => $operaters) {
            $query = $request->query($parm);
            if (!isset($query)) {
                continue;
            }
            $column = $this->columnMap[$parm] ?? $parm;

            foreach ($operaters as $operater) {
                if (isset($query[$operater])) {
                    $eloQuery[] = [$column, $this->operaterMap($operater), $query[$operater]];
                }
            }
        }
    }
}
