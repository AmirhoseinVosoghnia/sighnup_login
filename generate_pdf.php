<?php
require_once(__DIR__ . '/../../vendor/autoload.php');

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}


$username = $_SESSION['username'];
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Not available';

$pdf = new TCPDF();
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Vegas Restaurant');
$pdf->SetTitle('User Information');
$pdf->SetMargins(10, 10, 10);
$pdf->AddPage();

$pdf->SetFont('dejavusans', '', 14);
$pdf->Cell(0, 10, 'User Information', 0, 1, 'C');
$pdf->Ln(10);

$pdf->Cell(50, 10, 'Username:', 0, 0);
$pdf->Cell(100, 10, $_SESSION['username'], 0, 1);
$pdf->Cell(50, 10, 'Email:', 0, 0);
$pdf->Cell(100, 10, htmlspecialchars($email, ENT_QUOTES, 'UTF-8'), 0, 1);

$pdf->Output('UserDetails.pdf', 'D');
exit();
?>
