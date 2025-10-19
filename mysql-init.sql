CREATE USER 'user1'@'%' IDENTIFIED BY 'password1';
CREATE USER 'user2'@'%' IDENTIFIED BY 'password2';
GRANT ALL PRIVILEGES ON laravel.* TO 'user1'@'%';
GRANT ALL PRIVILEGES ON laravel.* TO 'user2'@'%';
FLUSH PRIVILEGES;
