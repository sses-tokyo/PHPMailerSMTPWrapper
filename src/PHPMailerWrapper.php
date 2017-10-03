<?php
/**
 * PHPMailer拡張
 *
 */

namespace SSESTokyo\PHPMailerSMTPWrapper;

use PHPMailer\PHPMailer\PHPMailer;

class PHPMailerSMTPWrapper {
    
    private $mail = null;

    /**
     * コンストラクタ
     *
     * @param int $smpt_debug
     * @param string $smpt_secure
     * @param string $smtp_host
     * @param string $smtp_port
     * @param string $smtp_user
     * @param string $smpt_password
     */
    public function __construct($smpt_debug, $smpt_secure, $smtp_host, $smtp_port, $smtp_user, $smpt_password) {
        $this->mail = new PHPMailer();
        $this->mail->IsSMTP();
        $this->mail->SMTPDebug = $smpt_debug;
        $this->mail->SMTPAuth = true;
        $this->mail->CharSet = 'utf-8';
        $this->mail->SMTPSecure = $smpt_secure;
        $this->mail->Host = $smtp_host;
        $this->mail->Port = $smtp_port;
        $this->mail->IsHTML(false);
        $this->mail->Username = $smtp_user;
        $this->mail->Password = $smpt_password;
        $this->mail->SetFrom($smtp_user);
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
                $this->mail->AddAddress($mail);
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
