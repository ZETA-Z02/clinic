<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
// 
use Dompdf\Dompdf;
use Dompdf\Options;
class Services extends Controller
{
    function __construct()
    {
        parent::__construct();
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
    public function email(): void
    {
        // Cargar Composer's autoloader
        require '../vendor/autoload.php';
        // Instancia de PHPMailer
        $proforma2 = '';
        $id = '';
        $email = '';
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';           // Servidor SMTP de Gmail
            $mail->SMTPAuth = true;
            $mail->Username = 'jersson.z032@gmail.com';
            // Tu correo de Gmail ===>>>  fxws idjg pqjo hmjd
            $mail->Password = 'fxws idjg pqjo hmjd';   // Tu contraseña de Gmail o contraseña de aplicación
            $mail->SMTPSecure = 'tls';                   // Encriptación TLS
            $mail->Port = 587;                           // Puerto TCP

            // Remitente y destinatario
            $mail->setFrom('jersson.z032@gmail.com', 'jersson');
            $mail->addAddress($email, 'dota2'); // Añadir destinatario

            // Adjuntar archivos
            if ($id != null) {
                if ($proforma2 != null) {
                    $mail->addAttachment('/var/www/html/katariPrice/dumps/pdf/proforma2:' . $id . '.pdf');
                } else {
                    $mail->addAttachment('/var/www/html/katariPrice/dumps/pdf/proforma:' . $id . '.pdf');
                }
            }
            // Contenido del correo
            $mail->isHTML(true);                         // Configurar el correo en formato HTML
            $mail->Subject = 'Asunto del correo';
            $mail->Body = 'Cotizacion Solicitada';
            // $mail->AltBody = 'Este es el cuerpo del correo en texto plano para clientes de correo que no soportan HTML';

            $mail->send();
            echo 'El mensaje ha sido enviado';
        } catch (Exception $e) {
            echo "El mensaje no pudo ser enviado. Mailer Error: {$mail->ErrorInfo}";
        }
    }
    public function pdf(): void
    {
        require 'vendor/autoload.php';
        // Configurar las opciones de DOMPDF
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true); // Habilitar análisis HTML5
        $options->set('isPhpEnabled', true);         // Habilitar funciones PHP si es necesario

        // Inicializar Dompdf con las opciones configuradas
        $dompdf = new Dompdf($options);

        // Leer el contenido del archivo HTML
        $html = file_get_contents('vista_pdf.html');  // Cargar el HTML de la vista

        // Cargar el contenido HTML en DOMPDF
        $dompdf->loadHtml($html);

        // Establecer el tamaño del papel y orientación
        $dompdf->setPaper('A4', 'portrait'); // Puedes usar 'landscape' si deseas orientación horizontal

        // Renderizar el PDF (esto convierte el HTML a PDF)
        $dompdf->render();

        // Salvar el PDF en el servidor
        file_put_contents('mi_archivo.pdf', $dompdf->output());
        echo "PDF generado exitosamente.";
    }
}

?>