<?php

function valid(array $post): array
{
    $validate = [
        'error' => false,
        'success' => false,
        'messages' => [],
    ];



    if (!empty($post['login']) && !empty($post['password']) && !empty($post['firstName']) && !empty($post['lastName'])) {
        $login = trim($post['login']); //trim - очищает строку
        $password = trim($post['password']);
        $firstName = trim($post['firstName']);
        $lastName = trim($post['lastName']);


        $constrains = [
            'login' => 6,
            'password' => 7,
        ];


        $validateForm = valigData($login, $password, $firstName, $lastName, $constrains);

        if (!$validateForm['login']) {
            $validate['error'] = true;
            array_push($validate['messages'],
                "логин должен быть длиной не менее чем {$constrains['login']} символов");
        }

        if (!$validateForm['password']) {
            $validate['error'] = true;
            array_push($validate['messages'],
                "пароль должен быть длиной не менее чем {$constrains['password']} символов");
        }

        if (!$validateForm['firstName']) {
            $validate['error'] = true;
            array_push($validate['messages'],
                "имя должно содержать русские только буквы и пробелы!"."<span class='er-nm'>"."{$firstName} неккоректно"."</span>");
        }

        if (!$validateForm['lastName']) {
            $validate['error'] = true;
            array_push($validate['messages'],
                "фамилия должна содержать только русские буквы и пробелы! "."<span class='er-nm'>"."{$lastName} неккоректно"."</span>");
        }
        if (!$validate['error']){
            $validate['success'] = true;
            array_push($validate['messages'],
                "Ваше имя:{$firstName}",
                "Ваша фамилия:{$lastName}",
                "Ваш логин:{$login}",
                "Ваш пароль:{$password}"
            );
        }
        return $validate;
    }
    return $validate;

}


function valigData(string $login, string $password,string $firstName,string $lastName,array $constrains): array{

    $validateForm = [
        'login' => true,
        'password' => true,
        'firstName' => true,
        'lastName' => true,
    ];

    if (strlen($login) <= $constrains['login']) {
        $validateForm['login'] = false;
    }

    if (strlen($password) <= $constrains['password']) {
        $validateForm['password'] = false;
    }

    if (!validNames($firstName)) {
        $validateForm['firstName'] = false;
    }

    if (!validNames($lastName)) {
        $validateForm['lastName'] = false;
    }

    return $validateForm;

}

function validNames (string $randomName){
    return preg_match('/^[а-яё ]++$/ui',$randomName);
}