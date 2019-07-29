<?php

namespace App\Controller;

use ApiPlatform\Core\Validator\ValidatorInterface;
use App\Entity\Team;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserRegisterPostCollectionController
 * @package App\Controller\Client
 */
class UserRegisterPostCollectionController
{
    /**
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param ParameterBagInterface $params
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @return Response
     */
    public function __invoke(
        Request $request,
        ValidatorInterface $validator,
        ParameterBagInterface $params,
        EntityManagerInterface $em,
        UserPasswordEncoderInterface $encoder
    ): Response {
        $data = \json_decode($request->getContent(), true);

        $user = new User();
        $user->setUsername($data['username']);
        $user->setName($data['name']);
        // $user->setPlainPassword($data['plainPassword']);
        $user->setPassword($encoder->encodePassword($user, $data['plainPassword']));
        $em->persist($user);

        if (!empty($data['team'])) {
            $team = $em->getRepository(Team::class)->findOneBy(['hash' => $data['team']]);
        } else {
            $team = new Team();
            $team->setHash(str_replace('.', '', uniqid('', true)));
            $team->setOwner($user);
            $em->persist($team);
        }

        $user->setTeam($team);
        $validator->validate($user);
        $em->flush();

        return new Response(null, Response::HTTP_CREATED);
    }
}
