<?php

namespace Kinzal\SSTP;

/**
 * Sakura Script Transfer Protocol.
 */
class SSTP
{
    /**
     * charset of send message.
     * @var string
     */
    public $charset = 'Shift-JIS';
    /**
     * send request message.
     * @var string
     */
    public $message = '';
    /**
     * last error message.
     */
    public $error = '';
    /**
     * Sending message to SSTP server.
     * @param  string  $address send address
     * @param  integer $port    send port
     * @param  integer $timeout socket timeout sec
     * @return string|bool      response from SSTP server
     */
    public function send($address, $port, $timeout = 0)
    {
        // create socket
        $sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($sock === false) {
            $this->error = 'connection error.';
            return false;
        }
        // set timeout
        if ($timeout === 0) {
            socket_set_option($sock, SOL_SOCKET, SO_SNDTIMEO, array("sec" => $timeout, 'usec'=>$timeout*1000));
            socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array("sec" => $timeout, 'usec'=>$timeout*1000));
        }
        // connect socket
        if (!socket_connect($sock, $address, $port)) {
            $this->error = socket_last_error($sock);
            return false;
        }
        // send message
        $message = preg_replace('/[\r\n]+([\s]*)?/', "\r\n", trim($this->message));
        if (mb_detect_encoding($message) !== $this->charset)
        {
            $message = mb_convert_encoding($message, $this->charset, mb_detect_encoding($message));
        }
        socket_write($sock, $message);

        $result = socket_read($sock, 1024);
        if (mb_detect_encoding($message) !== $this->charset)
        {
            $result = mb_convert_encoding($result, mb_detect_encoding($message), $this->charset);
        }
        // close socket
        socket_close($sock);

        return $result;
    }

}
