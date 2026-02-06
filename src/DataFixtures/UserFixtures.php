<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private const DEFAULT_PASSWORD = '1234';

    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        $users = [
            [
                'login' => 'admin',
                'email' => 'admin@admin.com',
                'firstName' => 'Главный',
                'name' => 'Администратор',
                'patronymic' => 'Системный',
                'roles' => ['ROLE_ADMIN'],
            ],
            [
                'login' => 'user1',
                'email' => 'user1@example.com',
                'firstName' => 'Иван',
                'name' => 'Иванов',
                'patronymic' => 'Иванович',
                'roles' => ['ROLE_USER'],
            ],
            [
                'login' => 'user2',
                'email' => 'user2@example.com',
                'firstName' => 'Петр',
                'name' => 'Петров',
                'patronymic' => 'Петрович',
                'roles' => ['ROLE_USER'],
            ],
            [
                'login' => 'user3',
                'email' => 'user3@example.com',
                'firstName' => 'Сидор',
                'name' => 'Сидоров',
                'patronymic' => 'Сидорович',
                'roles' => ['ROLE_USER'],
            ],
            [
                'login' => 'user4',
                'email' => 'user4@example.com',
                'firstName' => 'Козел',
                'name' => 'Козлов',
                'patronymic' => 'Козлович',
                'roles' => ['ROLE_USER'],
            ],
            [
                'login' => 'user5',
                'email' => 'user5@example.com',
                'firstName' => 'Смирн',
                'name' => 'Смирнов',
                'patronymic' => 'Смирнович',
                'roles' => ['ROLE_USER'],
            ],
            [
                'login' => 'guest',
                'email' => 'guest@example.com',
                'firstName' => null,
                'name' => null,
                'patronymic' => null,
                'roles' => ['ROLE_USER'],
            ],
        ];

        foreach ($users as $data) {
            $user = new User();
            $user->setLogin($data['login']);
            $user->setEmail($data['email']);
            $user->setFirstName($data['firstName']);
            $user->setName($data['name']);
            $user->setPatronymic($data['patronymic']);
            $user->setRoles($data['roles']);
            $user->setPassword($this->passwordHasher->hashPassword($user, self::DEFAULT_PASSWORD));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
