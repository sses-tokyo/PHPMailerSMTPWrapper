<?php
/**
 * PHPMailer拡張(SMTP)
 *
 */

namespace SSESTokyo\PHPMailerSMTPWrapper;

use PHPMailer\PHPMailer\PHPMailer;

class PHPMailerSMTPWrapper {
    
    private $mail = null;

    /**
     * コンストラクタ
     *
     * @param int $debug
     * @param string $secure
     * @param string $host
     * @param string $port
     * @param string $user
     * @param string $password
     */
    public function __construct($debug, $secure, $host, $port, $user, $password) {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug = $debug;
        $this->mail->SMTPAuth = true;
        $this->mail->CharSet = 'utf-8';
        $this->mail->SMTPSecure = $secure;
        $this->mail->Host = $host;
        $this->mail->Port = $port;
        $this->mail->IsHTML(false);
        $this->mail->Username = $user;
        $this->mail->Password = $password;
        $this->mail->SetFrom($user);
    }
    
    /**
     * SMTPを使ってメール送信
     *
     * @param string $to
     * @param string $subject
     * @param string $body
     * @param string $fromname
     * @param string $fromaddress
     * @return string
     */
    function send($to, $subject, $body, $fromname, $fromaddress) {
        $this->mail->From     = $fromaddress;
        $this->mail->Subject = $subject;
        $this->mail->Body = $body;
        // カンマ区切りの場合は分割して登録
        if (strpos($to, ',') !== false) {
            $to_split = explode(',', $to);
            foreach ($to_split as $mail) {
                $this->mail->AddAddress(trim($mail));
            }
        } else {
            $this->mail->AddAddress($to);
        }
        
        // デフォルトでSSL証明書を検証してしまうので無効化
        if ($this->mail->SMTPSecure != 'ssl') {
            $this->mail->SMTPOptions = array('ssl' => array('verify_peer' => false, 'verify_peer_name' => false, 'allow_self_signed' => true));
        }
        
        if (!$this->mail->Send()) {
            $message  = "Message was not sent<br/ >";
            $message .= "Mailer Error: " . $this->mail->ErrorInfo;
        } else {
            $message  = "Message has been sent";
        }
        
        return $message;
    }
}
