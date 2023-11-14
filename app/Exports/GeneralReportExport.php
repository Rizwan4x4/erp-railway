<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithMapping;


class GeneralReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    protected $data;
    protected $headings;
    protected $additionalFields;

    public function __construct( $data,  $headings, $additionalFields)
    {
        $this->data = $data;
        $this->headings = $headings;
        $this->additionalFields = $additionalFields;
    }
    public function collection()
    {
        // Retrieve the data for the export

        $dataCollection = collect($this->data);

        // Merge the original data collection with the additional row collection

        return $dataCollection;

    }

    public function headings(): array
    {
        return $this->headings;
    }

    public function map($row): array
    {
        return $row;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $sheet->insertNewRowBefore(1, count($this->additionalFields) + 1);

                $rowIndex = 1;
                foreach ($this->additionalFields as $heading => $value) {
                    $sheet->setCellValueByColumnAndRow(1, $rowIndex, $heading);
                    $sheet->setCellValueByColumnAndRow(2, $rowIndex, $value);
                    $rowIndex++;
                }

                // Apply bold formatting to the additional fields and headings
                $boldFont = $sheet->getStyle('A1:G' . ($rowIndex +2  - 1))->getFont();
                $boldFont->setBold(true);
            },
        ];
    }

}
