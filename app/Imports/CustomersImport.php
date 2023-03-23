<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
class CustomersImport implements ToCollection
{
    public $importedCount = 0;
    public $notImportedCount = 0;
    public function collection(Collection $rows)
    {

        DB::transaction(function () use ($rows) {
			
            foreach ($rows as $row) {
				try{
					  
               $query =Customer::query()->create([
                    'job_title' => $row[1],
                    'email_address' => $row[2],
					'name' => $row[3],
                    'registered_since' => $row[4],
                    'phone' => $row[5],
                ]);
				$this->importedCount++;
				
				}catch (QueryException $e) {
            // Log the error message and continue with the next iteration of the loop
            Log::error('Error importing the record, name: '.$row[3]." Detailed error:".$e->getMessage());
			$this->notImportedCount++;
            continue;
        
               } 
            }
        });
    }
		public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getNotImportedCount()
    {
        return $this->notImportedCount;
    }
}
