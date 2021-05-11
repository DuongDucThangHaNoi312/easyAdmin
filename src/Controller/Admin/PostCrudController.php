<?php

namespace App\Controller\Admin;

use App\Entity\Post;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;


class PostCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Post::class;
    }


    public function configureFields(string $pageName): iterable
    {

       $imageFile = TextareaField::new('thumbnailFile','PostImg')->setFormType(VichImageType::class);
       $image =   ImageField::new('thumbnail')->setBasePath('/images/thumbnails');

       $fields = [
            TextField::new('title'),
            TextEditorField::new('content'),
            DateField::new('updatedAt'),
            AssociationField::new('category'),
            AssociationField::new('user')->hideOnForm(),
           ];
      if ($pageName == Crud::PAGE_INDEX || $pageName == Crud::PAGE_DETAIL) {
      $fields[] = $image;
       } else {
      $fields[] = $imageFile;
     }
      return $fields;
}

    //Chỉ tài khoản admin mới được thêm sửa xóa
    public function  configureActions(Actions $actions): Actions
    {
        return $actions->setPermission(Action::DELETE,'ROLE_ADMIN')
            ->setPermission(Action::EDIT,'ROLE_ADMIN')
            ->setPermission(Action::NEW,'ROLE_ADMIN');

    }

}
