<?php

//���ݿ��û���
$username = 'root';

//���ݿ�����
$userpass = 'root';

//���ݿ�������
$dbhost = 'localhost';

//���ݿ���
$dbdatabase = 'cmssys';

//����Դ��
$dsn = 'mysql:host=' . $dbhost . ';dbname=' . $dbdatabase . ';';

$dbh = new PDO($dsn, $username, $userpass);

$stmt = $dbh->query('SELECT id,username FROM cms_user');

$row = $stmt->fetch();
