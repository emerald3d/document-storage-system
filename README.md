<p align="center">
    <a href="https://laravel.com" target="_blank"><img src="https://t3.ftcdn.net/jpg/07/32/10/90/360_F_732109080_4lXwGofazqAiysUpcCnrbflsNOl9EMdW.jpg" alt="Emerald Logo"></a>
</p>

## Описание

Document Storage System - система хранения документов с возможностью их просмотра и добавления авторизованными пользователями. 

## Основные функции

<div><p>Стандартная авторизация, аутентификация и идентификация Laravel + Voyager.</div></p>
<div><p>Доступ к просмотру, поиску, добавлению, редактированию и удалению своих документов в системе только зарегистрированным и авторизованным пользователям посредством стандартного Auth Middleware и Voyager role_id.</div></p>
<div><p>Администратор может осуществлять просмотр, редактирование, поиск и удаление документов созданных всеми пользователями прямо с основной страницы сайта.</p></div>
<div><p>Просмотр списка документов с информацией и ссылками на скачивание файла каждого документа.</div></p>
<div><p>Создание документа, состоящего из названия, файла (docx, pdf и другие, при настройке), хранящего в себе дату создания и автора (пользователя, добавившего документ).</div></p>
<div><p>Редактирование документа, позволяет изменить название и содержимое документа (файл), сохраняя дату последнего редактирования.</div></p>
<div><p>Удаление документа, позволяет мягко удалить документ с возможность его восстановления.</div></p>
<div><p>Сортировка списка документов по названию, автору и дате.</div></p>
<div><p>Поиск документов по названию, автору и дате.</div></p>
<div><p>Валидация всех вводимых в системе полей.</div></p>

## Настройка системы

Для добавления или измненения разрешенных расширений файлов кроме .pdf и .docx нужно внести изменения в строке файла
```php
App\Http\Requests\Document\StoreRequest
26    "'file' => 'required|file|mimes:docx,pdf',
```

Для измненения количества отображаемых документов на странице нужно изменить значение 8 на требуемое:

```php
App\Models\Document.php
13    const PAGINATE_NUMBER = 8;
```

## Используемые сторонние библиотеки

<div><p>Для системы шаблонов был использован Bootstrap</div></p>
<div><p>Для сортировки документов применен <a href="https://github.com/Kyslik/column-sortable">Kyslik/column-sortable<a></div></p>
<div><p>Для административной панели <a href="https://github.com/thedevdojo/voyager">Voyager 1.8.0<a></div></p>


### Специальное предложение
Используя этот исходник вы получаете favicon с JoJo!
