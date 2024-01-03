Новый сезон:

- mysqldump -u teams_user '-p******' teams > backup.DATE.sql. Пароль в application.ini

- `mysql -u teams_user '-p****' teams`
```
update turnir set old='y';
insert into turnir(id,imia,url,old) values(95,'ИЧБ-13', 'https://drive.google.com/file/d/1FP7lRd12SlsXb5dtkHheVFzZ7jEolMMl/', 'n');
```
- Отредактировать application.ini, загрузить на сервер. Особое внимание уделить параметрам `ichb.*`

- Data.php: сменить `TURNIR`

Обновить конфиг:
```
scp application/configs/application.ini teams:chgk-teams/application/configs/application.ini
```