<?php

namespace App\Imports;

use App\Models\Bill;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\WithValidation;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Validator;

class BillImport implements ToCollection , WithCalculatedFormulas ,WithHeadingRow 
{
    /**
     * @param Collection $collection
     */
    public $type;
    protected $errors = [];
    public function __construct($type){
        $this->type = $type;
    }
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Skip empty rows
            if (count(array_filter($row->toArray())) === 0) {
                continue;
            }
            // Perform validation
            $validator = Validator::make($row->toArray(), $this->rules());

            if ($validator->fails()) {
                // Get all validation errors
                $validationErrors = $validator->errors();

                // Store errors along with the invalid values
                foreach ($validationErrors->keys() as $key) {
                    $this->errors[$index][$key] = [
                        'value' => $row[$key],  // The invalid value
                        'errors' => $validationErrors->get($key),  // Error messages
                    ];
                }
            }
        }

        // Throw an exception if there are validation errors
        if (!empty($this->errors)) {
            throw new \Exception('Validation failed: ' . json_encode($this->errors, JSON_PRETTY_PRINT));
        }

        foreach ($rows as $index => $row) {

                if (count(array_filter($row->toArray())) === 0) {
                continue;
               }
               Bill::create([
                'invoice_date' => Date::excelToDateTimeObject($row['invoice_date'])->format('Y-m-d') ?? null,
                'due_date' => Date::excelToDateTimeObject($row['due_date'])->format('Y-m-d') ?? null,
                'bill_tran_date' => Date::excelToDateTimeObject($row['transaction_date'] ?? null)->format('Y-m-d') ?? null,
                'bill_open' => Date::excelToDateTimeObject($row['open'] ?? null) ?? null,
                'bill_close' => Date::excelToDateTimeObject($row['close'] ?? null) ?? null,
                'contract_no' => $row['contract_no'] ?? null,
                'unit' => $row['unit'] ?? null,
                'meter' => $row['meter_no'] ?? null,
                'p_time' => $row['previous_time'] ?? null,
                't_time' => $row['this_time'] ?? null ,
                'p_unit' => $row['diff'] ?? round($row['time_diff'],9) ?? null,
                'price_unit' => $row['rate']  ?? null,
                'status' => $row['status'] ?? null,
                'type' => $this->type,
                'created_by' => auth()->id(),
                'updated_by' => auth()->id()
            ]);
        }
    }

    public function rules(): array{
        return [
            'contract_no' => 'exists:customer_rentals,custr_contract_no'
        ];
    }
    public function getErrors()
    {
        return $this->errors;
    }

    public function headingRow(): int
    {
        return 2;
    }
}
