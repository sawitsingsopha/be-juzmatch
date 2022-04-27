<?php

/**
 * PHPMaker 2022 configuration file (Production)
 */

return [
    "Databases" => [
        "DB" => ["id" => "DB", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "10.148.0.3", "port" => "3306", "user" => "juzmatchusr", "password" => "dQUkPS78dLXNw50e", "dbname" => "juzmatch"],
        "juzmatch1" => ["id" => "juzmatch1", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "10.148.0.3", "port" => "3306", "user" => "juzmatchusr", "password" => "dQUkPS78dLXNw50e", "dbname" => "juzmatch"],
        "juzmatch2" => ["id" => "juzmatch2", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "10.148.0.3", "port" => "3306", "user" => "juzmatchusr", "password" => "dQUkPS78dLXNw50e", "dbname" => "juzmatch"],
        "juzmatch3" => ["id" => "juzmatch3", "type" => "MYSQL", "qs" => "`", "qe" => "`", "host" => "10.148.0.3", "port" => "3306", "user" => "juzmatchusr", "password" => "dQUkPS78dLXNw50e", "dbname" => "juzmatch"]
    ],
    "SMTP" => [
        "PHPMAILER_MAILER" => "smtp", // PHPMailer mailer
        "SERVER" => "smtp.gmail.com", // SMTP server
        "SERVER_PORT" => 587, // SMTP server port
        "SECURE_OPTION" => "tls",
        "SERVER_USERNAME" => "sawit204@gmail.com", // SMTP server user name
        "SERVER_PASSWORD" => "sawit21112538", // SMTP server password
    ],
    "JWT" => [
        "SECRET_KEY" => "Dx6SOwo5d0cOD0OM", // API Secret Key
        "ALGORITHM" => "HS512", // API Algorithm
        "AUTH_HEADER" => "X-Authorization", // API Auth Header (Note: The "Authorization" header is removed by IIS, use "X-Authorization" instead.)
        "NOT_BEFORE_TIME" => 0, // API access time before login
        "EXPIRE_TIME" => 600 // API expire time
    ]
];
