<?php

// require __DIR__ . "/dompdf/vendor/autoload.php";
require_once 'dompdf/autoload.inc.php';


use Dompdf\Dompdf;
use Dompdf\Options;

$dompdf = new Dompdf;
$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);
$options->setIsRemoteEnabled(true);

$options->setChroot(__DIR__);
$dompdf = new Dompdf($options);

$html = "Hello World";

// $html .= '</tbody></table></body></html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Output the PDF to the browser
// $dompdf->stream("student_marksheet.pdf");
if (!$dompdf->output()) {
    // Handle errors
    echo "Error in the pdf";
} else {
    // Output the PDF
    $dompdf->stream("student_marksheet.pdf");
}
?>