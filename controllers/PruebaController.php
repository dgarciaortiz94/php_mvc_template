<?php

namespace Controllers;

use Framework\Core\Controller;
use Framework\Http\Requests\Request;
use Models\Users;

class PruebaController extends Controller
{

    public function index()
    {  
        $usersObject = new Users();

        $users = $usersObject->getAll();

        echo json_encode($users, JSON_UNESCAPED_UNICODE);
    }


    public function show(Request $request)
    {
        var_dump($request);
    }


    public function store(Request $request)
    {
        var_dump($request);
    }


    public function update(Request $request)
    {
        var_dump($request);
    }


    public function delete(Request $request)
    {
        var_dump($request);
    }
    
}