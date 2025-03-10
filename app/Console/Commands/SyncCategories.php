<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class SyncCategories extends Command
{
    protected $signature = 'sync:categories';
    protected $description = 'Sync Categories';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $reader = new Xlsx();
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load(public_path('categories.xlsx'));
        $sheet = $spreadsheet->getSheet($spreadsheet->getFirstSheetIndex());
        $data = $sheet->toArray();
        foreach ($data as $d) {
            Category::updateOrCreate([
                'name' => $d[0]
            ], [
            ]);
        }
    }
}
