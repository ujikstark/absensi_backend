<?php

declare(strict_types=1);

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Cookie;


class AuthenticationSuccessListener
{
    public const REFRESH_TOKEN_COOKIE_NAME = 'REFRESH_TOKEN';

    public function __construct(
        private string $accessTokenTtl,
        private string $refreshTokenTtl
    ) {
    }

    public function onAuthenticationSuccess(AuthenticationSuccessEvent $event): void
    {
        /** @var array{token: string, refreshToken: string} $data */
        $data = $event->getData();
        

        $event->getResponse()->headers->setCookie(
            new Cookie(
                'access_token',
                $data['token'],
                (new \DateTime())->add(new \DateInterval(sprintf('PT%sS', $this->accessTokenTtl))),
                '/',
                null,
                true,
                true,
                false,
                'none'
            )
        );

        $event->getResponse()->headers->setCookie(
            new Cookie(
                'refresh_token',
                $data['refresh_token'],
                (new \DateTime())->add(new \DateInterval(sprintf('PT%sS', $this->refreshTokenTtl))),
                '/',
                null,
                true,
                true,
                false,
                'none'
            )
        );



        $event->setData($data);
    }
}
