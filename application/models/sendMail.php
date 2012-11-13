<?php

/**
 * 31/10/2012
 * @file           sendMail.php
 * @author         Fabio Pratta <fabiobrotas@hotmail.com>
 * @license        default 
 * @copyright      Copyright - SIGP | 31/10/2012
 * @version        Release: 1.0
 */
class Application_Model_sendMail {

 
    /**
     * Send Mail 
     */
    public function send($usuario, $email, $assunto, $mensagem) {
        $settings = array('ssl' => 'ssl',
            'port' => 465,
            'auth' => 'login',
            'username' => 'fabiopratta2011@gmail.com',
            'password' => 'f25b6i87');
        $transport = new Zend_Mail_Transport_Smtp('smtp.gmail.com', $settings);
        Zend_Mail::setDefaultTransport($transport);

        // dados do email
        $mail = new Zend_Mail('UTF-8');
        // definindo o corpo do email
        $mail->setBodyHtml($mensagem);
        //$mail->setReplyTo($formulario->getValue('email'), $formulario->getValue('nome'));
        // definindo remetente
        $mail->setFrom("noreply@grupoperaltas.com.br", "SIGP Grupo Peraltas");
        // definindo destinatário
        $mail->addTo($email, $usuario);
        //$mail->addCc('contato@brotasecoresort.com.br');
        // definindo assunto do email
        $mail->setSubject($assunto);
        // enviando
        $mail->send();
        // renderizando a view de sucesso
    }

}

