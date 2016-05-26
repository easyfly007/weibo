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

-- 我对关注的人的分组
-- 不同用户的关注的人的群，哪怕名字相同，在数据库上也是不同的
create table tb_group(
	id int not null primary key auto_increment,
	name char(45) not null,
	uid int not null, -- 用户的 id
	foreign key(uid) references tb_user(id)
);

-- 粉丝关系表
-- 粉丝数目
-- 粉丝用户id
-- 所属关注分组
create table tb_follow(
	follow int not null,  
	fans int not null,   
	gid int not null, 
	foreign key (gid) references tb_group (id)
);
ALTER TABLE tb_follow ADD INDEX (follow);
ALTER TABLE tb_follow ADD INDEX (fans);



create table tb_letter(
	id int not null primary key,
	ufrom int not null,
	content varchar(255) not null default '',
	time int(10) not null, -- 发送时间
	uto int not null,
	foreign key (ufrom) references tb_user(id),
	foreign key (uto) references tb_user(id) 
);

create table tb_weibo(
	id int not null primary key auto_increment,
	content varchar(140) not null default '', -- 微博内容
	original int not null default 0, -- 是否转发，0为原创，>0 为原微博id号码
	time int(10) not null, -- 微博发布时间
	forward int not null default 0,
	keep int not null default 0, -- 收藏
	comment int not null default 0, -- 评论
	uid int not null,
	foreign key (uid) references tb_user(id)
);

create table tb_picture(
	id int not null primary key auto_increment,
	mini varchar(60) not null, -- 小图
	medium varchar(60) not null, 
	max varchar(60) not null, 
	wid int not null, -- 所属微博id
	foreign key (wid) references tb_weibo (id)
);

-- 注意：注释和--之间必须要有空格

create table tb_comment(
	id int not null primary key auto_increment,
	content varchar(144) not null default '',
	time int(10) not null,
	uid int not null,
	wid int not null,
	foreign key (uid) references tb_user(id)
);
ALTER TABLE tb_comment ADD INDEX (uid);
ALTER table tb_comment add index (wid);

create table tb_keep(
	id int not null primary key auto_increment,
	time int(10) not null,
	uid int not null,
	wid int not null,
	foreign key (uid) references tb_user(id),
	foreign key (wid) references tb_weibo(id)
);
alter table tb_keep add index (uid);
alter table tb_keep add index (wid);

create table tb_atme(
	id int not null primary key auto_increment,
	time int(10) not null,
	wid int not null,
	uid int not null,
	foreign key (wid) references tb_weibo(id),
	foreign key (uid) references tb_user(id)
	-- at 了谁，谁at 的可以从 wid 找到，也就是发微博的人
);
alter table tb_atme add index (uid);
alter table tb_atme add index (wid);
