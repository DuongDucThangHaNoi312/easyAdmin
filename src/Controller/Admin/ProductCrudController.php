<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
//hiển thị  dữ liệu các cột databse

            TextField::new('name'),
             IntegerField::new('price'),
            AssociationField::new('category'),

        ];
    }

    //Chỉ tài khoản admin mới được thêm sửa xóa
    /**
     * @param Actions $actions
     * @return Actions
     */
    public function  configureActions(Actions $actions): Actions
    {
        return $actions->setPermission(Action::DELETE,'ROLE_ADMIN')
            ->setPermission(Action::EDIT,'ROLE_ADMIN')
            ->setPermission(Action::NEW,'ROLE_ADMIN');

    }


}
