<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCrudController extends AbstractCrudController
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('firstName', 'First name'),
            TextField::new('name'),
            TextField::new('patronymic'),
            TextField::new('login'),
            EmailField::new('email')->hideOnIndex(),
            TextField::new('password')
                ->setFormType(PasswordType::class)
                ->onlyOnForms()
                ->setRequired($pageName === 'new'),
            ChoiceField::new('roles')
                ->setChoices([
                    'User' => 'ROLE_USER',
                ])
                ->allowMultipleChoices(),
            DateTimeField::new('createdAt', 'Created at')->onlyOnIndex(),
            DateTimeField::new('updatedAt', 'Updated at')->onlyOnIndex(),
            DateTimeField::new('deletedAt', 'Deleted at')->onlyOnIndex(),
        ];
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $plain = $entityInstance->getPassword();
            if ($plain !== null && $plain !== '') {
                $entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $plain));
            }
        }
        parent::persistEntity($entityManager, $entityInstance);
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof User) {
            $plain = $entityInstance->getPassword();
            if ($plain !== null && $plain !== '') {
                $entityInstance->setPassword($this->passwordHasher->hashPassword($entityInstance, $plain));
            } else {
                $original = $entityManager->getRepository(User::class)->find($entityInstance->getId());
                if ($original instanceof User) {
                    $entityInstance->setPassword($original->getPassword());
                }
            }
        }
        parent::updateEntity($entityManager, $entityInstance);
    }
}
