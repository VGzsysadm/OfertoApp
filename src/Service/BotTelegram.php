<?php
namespace App\Service;

use Symfony\Component\HttpClient\HttpClient;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;


class BotTelegram

{

    //LoggerInterface 
    private $logger;

    public function __construct( LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function push($apiKey, $chatId, $name, $filename)
    {
        $domain = "https://demo.ofertoapp.com/uploads/photos/";
        $content = array (
            'headers' => array("Content-Type" => "application/x-www-form-urlencoded"),
            "body"  => array("chat_id" => $chatId, "text" => $name),
        );
        $content2 = array (
            'headers' => array("Content-Type" => "application/x-www-form-urlencoded"),
            "body"  => array("chat_id" => $chatId, "text" => $domain.$filename),
        );
        $httpClient = HttpClient::create();
        try {
            $response = $httpClient->request('GET', 'https://api.telegram.org/bot'.$apiKey.'/sendMessage', $content);
            $response = $httpClient->request('GET', 'https://api.telegram.org/bot'.$apiKey.'/sendMessage', $content2);
            $content = $response->getContent();
            $this->logger->info($content);
        }
        catch (\Exception $e) {
            $this->logger->critical($e);
        }
    }
}