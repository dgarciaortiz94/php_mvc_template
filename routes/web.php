<?php

use Framework\Http\Routes\Routes;

Routes::GET("/", "IndexController.index");
Routes::GET("/login", "LoginController.index");
Routes::GET("/registro", "RegisterController.index");
Routes::GET("/perfil", "ProfileController.index")->middleware("role", [1, 2, 3]);
Routes::GET("/perfil/seguridad", "ProfileController.security")->middleware("role", [1, 2, 3]);
Routes::GET("/perfil/logoff", "ProfileController.logOff")->middleware("role", [1, 2, 3]);

Routes::POST("/userLogin", "LoginController.login");
Routes::POST("/userRegister", "RegisterController.register");
Routes::POST("/perfil/updatePersonalData", "ProfileController.updatePersonalData")->middleware("role", [1, 2, 3]);
Routes::POST("/perfil/updateSecurity", "ProfileController.updatePass")->middleware("role", [1, 2, 3]);
Routes::POST("/profile/deletePhotoProfile", "ProfileController.deletePhotoProfile")->middleware("role", [1, 2, 3]);
Routes::POST("/profile/updatePhotoProfile", "ProfileController.updatePhotoProfile")->middleware("role", [1, 2, 3]);
Routes::POST("/profile/updatePhotoDefinitive", "ProfileController.updatePhotoDefinitive")->middleware("role", [1, 2, 3]);


Routes::GET("/prueba/users", "PruebaController.index");
Routes::GET("/prueba/users/{name}", "PruebaController.show");
Routes::POST("/prueba/users", "PruebaController.store");
Routes::PUT("/prueba/users/{name}", "PruebaController.prueba2");
Routes::PATCH("/prueba/users/{name}", "PruebaController.update");
Routes::DELETE("/prueba/users/{name}", "PruebaController.delete");

Routes::GET("/prueba", "PruebaController.prueba");
