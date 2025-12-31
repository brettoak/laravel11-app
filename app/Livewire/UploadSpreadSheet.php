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
    public bool $isProcessing = false;
    public string $fileName = '';

    public function updatedFile() : void
    {
        $this->validate([
            'file' => 'required|file|mimes:csv,xlsx,xls|max:10240', // 10MB max
        ]);

        $this->fileName = $this->file->getClientOriginalName();
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
        $rows = [];
        $rowCount = 0;

        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->toArray();

                if (empty($this->headers)) {
                    $this->headers = $cells;
                } else {
                    $rows[] = $cells;
                    $rowCount++;
                }
            }
            // Only read the first sheet
            break;
        }

        $reader->close();

        $this->dispatch('spreadsheet-parsed', headers: $this->headers, rows: $rows);
    }

    public function clear()
    {
        $this->reset(['file', 'headers', 'isProcessing', 'fileName']);
        $this->dispatch('clear-grid');
    }

    public function render() : View
    {
        return view('livewire.upload-spread-sheet');
    }
}

