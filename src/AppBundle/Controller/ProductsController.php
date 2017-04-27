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
            switch ($request->getRequestFormat()) {
            case "json":
                  return $this->json(self::PRODUCTS_TEST);
            case "html":
                  return $this->render('products/index.html.twig', [
                      'products' => self::PRODUCTS_TEST
                    ]);
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
            foreach (self::PRODUCTS_TEST as $product) {
                if ($product['id'] === $id) {
                    switch ($request->getRequestFormat()) {
                      case "json":
                            return $this->json($product);
                      case "html":
                            return $this->render('products/show.html.twig', compact('product'));  //compact('product') égal à [ 'product' => $product ]
                  }
                }
            }
            return $this->json(['error' => 'Product '.$id.' not found']);
        }

        /**
         * @Route("/products/{id}/edit")
         * @Method({"GET", "PUT", "PATCH"})
         */
        public function editAction(Request $request, int $id)
        {
            switch ($request->getMethod()) {
            case "GET":
            foreach (self::PRODUCTS_TEST as $product) {
                if ($product['id'] === $id) {
                    return $this->render('products/edit.html.twig', compact('product'));
                }
            }
            case "PUT":
                    $this->addFlash(
                    'success',
                    'Produit '.$id.' modifié !'
                  );
                  return $this->redirectToRoute('app_products_index');
            case "PATCH":
                    $this->addFlash(
                    'success',
                    'Produit '.$id.' modifié !'
                  );
                  return $this->redirectToRoute('app_products_index');
          }
        }
        /**
         * @Route("/products/create")
         * @Method({"GET","POST"})
         */
        public function createAction(Request $request)
        {
            switch ($request->getMethod()) {
            case "GET":
                  return $this->render('products/create.html.twig', compact('product'));
            case "POST":

                  $this->addFlash(
                  'success',
                  'Produit ajouté !'
                  );
                  return $this->redirectToRoute('app_products_index');
          }
        }
        /**
         * @Route("/products/{id}/delete")
         * @Method("DELETE")
         */
        public function deleteAction(Request $request)
        {
            $this->addFlash(
            'success',
            'Produit supprimer!'
          );

            return $this->redirectToRoute('app_products_index');
        }
    }
