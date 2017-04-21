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
                }}
            case "PUT":
                  return new Response("J'edite le produit ".$id." dans la bdd");
            case "PATCH":
                  return new Response("J'edite le produit ".$id." dans la bdd");
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
                  return new Response("Nouveau produit créé dans la bdd");
          }
        }
        /**
         * @Route("/products/{id}")
         * @Method("DELETE")
         */
        public function deleteAction($id)
        {
          switch ($request->getMethod()) {
            case "GET":
                  return $this->render('products/delete.html.twig');
          }
        }
    }
