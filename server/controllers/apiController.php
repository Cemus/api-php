<?php

class ApiController{
    private array $models;
    private PDO $bdd;
    public function __construct(array $models, PDO $bdd) {
        $this->models = $models;
        $this->bdd = $bdd;
    }

    function checkInformations(array $informations): bool {
        return !empty($informations["alias"]) 
            && filter_var($informations["email"], FILTER_VALIDATE_EMAIL) 
            && strlen($informations["password"]) >= 8;
    }
    function addUser():void {
        $data = file_get_contents('php://input');

        if (empty($data)) {
            echo "Pas de data";
            exit;
        }
        
        $data = json_decode($data);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            echo "JSON erreur : " . json_last_error_msg();
            http_response_code(400);
            echo json_encode(['message' => 'JSON invalide...', 'error' => json_last_error_msg()]);
            return;
        }

        if(isset($data)) {
            $informations = [
                "alias" => htmlspecialchars($data->alias),
                "email" => htmlspecialchars($data->email),
                "password" => $data->password
            ];
            if($this->checkInformations($informations)) {
                $user = $this->models["user"]->getUserByEmail($this->bdd,$informations["email"]);
                if(!$user) {
                    $hashedPassword = password_hash($informations["password"], PASSWORD_DEFAULT);
                    $informations["password"] = $hashedPassword;
                    try{
                        $this->models["user"]->addUser($this->bdd, $informations);
                        http_response_code(response_code: 200);
                        $response = json_encode(value: ['message' => "Utilisateur " . $informations["alias"]. " ajouté !", 'code response' => 200]);
                    }catch(Exception $e){
                        http_response_code(response_code: 500);
                        $response = json_encode(value: ['message' => "Erreur serveur", 'code response' => 500]);                    }
                }
                else {
                    http_response_code(response_code: 400);
                    $response = json_encode(value: ['message' => "Existe deja", 'code response' => 400]);
                } 
            }else{
                http_response_code(response_code: 400);
                $response = json_encode(value: ['message' => "Donnes non trouvees", 'code response' => 400]);
            }
        }
        header("Access-Control-Allow-Origin: same");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: POST");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
        echo $response;
    }

    function getUsers():void{
        $response = "";
        $users = $this->models["user"]->getAllUsers($this->bdd);
        if (isset($users)) {
            if (count($users) > 0){
                http_response_code(200);
                $response=json_encode(['status' => 'success', 'data' => $users]);
            }else{
                http_response_code(200);
                $response=json_encode(['status' => 'success', 'message' => "Personne dans le coin"]);      
            }

        } else {
            http_response_code(response_code: 404);
            $response=json_encode([
                'status' => 'error', 
                'message' => 'Erreur']);
        }

        header("Access-Control-Allow-Origin: same");
        header("Content-Type: application/json; charset=UTF-8");
        header("Access-Control-Allow-Methods: GET");
        header("Access-Control-Max-Age: 3600");
        header("Access-Control-Allow-Headers: Content-Type, Access-Control-AllowHeaders, Authorization, X-Requested-With");
        echo $response;

    }

    public function getModels(): array { return $this->models; }
    public function setModels(array $models): self { $this->models = $models; return $this; }

    public function getBdd(): PDO { return $this->bdd; }
    public function setBdd(PDO $bdd): self { $this->bdd = $bdd; return $this; }


}