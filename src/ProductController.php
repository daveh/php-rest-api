<?php

class ProductController
{
//    public function __construct(private ProductGateway $gateway)
    public function __construct()
    {

    }
    
    public function processRequest(string $method, string $request): void
    {
            $this->processCollectionRequest($method, $request);
    }
    
//    private function processResourceRequest(string $method, string $id): void
//    {
//        $product = $this->gateway->get($id);
//
//        if ( ! $product) {
//            http_response_code(404);
//            echo json_encode(["message" => "Product not found"]);
//            return;
//        }
//
//        switch ($method) {
//            case "GET":
//                echo json_encode($product);
//                break;
//
//            case "PATCH":
//                $data = (array) json_decode(file_get_contents("php://input"), true);
//
//                $errors = $this->getValidationErrors($data, false);
//
//                if ( ! empty($errors)) {
//                    http_response_code(422);
//                    echo json_encode(["errors" => $errors]);
//                    break;
//                }
//
//                $rows = $this->gateway->update($product, $data);
//
//                echo json_encode([
//                    "message" => "Product $id updated",
//                    "rows" => $rows
//                ]);
//                break;
//
//            case "DELETE":
//                $rows = $this->gateway->delete($id);
//
//                echo json_encode([
//                    "message" => "Product $id deleted",
//                    "rows" => $rows
//                ]);
//                break;
//
//            default:
//                http_response_code(405);
//                header("Allow: GET, PATCH, DELETE");
//        }
//    }
    
    private function processCollectionRequest(string $method, string $request): void
    {
        $file = 'httpCall.log';
        if (file_exists($file)) {
            $content = file_get_contents($file);
        } else {
            $content = "";
        }

        $date = new DateTime("now", new DateTimeZone('America/New_York'));
        $logDate = $date->format('Y-m-d H:i:s');
        $content .= "\n\n" . $logDate . "\n";

        $content .= "\n" . $method . "\n";
        $content .= "Request:\n" . $request . "\n";

        $allHeaders = getallheaders();
        unset($allHeaders["Authorization"]);
        echo "Headers:\n\n";
        echo json_encode($allHeaders);

        $content .= "\nHeaders:\n" . json_encode($allHeaders) . "\n";

        echo "\nBody:\n\n";
        $entityBody = file_get_contents('php://input');
        echo $entityBody;
        $content .= "\n" . $entityBody . "\n";

        switch ($method) {
            case "GET":
                break;

            case "POST":
                http_response_code(202);
                break;
            
            default:
                http_response_code(405);
                header("Allow: GET, POST");
        }

        file_put_contents($file, $content);

    }
}









