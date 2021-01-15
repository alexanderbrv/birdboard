<?php

/**
 * @param $email
 * @return string
 */
function gravatar_url($email)
{
    $email = md5($email);

    return "https://gravatar.com/avatar/{$email}?" . http_build_query([
            's' => 60,
            'd' => 'https://jessorrlit.files.wordpress.com/2013/07/leaf-bullet-point.jpg',
        ]);
}