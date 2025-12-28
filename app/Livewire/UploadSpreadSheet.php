<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;


use Livewire\WithFileUploads;
use OpenSpout\Reader\CSV\Reader as CsvReader;
use OpenSpout\Reader\XLSX\Reader as XlsxReader;

class UploadSpreadSheet extends Component
{
    use WithFileUploads;

    public $file;
    public array $headers = [];
    public array $rows = [];
    public bool $isProcessing = false;

    public function updatedFile() : void
    {
        $this->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // 10MB max
        ]);

        $this->isProcessing = true;

        try {
            $this->parseFile();
        } catch (\Exception $e) {
            $this->addError('file', 'Error parsing file: ' . $e->getMessage());
        } finally {
            $this->isProcessing = false;
        }
    }

    public function parseFile() : void
    {
        $path = $this->file->getRealPath();
        $extension = $this->file->getClientOriginalExtension();

        $reader = match (strtolower($extension)) {
            'csv' => new CsvReader(),
            'xlsx', 'xls' => new XlsxReader(),
            default => throw new \Exception('Unsupported file format'),
        };

        $reader->open($path);

        $this->headers = [];
        $this->rows = [];
        $rowCount = 0;

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->toArray();

                if (empty($this->headers)) {
                    $this->headers = $cells;
                } else {
                    $this->rows[] = $cells;
                    $rowCount++;
                }

                // Limit preview to 100 rows
                if ($rowCount >= 100) {
                    break 2;
                }
            }
            // Only read the first sheet
            break;
        }

        $reader->close();
    }

    public function clear()
    {
        $this->reset(['file', 'headers', 'rows', 'isProcessing']);
    }

    public function render() : View
    {
        return view('livewire.upload-spread-sheet');
    }
}

