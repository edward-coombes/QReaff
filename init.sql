CREATE USER 'QReaff'@'localhost' IDENTIFIED BY '$uperL337';
CREATE DATABASE QReaff;

GRANT ALL ON QReaff.* to 'QReaff'@'localhost';

CREATE TABLE QReaff.chapters (
       id int NOT NULL AUTO_INCREMENT,
       name varchar NOT NULL,
       latitude float NOT NULL,
       longitude float NOT NULL,
       PRIMARY KEY (id)
);

CREATE TABLE QReaff.activeReaffs(
       id int NOT NULL AUTO_INCREMENT,
       chapterId int,
       directLink text,
       startDate date,
       endDate date,
       PRIMARY KEY (id),
       FOREIGN KEY (chapterId) REFERENCES QReaff.chapters(id)
);
