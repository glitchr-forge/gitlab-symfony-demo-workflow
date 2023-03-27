<?php

namespace App\Controller\Crud;

use App\Entity\User;
use Base\Backend\Config\Extension;
use Base\Controller\Backend\AbstractCrudController;
use Base\Controller\Backend\AbstractDashboardController;
use Base\Controller\Backend\Crud\UserActionCrudController;
use Base\Entity\Layout\Attribute\Adapter\HyperpatternAdapter;
use Base\Field\ArrayField;
use Base\Field\AttributeField;
use Base\Field\AvatarField;

use Base\Field\PasswordField;
use Base\Field\RoleField;
use Base\Field\BooleanField;

use Base\Field\EmailField;
use Base\Field\SelectField;
use Base\Field\TextField;
use Base\Security\LoginRestrictionInterface;
use Base\Service\Model\LinkableInterface;
use Base\Service\Translator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use Symfony\Component\PropertyAccess\PropertyAccess;

use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

class ArticleCrudController extends AbstractCrudController
{
    public static function getPreferredIcon(): ?string
    {
        return null;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
                ->update(Crud::PAGE_INDEX, Action::NEW, fn (Action $a) => $this->setDiscriminatorMapAttribute($a))

                ->setPermission(Action::NEW, 'PUBLIC_ACCESS')
                ->setPermission(Action::EDIT, 'PUBLIC_ACCESS')
                ->setPermission(Action::DELETE, 'PUBLIC_ACCESS')
        ;
    }


    public function configureFilters(Filters $filters): Filters
    {
        return $filters->add('state');
    }

    public function configureFields(string $pageName, ...$args): iterable
    {
        return parent::configureFields($pageName, function () {

            yield TextField::new('title')->setColumns(8);
                yield SelectField::new("state")->setColumns(4);

            yield TextareaField::new("content")->setColumns(12);



        }, $args);
    }
}
