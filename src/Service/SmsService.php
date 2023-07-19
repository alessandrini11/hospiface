<?php

namespace App\Service;

use App\model\ReceiverModel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SmsService
{
    public function __construct(
        readonly private HttpClientInterface $client
    )
    {
    }
    public function sendSms(ReceiverModel $to): bool
    {
        $sender_id ='Hospiface';
        $destinataire = $to->phoneNumber;
        $message ="bonjour {$to->fullName}, vous avez une garde du {$to->startDate} au {$to->endDate} ";
        $html_brand = $this->connexion($sender_id, $destinataire, $message);
        try {
            $response = $this->client->request(
                'POST',
                $html_brand,
                ['headers' => []]
            );
            if($response->getStatusCode() === Response::HTTP_OK){
                return true;
            } else {
                return false;
            }
        } catch (TransportExceptionInterface $exception) {
            dd($exception->getMessage());
        }
    }
    private function connexion($sender_id, $destinataire, $message,): string
    {
        $login ='690469551';
        $password ='wamba';
        $ext_id='0123456';
        $time ='0';
        $dest = 'https://sms.etech-keys.com/ss/api.php?login='.$login.'&password='.urlencode($password).'&sender_id='.urlencode($sender_id);
        return $dest.'&destinataire='.trim($destinataire).'&message='.urlencode($message).'&ext_id='.$ext_id.'&programmation='.$time;
    }
}