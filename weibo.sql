create database db_weibo default charset utf8;

use db_weibo;

create table tb_user(
	id int not null primary key auto_increment,
	account char(20) not null,
	password char(40) not null,
	registime int(10) not null,
	logintime int(20) not null,
	locked tinyint(1) default 0
);

create table tb_userinfo(
	id int not null primary key auto_increment,
	uid int not null,
	username char(45) not null,
	truename char(45),
	sex enum('f','m') default 'm',
	location char(45) not null default '',
	constellation char(10) not null default '',
	intro varchar(100) not null default '',
	face50 varchar(100) not null,
	face80 varchar(100) not null,
	face180 varchar(100) not null,
	style varchar(45) not null default 'default',
	follow int not null default 0,
	fans int not null default 0,
	weibo int not null default 0,
	foreign key (uid) references tb_user (id)
);

-- 粉丝关系表
create table tb_follow(
	follow int not null,  -- 粉丝数目
	fans int not null,    -- 粉丝用户id
);


