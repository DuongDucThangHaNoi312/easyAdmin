<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }


//    public function configureFields(string $pageName): iterable
//    {
//        //hiển thị các cột database
//        return [
//            IdField::new('id'),
//            TextField::new('name'),
//
//        ];
//    }


    //Chỉ tài khoản admin mới được thêm sửa xóa

    public function  configureActions(Actions $actions): Actions
    {
        return $actions->setPermission(Action::DELETE,'ROLE_ADMIN')
            ->setPermission(Action::EDIT,'ROLE_ADMIN')
            ->setPermission(Action::NEW,'ROLE_ADMIN');

    }

}
