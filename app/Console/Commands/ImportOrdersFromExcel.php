<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\OrdersImport;

class ImportOrdersFromExcel extends Command
{
    protected $signature = 'import:orders {filename}';

    protected $description = 'Import orders from an Excel file';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
         $filename = $this->argument('filename');

        $this->info('Starting import from '.$filename);

        Excel::import($impObject = new OrdersImport, $filename);
        
        $this->info('Imported records='.$impObject->getImportedCount());	
        $this->info('Failed records='.$impObject->getNotImportedCount());				
    }
}
