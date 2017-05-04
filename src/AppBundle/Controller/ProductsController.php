<?php
    namespace AppBundle\Controller;

    use Symfony\Bundle\FrameworkBundle\Controller\Controller;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;
    use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
    use AppBundle\Entity\Product;

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
                  if ( $product) {
                    $categories = $this->getDoctrine()
                            ->getRepository('AppBundle:Category')
                            ->findAll();
                    return $this->render('products/edit.html.twig', compact('product', 'categories'));
                  } else {
                    throw $this->createNotFoundException('No product found for id: '.$id);
                  }
            case "PUT":
            case "PATCH":
            $reference = $request->request->get('ref');
            $price = $request->request->get('price');

                $product->setReference($reference);
                $product->setPrice($price);
                $em->flush();

              switch ($request->getRequestFormat()) {
                case "json":
                  if ($product) {
                      return $this->json(['success' => 'Product edited']);
                    }
                    else {
                      return $this->json(['Product '.$id.' not found']);
                    }
                case 'html':
                if ($product) {
                    $this->addFlash(
                    'success',
                    'Product edited !'
                    );
                    return $this->redirectToRoute('app_products_index');
                  }else {
                    throw $this->createNotFoundException('No product found for id: '.$id);
                  }
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
            $categories = $this->getDoctrine()
                    ->getRepository('AppBundle:Category')
                    ->findAll();
                  return $this->render('products/create.html.twig', compact('categories'));
            case "POST":
              $reference = $request->request->get('ref');
              $price = $request->request->get('price');

              if ($price !== "" && $reference !== "") {
                $product = new Product();
                $product->setPrice($price);
                $product->setReference($reference);
                $em = $this->getDoctrine()->getManager();
                $em->persist($product);
                $em->flush();

                $this->addFlash(
                'success',
                'Product created !'
                );

              }else if ($price === "" || $reference === "") {
                $this->addFlash(
                'warning',
                'Un ou plusieurs champs ne sont pas remplit !'
                );
              }

              switch ($request->getRequestFormat()) {
                case "json":
                      return $this->json(['success' => 'Product created']);
                case 'html':
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
        public function deleteAction(Request $request, int $id)
        {
          $product = $this->getDoctrine()->getRepository('AppBundle:Product')->find($id);

          if ( $product) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($product);
            $em->flush();
          }
            switch ($request->getRequestFormat()) {
            case "json":
            if ($product) {
                  return $this->json(['success' => 'Product deleted']);
                }else {
                  return $this->json(['Product '.$id.' not found']);
                }
            case 'html':
            if ($product) {
              $this->addFlash(
                'success',
                'Product deleted !'
              );
            }else {
                  throw $this->createNotFoundException('No product found for id: '.$id);
                }
          }
        }
    }
