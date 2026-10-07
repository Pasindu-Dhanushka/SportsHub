USE sports_hub;

INSERT INTO users (id,name,email,password,student_id,faculty,role,status) VALUES
(1,'Sports Administrator','admin@sportshub.lk','$2y$12$plH9cBAKFzQCSzjbVc.UwOBDc/JwrmLAAK1CNDHKYr1SPTa9O7Xh2',NULL,'Student Affairs','admin','active'),
(2,'Pasindu Dhanushka','student@sportshub.lk','$2y$12$B1YWhdHDAaENGTXXKDOMgeCMVTPS1HI8q4t465It.u6UR64NHzbXm','2621001','Faculty of Computing','student','active'),
(3,'Amandi Perera','amandi@nsbm.ac.lk','$2y$12$B1YWhdHDAaENGTXXKDOMgeCMVTPS1HI8q4t465It.u6UR64NHzbXm','2621042','Faculty of Business','student','active'),
(4,'Nimal Jayasinghe','nimal@nsbm.ac.lk','$2y$12$B1YWhdHDAaENGTXXKDOMgeCMVTPS1HI8q4t465It.u6UR64NHzbXm','2621098','Faculty of Engineering','student','active'),
(5,'Kavindi Silva','kavindi@nsbm.ac.lk','$2y$12$B1YWhdHDAaENGTXXKDOMgeCMVTPS1HI8q4t465It.u6UR64NHzbXm','2621155','Faculty of Computing','student','active');

INSERT INTO clubs (id,name,sport,coach,venue,training_days,capacity,description,status) VALUES
(1,'NSBM Basketball Club','Basketball','Coach D. Fernando','Indoor Sports Complex','Tue & Thu · 5:30 PM',40,'Fast-paced training, inter-university fixtures and a strong team culture for players at every competitive level.','active'),
(2,'NSBM Cricket Club','Cricket','Coach S. Wijeratne','University Cricket Ground','Mon, Wed & Sat · 4:30 PM',55,'Develop batting, bowling and fielding skills while representing NSBM in competitive university cricket.','active'),
(3,'NSBM Volleyball Club','Volleyball','Coach N. Peris','Main Outdoor Court','Mon & Fri · 5:00 PM',36,'A high-energy club focused on teamwork, technique and competitive indoor and beach volleyball.','active'),
(4,'NSBM Badminton Club','Badminton','Coach R. Samarasinghe','Indoor Badminton Courts','Wed & Sat · 6:00 PM',44,'Structured singles and doubles training with regular ladders, friendlies and tournament preparation.','active'),
(5,'NSBM Football Club','Football','Coach A. Gunasekara','NSBM Football Ground','Tue, Thu & Sun · 4:30 PM',50,'Build technical ability, tactical awareness and match fitness in a competitive but inclusive football environment.','active'),
(6,'NSBM Athletics Club','Athletics','Coach M. de Silva','Athletics Track','Mon, Wed & Fri · 6:00 AM',60,'Sprint, endurance and field-event development supported by structured training and performance tracking.','active');

INSERT INTO memberships (user_id,club_id,status,joined_at) VALUES
(2,1,'approved','2026-08-20'),(2,4,'approved','2026-09-03'),(3,3,'approved','2026-08-25'),(4,2,'approved','2026-08-18'),(5,5,'approved','2026-09-01'),
(3,1,'pending',NULL),(4,6,'pending',NULL),(5,4,'pending',NULL);

INSERT INTO training_sessions (club_id,title,session_date,start_time,end_time,venue,coach,notes,status) VALUES
(1,'Transition & shooting drills','2026-10-08','17:30','19:30','Indoor Sports Complex','Coach D. Fernando','Bring both light and dark jerseys.','scheduled'),
(4,'Doubles rotation practice','2026-10-09','18:00','20:00','Indoor Badminton Courts','Coach R. Samarasinghe','Match-play focus for tournament squad.','scheduled'),
(2,'Net session','2026-10-10','16:30','18:30','University Cricket Ground','Coach S. Wijeratne','Batting and death-over bowling.','scheduled'),
(5,'Tactical small-sided games','2026-10-11','16:30','18:30','NSBM Football Ground','Coach A. Gunasekara',NULL,'scheduled'),
(3,'Serve receive fundamentals','2026-10-04','17:00','19:00','Main Outdoor Court','Coach N. Peris',NULL,'completed');

INSERT INTO sports_matches (id,club_id,opponent,competition,match_date,start_time,venue,home_away,status) VALUES
(1,1,'SLIIT Panthers','Inter-University League','2026-10-10','17:30','NSBM Indoor Sports Complex','home','scheduled'),
(2,5,'IIT Lions','University Football Series','2026-10-12','16:00','Racecourse Ground','away','scheduled'),
(3,2,'UOC XI','Friendly Series','2026-10-15','09:30','NSBM Cricket Ground','home','scheduled'),
(4,3,'KDU Spikers','Inter-University League','2026-09-28','16:30','KDU Sports Hall','away','completed'),
(5,4,'SLTC Racquets','Campus Invitational','2026-09-30','15:00','NSBM Indoor Courts','home','completed');

INSERT INTO tournaments (id,title,sport,location,start_date,end_date,registration_deadline,max_participants,description,status) VALUES
(1,'Green University 3x3 Challenge','Basketball','NSBM Indoor Sports Complex','2026-10-18','2026-10-18','2026-10-12',64,'Fast-paced 3x3 basketball tournament open to registered student teams.','open'),
(2,'NSBM Smash Open 2026','Badminton','NSBM Indoor Badminton Courts','2026-10-24','2026-10-25','2026-10-16',80,'Singles and doubles badminton competition across beginner and open categories.','open'),
(3,'Campus Futsal Cup','Futsal','NSBM Sports Complex','2026-11-01','2026-11-02','2026-10-22',96,'Two-day futsal competition featuring faculty and open student teams.','open'),
(4,'Inter-Faculty Volleyball Cup','Volleyball','Main Outdoor Court','2026-09-12','2026-09-13','2026-09-05',72,'Annual inter-faculty volleyball tournament.','completed');

INSERT INTO tournament_registrations (tournament_id,user_id,team_name,status) VALUES
(1,2,'Code Dunkers','approved'),(2,2,'Pasindu D.','pending'),(1,3,'Business Ballers','pending'),(3,5,'Computing United','approved');

INSERT INTO match_results (match_id,nsbm_score,opponent_score,result,notes) VALUES
(4,3,1,'won','Strong service pressure and disciplined blocking.'),(5,2,3,'lost','Close deciding matches; strong doubles performance.');

INSERT INTO bookings (user_id,club_id,booking_type,item_name,booking_date,start_time,end_time,purpose,status,admin_note) VALUES
(2,1,'facility','Half Indoor Court','2026-10-09','15:00','16:30','Extra shooting practice before league fixture.','approved','Court B allocated.'),
(2,4,'equipment','Badminton Shuttle Tubes x3','2026-10-11','14:00','18:00','Doubles practice session.','pending',NULL),
(3,3,'facility','Main Outdoor Court','2026-10-13','16:00','18:00','Team serve-receive session.','pending',NULL),
(4,2,'equipment','Bowling Machine','2026-10-09','15:30','17:00','Batting practice.','rejected','Machine reserved for official squad training.'),
(5,5,'facility','Football Training Ground','2026-10-14','15:00','17:00','Small-sided team practice.','approved','Approved for full pitch use.');

INSERT INTO participation (user_id,club_id,event_type,event_name,event_date,points,remarks) VALUES
(2,1,'training','Shooting & conditioning','2026-10-06',10,'Full session completed.'),
(2,4,'training','Singles footwork session','2026-10-05',8,'Improved recovery movement.'),
(2,1,'match','Practice scrimmage','2026-10-02',18,'12 points and 4 assists.'),
(2,4,'tournament','September Racquet Ladder','2026-09-26',25,'Reached semifinal.'),
(3,3,'match','Friendly vs Alumni','2026-10-03',15,'Starting lineup.'),
(4,2,'training','Net session','2026-10-01',10,'Bowling unit.'),
(5,5,'match','Faculty Friendly','2026-09-29',20,'Scored one goal.');
