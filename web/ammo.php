<?php

$subdomain='baila'; #Наш аккаунт - поддомен
$site = 'LB';

function getNumber(){

    $file=fopen(dirname(__FILE__).'/num.txt',"a+"); //Открытие
    flock($file,LOCK_EX); //Блокировка
    $count=fread($file,100); //Чтение
    $count++; // Увеличение значение на 1
    ftruncate($file,0); // Очищаем файл
    fwrite($file,$count); //Записываем новое значение
    flock($file,LOCK_UN); //Разблокируем
    fclose($file); //Закрываем
    return --$count ;
}


function query($link, $data, $auth = false){


    $curl=curl_init(); #Сохраняем дескриптор сеанса cURL
#Устанавливаем необходимые опции для сеанса cURL
    curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
    curl_setopt($curl,CURLOPT_URL,$link);
    curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
    curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($data));
    curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
    curl_setopt($curl,CURLOPT_HEADER,false);
    curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
    curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
    curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);

    $out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
    $code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
    curl_close($curl); #Заверашем сеанс cURL
    if ($auth == true){
        return $code;
    }else{
        return $out;
    }
}



    #Формируем ссылку для запроса
    $link='https://'.$subdomain.'.amocrm.ru/private/api/auth.php?type=json';
    $link2='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/contacts/set';
    $link3='https://'.$subdomain.'.amocrm.ru/private/api/v2/json/leads/set';


    $user=array(
        'USER_LOGIN'=>'z.eduard.m@gmail.com', #Ваш логин (электронная почта)
        'USER_HASH'=>'50da4debe100c3481c46c0eedc283444' #Хэш для доступа к API (смотрите в профиле пользователя)
    );
    $contacts['request']['contacts']['add']=array(
        array(
            'name'=> $_POST['lead_name'], #Имя контакта
            //'last_modified'=>1298904164, //optional
            'linked_leads_id'=>array( #Список с айдишниками сделок контакта
//                3698752,
//                3698754
            ),
            'company_name'=>'', #Наименование компании
            'tags' => '', #Теги
            'custom_fields'=>array(
                array(
                    #Телефоны
                    'id'=>1057420, #Уникальный индентификатор заполняемого дополнительного поля
                    'values'=>array(
                        array(
                            'value'=> $_POST['lead_phone'],
                            'enum'=>'MOB' #Мобильный
                        ),
                    )
                ),
                array(
                    #E-mails
                    'id'=>1057422,
                    'values'=>array(
                        array(
                            'value'=> $_POST['lead_email'],
                            'enum'=>'WORK', #Рабочий
                        ),
                    )
                ),
            )
        ),
    );


    $leads['request']['leads']['add']=array(
        array(
            'name'=>$site.'. Roman Feygenberg 2 ',
            //'date_create'=>1298904164, //optional
            'status_id'=>7744690,
            'price'=>0,
            'responsible_user_id'=>294972,
            'tags' => '', #Теги
        ),
    );



    if ( query($link,$user, true)== 200){
        $leads['request']['leads']['add'][0]['name'] = getNumber();
        $q = query($link3,$leads); #Сделка
        $q = json_decode($q);
        $q = $q->response->leads->add[0]->id;
        $contacts['request']['contacts']['add'][0]['linked_leads_id'] = array($q);

        query($link2,$contacts); #Контакт
    }