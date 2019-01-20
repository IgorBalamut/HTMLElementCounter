-- create database
create database project;

-- use database
use project;

-- create table tbDomain
create table tbDomain (
	id int unsigned not null auto_increment,
	name varchar(255) not null, 
	constraint pk_domain primary key (id),
	constraint unique_domain_name unique key(name) 
);

-- create table tbElement
create table tbElement (
	id int unsigned not null auto_increment,
	name varchar(255) not null, 
	constraint pk_element primary key (id),
	constraint unique_element_name unique key(name) 
);

-- create table tbUrl
create table tbUrl (
	id int unsigned not null auto_increment,
	name varchar(255) not null, 
	constraint pk_url primary key (id),
	constraint unique_url_name unique key(name) 
);

-- create table tbRequest
create table tbRequest (
	id int unsigned not null auto_increment,
	url_id int unsigned not null,
	domain_id int unsigned not null,
	element_id int unsigned not null,
	request_time datetime not null,
	duration_mls int unsigned not null,
	count_elm int unsigned not null,
	constraint pk_request primary key (id) 
);

-- create foreing keys 
alter table tbRequest 
ADD FOREIGN KEY (url_id) references tbUrl(id);

alter table tbRequest 
ADD FOREIGN KEY (domain_id) references tbDomain(id);

alter table tbRequest
ADD FOREIGN KEY (element_id) references tbElement(id);

