<?php
    namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

    class ProductsController extends Controller
    {
        const PRODUCTS_TEST = [
        ['id' => 1, 'reference' => 'AFR-1'],
        ['id' => 2, 'reference' => 'AFR-2'],
        ['id' => 3, 'reference' => 'AFR-3'],
        ['id' => 4, 'reference' => 'AFR-4']
      ];

        /**
         * @Route(
         *        "/products.{_format}",
         *         defaults={"_format": "html"},
         *         requirements={
         *                "_format": "html|json"
         *    })
         * @Method("GET")
         */

        public function indexAction(Request $request)
        {
            $products = $this->getDoctrine()
              ->getRepository('AppBundle:Product')
              ->findAll();

            switch ($request->getRequestFormat()) {
            case "json":
                  return $this->json(self::$products);
            case "html":
                  return $this->render('products/index.html.twig', compact('products'));
          }
        }

        /**
         * @Route(
         *        "/products/{id}.{_format}",
         *         defaults={
         *                   "_format": "html"},
         *         requirements={
         *                "_format": "html|json",
         *                "id": "\d+"
         *    })
         * @Method("GET")
         */
        public function showAction(Request $request, int $id)
        {
            $product = $this->getDoctrine()
              ->getRepository('AppBundle:Product')
              ->find($id);

            switch ($request->getRequestFormat()) {
                      case "json":
                            if ($product) {
                              return $this->json($product);
                            }else {
                              return $this->json(['error' => 'not found']);
                            }

                      case "html":
                      if ($product) {
                            return $this->render('products/show.html.twig', compact('product'));  //compact('product') égal à [ 'product' => $product ]
                          }else {
                            throw $this->createNotFoundException('No product found for id: '.$id);
                          }
                }

            return $this->json(['error' => 'Product '.$id.' not found']);
        }

        /**
         * @Route("/products/{id}/edit.{_format}",
         *         defaults={
         *                   "_format": "html"},
         *         requirements={
         *                "_format": "html|json",
         *                "id": "\d+"
         *    })")
         * @Method({"GET", "PUT", "PATCH"})
         */
        public function editAction(Request $request, int $id)
        {
            $em = $this->getDoctrine()->getManager();
            $product = $em->getRepository('AppBundle:Product')->find($id);

            switch ($request->getMethod()) {
            case "GET":
                    return $this->render('products/edit.html.twig', compact('product'));
            case "PUT":
              switch ($request->getRequestFormat()) {
                case "json":
                    return $this->json(['success' => 'Product edited']);
                case 'html':
                    $product->setReference();
                    $product->setPrice();
                    $em->flush();

                    $this->addFlash(
                      'success',
                      'Product edited !'
                    );

                  return $this->redirectToRoute('app_products_index');
          }
            case "PATCH":
              switch ($request->getRequestFormat()) {
                case "json":
                      return $this->json(['success' => 'Product edited']);
                case 'html':
                    $product->setReference();
                    $product->setPrice();
                    $em->flush();

                    $this->addFlash(
                    'success',
                    'Product edited !'
                    );
                    return $this->redirectToRoute('app_products_index');
            }
          }
        }
        /**
         * @Route("/products/create.{_format}",
         *         defaults={
         *                   "_format": "html"},
         *         requirements={
         *                "_format": "html|json",
         *                "id": "\d+"
         *    })")
         * @Method({"GET","POST"})
         */
        public function createAction(Request $request)
        {
            switch ($request->getMethod()) {
            case "GET":
                  return $this->render('products/create.html.twig', compact('product'));
            case "POST":
              switch ($request->getRequestFormat()) {
                case "json":
                      return $this->json(['success' => 'Product created']);
                case 'html':
                      $this->addFlash(
                      'success',
                      'Product created !'
                      );
                      return $this->redirectToRoute('app_products_index');
              }
          }
        }
        /**
         * @Route("/products/{id}/delete.{_format}",
         *         defaults={
         *                   "_format": "html"},
         *         requirements={
         *                "_format": "html|json",
         *                "id": "\d+"
         *    })")
         * @Method("DELETE")
         */
        public function deleteAction(Request $request)
        {
            switch ($request->getRequestFormat()) {
            case "json":
                  return $this->json(['success' => 'Product deleted']);
            case 'html':
                  $this->addFlash(
                  'success',
                  'Product deleted !'
                  );
                  return $this->redirectToRoute('app_products_index');
          }
        }
    }
