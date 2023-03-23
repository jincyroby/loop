<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;
class ProductsImport implements ToCollection
{
	public $importedCount = 0;
    public $notImportedCount = 0;
    public function collection(Collection $rows)
    {
         
        DB::transaction(function () use ($rows) {
			
            foreach ($rows as $row) {
				try{
					  
               $query =Product::query()->create([
                    'productname' => $row[1],
                    'price' => $row[2],
                ]);
				 $this->importedCount++;
				}catch (QueryException $e) {
            // Log the error message and continue with the next iteration of the loop
            Log::error('Error importing the product record, name: '.$row[1]." Detailed error:".$e->getMessage());
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
