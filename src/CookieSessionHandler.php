<?php

namespace zonuexe\PhpCon2017;

/**
 * Session store using COOKIE
 *
 * @author    USAMI Kenta <tadsan@zonu.me>
 * @copyright 2017 USAMI Kenta
 * @license   https://www.apache.org/licenses/LICENSE-2.0 Apache-2.0
 */
final class CookieSessionHandler implements \SessionHandlerInterface
{
    const SAVE_KEY = 'z';
    const CRYPT_METHOD = 'AES-128-ECB';

    /** @var string */
    private $crypt_key_salt;
    /** @var bool */
    private $closed = false;

    /**
     * @param  string $save_key
     */
    public function __construct($crypt_key_salt)
    {
        $this->crypt_key_salt = $crypt_key_salt;
    }

    public function close ()
    {
        if ($this->closed) {
            throw new \RuntimeException('session is already closed.');
        }

        $this->closed = true;

        return true;
    }

    /**
     * @param  string  $session_id
     * @return bool
     */
    public function destroy ($session_id)
    {
        return true;
    }

    /**
     * @param  int $_maxlifetime
     * @return bool
     */
    public function gc ($_maxlifetime)
    {
        return true;
    }

    /**
     * Summary
     *
     * @param  string $save_path
     * @param  string $session_name
     * @return bool
     */
    public function open($save_path, $session_name)
    {
        return true;
    }

    /**
     * @param  string $session_id
     * @return string
     */
    public function read($session_id)
    {
        if (!isset($_COOKIE[self::SAVE_KEY])) {
            return '';
        }

        $data = openssl_decrypt(
            $_COOKIE[self::SAVE_KEY],
            self::CRYPT_METHOD,
            $this->key($session_id)
        );

        return $data ? gzuncompress($data) : '';
    }

    /**
     * @param  string $session_id
     * @param  string $session_data
     * @return string
     */
    public function write ($session_id, $session_data)
    {
        $data = openssl_encrypt(gzcompress($session_data), self::CRYPT_METHOD, $this->key($session_id));

        return setcookie(
            self::SAVE_KEY, $data,
            time() + 24 * 60 * 64, '/', '', false, true
        );
    }

    /**
     * @param  string $session_id
     * @return string
     */
    private function key($session_id)
    {
        return $this->crypt_key_salt . $session_id;
    }
}
