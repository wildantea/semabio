<?php
session_start();
include "../../inc/config.php";
require('../../inc/lib/fpdf/fpdf.php');
session_check_json();

 
class PDF extends FPDF
{
    public $nama;
    public $affiliation;
// Page header
function Header(){
    // Logo
    $this->Image('logo.png',132,13,60);
    // Arial bold 15
    $this->SetFont('Arial','B',20);
    
    $this->Cell(10);
    // Title
    $this->Cell(5,20,'Ticket',0,0,'C');
//overides the above settings
    $this->SetFont('Arial','B',14);
     $this->SetTextColor(0);
    $this->Cell(-13);
    $this->Cell(10,50,'Name ');
    $this->SetXY(40,10);
     $this->Cell(10,50,': '.$this->get_user().'');
      $this->SetXY(12,10);
    $this->Cell(10,64,'Affiliation ');
      $this->SetXY(40,10);
     $this->Cell(10,64,': '.$this->affiliation.'');
      $this->SetXY(12,10);
    $this->Cell(25,76,'Paper :'); 
}
public function set_user($name,$affiliation) {
    $this->nama = $name;
    $this->affiliation = $affiliation;
}

function get_user() {
    return $this->nama;
}
//MultiCell with bullet
    function MultiCellBlt($w, $h, $blt, $txt, $border=0, $align='L', $fill=false)
    {
        //Get bullet width including margins
        $blt_width = $this->GetStringWidth($blt)+$this->cMargin*2;

        //Save x
        $bak_x = $this->x;

        //Output bullet
        $this->Cell($blt_width,$h,$blt,0,'',$fill);

        //Output text
        $this->MultiCell($w-$blt_width,$h,$txt,$border,$align,$fill);

        //Restore x
        $this->x = $bak_x;
    }
 
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-13);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
$this->Cell(0,10,'http://iconistech.fst.uinsgd.ac.id',0,0,'C');
}
}
// Instanciation of inherited class
$pdf = new PDF('L','mm','A5');



//$get_user_info = $db->fetch_single_row("tb_data_payment_proof","id",$_GET['id']);
$user = $db->fetch_single_row("view_member",'id_user',$_GET['id']);
$pdf->set_user($user->full_name,$user->affiliation);
$pdf->AddPage();
$pdf->SetFont('Times','',13);
$pdf->SetXY(13,53);
$column_width = ($pdf->GetPageWidth()-30);
$paper = $db->query("select tda.title_abstract from  tb_data_abstract tda
inner join tb_data_payment tdp on tda.id=tdp.id_abstract
inner join tb_data_payment_detail tdpd on tdp.id=tdpd.payment_id
where tdpd.payment_proof_id=?
",array('id' => $_GET['id']));

$n=1;
foreach ($paper as $pp) {
    $pdf->MultiCellBlt($column_width,6,$n.'.',$pp->title_abstract.' '.$pp->title_abstract);
$n++;
}
$pdf->Output();
?>