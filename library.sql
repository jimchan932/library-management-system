use library;
/*
drop table user;
create table user (
  username char(16) primary key,
  passwd char(40) not null,
  can_reserve_date date,
  location char(30) not null
);
*/
/*
drop table book;
create table book (
       bookID char(20) primary key,
       title char(100) not null,
       author char(50) not null,
       publisher char(20) not null,
       category char(20) not null,
       library char(30) not null,
       due_date date,
       fine float,
       available tinyint(1) not null,
       status char(20) not null
);
*/
/*
create table borrow
(
	bookID char(10) primary key,
	username char(16) not null
);
*/
/*
drop table reserve;
create table reserve
(
	username char(16) primary key,
	bookID char(25) not null,
	library_location() 
	delivired tinyint(1) not null,
	deliviery_date date
); 
*/
/*
 create table admin_user
 (
    username char(16) primary key,
    passwd char(40) not null,
    location char(30) not null
 );

-- create user administrator identified by 'admin';
grant select, insert, update, delete on library.* to administrator;

grant select, insert, update, delete on library.* to normaluser;
-- insert into user values('jim314', '314159', null);
-- insert into book values('TP312/B642', 'Programming Rust', 'Orendorff, Jason', 'O\'Reilly','Computer Science', 'South', '2022-11-06',0, 0, 'Borrowed');
-- insert into borrow values('TP312/B642','jim314');
insert into user values('jim314', '314159', null, 'south');
insert into admin_user values('admin_s', 'admin_s', 'south');
*/
-- drop table book;
/*
create table book (
       bookID char(30) not null,
       title char(100) not null,
       author char(50) not null,
       publisher char(40) not null,
       category char(20) not null,
       library_location char(10) not null,
       due_date date,
       fine float,
       available tinyint(1) not null,
       status char(20) not null,
       primary key(bookID, library_location)
);*/

-- drop table reserve;
/*
create table reserve
(
	username char(16) primary key,
	bookID char(30) not null,
	library_location char(10) not null,
	delivired tinyint(1) not null,
	deliviery_date date
);*/ 
/*
insert into book values('B942.5/K12', 'Thinking, fast and slow', 'Daniel Kahneman', 'Penguin', 'Psychology', 'South', null, 0, 0, 'On Shelf');
insert into book values('TP312/B642', 'Programming Rust', 'Orendorff, Jason', 'OReilly','Computer Science', 'South', '2022-11-06',0, 0, 'Borrowed');

insert into book values('O4/F435 E*', 'The Feynman lectures on physics', 'Feynman Richard P.', 'New York', 'Science and Maths','South', null, 0, 1,'On Shelf');


insert into book values('O17/C858',
'Introduction to Calculus and Analysis',
'Richard Courant', 'Springer', 'Science and Maths', 'South', null, 0, 0, 'On Shelf');

insert into book values('TP312C','Expert C programming: deep C secrets', 'Peter van der Linden', 'Pearson', 'Computer Science', 'South', null, 0, 0, 'On Shelf');

insert into book values('N94/T143 *','The Black Swan: The impact of the highly improbable', 'Nassim Nicholas Taleb', 'Penguin','Uncertainty', 'South', null, 0, 0, 'On Shelf');

insert into book values('A123/M392ag','Capital: a critique of political economy', 'Karl Marx', 'Liaoning People\'s Publishing House', 'Economics', 'East', null, 0, 0, 'On Shelf');

insert into book values('F091.33/S642ac E', 'The Wealth of Nations', 'Smith, Adam','Liaoning People\'s Publishing House', 'Economics', 'East', null, 0, 0, 'On Shelf');

insert into book values('I512.45/D724-1 EO', 'The Idiot', 'Fyodor Dotoevsky','Oxford', 'Novel', 'East', null, 0, 0, 'On Shelf');

insert into book values('I512.45/D724-1 EO', 'The Idiot', 'Fyodor Dotoevsky','Oxford', 'Novel', 'South', null, 0, 0, 'On Shelf');

insert into book values('TP393/F727', 'Computer networks: a top down approach', 'Mosharraf, Firouz', 'China Machine Press', 'Computer Science', 'South', null, 0, 0, 'On Shelf');

create table user
(
    username char(16) primary key,
    passwd char(40) not null,
    location char(30) not null,
    can_borrow tinyint(1) not null
);
insert into user values('jim314', '314159', 'south', 1);
*/

/*
create table reserve
(
	username char(16) not null,
	bookID char(30) not null,
	library_location char(10) not null,
	departed tinyint(1) not null,
	arrived tinyint(1) not null,
	arrival_date date,
	primary key(bookID, library_location)
);
*/

drop table user;
create table user
(
    username char(16) primary key,
    passwd char(40) not null,
    location char(30) not null,
    num_of_overdue_books int not null
);

insert into user values('jim314', '314159', 'South', 0);
