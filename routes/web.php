<?php

use Framework\Http\Routes\Routes;

Routes::GET("/", "IndexController.index");
Routes::GET("/login", "LoginController.index");
Routes::GET("/registro", "RegisterController.index");
Routes::GET("/perfil", "ProfileController.index")->middleware("role", [1, 2, 3]);
Routes::GET("/perfil/seguridad", "ProfileController.security")->middleware("role", [1, 2, 3]);
Routes::GET("/perfil/logoff", "ProfileController.logOff")->middleware("role", [1, 2, 3]);
Routes::GET("/perfil/logoff", "ProfileController.logOff")->middleware("role", [1, 2, 3]);

Routes::POST("/userLogin", "LoginController.login");
Routes::POST("/userRegister", "RegisterController.register");
Routes::POST("/perfil/updatePersonalData", "ProfileController.updatePersonalData")->middleware("role", [1, 2, 3]);
Routes::POST("/perfil/updateSecurity", "ProfileController.updatePass")->middleware("role", [1, 2, 3]);
