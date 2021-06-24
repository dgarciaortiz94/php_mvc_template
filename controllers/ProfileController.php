<?php

namespace Controllers;

use Framework\Authentication\Auth;
use Framework\Core\Controller;
use Framework\Forms\Images\Images;
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
        $userData = Auth::GetData($_SESSION['token']);
        $imgName = $userData->profile_picture;

        if($imgName != DEFAULTPROFILEPHOTO){
            $userObject = new Users();
            $success = $userObject->updateById($userData->id, "profile_picture", DEFAULTPROFILEPHOTO);
    
            if ($success) {
                if (Images::delete(PROFILEPHOTOS, $imgName)) {
                    $myUser = $userObject->getByColumn("id", $userData->id)[0];
                    $token = Auth::createToken($myUser);
                    $_SESSION['token'] = $token;
    
                    if (isset($_COOKIE['session'])) $_COOKIE['session'] = $token;
    
                    $response = ["response" => true];
                } else {
                    $response = ["response" => false, "message" => "Fail to delete img from server"];
                }
            }else{
                die(header("HTTP/1.1 520 User can´t be updated"));
            }
        }else{
            $response = ["response" => true];
        }

        echo json_encode($response);
    }

    

    function updatePhotoProfile(Request $request)
    {
        if (isset($request->post["photo"])) {
            $img = new Images($request->post["photo"], 2000000, ["jpg", "jpeg", "png", "gif", "webp"]);

            if ($img->validate()) {

                $userData = Auth::GetData($_SESSION['token']);

                $name = "profile-" . $userData->username . "-" . implode("-", getdate()) . ".jpg";  //Create unique name

                if ($img->upload(PROFILEPHOTOS, $name)) {
                    $lastPhoto = $userData->profile_picture;

                    $userObject = new Users();
                    $success = $userObject->updateById($userData->id, "profile_picture", $name);

                    if ($success) {
                        $imageExist = Images::exist(PROFILEPHOTOS, $lastPhoto);

                        if ($imageExist && $lastPhoto != DEFAULTPROFILEPHOTO) {
                            Images::delete(PROFILEPHOTOS, $lastPhoto);
                        }

                        $myUser = $userObject->getByColumn("id", $userData->id)[0];
                        $token = Auth::createToken($myUser);
                        $_SESSION['token'] = $token;

                        if (isset($_COOKIE['session'])) $_COOKIE['session'] = $token;

                        $response = ["status" => true, "response" => "Success", "image" => $name];
                    }else{
                        $response = ["status" => false, "response" => "User couldn´t be saved"];
                    }
                }else{
                    $response = ["response" => false, "message" => "File couldn´t be saved"];
                }
            }else{
                $response = ["response" => false, "message" => "Size or format is incorrect. It´s allowed .gif, .jpeg, jpg, .png as format."];
            }
        }

        echo json_encode($response);
    }

}