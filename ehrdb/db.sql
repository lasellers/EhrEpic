CREATE USER 'admin' IDENTIFIED BY 'password';
GRANT ALL ON *.* TO 'admin'@'%';
CREATE USER 'ehr' IDENTIFIED BY 'password';
GRANT ALL ON *.* TO 'ehr'@'%';
create table docker_entrypoint_initdb (id int, created_at timestamp DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP);
insert into docker_entrypoint_initdb (id) values (1);
