CREATE TABLE "users" (
	"userId"	INTEGER NOT NULL,
	"userName"	TEXT,
	"email"	TEXT,
	"hashedPassword"	TEXT,
	PRIMARY KEY("userId" AUTOINCREMENT)
);


CREATE TABLE "statuses" (
	"statusId"	INTEGER NOT NULL,
	"userId"	INTEGER,
	"statusText"	TEXT,
	PRIMARY KEY("statusId" AUTOINCREMENT)
);