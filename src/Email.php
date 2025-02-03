<?php

namespace BaseProject;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;
use PDO;

class Email {
    private PHPMailer $mailer;

    public function __construct() {
        $this->mailer = new PHPMailer(true);
        $this->configurarSMTP();
    }

    
    private function configurarSMTP(): void {  
        // Carrega as variáveis do .env
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
         
        $smtp_host = $_ENV['SMTP_HOST'];
        $smtp_username = $_ENV['SMTP_USERNAME'];
        $smtp_password = $_ENV['SMTP_PASSWORD'];
        $smtp_port = $_ENV['SMTP_PORT'];
        $smtp_from_email = $_ENV['SMTP_FROM_EMAIL'];
        $smtp_from_name = $_ENV['SMTP_FROM_NAME'];
                

        $this->mailer->isSMTP();
        $this->mailer->Host = $smtp_host;
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $smtp_username;
        $this->mailer->Password = $smtp_password;
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port = $smtp_port;
        $this->mailer->setFrom($smtp_from_email, $smtp_from_name);
        $this->mailer->CharSet = 'UTF-8';
    }

    public function construirMensagem(string $template, array $dados): string {
        $mensagem = $template;
        foreach ($dados as $chave => $valor) {
            $mensagem = str_replace("{{ $chave }}", $valor, $mensagem);
        }
        return $mensagem;
    }

    public function adicionarFila(string $destinatario, string $assunto, string $mensagem): bool {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO email_queue (destinatario, assunto, mensagem, status) VALUES (:destinatario, :assunto, :mensagem, 'pendente')");
        $executado = $stmt->execute([
            ':destinatario' => $destinatario,
            ':assunto' => $assunto,
            ':mensagem' => $mensagem
        ]);

        if ($executado) {
            Logger::log("email_queue", "INSERT", ["destinatario" => $destinatario, "assunto" => $assunto]);
        }

        return $executado;
    }

    public function enviarEmail(string $destinatario, string $assunto, string $mensagem): bool {
        try {
            $this->mailer->addAddress($destinatario);
            $this->mailer->Subject = $assunto;
            $this->mailer->Body = $mensagem;
            $this->mailer->isHTML(true);

            if ($this->mailer->send()) {
                Logger::log("email_queue", "EMAIL SENT", ["destinatario" => $destinatario, "assunto" => $assunto]);
                return true;
            }

            return false;
        } catch (Exception $e) {
            Logger::log("email_queue", "EMAIL ERROR", ["erro" => $e->getMessage()]);
            return false;
        }
    }

    public function processarFila(int $limite = 5): void {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM email_queue WHERE status = 'pendente' ORDER BY criado_em ASC LIMIT :limite");
        $stmt->bindValue(":limite", $limite, PDO::PARAM_INT);
        $stmt->execute();
        $emails = $stmt->fetchAll();

        foreach ($emails as $email) {
            $sucesso = $this->enviarEmail($email['destinatario'], $email['assunto'], $email['mensagem']);

            $updateStmt = $db->prepare("UPDATE email_queue SET status = :status, data_envio = NOW(), tentativas = tentativas + 1 WHERE id = :id");
            $updateStmt->execute([
                ":status" => $sucesso ? 'enviado' : 'erro',
                ":id" => $email['id']
            ]);
        }
    }
}
