<?php

namespace App\Controller;

use App\Entity\Category;

use App\Form\CategoryType;


use App\Form\UpdateCategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{

    #[Route('/home', name: 'home')]
    public function home(): Response
   {
    return $this->render('product/Home.html.twig');
    }



    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/createCategory', name: 'category')]
    public function create(Request $request): Response
    {
        //tạo 1 đối tượng của lớp Product
        $category= new Category();


        //lấy các cột ở database để tạo ra form ở folder form(Chưa có dữ liệu)
        $form = $this->createForm(CategoryType::class, $category);

        //đợi yêu cầu từ trang (đợi submit)
        $form->handleRequest($request);

        // nếu ấn submit
        if ($form->isSubmitted() && $form->isValid()) {

            //truy cập trình quản lý dữ liệu bằng cách sử dụng phương thức getManager () thông qua getDoctrine ()  để thao tác với csdl
            $x = $this->getDoctrine()->getManager();

            // cho Doctrine biết bạn muốn lưu sản phẩm câu truy vấn đã thêm vào hàng đợi
            $x->persist($category);

            // thực thi câu truy vấn
            $x->flush();

            return $this->redirect($this->generateUrl('CategoryList'));

        }
        return $this->render('category/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/categories', name: 'CategoryList')]
    public function showAllProduct(Request $request): Response
    {
        //muốn đến trình quản lí dữ liệu không chỉnh sửa
        $categoryRepo = $this->getDoctrine()->getRepository(persistentObject: Category::class);

        //lấy tất cả dữ liệu
        $category = $categoryRepo->findAll();

        return $this->render('category/listcategory.html.twig', parameters: [
            'category' => $category
        ]);
    }

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/categoryDelete', name: 'categoryDelete')]
    public function delete(Request $request): Response
    {// lấy id trên url được truyền lên từ bên view
        $id = $request->get('id');

        // Muốn lấy dữ liệu ở database qua Repository
        $categoryDelete = $this->getDoctrine()->getRepository(Category::class)->find($id);

        //truy cập trình quản lý dữ liệu bằng cách sử dụng phương thức getManager () thông qua getDoctrine ()  để xử lí
        $category = $this->getDoctrine()->getManager();

        //cho Doctrine biết muốn xóa sản phẩm
        $category ->remove($categoryDelete);

        // thực thi câu truy vấn xóa dữ liệu
        $category->flush();

        return $this->redirect($this->generateUrl('CategoryList'));
    }


    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/categoryEdit', name: 'categoryEdit')]
    public function edit(Request $request): Response
    {
        //lấy id từ url
        $id = $request->get('id');
        //lấy dữ liệu ra không chỉnh sửa theo id
        $categoryEdit = $this->getDoctrine()->getRepository(Category::class)->find($id);
        //đẩy giá trị vào form
        $form = $this->createForm(UpdateCategoryType::class, $categoryEdit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //lấy dữ liệu ra để chỉnh sửa
            $x = $this->getDoctrine()->getManager();
            //
            $x->persist($categoryEdit);
            //đẩy lên db
            $x->flush();
            return $this->redirect($this->generateUrl('CategoryList'));

        }
        return $this->render('category/form.html.twig', [
            'form' => $form->createView()
        ]);

    }



}


