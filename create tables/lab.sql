create table Students(
	sid integer,
	sname char(30) not null,
	email char(30),
	primary key (sid) 
);

create table Antibodies(
	aid char(20),
	pid integer,
	`type` char(20),
	host char(20),
	fluorescence char(20),
	primary key (aid) 
	foreign key (pid) references Projects (pid) ON UPDATE CASCADE ON DELETE CASCADE,
);

create table ResultsPhotos(
	`path` varchar(255),
	`date` date not null,
	primary key (`path`) 
);

create table Projects(
	pid integer,
	pname char(50) not null,
	primary key (pid) 
);

create table Techniques(
	technique char(20),
	primary key (technique) 
);

create table Results(
	`path` varchar(255) not null,
	pid integer not null,
	aid char(20) not null,
	sid integer not null,
	technique char(20),
	primary key (`path`),
	foreign key (pid) references Projects (pid) ON UPDATE CASCADE ON DELETE CASCADE, 
	foreign key (aid) references Antibodies (aid) ON UPDATE CASCADE ON DELETE CASCADE,
	foreign key (sid) references Students (sid) ON UPDATE CASCADE ON DELETE CASCADE,
	foreign key (`path`) references ResultsPhotos (`path`) ON UPDATE CASCADE ON DELETE CASCADE, 
	foreign key (technique) references Techniques (technique)
);

create table Stud_Proj(
	pid integer,
	sid integer,
	primary key (sid,pid),
	foreign key (sid) references Students (sid) ON UPDATE CASCADE ON DELETE CASCADE,
	foreign key (pid) references Projects (pid) ON UPDATE CASCADE ON DELETE CASCADE
);

