<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once './vendor/setasign/fpdf/fpdf.php';
// 
class Services extends Controller
{
    function __construct()
    {
        parent::__construct();
    }
    public function boleta()
    {
        $pdf = new Boleta('P', 'mm', array(72, 130)); // Asegurar el ancho correcto
        $pdf->SetMargins(4, 2, 4); // Agregar márgenes para evitar desbordamientos
        $pdf->AddPage();
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(70, 6, 'Boleta N: B001-00012345', 0, 1, 'L');
        $pdf->Cell(35, 6, 'Fecha: ' . date('d/m/Y'), 0, 0, 'L');
        $pdf->Cell(35, 6, 'Hora: ' . date(' h:i A'), 0, 1, 'L');
        $pdf->Ln(2);
        $pdf->Cell(70, 0, str_repeat('-', 32), 0, 1, 'C');
        $pdf->Ln(2);

        // Detalle de productos
        $productos = [
            ['Producto A', 1, 10.00],
            ['Producto B', 2, 20.00],
            ['Producto C', 3, 30.00],
            ['Producto D', 4, 40.00],
            ['Producto E', 5, 50.00],
        ];

        $pdf->SetFont('Arial', 'B', 9);
        // $pdf->Cell(15, 6, 'Cant', 0, 0, 'C');
        $pdf->Cell(40, 6, 'Descripcion', 0, 0, 'C');
        $pdf->Cell(30, 6, 'Total', 0, 1, 'C');
        $pdf->Cell(70, 0, str_repeat('-', 60), 0, 1, 'C');
        $pdf->Ln(2);

        $total = 0;
        $pdf->SetFont('Arial', '', 9);
        foreach ($productos as $p) {
            // $pdf->Cell(15, 6, $p[1], 0, 0, 'C');
            $pdf->Cell(40, 6, $p[0], 0, 0, 'C');
            $pdf->Cell(30, 6, number_format($p[2], 2), 0, 1, 'C');
            $total += $p[2];
        }

        $pdf->Cell(70, 0, str_repeat('-', 60), 0, 1, 'C');
        $pdf->Ln(2);
        $pdf->Cell(45, 6, 'Subtotal:', 0, 0, 'R');
        $pdf->Cell(18, 6, number_format($total, 2), 0, 1, 'R');
        $pdf->Cell(45, 6, 'IGV (18%):', 0, 0, 'R');
        $pdf->Cell(18, 6, number_format($total * 0.18, 2), 0, 1, 'R');
        $pdf->Cell(45, 6, 'Total a pagar:', 0, 0, 'R');
        $pdf->Cell(18, 6, number_format($total * 1.18, 2), 0, 1, 'R');
        $pdf->Ln(5);

        $pdf->Output();

    }
    public function dni(): void
    {
        // TOKEN ZETA PARA PRODUCCION
        $apiZeta = 'apis-token-11103.WQaaHijemn0xeAv1QypRX5W6mGeEiMuE';
        // TOKEN JOSUE PARA TESTS
        $token = 'apis-token-8574.bPsef4wHOYjVwA7bFoDMZqLLrNrAMKiY';
        $dni = $_POST["dni"];
        // Iniciar llamada a API
        $curl = curl_init();
        // Buscar dni
        curl_setopt_array(
            $curl,
            array(
                CURLOPT_URL => 'https://api.apis.net.pe/v2/reniec/dni?numero=' . $dni,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 2,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Referer: https://apis.net.pe/consulta-dni-api',
                    'Authorization: Bearer ' . $token
                ),
            )
        );
        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'error del scraper: ' . curl_error($curl);
            exit;
        }
        curl_close($curl);
        // Datos listos para usar
        echo $response;

    }
}
class Boleta extends FPDF
{
    function Header() {
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(70, 6, 'CHIC CONSULTORIO DENTAL', 0, 1, 'C');
        $this->SetFont('Arial', '', 9);
        $this->Cell(70, 4, 'Jr. Lambayeque 123, Puno', 0, 1, 
        'C');
        $this->Cell(70, 4, 'RUC: 12345678901', 0, 1, 'C');
        $this->Cell(70, 4, 'Tel: 951781807', 0, 1, 'C');
        $this->Ln(2);
        $this->Cell(70, 0, str_repeat('-', 32), 0, 1, 'C');
        $this->Ln(2);
    }

    function Footer() {
        $this->SetY(-20);
        $this->SetFont('Arial', '', 9);
        $this->Cell(72, 6, '!Gracias por su compra!', 0, 1, 'C');
        $this->Cell(72, 0, str_repeat('-', 32), 0, 1, 'C');
    }
}

?>