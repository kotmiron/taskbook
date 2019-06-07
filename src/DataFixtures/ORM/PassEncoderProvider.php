<?php

namespace App\DataFixtures\ORM;

use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker\Provider\Base as BaseProvider;
use Faker\Generator;

class PassEncoderProvider extends BaseProvider
{

    /** @var UserPasswordEncoderInterface */
    private $encoder;

    /**
     * {@inheritdoc}
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(Generator $generator, UserPasswordEncoderInterface $encoder)
    {
        parent::__construct($generator);
        $this->encoder = $encoder;
    }

    public function myEncodePassword($plainPassword)
    {
        $user = new User();
        $password = $this->encoder->encodePassword($user, $plainPassword);
        return $this->generator->parse($password);
    }

}
