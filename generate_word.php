<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;

session_start();

if (!isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$username = $_SESSION['username'];
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'Not available';


$phpWord = new PhpWord();
$section = $phpWord->addSection();

$section->addText('User Information', ['bold' => true, 'size' => 16], ['alignment' => 'center']);
$section->addTextBreak(1);


$section->addText("Username: $username", ['size' => 14]);
$section->addText("Email: $email", ['size' => 14]);


$file = 'UserDetails.docx';
$path = __DIR__ . '/' . $file;
$objWriter = IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save($path);


header("Content-Description: File Transfer");
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header("Content-Disposition: attachment; filename=$file");
header('Content-Length: ' . filesize($path));
readfile($path);
unlink($path); 
exit();
?>
