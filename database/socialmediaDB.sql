DROP DATABASE IF EXISTS socialmedia;

CREATE DATABASE socialmedia;
USE socialmedia;

CREATE TABLE UserAccount (
	userID smallint NOT NULL,
    emailAddress varchar(40) NOT NULL,
    userPassword varchar(20) NOT NULL,
    dateAccountCreated date NOT NULL,
    isInactive bool NOT NULL,
    profileID smallint,
    PRIMARY KEY (userID)
    );
    
CREATE TABLE UserProfile (
	profileID smallint NOT NULL,
    firstName varchar(35) NOT NULL,
    lastName varchar(35)NOT NULL,
    dateOfBirth date NOT NULL,
    city char(20),
    country char(50) NOT NULL,
    aboutMeDesc tinytext,
    profileLevelID smallint NOT NULL,
    postCount smallint,
    communityMember smallint NOT NULL,
    PRIMARY KEY (profileID)
    );
    
CREATE TABLE Community (
	communityID smallint NOT NULL,
    communityName varchar(50) NOT NULL,
    communityTheme varchar(40) NOT NULL,
    PRIMARY KEY (communityID)
    );
        
CREATE TABLE Post (
	postID smallint NOT NULL,
    postContent tinytext NOT NULL,
    datePostCreated date NOT NULL,
    postAuthor varchar(70) NOT NULL,
    isDeleted bool NOT NULL,
    profileID smallint NOT NULL,
    PRIMARY KEY (postID)
    );
        
CREATE TABLE ProfileLevel (
	levelID smallint NOT NULL,
    level smallint NOT NULL,
    badge char(15) NOT NULL,
    PRIMARY KEY (levelID)
    );
        
CREATE TABLE Friendship (
	friendshipID smallint NOT NULL,
    friendID1 smallint NOT NULL,
    friendID2 smallint NOT NULL,
    dateEstabilished date NOT NULL,
    PRIMARY KEY (friendshipID)
    );
    
CREATE TABLE DeletedPost (
	postID smallint NOT NULL,
    dateDeleted date NOT NULL
    );

CREATE TABLE DeletedAccount (
	userID smallint NOT NULL,
    dateDeleted date NOT NULL
    );

INSERT UserAccount (userID, emailAddress, userPassword, dateAccountCreated, isInactive, profileID) VALUES (1, 'testemail1@gmail.com', SHA1('testpassword1'), '2020-01-01', 0, 1);     
INSERT UserAccount (userID, emailAddress, userPassword, dateAccountCreated, isInactive, profileID) VALUES (2, 'testemail2@gmail.com', SHA1('testpassword2'), '2020-02-01', 0, 2);     
INSERT UserAccount (userID, emailAddress, userPassword, dateAccountCreated, isInactive, profileID) VALUES (3, 'testemail3@gmail.com', SHA1('testpassword3'), '2020-03-01', 0, 3);     
INSERT UserAccount (userID, emailAddress, userPassword, dateAccountCreated, isInactive, profileID) VALUES (4, 'testemail4@gmail.com', SHA1('testpassword4'), '2020-04-01', 0, 4);     
INSERT UserAccount (userID, emailAddress, userPassword, dateAccountCreated, isInactive, profileID) VALUES (5, 'testemail5@gmail.com', SHA1('testpassword5'), '2020-05-01', 0, 5);
INSERT UserAccount (userID, emailAddress, userPassword, dateAccountCreated, isInactive, profileID) VALUES (6, 'inactiveemail@gmail.com', SHA1('inactivepassword'), '2015-05-01', 1, 6);

INSERT UserProfile (profileID, firstName, lastName, dateOfBirth, city, country, aboutMeDesc, profileLevelID, postCount, communityMember) VALUES (1, 'George', 'Georgeston', '1995-01-01', 'Christchurch', 'New Zealand', 'I enjoy gaming online', 5, 0, 1);      
INSERT UserProfile (profileID, firstName, lastName, dateOfBirth, city, country, aboutMeDesc, profileLevelID, postCount, communityMember) VALUES (2, 'Ann', 'Annston', '1995-02-01', 'Wellington', 'New Zealand', 'I enjoy gaming online too', 1, 0, 1);      
INSERT UserProfile (profileID, firstName, lastName, dateOfBirth, city, country, aboutMeDesc, profileLevelID, postCount, communityMember) VALUES (3, 'Bobby', 'Bobston', '1995-03-01', 'Auckland', 'New Zealand', 'I enjoy making new friends over gaming', 1, 0, 2);      
INSERT UserProfile (profileID, firstName, lastName, dateOfBirth, city, country, aboutMeDesc, profileLevelID, postCount, communityMember) VALUES (4, 'Charlie', 'Charleston', '1995-04-01', 'Amsterdam', 'Netherlands', 'I enjoy playing new games', 6, 0, 1);      
INSERT UserProfile (profileID, firstName, lastName, dateOfBirth, city, country, aboutMeDesc, profileLevelID, postCount, communityMember) VALUES (5, 'Rebecca', 'Clarkson', '1995-05-01', 'New Delhi', 'India', 'I enjoy gaming in my spare time', 2, 0, 2); 
INSERT UserProfile (profileID, firstName, lastName, dateOfBirth, city, country, aboutMeDesc, profileLevelID, postCount, communityMember) VALUES (6, 'Daniel', 'Reed', '1995-06-01', '', 'Denmark', 'I enjoy completing all achievements in my games', 3, 0, 1); 

INSERT Community (communityID, communityName, communityTheme) VALUES (1, 'All Things Video Gaming', 'Recreational - Entertainment');
INSERT Community (communityID, communityName, communityTheme) VALUES (2, 'All Things Hindi', 'Educational - Language');

INSERT Post (postID, postContent, datePostCreated, postAuthor, isDeleted, profileID) VALUES (1, 'This is a post. Today I posted.', '2020-03-15', 'Ann Annston', 0, 2);
INSERT Post (postID, postContent, datePostCreated, postAuthor, isDeleted, profileID) VALUES (2, 'This is also post. Today I posted too.', '2020-02-10', 'Charlie Charleston', 0, 4);
INSERT Post (postID, postContent, datePostCreated, postAuthor, isDeleted, profileID) VALUES (3, 'This is a post. Today I posted twice.', '2020-03-15', 'Ann Annston', 0, 2);
INSERT Post (postID, postContent, datePostCreated, postAuthor, isDeleted, profileID) VALUES (4, 'This is a deleted post. Today I posted irrelevant content.', '2020-01-04', 'Ann Annston', 1, 2);
INSERT Post (postID, postContent, datePostCreated, postAuthor, isDeleted, profileID) VALUES (5, 'Today I posted content.', '2020-01-04', 'Bobby Bobston', 0, 3);

INSERT ProfileLevel (levelID, level, badge) VALUES (1, 1, 'Novice');
INSERT ProfileLevel (levelID, level, badge) VALUES (2, 2, 'Power Novice');
INSERT ProfileLevel (levelID, level, badge) VALUES (3, 3, 'User');
INSERT ProfileLevel (levelID, level, badge) VALUES (4, 4, 'Power User');
INSERT ProfileLevel (levelID, level, badge) VALUES (5, 5, 'Super User');
INSERT ProfileLevel (levelID, level, badge) VALUES (6, 6, 'Loyal User');
INSERT ProfileLevel (levelID, level, badge) VALUES (7, 7, 'VIP User');

INSERT Friendship (friendshipID, friendID1, friendID2, dateEstabilished) VALUES (1, 1, 2, '2020-02-05');
INSERT Friendship (friendshipID, friendID1, friendID2, dateEstabilished) VALUES (2, 1, 3, '2020-03-05');
INSERT Friendship (friendshipID, friendID1, friendID2, dateEstabilished) VALUES (3, 2, 4, '2020-04-02');
INSERT Friendship (friendshipID, friendID1, friendID2, dateEstabilished) VALUES (4, 2, 3, '2020-04-05');
INSERT Friendship (friendshipID, friendID1, friendID2, dateEstabilished) VALUES (5, 3, 5, '2020-05-05');

INSERT DeletedPost (postID, dateDeleted) VALUES (4, '2020-01-04');

INSERT DeletedAccount (userID, dateDeleted) VALUES (6, '2018-01-01');

ALTER TABLE UserAccount ADD CONSTRAINT FK_User_Profile FOREIGN KEY (profileID) REFERENCES UserProfile(profileID);
ALTER TABLE UserProfile ADD CONSTRAINT FK_Profile_Level FOREIGN KEY (profileLevelID) REFERENCES ProfileLevel(levelID);
ALTER TABLE Post ADD CONSTRAINT FK_Post_Profile FOREIGN KEY (profileID) REFERENCES UserProfile(profileID);
ALTER TABLE Friendship ADD CONSTRAINT FK_Friend1_Friend2 FOREIGN KEY (friendID1) REFERENCES UserAccount(userID);
ALTER TABLE Friendship ADD CONSTRAINT FK_Friend2_Friend1 FOREIGN KEY (friendID2) REFERENCES UserAccount(userID);
ALTER TABLE DeletedPost ADD CONSTRAINT FK_Deleted_Post FOREIGN KEY (postID) REFERENCES Post(postID);
ALTER TABLE DeletedAccount ADD CONSTRAINT FK_Deleted_Account FOREIGN KEY (userID) REFERENCES UserAccount(userID);
ALTER TABLE UserProfile ADD CONSTRAINT FK_Community_Profile FOREIGN KEY (communityMember) REFERENCES Community(communityID);

SELECT * FROM UserAccount;
SELECT * FROM UserProfile;  
SELECT * FROM Community;
SELECT * FROM Post;
SELECT * FROM ProfileLevel;
SELECT * FROM Friendship;
SELECT * FROM DeletedPost;
SELECT * FROM DeletedAccount;


-- Who is friends with George Georgeston?
SELECT p.profileID, P.firstName, P.lastName 
FROM Friendship F
JOIN UserProfile P ON P.profileID = F.friendID1
WHERE F.friendID2 = 1
UNION
SELECT P.profileID, P.firstName, P.lastName
FROM Friendship F
JOIN UserProfile P ON P.profileID = F.friendID2
WHERE F.friendID1 = 1;

-- Who is George's and Ann's mutal friends?
SELECT P2.profileID, UP.firstName, UP.lastName
FROM (
	SELECT P.profileID FROM Friendship F
    JOIN UserProfile P ON P.profileID = F.friendID1
    WHERE F.FriendID2 = 1
    UNION
    SELECT P.profileID FROM Friendship F
    JOIN UserProfile P ON P.profileID = F.friendID2
    WHERE F.friendID1 = 1
    ) AS P2
JOIN UserProfile UP ON UP.profileID = P2.profileID
WHERE P2.profileID IN (
	SELECT DISTINCT P3.profileID FROM (
		SELECT P.profileID FROM Friendship F
        JOIN UserProfile P ON P.profileID = F.friendID1
        WHERE F.friendID2 = 2
		UNION
        SELECT P.profileID FROM Friendship F
        JOIN UserProfile P ON P.profileID = F.friendID2
        WHERE F.friendID1 = 2
        ) AS P3
	);
    
-- Display all posts made by a user
SELECT postID, postContent, postAuthor, isDeleted
FROM Post P
INNER JOIN UserProfile UP ON UP.profileID = P.profileID
WHERE UP.profileID = 2;

-- Display all accounts inactive longer than a year
SELECT userID, emailAddress, dateAccountCreated, firstName, lastName
FROM UserAccount UA
INNER JOIN UserProfile UP ON UP.profileID = UA.profileID
WHERE UA.isInactive = 1 AND UA.dateAccountCreated < DATE_SUB(NOW(), INTERVAL 1 YEAR);
    
-- Total number of posts by user
DELIMITER //
CREATE TRIGGER IncrementPostCount_AI
	AFTER INSERT ON Post FOR EACH ROW
    BEGIN
        
        UPDATE UserProfile UP
        INNER JOIN Post P ON P.profileID = UP.profileID
		SET UP.postCount = UP.postCount + 1
        WHERE NEW.profileID = UP.profileID
        AND P.isDeleted = 0;
        
	END//
DELIMITER ;
		