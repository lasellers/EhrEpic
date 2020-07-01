CREATE DATABASE ehr;
CREATE USER 'admin' IDENTIFIED BY 'password';
GRANT ALL ON *.* TO 'admin'@'%';
CREATE USER 'ehr' IDENTIFIED BY 'password';
GRANT ALL ON *.* TO 'ehr'@'%';
