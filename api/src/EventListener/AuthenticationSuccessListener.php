<?php

namespace App\EventListener;

use App\Entity\User;
use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWSProvider\LcobucciJWSProvider;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

/**
 * Class AuthenticationSuccessListener
 * @package App\EventListener
 */
class AuthenticationSuccessListener
{
    /**
     * @var LcobucciJWSProvider
     */
    protected $jwt;

    /**
     * @var ParameterBagInterface
     */
    protected $params;

    /**
     * AuthenticationSuccessListener constructor.
     * @param LcobucciJWSProvider $jwt
     * @param ParameterBagInterface $params
     */
    public function __construct(LcobucciJWSProvider $jwt, ParameterBagInterface $params)
    {
        $this->jwt = $jwt;
        $this->params = $params;
    }

    /**
     * @param AuthenticationSuccessEvent $event
     * @throws \Exception
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event): void
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof User) {
            return;
        }

        $token = (new Builder())
            ->withClaim('mercure', ['subscribe' => $user->getTeam()->getMercureIri()])
            ->sign(new Sha256(), $this->params->get('mercure_secret_key'))
            ->getToken();

        $data['mercureToken'] = $token->__toString();

        $event->setData($data);
    }
}
