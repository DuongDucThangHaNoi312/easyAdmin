<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductType;
use App\Form\UpdateProductType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{

    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/createProduct', name: 'product')]
        public function create(Request  $request): Response
    {

        //tạo 1 đối tượng của lớp Product
        $product = new Product();


        //lấy các cột ở database để tạo ra form ở folder form(Chưa có dữ liệu)
        $form = $this->createForm(ProductType::class, $product);

        //đợi yêu cầu từ trang (đợi submit)
        $form->handleRequest($request);

        // nếu ấn submit
        if ($form->isSubmitted() && $form->isValid()) {

            //truy cập trình quản lý dữ liệu bằng cách sử dụng phương thức getManager () thông qua getDoctrine ()  để thao tác với csdl
            $x = $this->getDoctrine()->getManager();

            // cho Doctrine biết bạn muốn lưu sản phẩm câu truy vấn đã thêm vào hàng đợi
            $x->persist($product);

            // thực thi câu truy vấn
            $x->flush();

            return $this->redirect($this->generateUrl('productList'));

        }
        return $this->render('product/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

//        $category = new Category();
//        $category->setName('Computer Peripherals');
//
//        $product = new Product();
//        $product->setName('Mouse');
//        $product->setPrice(20.33);
//
//        // relates this product to the category
//        $product->setCategory($category);
//
//        $entityManager = $this->getDoctrine()->getManager();
//        $entityManager->persist($category);
//        $entityManager->persist($product);
//        $entityManager->flush();
//
//        return new Response(
//            'Saved new product with id: ' . $product->getId()
//            . ' and new category with id: ' . $category->getId()
//        );



    public  function __toString()
    {
       return $this->name;
    }


    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/products', name: 'productList')]
    public function showAllProduct(Request $request): Response
    {
        //muốn đến trình quản lí dữ liệu không chỉnh sửa
        $productRepo = $this->getDoctrine()->getRepository(persistentObject: Product::class);

        //lấy tất cả dữ liệu
        $products = $productRepo->findAll();
        return $this->render('product/list.html.twig', [
            'products' => $products
        ]);
    }


    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/productDelete', name: 'productDelete')]
    public function delete(Request $request): Response
    {// lấy id trên url được truyền lên từ bên view
        $id = $request->get('id');

        // Muốn lấy dữ liệu ở database qua Repository
        $productDelete = $this->getDoctrine()->getRepository(Product::class)->find($id);

        //truy cập trình quản lý dữ liệu bằng cách sử dụng phương thức getManager () thông qua getDoctrine ()  để xử lí
        $product = $this->getDoctrine()->getManager();

        //cho Doctrine biết muốn xóa sản phẩm
        $product->remove($productDelete);

        // thực thi câu truy vấn xóa dữ liệu
        $product->flush();

        return $this->redirect($this->generateUrl('productList'));
    }


    /**
     * @param Request $request
     * @return Response
     */
    #[Route('/productEdit', name: 'productEdit')]
    public function edit(Request $request): Response
    {
        //lấy id từ url
        $id = $request->get('id');
        //lấy dữ liệu ra không chỉnh sửa theo id
        $productEdit = $this->getDoctrine()->getRepository(Product::class)->find($id);
        //đẩy giá trị vào form
        $form = $this->createForm(UpdateProductType::class, $productEdit);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //lấy dữ liệu ra để chỉnh sửa
            $x = $this->getDoctrine()->getManager();
            //
            $x->persist($productEdit);
            //đẩy lên db
            $x->flush();
            return $this->redirect($this->generateUrl('productList'));

        }
        return $this->render('product/create.html.twig', [
            'form' => $form->createView()
        ]);

    }


}
