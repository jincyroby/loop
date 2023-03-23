<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
class OrdersImport implements ToCollection
{
	public $importedCount = 0;
    public $notImportedCount = 0;
	public $counter = 0;
    public function collection(Collection $rows)
    {
         
        DB::transaction(function () use ($rows) {
			
            foreach ($rows as $row) {
				if($this->counter==0){
					$this->counter++;
					continue;
				}
				try{
					  
               $query =Order::query()->create([
                    'customer' => $row[1],
                    'payed' => $row[2],
					'product_id' => $row[3],
                ]);
				 $this->importedCount++;
				}catch (QueryException $e) {
            // Log the error message and continue with the next iteration of the loop
            Log::error('Error importing the order record, name: '.$row[1]." Detailed error:".$e->getMessage());
			 $this->notImportedCount++;
            continue;        
            } 
			$this->counter++;
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
