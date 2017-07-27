<?php

namespace AdminBundle\Services;

use Doctrine\ORM\EntityManager;

class AlgorithmicHelper
{
	  private $entityManager;

    public function __construct(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }

    /**
     * Function use to encrypt | decrypt a string
     * @Route(name="encrypt_decrypt")
     */
    public function encrypt_decrypt($action, $string) {
      $output = false;
      $encrypt_method = "AES-256-CBC";
      $key = hash('sha256', 'X96SnRy441');
      $iv = substr(hash('sha256', 'JAf244pzs2'), 0, 16);
      if($action == 'encrypt') {
        $output = base64_encode(openssl_encrypt($string, $encrypt_method, $key, 0, $iv));
      }
      elseif($action == 'decrypt') {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
      }

      return $output;
    }
    
}
