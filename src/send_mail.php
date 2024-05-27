<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);

    if (empty($name) || empty($email) || empty($phone)) {
        http_response_code(400);
        echo "Пожалуйста, заполните все поля.";
        exit;
    }

    $recipient = "rbru-metrika@yandex.ru";
    $subject = "Новая запись на прием от $name";
    $email_content = "Имя: $name\n";
    $email_content .= "Email: $email\n";
    $email_content .= "Телефон: $phone\n";

    $email_headers = "From: $name <$email>";

    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200);
        echo "Спасибо! Ваша заявка отправлена.";
    } else {
        http_response_code(500);
        echo "Что-то пошло не так, и ваша заявка не была отправлена.";
    }
} else {
    http_response_code(403);
    echo "Запрос не отправлен, попробуйте еще раз.";
}
?>
