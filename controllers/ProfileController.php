<?php

namespace Controllers;

use Framework\Authentication\Auth;
use Framework\Core\Controller;
use Framework\Forms\Validations\Validations;
use Framework\Http\Requests\Request;
use Models\Users;

class ProfileController extends Controller
{
    public function __construct()
    {
        $userData = Auth::GetData($_SESSION['token']);

        $imgProfiles = scandir(PROFILEPHOTOS);

        if ($userData->profile_picture == NULL || !in_array($userData->profile_picture, $imgProfiles)) {
            $userData->profile_picture = DEFAULTPROFILEPHOTO;
        }

        $this->data["userData"] = $userData;
    }


    public function index()
    {
        $this->render("profile/personalData/personalData");
    }


    public function security()
    {
        $this->render("profile/security/security");
    }


    public function logOff()
    {
        session_destroy();

        if (isset($_COOKIE['session'])) {
            setcookie('session');
        }

        header("location: /login");
    }


    public function updatePersonalData(Request $request)
    {
        $userData = Auth::GetData($_SESSION['token']);

        $id = $userData->id;
        $username = $request->post['username'];
        $firstname = $request->post['firstname'];
        $lastname = $request->post['lastname'];
        $email = $request->post['email'];

        $successValidateForm = Validations::validateRegister($request->post, $email);

        if ($successValidateForm === "empty fields") $response = ["status" => false, "response" => "Hay campos vacíos"];
        else if ($successValidateForm === "wrong email") $response = ["status" => false, "response" => "El email no tiene un formato correcto"];
        else {
            $userObject = new Users();
            $user = $userObject->constructUser($username, $firstname, $lastname, $email, "");

            $success = $user->updatePersonalData($id);

            if ($success) {
                $myUser = $userObject->getByColumn("id", $id)[0];

                $token = Auth::createToken($myUser);

                $_SESSION['token'] = $token;

                if (isset($_COOKIE['session'])) {
                    $_COOKIE['session'] = $token;
                }

                $response = ["status" => true, "response" => "Success"];
            }else{
                die(header("HTTP/1.1 515 The user could not be saved"));
            }
        }

        echo json_encode($response);
    }


    public function updatePass(Request $request)
    {
        $userData = Auth::GetData($_SESSION['token']);

        $id = $userData->id;
        $lastPass = $request->post['lastPass'];
        $newPass = $request->post['newPass'];
        $repeatNewPass = $request->post['repeatNewPass'];

        $successValidateForm = Validations::dataIsEmpty($request->post);

        if ($successValidateForm) {
            $userObject = new Users();
            $user = $userObject->getById($id);
    
            $passwordIsSame = password_verify($lastPass, $user->pass);
    
            if ($passwordIsSame) {
                $newUserObject = new Users();
                $newUser = $newUserObject->constructUser("", "", "", "", password_hash($newPass, PASSWORD_DEFAULT));
    
                $success = $newUser->updatePass($id);
    
                if ($success) {
                    $response = ["status" => true, "response" => "Success"];

                    if ($newPass !== $repeatNewPass) {
                        $response = ["status" => false, "response" => "Las contraseñas no coinciden"];
                    }else{
                        if ($lastPass === $newPass) {
                            $response = ["status" => false, "response" => "La contraseña antigua y nueva es la misma"];
                        }
                    }
                }else{
                    die(header("HTTP/1.1 516 The password could not be saved"));
                }
            }else{
                $response = ["status" => false, "response" => "La contraseña antigua no es correcta"];
            }   
        }else{
            $response = ["status" => false, "response" => "Hay campos vacíos"];
        }

        echo json_encode($response);
    }


    function deletePhotoProfile()
    {
        $directory = PROFILEPHOTOS;

        $userData = Auth::GetData($_SESSION['token']);
        $imgName = $userData->profile_picture;

        $userObject = new Users();

        $success = $userObject->updateById($userData->id, "profile_picture", DEFAULTPROFILEPHOTO);

        if ($success) {
            if (unlink($directory . $imgName)) {
                $myUser = $userObject->getByColumn("id", $userData->id)[0];

                $token = Auth::createToken($myUser);

                $_SESSION['token'] = $token;

                if (isset($_COOKIE['session'])) {
                    $_COOKIE['session'] = $token;
                }

                echo json_encode(array("response" => true));
            } else {
                echo json_encode(array("response" => false, "message" => "Fail to delete img from server"));
            }
        }else{
            die(header("HTTP/1.1 520 User can´t be updated"));
        }
    }


    function updatePhotoProfile(Request $request)
    {
        if (isset($request->post["photo"])) {
            $image = $request->post["photo"];

            if (isset($image) && $image != "") {
               $userData = Auth::GetData($_SESSION['token']);

               $lastPhoto = $userData->profile_picture;

               $type = $image['type'];
               $name = "profile-" . $userData->username . "-" . implode("-", getdate()) . ".jpg";  //Create name unique
               $size = $image['size'];
               $temp = $image['tmp_name'];

               //Se comprueba si el image a cargar es correcto observando su extensión y tamaño
              if (!((strpos($type, "gif") || strpos($type, "jpeg") || strpos($type, "jpg") || strpos($type, "png")) && ($size < 2000000))) {
                $response = ["response" => false, "message" => "Size or format is incorrect. It´s allowed .gif, .jpeg, jpg, .png as format."];
              }
              else {
                 //Si la imagen es correcta en tamaño y type
                 //Se intenta subir al servidor
                 if (move_uploaded_file($temp, PROFILEPHOTOS . $name)) {
                    //Cambiamos los permisos del image a 777 para poder modificarlo posteriormente
                    chmod(PROFILEPHOTOS . $name, 0777);

                    $id = $userData->id;

                    $userObject = new Users();

                    $success = $userObject->updateById($id, "profile_picture", $name);

                    if ($success) {

                        $filesOfProfileDir = scandir(PROFILEPHOTOS);

                        $existInProfileDir = in_array($lastPhoto, $filesOfProfileDir);

                        if ($existInProfileDir && $lastPhoto != DEFAULTPROFILEPHOTO) {
                            unlink(PROFILEPHOTOS . $lastPhoto);
                        }

                        $myUser = $userObject->getByColumn("id", $id)[0];

                        $token = Auth::createToken($myUser);

                        $_SESSION['token'] = $token;

                        if (isset($_COOKIE['session'])) {
                            $_COOKIE['session'] = $token;
                        }

                        $response = ["status" => true, "response" => "Success", "image" => $name];
                    }else{
                        $response = ["status" => false, "response" => "User couldn´t be saved"];
                    }
                 }
                 else {
                    //Si no se ha podido subir la imagen, mostramos un mensaje de error
                    $response = ["response" => false, "message" => "File couldn´t be saved"];
                 }
               }
            }else{
                die(header("HTTP/1.1 522 File is empty"));
            }
        }else{
            die(header("HTTP/1.1 521 No files was sent"));
        }

        echo json_encode($response);
    }

}