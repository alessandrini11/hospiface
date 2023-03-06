<?php

namespace App\Security;

use App\Exceptions\UnauthorizedException;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

class ApiAuthenticator extends AbstractAuthenticator
{
    public function supports(Request $request): ?bool
    {
        return $request->headers->has('X-AUTH-TOKEN');
    }
    
    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->headers->has('X-AUTH-TOKEN');
        if(!$apiToken){
            throw new UnauthorizedException('No Api token provided');
        }
        return new SelfValidatingPassport(new UserBadge($apiToken));

    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return $this->onAuthenticationSuccess($request, $token, $firewallName);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return $this->onAuthenticationFailure($request, $exception);
    }

   public function start(Request $request, AuthenticationException $authException = null): Response
   {
        return new JsonResponse('Authentication Required', Response::HTTP_UNAUTHORIZED);
   }
}
