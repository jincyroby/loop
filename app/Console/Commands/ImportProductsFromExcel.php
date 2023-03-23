<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Customer;
use App\Imports\ProductsImport;

class ImportProductsFromExcel extends Command
{
    protected $signature = 'import:products {filename}';

    protected $description = 'Import products from an Excel file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
         $filename = $this->argument('filename');

        $this->info('Starting import from '.$filename);

        Excel::import($impObject = new ProductsImport, $filename);
        
        $this->info('Imported records='.$impObject->getImportedCount());	
        $this->info('Failed records='.$impObject->getNotImportedCount());				
    }
}
