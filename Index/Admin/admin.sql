use db_weibo;

create table tb_admin(
	id int not null primary key auto_increment,
	username char(20) not null,
	password char(40) not null,
	registime int(10) not null,
	logintime int(20) not null,
	loginip  char(20) not null,
	locked tinyint(1) default 0,
	admin tinyint(1) default 1 -- 0 超级管理员，1 普通管理员
	-- grantedby int not null,
	-- foreign key (grantedby) references tb_admin (id)
) default charset = utf8;
-- 最开始的超级管理员 grantedby 0

create table tb_filter(
	id int not null primary key auto_increment,
	word char(20) not null,
	replacement char(20) not null
) default charset = utf8;

insert into tb_admin (username, password, admin) values('admin', md5('admin'), 0);
	

