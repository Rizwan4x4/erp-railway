<?php
namespace App;
use Codedge\Fpdf\Fpdf\Fpdf;


class CustomFpdf  extends Fpdf
{
    protected $fontSize;
    protected $fontType;

    public function __construct($fontSize = 10, $fontType = 'Arial')
    {
        parent::__construct();

        $this->fontSize = $fontSize;
        $this->fontType = $fontType;

        // Set the default font and font size
        $this->SetFont($this->fontType, '', $this->fontSize);

        // Set default values for CurrentFont and FontSize properties
        $this->CurrentFont = ['name' => $this->fontType, 'up' => false, 'ut' => false, 'cw' => [], 'desc' => []];
        $this->FontSize = $this->fontSize;
    }

    function NbLines($w, $txt) {
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb) {
            $c = $s[$i];
            if($c=="\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax) {
                if($sep==-1) {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}
